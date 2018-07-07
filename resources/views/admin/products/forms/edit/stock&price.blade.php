<div class="row">
    <div class="col-xs-12 form-group">
        {!! Form::label('available_qty', 'Available Quantity*', []) !!}
        {!! Form::text('available_qty', $product->stock->available_qty, ['class' => 'form-control', 'placeholder' => 'Product Available Quantity', 'required'=>'']) !!}
        <p class="help-block"></p>
        @if($errors->has('available_qty'))
            <p class="help-block">
                {{ $errors->first('available_qty') }}
            </p>
        @endif
    </div>
    <div class="col-xs-12 form-group">
        {!! Form::label('minimum_order_qty', 'Minimum Order Quantity*', []) !!}
        {!! Form::text('minimum_order_qty', $product->stock->minimum_order_qty, ['class' => 'form-control', 'placeholder' => 'Minimum Order Quantity', 'required'=>'']) !!}
        <p class="help-block"></p>
        @if($errors->has('minimum_order_qty'))
            <p class="help-block">
                {{ $errors->first('minimum_order_qty') }}
            </p>
        @endif
    </div>
    <div class="col-xs-12 form-group">
        {!! Form::label('stock_status', 'Stock Status*', []) !!}
        {{ Form::select('stock_status', ['inStock'=> 'In Stock', 'outOfStock'=>'Out of Stock', 'pre-order'=>'Pre-Oder'],$product->stock->stock_status, ['id'=>'stock_status','required' => '', 'class' => 'form-control select2', 'style'=>'width: 100%']) }}
    </div>
    <div class="col-xs-12 form-group">
        {!! Form::label('price', 'Price*', []) !!}
        {!! Form::text('price', old('price'), ['class' => 'form-control ', 'placeholder' => 'Price', 'required'=>'']) !!}
        <p class="help-block"></p>
        @if($errors->has('price'))
            <p class="help-block">
                {{ $errors->first('price') }}
            </p>
        @endif
    </div>
    <div class="col-xs-12 form-group">
        {!! Form::label('subtract_stock', 'Subtract Stock*', []) !!}
        {{ Form::checkbox('subtract_stock', true, $product->stock->subtract_stock, ['id'=>'subtract_stock','class' => 'field']) }}
    </div>
</div>
