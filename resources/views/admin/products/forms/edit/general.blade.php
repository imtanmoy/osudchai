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
        {!! Form::label('manufacturer', 'Manufacturer*', []) !!}
        {{ Form::select('manufacturer', $manufacturers, $product->manufacturer->id, ['id'=>'manufacturer','required' => '', 'class' => 'form-control select2', 'style'=>'width: 100%']) }}
        @if($errors->has('manufacturer'))
            <span class="help-block">
                {{ $errors->first('manufacturer') }}
            </span>
        @endif
    </div>
    <div class="col-xs-12 form-group">
        {!! Form::label('category', 'Category*', []) !!}
        {{ Form::select('category', $categories, $product->category->id, ['id'=>'category','required' => '', 'class' => 'form-control select2', 'style'=>'width: 100%']) }}
        @if($errors->has('category'))
            <span class="help-block">
                {{ $errors->first('category') }}
            </span>
        @endif
    </div>
</div>
