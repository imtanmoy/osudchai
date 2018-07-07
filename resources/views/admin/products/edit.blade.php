@extends('admin.layouts.dashboard')

@section('content')
    <h3 class="page-title">Product</h3>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{$product->name}}</h3>
                </div>
                <div class="box-body">
                    <!-- Custom Tabs -->
                    {!! Form::model($product, ['method' => 'PUT','files' => true, 'route' => ['admin.products.update', $product->id]]) !!}
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">General</a></li>
                            <li><a href="#tab_2" data-toggle="tab" aria-expanded="false">Product Info</a></li>
                            <li><a href="#tab_3" data-toggle="tab">Attributes</a></li>
                            <li><a href="#tab_4" data-toggle="tab">Stock & Price</a></li>
                            <li><a href="#tab_5" data-toggle="tab">Images</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">

                                <div class="row">
                                    <div class="{{$errors->has('name')? 'col-xs-12 form-group has-error': 'col-xs-12 form-group'}}">
                                        {!! Form::label('name', 'Name*', []) !!}
                                        {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                                        <p class="help-block"></p>
                                        @if($errors->has('name'))
                                            <p class="help-block">
                                                {{ $errors->first('name') }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="{{$errors->has('sku')? 'col-xs-12 form-group has-error': 'col-xs-12 form-group'}}">
                                        {!! Form::label('sku', 'SKU*', []) !!}
                                        {!! Form::text('sku', old('sku'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                                        <p class="help-block"></p>
                                        @if($errors->has('sku'))
                                            <p class="help-block">
                                                {{ $errors->first('sku') }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="{{$errors->has('description')? 'col-xs-12 form-group has-error': 'col-xs-12 form-group'}}">
                                        {!! Form::label('description', 'Description*', []) !!}
                                        {!! Form::textarea('description', old('description'), ['class' => 'form-control', 'placeholder' => '']) !!}
                                        <p class="help-block"></p>
                                        @if($errors->has('description'))
                                            <p class="help-block">
                                                {{ $errors->first('description') }}
                                            </p>
                                        @endif
                                    </div>

                                    <div class="{{$errors->has('manufacturer_id')? 'col-xs-12 form-group has-error': 'col-xs-12 form-group'}}">
                                        <label class="control-label" for="category">Manufacturer</label>
                                        {{ Form::select('manufacturer_id', $manufacturers,old('manufacturer_id'), ['id'=>'manufacturer_id','required' => '', 'class' => 'form-control select2','placeholder' => 'Pick a manufacturer_id...', 'style'=>'width: 100%']) }}
                                        @if($errors->has('manufacturer_id'))
                                            <span class="help-block">
                                                {{ $errors->first('manufacturer_id') }}
                                            </span>
                                        @endif
                                    </div>


                                    <div class="{{$errors->has('category_id')? 'col-xs-12 form-group has-error': 'col-xs-12 form-group'}}">
                                        <label class="control-label" for="category_id">Category</label>
                                        {{ Form::select('category_id', $categories,old('category_id'), ['id'=>'category_id','required' => '', 'class' => 'form-control select2','placeholder' => 'Pick a Category...', 'style'=>'width: 100%']) }}
                                        @if($errors->has('category_id'))
                                            <span class="help-block">
                                                {{ $errors->first('category_id') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                            </div>
                            <div class="tab-pane" id="tab_2">
                                <div class="row">
                                    <div class="{{$errors->has('product_type_id')? 'col-xs-12 form-group has-error': 'col-xs-12 form-group'}}">
                                        <label class="control-label" for="product_type_id">Product Type</label>
                                        {{ Form::select('product_type_id', $product_types,old('product_type_id'), [ 'style'=>'width: 100%', 'id'=>'product_type_id','required' => '', 'class' => 'form-control select2','placeholder' => 'Pick a Category...']) }}
                                        @if($errors->has('product_type_id'))
                                            <span class="help-block">
                                                {{ $errors->first('product_type_id') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div id="strengthDiv"
                                         class="{{$errors->has('strength')? 'col-xs-12 form-group has-error': 'col-xs-12 form-group'}}">

                                        {!! Form::label('strength', 'Strength*', []) !!}
                                        {!! Form::text('strength', $product->strength, ['class' => 'form-control typeahead', 'placeholder' => '']) !!}
                                        <p class="help-block"></p>
                                        @if($errors->has('strength'))
                                            <p class="help-block">
                                                {{ $errors->first('strength') }}
                                            </p>
                                        @endif
                                    </div>
                                    <div id="genericNameDiv"
                                         class="{{$errors->has('genericName')? 'col-xs-12 form-group has-error': 'col-xs-12 form-group'}}">
                                        {!! Form::label('generic_name', 'Generic Name*', []) !!}
                                        {!! Form::text('generic_name',  $product->generic_name->name, ['class' => 'form-control typeahead ', 'placeholder' => '']) !!}
                                        <p class="help-block"></p>
                                        @if($errors->has('genericName'))
                                            <p class="help-block">
                                                {{ $errors->first('genericName') }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_3">
                                <div class="row box-body">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Attribute Name</th>
                                            <th>Attribute Value</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody id="attributeTable">
                                        </tbody>
                                    </table>

                                </div>
                                <div class="box-footer clearfix">
                                    <button id="addAttribute" class="btn btn-primary pull-right">+Add</button>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_4">
                                <div class="row">
                                    <div class="{{$errors->has('available_qty')? 'col-xs-12 form-group has-error': 'col-xs-12 form-group'}}">
                                        {!! Form::label('available_qty', 'Available Quantity*', []) !!}
                                        {!! Form::text('available_qty', $product->stock->available_qty, ['class' => 'form-control', 'placeholder' => '']) !!}
                                        <p class="help-block"></p>
                                        @if($errors->has('available_qty'))
                                            <p class="help-block">
                                                {{ $errors->first('available_qty') }}
                                            </p>
                                        @endif
                                    </div>

                                    <div class="{{$errors->has('stock_status')? 'col-xs-12 form-group has-error': 'col-xs-12 form-group'}}">
                                        <label class="control-label" for="stock_status">Product Type</label>
                                        {{ Form::select('stock_status', [
                                        'inStock'=> 'In Stock',
                                        'outOfStock'=> 'Out of Stock',
                                        'pre-order'=> 'Pre-Oder'
                                        ],$product->stock->stock_status, [ 'style'=>'width: 100%', 'id'=>'stock_status','required' => '', 'class' => 'form-control select2','placeholder' => 'Pick a stock_status...']) }}
                                        @if($errors->has('stock_status'))
                                            <span class="help-block">
                                                {{ $errors->first('stock_status') }}
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-xs-12 form-group">
                                        {!! Form::label('minimum_order_qty', 'Minimum Order Quantity*', []) !!}
                                        {!! Form::text('minimum_order_qty', $product->stock->minimum_order_qty, ['class' => 'form-control', 'placeholder' => '']) !!}
                                        <p class="help-block"></p>
                                        @if($errors->has('minimum_order_qty'))
                                            <p class="help-block">
                                                {{ $errors->first('minimum_order_qty') }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="{{$errors->has('price')? 'col-xs-12 form-group has-error': 'col-xs-12 form-group'}}">
                                        {!! Form::label('price', 'Price*', []) !!}
                                        {!! Form::text('price', $product->price, ['class' => 'form-control ', 'placeholder' => '']) !!}
                                        <p class="help-block"></p>
                                        @if($errors->has('price'))
                                            <p class="help-block">
                                                {{ $errors->first('price') }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 form-group">
                                            {!! Form::label('is_active', 'Active', ['class' => 'control-label']) !!}
                                            @if($product->is_active == 0)
                                                {!! Form::checkbox('is_active', 1, false) !!}
                                            @else
                                                {!! Form::checkbox('is_active', 0, true) !!}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_5">
                                <div class="row">
                                    <div class="col-xs-12 form-group">
                                        <label for="featuredImg">Featured Image</label>
                                        <input type="file" name="featuredImg" id="featuredImg">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 form-group">
                                        <label for="otherImgs">Other Images</label>
                                        <input type="file" name="images[]" id="otherImgs" multiple>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {!! Form::submit(trans('global.app_save'), ['class' => 'btn btn-danger']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')
    <script>
        $(document).ready(function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            var $strengthDiv = $('#strengthDiv');
            var $addAttribute = $('#addAttribute');
            var $attributeTable = $('#attributeTable');


            var genericNameAutoComplete = "{{ route('admin.ganeric_name_autocomplete') }}";
            var strengthAutoComplete = "{{ route('admin.strength_autocomplete') }}";


            $('.select2').select2({
                placeholder: 'Select an option'
            });


            var rowCount = 0;
            $addAttribute.click(function (e) {
                rowCount++;
                e.preventDefault();
                $(
                    '<tr>\n' +
                    '<td><input class="form-control" name="attribute_name[' + rowCount + ']" placeholder="Attribute Name" id="vvvv"></td>\n' +
                    '<td><input class="form-control" name="attribute_value[' + rowCount + ']" placeholder="Attribute Value"></td>\n' +
                    '<td class="text-center"><input data-id="' + rowCount + '" type="button" id="rowDel" class="btn btn-danger btn-sm" value="Delete"></td>\n' +
                    '</tr>'
                ).appendTo($attributeTable);
            });

            $attributeTable.on("click", "#rowDel", function (e) {
//                console.log(e);
//                console.log($(this).attr("data-id"));
                $(this).parents("td").parent('tr').remove();
            });


            $('input#generic_name').typeahead({
                source: function (query, process) {
                    return $.get(genericNameAutoComplete, {query: query}, function (data) {
                        return process(data);
                    });
                }
            });
            $('input#strength').typeahead({
                source: function (query, process) {
                    // console.log('aaaa');
                    return $.get(strengthAutoComplete, {query: query}, function (data) {
                        // console.log(data);
                        return process(data);
                    });
                }
            });

            $('form').submit(function (e) {
                console.log($(this).serializeArray());
                //  console.log($(this).serialize());

                //console.log(this);

                var formData = new FormData(this);

                console.log(formData);

                $.ajax({
                    type: 'POST',
                    url: '{{url('/admin/products/'.$product->id)}}',
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    enctype: 'multipart/form-data',
                    cache: false,
                    data: formData
                })
                    .done(function (data) {
                        console.log(data);
                        {{--window.location.href = '{{route('admin.products.index')}}';--}}
                    }).fail(function () {
                    alert("error");
                });

                e.preventDefault();
            });
        });
    </script>


@endsection

