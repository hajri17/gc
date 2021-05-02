<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\TransactionsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function index(TransactionsDataTable $dataTable)
    {
        return $dataTable->render('admin.transactions.index');
    }

    public function confirm(Transaction $transaction)
    {
        try {
            $transaction->update([
                'paid_at' => now(),
            ]);
        } catch (\Exception $exception) {
            Log::error('Failed to update transactions');

            return redirect()
                ->back()
                ->with([
                    'failed' => 'Failed to update transaction.',
                    'error' => $exception->getMessage(),
                ]);
        }

        return redirect()
            ->route('admin.transactions.index')
            ->with([
                'success' => 'Transaction updated successfully',
                'id' => $transaction->id,
            ]);
    }

    public function ship(Request $request, Transaction $transaction)
    {
        $validator = Validator::make($request->all(), [
            'shipping_number' => 'required|string|min:6',
        ]);

        $validator->errors()->add('ship', 'error');

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput()
                ->with(['transaction_id' => $transaction->id]);
        }

        try {
            $transaction->shipping_number = $request->input('shipping_number');
            $transaction->shipped_at = now();
            $transaction->save();
        } catch (\Exception $exception) {
            return redirect()
                ->back()
                ->withErrors([
                    'ship' => 'error',
                    'shipping_number' => 'Failed to update transaction',
                ])
                ->withInput()
                ->with(['transaction_id' => $transaction->id]);
        }

        return redirect()
            ->route('admin.transactions.index')
            ->with([
                'success' => 'Transaction updated successfully',
                'id' => $transaction->id,
            ]);
    }

    public function editShip(Transaction $transaction)
    {

    }

    public function updateShip(Request $request, Transaction $transaction)
    {

    }

    public function cancel(Transaction $transaction)
    {
        try {
            $transaction->update([
                'is_canceled' => true,
            ]);
        } catch (\Exception $exception) {
            Log::error('Failed to cancel transactions');

            return redirect()
                ->back()
                ->with([
                    'failed' => 'Failed to cancel transaction.',
                    'error' => $exception->getMessage(),
                ]);
        }

        return redirect()
            ->route('admin.transactions.index')
            ->with([
                'success' => 'Transaction canceled.',
                'id' => $transaction->id,
            ]);
    }
}
