<?php

namespace App\DataTables;

use App\User;
use Yajra\DataTables\Services\DataTable;

class userDatatable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)
            ->addColumn('edit', 'admin.users.btn.edit')
            ->addColumn('delete', 'admin.users.btn.delete')
            ->addColumn('checkbox', 'admin.users.btn.checkbox')
            ->addColumn('level', 'admin.users.btn.level')
            ->rawColumns(['edit','delete','checkbox','level']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return User::query()->where(function ($q){
            if(request()->has('level')){
                $q->where('level',request('level'));
            }
        });
    }




    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->columns($this->getColumns())
                    ->minifiedAjax()

//                    ->addAction(['width' => '80px'])
//                    ->parameters($this->getBuilderParameters());
            ->parameters([
                'dom'        => 'Blfrtip',
                'lengthMenu' => [[10, 25, 50, 100], [10, 25, 50, 'All Record']],
                'buttons'    => [
                    ['extend' => 'print', 'className' => 'btn btn-danger', 'text' => '<i class="fa fa-print">'. __("admin.pdf") .'</i>'],
                    ['extend' => 'csv', 'className' => 'btn btn-info', 'text' => '<i class="fa fa-file">'.__("admin.csv") .'</i> '],
                    ['extend' => 'excel', 'className' => 'btn btn-success', 'text' => '<i class="fa fa-file">'.__("admin.excel") .'</i> '],
                    ['extend' => 'reload', 'className' => 'btn btn-default', 'text' => '<i class="fa fa-refresh"></i>'],
                    ['className' => 'btn btn-danger delBtn' , 'text' => '<i class="fa fa-trash">'.__('admin.delete').'</i>'],
                    ['className' => 'btn btn-primary add_member' , 'text' => '<i class="fa fa-plus">'.__("admin.add").'</i>'],

                ],
//                'initComplete'=>'function () {
//                  this.api().columns().every(function () {
//                  var column = this;
//                  var input = document.createElement("input");
//                 $(input).appendTo($(column.footer()).empty())
//                   .on(\'keyup\', function () {
//                    var val = $.fn.dataTable.util.escapeRegex($(this).val());
//                    column.search(val ? val : \'\', true, false).draw();
//                });
//            });
//        }',
         'language'=>datatable_language()


            ]);

    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            [
                'title'=>'<input id="check_all" type="checkbox" class="check_all">',
                'name'=>'checkbox',
                'data'=>'checkbox',
                'printable'=>false,
                'searchable'=>false,
                'exportable'=>false,
                'orderable'=>false
            ],
            [
                'title'=>'#',
                'name'=>'id',
                'data'=>'id',
            ],

            [
                'title'=>__('admin.name'),
                'name'=>'name',
                'data'=>'name',
            ],

            [
                'title'=>__('admin.email'),
                'name'=>'email',
                'data'=>'email',
            ],
            [
                'title'=>__('admin.level'),
                'name'=>'level',
                'data'=>'level',
            ],
            [
                'title'=>__('admin.created_at'),
                'name'=>'created_at',
                'data'=>'created_at',
            ],

            [
                'title'=>__('admin.updated_at'),
                'name'=>'updated_at',
                'data'=>'updated_at',
            ],


            [
                'title'=>__('admin.edit'),
                'name'=>'edit',
                'data'=>'edit',
                'printable'=>false,
                'searchable'=>false,
                'exportable'=>false,
                'orderable'=>false
            ],
            [
                'title'=>__('admin.delete'),
                'name'=>'delete',
                'data'=>'delete',
                'printable'=>false,
                'searchable'=>false,
                'exportable'=>false,
                'orderable'=>false
            ],


        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'admin_' . date('YmdHis');
    }
}
