<div class="row">
    <div class="col-xs-12 form-group">
        {!! Form::label('available_qty', 'Available Quantity*', []) !!}
        @if(!$productOptions->isEmpty())
            {!! Form::text('available_qty', $product->stock->available_qty, ['class' => 'form-control', 'placeholder' => 'Product Available Quantity', 'disabled'=>'true']) !!}
        @else
            {!! Form::text('available_qty', $product->stock->available_qty, ['class' => 'form-control', 'placeholder' => 'Product Available Quantity']) !!}
        @endif
        @if(!$productOptions->isEmpty())<span class="text-danger">Note: Quantity is disabled. Total quantity is calculated by the sum of all the combinations.</span> @endif
        <p class="help-block"></p>
        @if($errors->has('available_qty'))
            <p class="help-block">
                {{ $errors->first('available_qty') }}
            </p>
        @endif
    </div>
    <div class="col-xs-12 form-group">
        {!! Form::label('minimum_order_qty', 'Minimum Order Quantity*', []) !!}
        @if(!$productOptions->isEmpty())
            {!! Form::text('minimum_order_qty', $product->stock->minimum_order_qty, ['class' => 'form-control', 'placeholder' => 'Minimum Order Quantity', 'disabled'=>'disable']) !!}
        @else
            {!! Form::text('minimum_order_qty', $product->stock->minimum_order_qty, ['class' => 'form-control', 'placeholder' => 'Minimum Order Quantity']) !!}
        @endif
        @if(!$productOptions->isEmpty())<span class="text-danger">Note: Quantity is disabled. Total quantity is calculated by the sum of all the combinations.</span> @endif
        <p class="help-block"></p>
        @if($errors->has('minimum_order_qty'))
            <p class="help-block">
                {{ $errors->first('minimum_order_qty') }}
            </p>
        @endif
    </div>
    <div class="col-xs-12 form-group">
        {!! Form::label('stock_status', 'Stock Status*', []) !!}
        @if(!$productOptions->isEmpty())
            {{ Form::select('stock_status', ['inStock'=> 'In Stock', 'outOfStock'=>'Out of Stock', 'pre-order'=>'Pre-Oder'],$product->stock->stock_status, ['id'=>'stock_status','required' => '', 'class' => 'form-control select2', 'style'=>'width: 100%', 'disabled'=>'disable']) }}
        @else
            {{ Form::select('stock_status', ['inStock'=> 'In Stock', 'outOfStock'=>'Out of Stock', 'pre-order'=>'Pre-Oder'],$product->stock->stock_status, ['id'=>'stock_status','required' => '', 'class' => 'form-control select2', 'style'=>'width: 100%']) }}
        @endif
        @if(!$productOptions->isEmpty())<span class="text-danger">Note: Quantity is disabled. Total quantity is calculated by the sum of all the combinations.</span> @endif
    </div>
    <div class="col-xs-12 form-group">
        {!! Form::label('price', 'Price*', []) !!}
        @if(!$productOptions->isEmpty())
            {!! Form::text('price',$product->stock->price, ['class' => 'form-control ', 'placeholder' => 'Price', 'disabled'=>'disable']) !!}
        @else
            {!! Form::text('price',$product->stock->price, ['class' => 'form-control ', 'placeholder' => 'Price']) !!}
        @endif
        @if(!$productOptions->isEmpty())<span class="text-danger">Note: Price is disabled. Price is derived based on the combination.</span> @endif
        <p class="help-block"></p>
        @if($errors->has('price'))
            <p class="help-block">
                {{ $errors->first('price') }}
            </p>
        @endif
    </div>
    <div class="col-xs-12 form-group">
        {!! Form::label('subtract_stock', 'Subtract Stock*', []) !!}
        @if(!$productOptions->isEmpty())
            {{ Form::checkbox('subtract_stock', true, $product->stock->subtract_stock, ['id'=>'subtract_stock','class' => 'field', 'disabled'=> 'disable']) }}
        @else
            {{ Form::checkbox('subtract_stock', true, $product->stock->subtract_stock, ['id'=>'subtract_stock','class' => 'field']) }}
        @endif
    </div>
</div>
