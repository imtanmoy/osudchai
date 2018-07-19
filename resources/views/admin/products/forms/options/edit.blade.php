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
                    {!! Form::model($productOption, ['method' => 'PUT', 'route' => ['admin.products.options.update', $product->id, $productOption->id]]) !!}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="option_id">Option</label>
                            <select id="option_id" name="option_id"
                                    class="form-control select2"
                                    style="width: 100%;" disabled>
                                <option selected
                                        value="{{$productOption->option->id}}">{{$productOption->option->name}}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="option_value_id">Option Value</label>
                            <select id="option_value_id" name="option_value_id"
                                    class="form-control select2"
                                    style="width: 100%;" disabled>
                                <option selected
                                        value="{{$productOption->optionValue->id}}">{{$productOption->optionValue->value}}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            {!! Form::number('quantity', $productOption->quantity, ['id'=> 'quantity','class' => 'form-control', 'placeholder' => 'Quantity', 'required'=> '']) !!}
                            @if($errors->has('quantity'))
                                <p class="help-block">
                                    {{ $errors->first('quantity') }}
                                </p>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            {!! Form::number('price', $productOption->price, ['id'=> 'price','class' => 'form-control', 'placeholder' => 'Price', 'required'=> '']) !!}
                            @if($errors->has('price'))
                                <p class="help-block">
                                    {{ $errors->first('price') }}
                                </p>
                            @endif
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
        });
    </script>
@endsection
