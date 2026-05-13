<?php

namespace App\DataTables;

use App\Models\DeliveryArea;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class DeliveryAreaDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<DeliveryArea> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($query) {
                if (auth()->user()->can('edit delivery areas')) {
                $edit = "<a href='" . route('admin.delivery-area.edit', $query->id) . "' class='btn btn-primary'><i class='fas fa-pen'></i></a>";
                }
                if (auth()->user()->can('delete delivery areas')) {
                $delete = "<a href='" . route('admin.delivery-area.destroy', $query->id) . "' class='btn btn-danger delete-item ml-2'><i class='fas fa-trash-alt'></i></a>";
                }
                return $edit . $delete;
            })
            ->addColumn('delivery_fee', function ($query) {
                return currencyPosition($query->delivery_fee);
            })
            ->addColumn('status', function ($query) {
                if ($query->status === 1) {
                    return '<span class="badge badge-primary">Active</span>';
                } else {
                    return '<span class="badge badge-danger">Inactive</span>';
                }
            })
            ->rawColumns(['action', 'status'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<DeliveryArea>
     */
    public function query(DeliveryArea $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('deliveryarea-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(1)
            ->parameters([
                'scrollX' => true,
                'responsive' => true,
            ])
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [

            Column::make('id'),
            Column::make('area_name'),
            Column::make('delivery_fee'),
            Column::make('min_delivery_time'),
            Column::make('max_delivery_time'),
            Column::make('status'),

            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(150)
                ->addClass('text-center text-nowrap'),
        ];
    }


    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'DeliveryArea_' . date('YmdHis');
    }
}
