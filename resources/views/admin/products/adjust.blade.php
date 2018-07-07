@extends('admin.layouts.dashboard')

@section('content')
    <h3 class="page-title">{{$product->name}}</h3>
    {!! Form::open(['method' => 'POST', 'route' => ['admin.products.updateAdjust', $product->id]]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            Update Stock And Price
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('available_qty', 'Available Qty*', ['class' => 'control-label']) !!}
                    {!! Form::text('available_qty', $product->stock->available_qty, ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('available_qty'))
                        <p class="help-block">
                            {{ $errors->first('available_qty') }}
                        </p>
                    @endif
                </div>
                <div class="col-xs-12 form-group">
                    <label>Stock Status</label>
                    {!!Form::select('stock_status', ['inStock' => 'In Stock', 'outOfStock' => 'Out of Stock', 'pre-order'=>
                    'Pre-Oder'], $product->stock->stock_status, ['class'=>'form-control select2 select2-hidden-accessible', 'style'=> 'width: 100%;', 'tabindex'=>'-1']) !!}
                </div>
                <div class="col-xs-12 form-group">
                    {!! Form::label('price', 'Price*', ['class' => 'control-label']) !!}
                    {!! Form::text('price', $product->price, ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('price'))
                        <p class="help-block">
                            {{ $errors->first('price') }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {!! Form::submit(trans('global.app_save'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@endsection

@section('javascript')
    <script>
        $(document).ready(function () {
            $('.select2').select2({
                placeholder: 'Select an option'
            });
        });
    </script>

@endsection

