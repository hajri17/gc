<?php

namespace App\DataTables;

use App\Models\Transaction;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class TransactionsDataTable extends GCDataTable implements GCDataTableContract
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->editColumn('created_at', function ($data) {
                return $data->created_at->isoFormat('DD/MM/YYYY HH:mm');
            })
            ->editColumn('updated_at', function ($data) {
                return $data->updated_at->isoFormat('DD/MM/YYYY HH:mm');
            })
            ->editColumn('status', function ($data) {
                if ($data->is_canceled) {
                    return '<div class="badge badge-danger">Canceled</div>';
                }

                if ($data->accepted_at) {
                    return '<div class="badge badge-success">Done</div>';
                }

                if (!$data->paid_at && $data->proof) {
                    $html = '<button data-url="' . $data->proof . '" data-toggle="modal" data-target="#proof-modal" class="btn btn-primary badge badge-primary">
                        <i class="fa fa-eye mr-1"></i>Payment proof uploaded
                    </button>';
                    return $html;
                }

                if ($data->paid_at && !$data->shipped_at) {
                    return '<div class="badge badge-success">Paid</div>';
                }

                if ($data->shipped_at) {
                    return '<div class="badge badge-info">Shipped</div>';
                }

                return '<div class="badge badge-warning">Unpaid</div>';
            })
            ->addColumn('action', function ($transaction) {
                return view('admin.transactions.action', compact('transaction'));
            })
            ->rawColumns(['status']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Transaction $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Transaction $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('transactions-table')
                    ->orderBy(0, 'ASC')
                    ->buttons(
                        Button::make('export'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')
                ->title('#')
                ->width('1%')
                ->className('no-vis no-wrap'),
            Column::make('name'),
            Column::make('phone'),
            Column::make('address'),
            Column::make('status'),
            Column::make('created_at')
                ->width('1%')
                ->className('no-vis no-wrap'),
            Column::make('updated_at')
                ->width('1%')
                ->className('no-vis no-wrap'),
            Column::computed('action', '')
                ->width('1%')
                ->className('no-vis no-wrap'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Transactions_' . date('YmdHis');
    }
}
