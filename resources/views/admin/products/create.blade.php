@extends('admin.layouts.dashboard')

@section('content')
    <h3 class="page-title">Product</h3>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Quick Example</h3>
                </div>
                <div class="box-body">
                    <!-- Custom Tabs -->
                    {!! Form::open(['method' => 'POST','files' => true, 'route' => ['admin.products.store']]) !!}
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">General</a></li>
                            <li><a href="#tab_2" data-toggle="tab" aria-expanded="false">Product Info</a></li>
                            <li><a href="#tab_3" data-toggle="tab">Attributes</a></li>
                            <li><a href="#tab_4" data-toggle="tab">Stock & Price</a></li>
                            {{--<li><a href="#tab_5" data-toggle="tab">Discount</a></li>--}}
                            <li><a href="#tab_6" data-toggle="tab">Images</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">


                                {{--<div class="panel panel-default">--}}
                                {{--<div class="panel-heading">--}}
                                {{--@lang('global.app_create')--}}
                                {{--</div>--}}

                                {{--<div class="panel-body">--}}
                                <div class="row">
                                    <div class="col-xs-12 form-group">
                                        {!! Form::label('name', 'Name*', []) !!}
                                        {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                                        <p class="help-block"></p>
                                        @if($errors->has('name'))
                                            <p class="help-block">
                                                {{ $errors->first('name') }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="col-xs-12 form-group">
                                        {!! Form::label('sku', 'SKU*', []) !!}
                                        {!! Form::text('sku', old('sku'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                                        <p class="help-block"></p>
                                        @if($errors->has('sku'))
                                            <p class="help-block">
                                                {{ $errors->first('sku') }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="col-xs-12 form-group">
                                        {!! Form::label('description', 'Description*', []) !!}
                                        {!! Form::textarea('description', old('description'), ['class' => 'form-control', 'placeholder' => '']) !!}
                                        <p class="help-block"></p>
                                        @if($errors->has('description'))
                                            <p class="help-block">
                                                {{ $errors->first('description') }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="col-xs-12 form-group">
                                        <label>Manufacturer</label>
                                        <select id="manufactureSelect" required name="manufacturer_id"
                                                class="form-control select2 select2-hidden-accessible"
                                                style="width: 100%;" tabindex="-1" aria-hidden="true">
                                            <option></option>
                                            @foreach($manufacturers as $manufacturer)
                                                <option value="{{$manufacturer->id}}">{{$manufacturer->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-xs-12 form-group">
                                        <label>Category</label>
                                        <select id="categorySelect" name="category_id" required
                                                class="form-control select2 select2-hidden-accessible"
                                                style="width: 100%;" tabindex="-1" aria-hidden="true">
                                            <option></option>
                                            @foreach($categories as $category)
                                                <option value="{{$category->id}}">{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    {{--<div class="col-xs-12 form-group">--}}
                                        {{--<label>Sub-Category</label>--}}
                                        {{--<select id="subCategorySelect" data-placeholder="Select a Category" required--}}
                                                {{--name="subCategory_id"--}}
                                                {{--class="form-control select2 select2-hidden-accessible"--}}
                                                {{--style="width: 100%;" tabindex="-1" aria-hidden="true">--}}
                                            {{--<option></option>--}}
                                        {{--</select>--}}
                                    {{--</div>--}}
                                </div>
                                {{--</div>--}}
                                {{--</div>--}}

                            </div>
                            <div class="tab-pane" id="tab_2">
                                <div class="row">
                                    <div class="col-xs-12 form-group">
                                        <label>Product Type</label>
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
                                        {!! Form::label('strength', 'Strength*', []) !!}
                                        {!! Form::text('strength', old('strength'), ['class' => 'form-control typeahead', 'placeholder' => '']) !!}
                                        <p class="help-block"></p>
                                        @if($errors->has('strength'))
                                            <p class="help-block">
                                                {{ $errors->first('strength') }}
                                            </p>
                                        @endif
                                    </div>
                                    <div id="genericNameDiv" class="col-xs-12 form-group">
                                        {!! Form::label('generic_name', 'Generic Name*', []) !!}
                                        {!! Form::text('generic_name', old('generic_name'), ['class' => 'form-control typeahead ', 'placeholder' => '']) !!}
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
                                    <div class="col-xs-12 form-group">
                                        {!! Form::label('available_qty', 'Available Quantity*', []) !!}
                                        {!! Form::text('available_qty', old('available_qty'), ['class' => 'form-control', 'placeholder' => '']) !!}
                                        <p class="help-block"></p>
                                        @if($errors->has('available_qty'))
                                            <p class="help-block">
                                                {{ $errors->first('available_qty') }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="col-xs-12 form-group">
                                        {!! Form::label('minimum_order_qty', 'Minimum Order Quantity*', []) !!}
                                        {!! Form::text('minimum_order_qty', old('minimum_order_qty'), ['class' => 'form-control', 'placeholder' => '']) !!}
                                        <p class="help-block"></p>
                                        @if($errors->has('minimum_order_qty'))
                                            <p class="help-block">
                                                {{ $errors->first('minimum_order_qty') }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="col-xs-12 form-group">
                                        <label>Stock Status</label>
                                        <select id="stock_status" name="stock_status" required
                                                class="form-control select2 select2-hidden-accessible"
                                                style="width: 100%;" tabindex="-1" aria-hidden="true">
                                            <option value="inStock">In Stock</option>
                                            <option value="outOfStock">Out of Stock</option>
                                            <option value="pre-order">Pre-Oder</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-12 form-group">
                                        {!! Form::label('price', 'Price*', []) !!}
                                        {!! Form::text('price', old('price'), ['class' => 'form-control ', 'placeholder' => '']) !!}
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
                            </div>
                            {{--<div class="tab-pane" id="tab_5">--}}
                                {{--@include('admin.products.discount')--}}
                            {{--</div>--}}
                            <div class="tab-pane" id="tab_6">
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

            //Date picker
            $('#datepicker').datepicker({
                autoclose: true
            });
            $('#datepicker1').datepicker({
                autoclose: true
            });
//            $('#subCategorySelect').select2();
//            $('#manufactureSelect').on('select2:select', function (e) {
//                console.log("change", e);
//            });

            {{--$('#categorySelect').on('change', function () {--}}
                {{--console.log(this.value);--}}
                {{--$.ajax({--}}
                    {{--type: 'GET',--}}
                    {{--url: '{{url('/api/category')}}/' + this.value,--}}
                    {{--dataType: 'json',--}}
                {{--})--}}
                    {{--.done(function (data) {--}}
{{--//                        console.log(data);--}}
                        {{--var category = data;--}}
                        {{--$subCategorySelect.empty();--}}
                        {{--var optionsAsString = "";--}}
                        {{--for (var i = 0; i < category.sub_categories.length; i++) {--}}
                            {{--optionsAsString += "<option value='" + category.sub_categories[i].id + "'>" + category.sub_categories[i].name + "</option>";--}}
                        {{--}--}}
                        {{--$subCategorySelect.append(optionsAsString);--}}
                        {{--$subCategorySelect.prop("disabled", false);--}}
                    {{--});--}}
            {{--});--}}


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
                    // console.log('aaaa');
                    return $.get(genericNameAutoComplete, {query: query}, function (data) {
                        // console.log(data);
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
                    url: '{{url('/admin/products')}}',
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    enctype: 'multipart/form-data',
                    cache: false,
                    data: formData
                })
                    .done(function (data) {
                        console.log(data);
                        window.location.href = '{{route('admin.products.index')}}';
                    });

                e.preventDefault();
            });
        });
    </script>


@endsection

