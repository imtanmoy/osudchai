<div class="row">
    <div class="col-xs-12 form-group">
        <label for="productTypeSelect">Product Type</label>
        <select id="productTypeSelect" name="product_type_id" required
                class="form-control select2 select2-hidden-accessible"
                style="width: 100%;" tabindex="-1" aria-hidden="true">
            <option></option>
            @foreach($product_types as $product_type)
                <option value="{{$product_type->id}}">{{$product_type->name}}</option>
            @endforeach
        </select>
    </div>
    <div id="strengthDiv" class="col-xs-12 form-group">
        {!! Form::label('strength', 'Strength', []) !!}
        {!! Form::text('strength', old('strength'), ['class' => 'form-control typeahead', 'placeholder' => 'Product Strength']) !!}
        <p class="help-block"></p>
        @if($errors->has('strength'))
            <p class="help-block">
                {{ $errors->first('strength') }}
            </p>
        @endif
    </div>
    <div id="genericNameDiv" class="col-xs-12 form-group">
        {!! Form::label('generic_name', 'Generic Name', []) !!}
        {!! Form::text('generic_name', old('generic_name'), ['class' => 'form-control typeahead ', 'placeholder' => 'Product Generic Name']) !!}
        <p class="help-block"></p>
        @if($errors->has('generic_name'))
            <p class="help-block">
                {{ $errors->first('generic_name') }}
            </p>
        @endif
    </div>
</div>
