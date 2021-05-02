<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Services\UploadService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function confirm(Request $request, Transaction $transaction)
    {
        $this->validate($request, [
            'payment_proof' => 'file|image|max:1024',
        ]);

        try {
            $file = $request->file('payment_proof');
            $transaction->proof = (new UploadService($file))->storeToDiskOnly();
            $transaction->save();
        } catch (\Exception $exception) {
            return redirect()
                ->back()
                ->withErrors([
                    'payment_proof' => 'Failed to confirm payment',
                ]);
        }

        return redirect()
            ->back()
            ->with('success', 'Your transaction will be processed soon.');
    }

    public function accept(Transaction $transaction)
    {
        try {
            $transaction->accepted_at = now();
            $transaction->save();
        } catch (\Exception $exception) {
            return redirect()
                ->back()
                ->withErrors([
                    'accept' => 'Failed to accept transaction',
                ]);
        }

        return redirect()
            ->back()
            ->with('success', 'Your transaction has been completed.');
    }
}
