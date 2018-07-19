@extends('admin.layouts.dashboard')

@section('content')
    <h3 class="page-title">Product</h3>
    @include('admin.layouts.errors-and-messages')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{$product->name}}</h3>
                </div>
                <div class="box-body">
                    {!! Form::open(['method' => 'POST', 'route' => ['admin.products.options', $product->id]]) !!}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="option_id">Option</label>
                            <select id="option_id" name="option_id"
                                    class="form-control select2"
                                    style="width: 100%;">
                                <option></option>
                                @foreach($options as $option)
                                    <option value="{{$option->id}}">{{$option->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="option_value_id">Option Value</label>
                            <select id="option_value_id" name="option_value_id"
                                    class="form-control select2"
                                    style="width: 100%;">
                                <option></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            {!! Form::number('quantity', '', ['id'=> 'quantity','class' => 'form-control', 'placeholder' => 'Quantity', 'required'=> '']) !!}
                            @if($errors->has('quantity'))
                                <p class="help-block">
                                    {{ $errors->first('quantity') }}
                                </p>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            {!! Form::number('price', '', ['id'=> 'price','class' => 'form-control', 'placeholder' => 'Price', 'required'=> '']) !!}
                            @if($errors->has('price'))
                                <p class="help-block">
                                    {{ $errors->first('price') }}
                                </p>
                            @endif
                        </div>
                        <div class="form-group">
                            {!! Form::label('stock_status', 'Stock Status*', []) !!}
                            {{ Form::select('stock_status', ['inStock'=> 'In Stock', 'outOfStock'=>'Out of Stock', 'pre-order'=>'Pre-Oder'],'', ['id'=>'stock_status','required' => '', 'class' => 'form-control select2', 'style'=>'width: 100%']) }}
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

            $('.select2').select2({
                placeholder: 'Select an option'
            });

            $("#option_id").on("change", function (e) {
                console.log(e.target.value);
                var oid = e.target.value;
                $("#option_value_id").val(null).trigger('change');
                $('#option_value_id').children('option:not(:first)').remove();
                $.ajax({
                    type: 'GET',
                    url: '{{url('/admin/options/')}}' + '/' + oid,
                    dataType: 'json',
                }).done(function (data) {
                    $.each(data, function (key, value) {
                        var newOption = new Option(value.value, value.id, false, false);
                        $('#option_value_id').append(newOption);
                    });
                }).fail(function () {
                    alert("error");
                });
            });
        });
    </script>
@endsection
