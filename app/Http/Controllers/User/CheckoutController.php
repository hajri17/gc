<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
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
        $transaction = Transaction::with(
                'transaction_details.item',
            )
            ->where('user_id', auth()->id())
            ->whereNull('paid_at')
            ->first();

        $total = 0;
        $shippingCost = 0;

        if ($transaction) {
            switch ($transaction->shipping) {
                case 'Free Shipping':
                    $shippingCost = 0;
                    break;
                case 'Express Shipping':
                    $shippingCost = 34000;
                    break;
                default:
                    $shippingCost = 12000;
            }

            $total = $transaction->transaction_details->sum(function ($td) {
                return $td->item->price * $td->qty;
            });
        }

        return view('user.checkout.index', compact('transaction', 'total', 'shippingCost'));
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
        $shippingCost = 0;
        $shipping = $request->query('shipping-option');

        switch ($shipping) {
            case 'free-shipping':
                $shippingCost = 0;
                break;
            case 'express-shipping':
                $shippingCost = 34000;
                break;
            default:
                $shippingCost = 12000;
        }

        $cartTotal = $carts->sum(function ($s) {
            return $s->qty * $s->item->price;
        });
        $total = $cartTotal + $shippingCost;


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
            'shipping' => 'required|string',
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
