<?php

namespace App\DataTables;

use Spatie\Permission\Models\Role;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class RoleDataTable extends DataTable
{
    public function dataTable($query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($query) {
                if ($query->name !== 'Super Admin') {
                    if (auth()->user()->can('edit roles')) {
                    $edit = "<a href='" . route('admin.roles.edit', $query->id) . "' class='btn btn-primary'><i class='fas fa-pen'></i></a>";
                    }
                    if (auth()->user()->can('delete roles')) {
                    $delete = "<a href='" . route('admin.roles.destroy', $query->id) . "' class='btn btn-danger delete-item ml-2'><i class='fas fa-trash-alt'></i></a>";
                    }
                    return $edit . $delete;
                }
                return '<span class="badge badge-danger">Not Editable</span>';
            })
            ->addColumn('permissions', function ($query) {
                if ($query->name === 'Super Admin') return '<span class="badge badge-success">All Permissions</span>';
                return $query->permissions->count() > 0 ? '<span class="badge badge-primary">' . $query->permissions->count() . ' Permissions</span>' : '<span class="badge badge-warning">No Permissions</span>';
            })
            ->rawColumns(['action', 'permissions'])
            ->setRowId('id');
    }

    public function query(Role $model)
    {
        return $model->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()->setTableId('role-table')->columns($this->getColumns())->minifiedAjax()->orderBy(0, 'asc')->parameters(['scrollX' => true,'responsive' => true]);
    }

    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('name'),
            Column::make('permissions'),
            Column::computed('action')->exportable(false)->printable(false)->width(150)->addClass('text-center text-nowrap'),
        ];
    }
}
