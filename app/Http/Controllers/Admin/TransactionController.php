<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\TransactionsDataTable;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    public function index(TransactionsDataTable $dataTable)
    {
        return $dataTable->render('admin.transactions.index');
    }

    public function paid(Transaction $transaction)
    {
        try {
            $transaction->update([
                'paid_at' => now(),
                'is_canceled' => false,
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

    public function cancel(Transaction $transaction)
    {
        try {
            $transaction->update([
                'paid_at' => null,
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
