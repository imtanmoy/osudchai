<div class="row">
    <div class="col-xs-12 form-group">
        {!! Form::label('name', 'Name*', []) !!}
        {!! Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'Product Name', 'required' => '']) !!}
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
        <label for="manufactureSelect">Manufacturer</label>
        <select id="manufactureSelect" required name="manufacturer"
                class="form-control select2 select2-hidden-accessible"
                style="width: 100%;" tabindex="-1" aria-hidden="true">
            <option></option>
            @foreach($manufacturers as $manufacturer)
                <option value="{{$manufacturer->id}}">{{$manufacturer->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-xs-12 form-group">
        <label for="categorySelect">Category</label>
        <select id="categorySelect" name="category" required
                class="form-control select2 select2-hidden-accessible"
                style="width: 100%;" tabindex="-1" aria-hidden="true">
            <option></option>
            @foreach($categories as $category)
                <option value="{{$category->id}}">{{$category->name}}</option>
            @endforeach
        </select>
    </div>
</div>
