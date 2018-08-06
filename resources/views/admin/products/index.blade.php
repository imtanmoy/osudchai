@inject('request', 'Illuminate\Http\Request')
@extends('admin.layouts.dashboard')

@section('content')
    <h3 class="page-title">Product List</h3>
    <p>
        <a href="{{ route('admin.products.create') }}" class="btn btn-success">@lang('global.app_add_new')</a>
    </p>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped {{ count($products) > 0 ? 'datatable' : '' }} dt-select">
                <thead>
                <tr>
                    <th style="text-align:center;"><input type="checkbox" id="select-all"/></th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Status</th>
                    <th>&nbsp;</th>
                </tr>
                </thead>

                <tbody>
                @if (count($products) > 0)
                    @foreach ($products as $product)
                        <tr data-entry-id="{{ $product->id }}">
                            <td></td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->stock->available_qty }}</td>
                            <td>{{ $product->is_active }}</td>
                            <td>
                                {{--<a href="{{ route('admin.products.adjust',[$product->id]) }}" class="btn btn-xs btn-info">Update Stock and Price</a>--}}
                                <a href="{{ route('admin.products.edit',[$product->id]) }}"
                                   class="btn btn-primary btn-sm">@lang('global.app_edit')</a>
                                {!! Form::open(array(
                                    'style' => 'display: inline-block;',
                                    'method' => 'DELETE',
                                    'onsubmit' => "return confirm('".trans("global.app_are_you_sure")."');",
                                    'route' => ['admin.products.destroy', $product->id])) !!}
                                {!! Form::submit(trans('global.app_delete'), array('class' => 'btn btn-sm btn-danger')) !!}
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