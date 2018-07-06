@inject('request', 'Illuminate\Http\Request')
@extends('admin.layouts.dashboard')

@section('content')
    <h3 class="page-title">Product Type</h3>
    <p>
        <a href="{{ route('admin.product_types.create') }}" class="btn btn-success">@lang('global.app_add_new')</a>
    </p>

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
                    <th>Action</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
@stop

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
                ajax: '{!!route('admin.datatable.product_types')!!}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'action', name: 'action'},
                ]
            });

            $("table").on('click', '#deleteBtn', function () {
//                e.preventDefault();

                var id = $(this).data('id');
                $.confirm({
                    title: 'Confirm!',
                    content: 'Delete Product Type',
                    buttons: {
                        confirm: function () {
                            $.ajax({
                                url: '/admin/product_types/' + id,
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
