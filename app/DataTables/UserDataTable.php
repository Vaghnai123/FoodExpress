<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UserDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<User> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($query) {
                if ($query->id != 1) {
                    if (auth()->user()->can('edit admins')) {
                    $edit = "<a href='" . route('admin.admin-management.edit', $query->id) . "' class='btn btn-primary'><i class='fas fa-pen'></i></a>";
                    }
                    if (auth()->user()->can('delete admins')) {
                    $delete = "<a href='" . route('admin.admin-management.destroy', $query->id) . "' class='btn btn-danger delete-item ml-2'><i class='fas fa-trash-alt'></i></a>";
                    }
                    return $edit . $delete;
                }
                return '<span class="badge badge-danger">Not Editable</span>';
            })
            ->addColumn('role', function ($query) {
                $roleName = $query->roles->pluck('name')->first();

                if ($roleName) {
                    return '<span class="badge badge-info">' . $roleName . '</span>';
                } else {
                    return '<span class="badge badge-warning">No Role</span>';
                }
            })
            ->rawColumns(['action', 'role'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<User>
     */
    public function query(User $model): QueryBuilder
    {
        return $model->where('role', 'admin')->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('adminmanagement-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(0, 'asc')
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
            Column::make('name'),
            Column::make('email'),
            Column::make('role'),

            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(100)
                ->addClass('text-center text-nowrap'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'User_' . date('YmdHis');
    }
}
