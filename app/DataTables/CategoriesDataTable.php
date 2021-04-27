<?php

namespace App\DataTables;

use App\Models\Category;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;

class CategoriesDataTable extends GCDataTable implements GCDataTableContract
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
            ->editColumn('parent', function ($data) {
                if ($data->category) {
                    return $data->category->name;
                }
                return '-';
            })
            ->editColumn('created_at', function ($data) {
                return $data->created_at->isoFormat('LLL');
            })
            ->editColumn('updated_at', function ($data) {
                return $data->created_at->isoFormat('LLL');
            })
            ->addColumn('action', function ($category) {
                return view('admin.categories.action', compact('category'));
            })
            ->rawColumns(['action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Category $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Category $model)
    {
        return $model->newQuery()->with('category', 'categories');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('categories-table')
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
            Column::make('parent'),
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
        return 'Categories_' . date('YmdHis');
    }
}
