<?php

namespace App\DataTables;

use App\Models\Item;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;

class ItemsDataTable extends GCDataTable implements GCDataTableContract
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
            ->editColumn('main_image', function ($data) {
                return '<img class="img-fluid" style="height: 200px" src="' . asset('storage/' . $data->main_image->url) . '">';
            })
            ->editColumn('created_at', function ($data) {
                return $data->created_at->isoFormat('LLL');
            })
            ->editColumn('updated_at', function ($data) {
                return $data->created_at->isoFormat('LLL');
            })
            ->addColumn('action', function ($item) {
                return view('admin.items.action', compact('item'));
            })
            ->rawColumns(['main_image']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Item $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Item $model)
    {
        return $model->newQuery()->with('main_image');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('items-table')
                    ->orderBy(0)
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
            Column::computed('main_image', 'Thumbnail'),
            Column::make('name'),
            Column::make('price'),
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
        return 'Items_' . date('YmdHis');
    }
}
