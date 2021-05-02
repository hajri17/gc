<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\ShippingMethod;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(
                'transaction_details.item',
            )
            ->where('user_id', auth()->id())
            ->latest('updated_at')
            ->get();

        return view('user.checkout.index', compact('transactions'));
    }

    public function create(Request $request)
    {
        $carts = Cart::with(
                'item.main_image',
                'item.category',
            )
            ->where('user_id', auth()->id())
            ->get();

        if ($carts->isEmpty()) {
            return redirect()->route('carts.index');
        }

        $user = Auth::user();
        $shipping = ShippingMethod::query()
            ->where('name', $request->query('shipping-option'))
            ->first();

        if (!$shipping) {
            return redirect()->back();
        }

        $cartTotal = $carts->sum(function ($s) {
            return $s->qty * $s->item->price;
        });

        $total = $cartTotal + $shipping->price_per_kg;


        return view('user.checkout.create', compact('shipping', 'user', 'total'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:1|max:255',
            'address-1' => 'required|string|min:1|max:255',
            'address-2' => 'nullable|string|min:1|max:255',
            'city' => 'required|string|min:1|max:255',
            'state' => 'required|string|min:1|max:255',
            'phone' => 'required|string|numeric|digits_between:8,16',
            'email' => 'required|string|email|min:1|max:255',
            'description' => 'nullable|string|min:1|max:255',
            'shipping_method_id' => 'required|numeric|exists:shipping_methods,id',
        ]);

        $address = $validated['address-1'];
        $address .= ' ' . $validated['address-2'];
        $address .= ', ' . $validated['city'];
        $address .= ', ' . $validated['state'];

        DB::beginTransaction();
        try {
            $transaction = new Transaction($request->except('address'));
            $transaction->address = $address;
            $transaction->user_id = auth()->id();
            $transaction->save();

            $carts = Cart::query()
                ->where('user_id', auth()->id())
                ->get();

            foreach ($carts as $cart) {
                $transactionDetail = new TransactionDetail([
                    'qty' => $cart->qty,
                    'price' => $cart->item->price,
                    'item_id' => $cart->item->id,
                    'transaction_id' => $transaction->id,
                ]);

                $transactionDetail->save();
            }
        } catch (\Exception $exception) {
            DB::rollBack();

            Log::error('Failed to create transaction: ' . $exception->getMessage());

            return redirect()
                ->back()
                ->with([
                   'failed' => 'Failed to create transaction.',
                ]);
        }
        DB::commit();

        Cart::destroy($carts);

        return redirect()
            ->route('checkout.index')
            ->with('success', 'Transaction placed');
    }
}
