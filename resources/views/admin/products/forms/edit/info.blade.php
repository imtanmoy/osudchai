<div class="row">
    <div class="col-xs-12 form-group">
        {!! Form::label('product_type_id', 'Product Type*', []) !!}
        {{ Form::select('product_type_id', $product_types,$product->product_type->id, ['id'=>'product_type_id','required' => '', 'class' => 'form-control select2', 'style'=>'width: 100%']) }}
        @if($errors->has('product_type_id'))
            <span class="help-block">
                {{ $errors->first('product_type_id') }}
            </span>
        @endif
    </div>
    <div id="strengthDiv" class="col-xs-12 form-group">
        {!! Form::label('strength', 'Strength', []) !!}
        {!! Form::text('strength', $product->strength->value, ['class' => 'form-control typeahead', 'placeholder' => 'Product Strength']) !!}
        <p class="help-block"></p>
        @if($errors->has('strength'))
            <p class="help-block">
                {{ $errors->first('strength') }}
            </p>
        @endif
    </div>
    <div id="genericNameDiv" class="col-xs-12 form-group">
        {!! Form::label('generic_name', 'Generic Name', []) !!}
        {!! Form::text('generic_name', $product->generic_name->name, ['class' => 'form-control typeahead ', 'placeholder' => 'Product Generic Name']) !!}
        <p class="help-block"></p>
        @if($errors->has('generic_name'))
            <p class="help-block">
                {{ $errors->first('generic_name') }}
            </p>
        @endif
    </div>
</div>
