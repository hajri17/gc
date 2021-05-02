<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function create(Transaction $transaction)
    {
        return view('user.checkout.review', compact('transaction'));
    }

    public function store(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            'reviews.*.item_id' => 'required|numeric|exists:items,id',
            'reviews.*.content' => 'required|string|min:5',
        ]);

        try {
            $transaction->reviews()->createMany($validated['reviews']);
        } catch (\Exception $exception) {
            return redirect()
                ->route('checkout.index')
                ->withErrors('review', 'Failed to add review(s).');
        }

        return redirect()
            ->route('checkout.index')
            ->with('success', 'Your review(s) has been recorded.');
    }
}
