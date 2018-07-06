@inject('request', 'Illuminate\Http\Request')
@extends('admin.layouts.dashboard')

@section('content')
    <h3 class="page-title">Category</h3>
    <div style="display: inline-flex; flex-direction: row; align-items: flex-start; align-content: space-between">
        <p style="align-content: space-between">
            <a href="{{ route('admin.categories.create') }}" class="btn btn-success">Add New Category</a>
        </p>
    </div>



    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-hover table-bordered table-striped datatable text-center" style="width:100%">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Active</th>
                    <th>Action</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var table = undefined;
        $(document).ready(function () {
            table = $('.datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!!route('admin.datatable.categories')!!}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'is_active', name: 'is_active'},
                    {data: 'action', name: 'action'},
                ]
            });

            $("table").on('click', '#deleteBtn', function () {
//                e.preventDefault();

                var id = $(this).data('id');
                $.confirm({
                    title: 'Confirm!',
                    content: 'Delete Category',
                    buttons: {
                        confirm: function () {
                            $.ajax({
                                url: '/admin/categories/' + id,
                                type: 'DELETE',
                                dataType: 'json',
                                data: {method: '_DELETE', submit: true}
                            }).always(function (data) {
                                table.ajax.reload();
                            }).done(function (data) {
                                console.log(data);
                                noty({
                                    layout: 'bottomCenter',
                                    theme: 'relax',
                                    text: data.message,
                                    type: 'success',
                                    timeout: 2000
                                });
                            });
                        },
                        cancel: function () {

                        }
                    }
                });

            });
        });
    </script>
@endsection