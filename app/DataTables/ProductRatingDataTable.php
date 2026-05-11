<?php

namespace App\DataTables;

use App\Models\ProductRating;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ProductRatingDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<ProductRating> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($query) {
                $delete = "<a href='" . route('admin.product-reviews.destroy', $query->id) . "' class='btn btn-danger delete-item ml-2'><i class='fas fa-trash-alt'></i></a>";

                return $delete;
            })
            ->addColumn('user_name', function ($query) {
                return $query->user->name;
            })
            ->addColumn('product', function ($query) {
                return $query->product->name;
            })
            ->addColumn('status', function ($query) {
                $bgColor = '';
                if ($query->status == 0) {
                    $bgColor = '#ffa426';
                } elseif ($query->status == 1) {
                    $bgColor = '#3abaf4';
                } else {
                    $bgColor = '#6777ef';
                }

                $html = '<div style="position: relative; display: inline-block;">';
                $html .= '<select class="review_status" data-id="' . $query->id . '"
                    style="background-color: ' . $bgColor . '; color: #ffffff; border: none; border-radius: 30px; padding: 6px 30px 6px 15px; font-weight: 600; font-size: 13px; cursor: pointer; outline: none; appearance: none; -webkit-appearance: none; -moz-appearance: none; box-shadow: 0 4px 8px ' . $bgColor . '40;">

                    <option style="color: #333; background: #fff;" ' . ($query->status == 0 ? 'selected' : '') . ' value="0">Pending</option>
                    <option style="color: #333; background: #fff;" ' . ($query->status == 1 ? 'selected' : '') . ' value="1">Approved</option>
                </select>';
                $html .= '<i class="fas fa-chevron-down" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: white; font-size: 10px; pointer-events: none;"></i>';
                $html .= '</div>';

                return $html;
            })
            ->rawColumns(['status', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<ProductRating>
     */
    public function query(ProductRating $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('productrating-table')
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
            Column::make('user_name'),
            Column::make('product'),
            Column::make('rating'),
            Column::make('review'),
            Column::make('status')->width(100),

            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center text-nowrap'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'ProductRating_' . date('YmdHis');
    }
}
