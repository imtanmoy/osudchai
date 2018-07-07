<div class="row">
    <div class="col-xs-12 form-group">
        {!! Form::label('name', 'Name*', []) !!}
        {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => 'Product Name', 'required' => '']) !!}
        <p class="help-block"></p>
        @if($errors->has('name'))
            <p class="help-block">
                {{ $errors->first('name') }}
            </p>
        @endif
    </div>
    <div class="col-xs-12 form-group">
        {!! Form::label('sku', 'SKU*', []) !!}
        {!! Form::text('sku', old('sku'), ['class' => 'form-control', 'placeholder' => 'Product SKU', 'required' => '']) !!}
        <p class="help-block"></p>
        @if($errors->has('sku'))
            <p class="help-block">
                {{ $errors->first('sku') }}
            </p>
        @endif
    </div>
    <div class="col-xs-12 form-group">
        {!! Form::label('description', 'Description', []) !!}
        {!! Form::textarea('description', old('description'), ['class' => 'form-control', 'placeholder' => 'Product Description']) !!}
        <p class="help-block"></p>
        @if($errors->has('description'))
            <p class="help-block">
                {{ $errors->first('description') }}
            </p>
        @endif
    </div>
    <div class="col-xs-12 form-group">
        {!! Form::label('manufacturer_id', 'Manufacturer*', []) !!}
        {{ Form::select('manufacturer_id', $manufacturers,old('manufacturer_id'), ['id'=>'manufacturer_id','required' => '', 'class' => 'form-control select2', 'style'=>'width: 100%']) }}
        @if($errors->has('manufacturer_id'))
            <span class="help-block">
                {{ $errors->first('manufacturer_id') }}
            </span>
        @endif
    </div>
    <div class="col-xs-12 form-group">
        {!! Form::label('category_id', 'Category*', []) !!}
        {{ Form::select('category_id', $categories,old('category_id'), ['id'=>'category_id','required' => '', 'class' => 'form-control select2', 'style'=>'width: 100%']) }}
        @if($errors->has('category_id'))
            <span class="help-block">
                {{ $errors->first('category_id') }}
            </span>
        @endif
    </div>
</div>
