@inject('request', 'Illuminate\Http\Request')
@extends('admin.layouts.dashboard')

@section('content')
    <h3 class="page-title">@lang('global.manufacturer.title')</h3>
    <p>
        <a href="{{ route('admin.manufacturers.create') }}" class="btn btn-success">@lang('global.app_add_new')</a>
    </p>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($manufacturers) > 0 ? 'datatable' : '' }} dt-select">
                <thead>
                    <tr>
                        <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>

                <tbody>
                    @if (count($manufacturers) > 0)
                        @foreach ($manufacturers as $manufacturer)
                            <tr data-entry-id="{{ $manufacturer->id }}">
                                <td></td>
                                <td>{{ $manufacturer->name }}</td>
                                <td>{{ $manufacturer->phone }}</td>
                                <td>{{ $manufacturer->email }}</td>
                                <td>{{ $manufacturer->address }}</td>
                                <td>
                                    <a href="{{ route('admin.manufacturers.edit',[$manufacturer->id]) }}" class="btn btn-xs btn-info">@lang('global.app_edit')</a>
                                    {!! Form::open(array(
                                        'style' => 'display: inline-block;',
                                        'method' => 'DELETE',
                                        'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                        'route' => ['admin.manufacturers.destroy', $manufacturer->id])) !!}
                                    {!! Form::submit(trans('global.app_delete'), array('class' => 'btn btn-xs btn-danger')) !!}
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6">@lang('global.app_no_entries_in_table')</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('javascript')
    <script>
        {{--window.route_mass_crud_entries_destroy = '{{ route('admin.roles.mass_destroy') }}';--}}
    </script>
@endsection
