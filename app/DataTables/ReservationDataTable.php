<?php

namespace App\DataTables;

use App\Models\Reservation;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ReservationDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($query) {
                $delete = "<a href='" . route('admin.reservation.destroy', $query->id) . "' class='btn btn-danger delete-item ml-2'><i class='fas fa-trash-alt'></i></a>";

                return $delete;
            })
            ->addColumn('status', function ($query) {
                $bgColor = '';
                if ($query->status === 'pending') {
                    $bgColor = '#ffa426';
                } elseif ($query->status === 'approved') {
                    $bgColor = '#3abaf4';
                } elseif ($query->status === 'complete') {
                    $bgColor = '#63ed7a';
                } elseif ($query->status === 'cancel') {
                    $bgColor = '#fc544b';
                } else {
                    $bgColor = '#6777ef';
                }

                $html = '<div style="position: relative; display: inline-block;">';
                $html .= '<select class="reservation_status" data-id="' . $query->id . '"
                    style="background-color: ' . $bgColor . '; color: #ffffff; border: none; border-radius: 30px; padding: 6px 30px 6px 15px; font-weight: 600; font-size: 13px; cursor: pointer; outline: none; appearance: none; -webkit-appearance: none; -moz-appearance: none; box-shadow: 0 4px 8px ' . $bgColor . '40;">

                    <option style="color: #333; background: #fff;" ' . ($query->status === 'pending' ? 'selected' : '') . ' value="pending">pending</option>
                    <option style="color: #333; background: #fff;" ' . ($query->status === 'approved' ? 'selected' : '') . ' value="approved">approved</option>
                    <option style="color: #333; background: #fff;" ' . ($query->status === 'complete' ? 'selected' : '') . ' value="complete">completed</option>
                    <option style="color: #333; background: #fff;" ' . ($query->status === 'cancel' ? 'selected' : '') . ' value="cancel">cancelled</option>
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
     */
    public function query(Reservation $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('reservation-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(0)
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
            Column::make('reservation_id')->addClass('text-nowrap'),
            Column::make('name')->addClass('text-nowrap'),
            Column::make('phone')->addClass('text-nowrap'),
            Column::make('date')->addClass('text-nowrap'),
            Column::make('time')->addClass('text-nowrap'),
            Column::make('persons'),
            Column::make('status'),

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
        return 'Reservation_' . date('YmdHis');
    }
}
