<?php

namespace App\DataTables;

use Spatie\Permission\Models\Permission;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PermissionDataTable extends DataTable
{
    public function dataTable($query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($query) {
                $edit = "<a href='" . route('admin.permissions.edit', $query->id) . "' class='btn btn-primary'><i class='fas fa-pen'></i></a>";
                $delete = "<a href='" . route('admin.permissions.destroy', $query->id) . "' class='btn btn-danger delete-item ml-2'><i class='fas fa-trash-alt'></i></a>";
                return $edit . $delete;
            })
            ->addColumn('group_name', function ($query) {
                return '<span class="badge badge-info">' . str_replace('_', ' ', strtoupper($query->group_name)) . '</span>';
            })
            ->rawColumns(['action', 'group_name'])
            ->setRowId('id');
    }

    public function query(Permission $model)
    {
        return $model->newQuery();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()->setTableId('permission-table')->columns($this->getColumns())->minifiedAjax()->orderBy(0, 'asc')->parameters(['scrollX' => true,'responsive' => true]);
    }

    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('name'),
            Column::make('group_name')->title('Module Group'),
            Column::computed('action')->exportable(false)->printable(false)->width(150)->addClass('text-center text-nowrap'),
        ];
    }
}
