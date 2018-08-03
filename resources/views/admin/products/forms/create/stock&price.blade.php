<div class="row">
    <div class="col-xs-12 form-group">
        {!! Form::label('available_qty', 'Available Quantity*', []) !!}
        {!! Form::text('available_qty', old('available_qty'), ['class' => 'form-control', 'placeholder' => 'Product Available Quantity']) !!}
        <p class="help-block"></p>
        @if($errors->has('available_qty'))
            <p class="help-block">
                {{ $errors->first('available_qty') }}
            </p>
        @endif
    </div>
    <div class="col-xs-12 form-group">
        {!! Form::label('minimum_order_qty', 'Minimum Order Quantity*', []) !!}
        {!! Form::text('minimum_order_qty', old('minimum_order_qty'), ['class' => 'form-control', 'placeholder' => 'Minimum Order Quantity']) !!}
        <p class="help-block"></p>
        @if($errors->has('minimum_order_qty'))
            <p class="help-block">
                {{ $errors->first('minimum_order_qty') }}
            </p>
        @endif
    </div>
    <div class="col-xs-12 form-group">
        <label for="stock_status">Stock Status</label>
        <select id="stock_status" name="stock_status"
                class="form-control select2 select2-hidden-accessible"
                style="width: 100%;" tabindex="-1" aria-hidden="true">
            <option value="inStock">In Stock</option>
            <option value="outOfStock">Out of Stock</option>
            <option value="pre-order">Pre-Oder</option>
        </select>
    </div>
    <div class="col-xs-12 form-group">
        {!! Form::label('price', 'Price*', []) !!}
        {!! Form::text('price', old('price'), ['class' => 'form-control ', 'placeholder' => 'Price']) !!}
        <p class="help-block"></p>
        @if($errors->has('price'))
            <p class="help-block">
                {{ $errors->first('price') }}
            </p>
        @endif
    </div>
    <div class="col-xs-12 form-group">
        <div class="checkbox">
            <label>
                <input id="subtract_stock" name="subtract_stock" type="checkbox"
                       value="true">
                Subtract Stock
            </label>
        </div>
    </div>
</div>
