<?php

namespace App\DataTables;

use Yajra\DataTables\Services\DataTable;

class GCDataTable extends DataTable implements GCDataTableContract
{
    public function builder(): \Yajra\DataTables\Html\Builder
    {
        return parent::builder()
            ->addTableClass('table-stripped')
            ->autoWidth(false)
            ->columns($this->getColumns())
            ->dom('<"d-flex align-items-center justify-content-between"
                <"d-flex align-items-center"l<"ml-2 mb-2"B>>f>rt
                <"d-flex justify-content-between"ip>')
            ->minifiedAjax()
            ->select([
                'style' => 'multi+shift',
                'selector' => 'td:first-child',
            ]);
    }

    public function getColumns(): array
    {
        // TODO: Implement getColumns() method.
    }
}
