<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function index()
    {
        return view('user.others.cart');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_id' => 'required|numeric|exists:items,id',
            'qty' => 'required|numeric',
        ]);

        try {
            $existingCart = Cart::query()
                ->where('item_id', $validated['item_id'])
                ->where('user_id', auth()->id())
                ->get();

            if ($existingCart->isNotEmpty()) {
                $existingCart[0]->update([
                    'qty' => $existingCart[0]->qty + $validated['qty'],
                ]);
            } else {
                $cart = Cart::query()->create([
                    'qty' => $validated['qty'],
                    'item_id' => $validated['item_id'],
                    'user_id' => auth()->id(),
                ]);
            }
        } catch (\Exception $exception) {
            Log::error('Failed to add cart: ' . $exception->getMessage());

            return redirect()->back();
        }

        return redirect()->back();
    }

    public function destroy($id)
    {
        try {
            $cart = Cart::find($id);

            $cart->delete();
        } catch (\Exception $exception) {
            Log::error('Failed to delete cart: ' . $exception->getMessage());

            return redirect()->back();
        }

        return redirect()->back();
    }
}
