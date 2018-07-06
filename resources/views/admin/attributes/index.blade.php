@inject('request', 'Illuminate\Http\Request')
@extends('admin.layouts.dashboard')

@section('content')
    <h3 class="page-title">Attributes</h3>
    <p>
        <a href="{{ route('admin.attributes.create') }}" class="btn btn-success">@lang('global.app_add_new')</a>
    </p>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_list')
        </div>

        <div class="panel-body table-responsive">
            {{--<table class="table table-bordered table-striped {{ count($attributes) > 0 ? 'datatable' : '' }} dt-select">--}}
            {{--<thead>--}}
            {{--<tr>--}}
            {{--<th style="text-align:center;"><input type="checkbox" id="select-all" /></th>--}}
            {{--<th>Name</th>--}}
            {{--<th>&nbsp;</th>--}}
            {{--</tr>--}}
            {{--</thead>--}}

            {{--<tbody>--}}
            {{--@if (count($attributes) > 0)--}}
            {{--@foreach ($attributes as $attribute)--}}
            {{--<tr data-entry-id="{{ $attribute->id }}">--}}
            {{--<td></td>--}}
            {{--<td>{{ $attribute->name }}</td>--}}
            {{--<td>--}}
            {{--<a href="{{ route('admin.attributes.edit',[$attribute->id]) }}" class="btn btn-xs btn-info">@lang('global.app_edit')</a>--}}
            {{--{!! Form::open(array(--}}
            {{--'style' => 'display: inline-block;',--}}
            {{--'method' => 'DELETE',--}}
            {{--'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",--}}
            {{--'route' => ['admin.attributes.destroy', $attribute->id])) !!}--}}
            {{--{!! Form::submit(trans('global.app_delete'), array('class' => 'btn btn-xs btn-danger')) !!}--}}
            {{--{!! Form::close() !!}--}}
            {{--</td>--}}
            {{--</tr>--}}
            {{--@endforeach--}}
            {{--@else--}}
            {{--<tr>--}}
            {{--<td colspan="6">@lang('global.app_no_entries_in_table')</td>--}}
            {{--</tr>--}}
            {{--@endif--}}
            {{--</tbody>--}}
            {{--</table>--}}
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
                ajax: '{!!route('admin.datatable.attributes')!!}',
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
                    content: 'Delete Attribute',
                    buttons: {
                        confirm: function () {
                            $.ajax({
                                url: '/admin/attributes/' + id,
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
