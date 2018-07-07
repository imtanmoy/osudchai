<div class="row box-body">
    {{--<div class="col-xs-12 form-group">--}}
    {{--<label for="discount_type">Discount Type</label>--}}
    {{--<select id="discount_type" name="discount_type" class="form-control select2 select2-hidden-accessible"--}}
    {{--style="width: 100%;" tabindex="-1" aria-hidden="true">--}}
    {{--<option></option>--}}
    {{--<option value="percentage">Percentage / %</option>--}}
    {{--<option value="cash">Cash / $</option>--}}
    {{--</select>--}}
    {{--</div>--}}

    {{--<div class="col-xs-12 form-group">--}}
    {{--{!! Form::label('discount_value', 'Discount Value*', []) !!}--}}
    {{--{!! Form::number('discount_value', '', ['class' => 'form-control', 'placeholder' => '']) !!}--}}
    {{--@if($errors->has('discount_value'))--}}
    {{--<p class="help-block">--}}
    {{--{{ $errors->first('discount_value') }}--}}
    {{--</p>--}}
    {{--@endif--}}
    {{--</div>--}}

    {{--<div class="col-xs-12 form-group">--}}
    {{--{!! Form::label('minimum_order_quantity', 'Minimum Order Quantity*', []) !!}--}}
    {{--{!! Form::number('minimum_order_quantity', '', ['class' => 'form-control', 'placeholder' => '']) !!}--}}
    {{--@if($errors->has('minimum_order_quantity'))--}}
    {{--<p class="help-block">--}}
    {{--{{ $errors->first('minimum_order_quantity') }}--}}
    {{--</p>--}}
    {{--@endif--}}
    {{--</div>--}}

    {{--<div class="col-xs-12 form-group">--}}
    {{--{!! Form::label('maximum_order_quantity', 'Maximum Order Quantity*', []) !!}--}}
    {{--{!! Form::number('maximum_order_quantity', '', ['class' => 'form-control', 'placeholder' => 'Maximum Order Per User']) !!}--}}
    {{--@if($errors->has('maximum_order_quantity'))--}}
    {{--<p class="help-block">--}}
    {{--{{ $errors->first('maximum_order_quantity') }}--}}
    {{--</p>--}}
    {{--@endif--}}
    {{--</div>--}}

    {{--<div class="col-xs-12 form-group">--}}
    {{--{!! Form::label('usage_limit', 'Usage Limit*', []) !!}--}}
    {{--{!! Form::number('usage_limit', '', ['class' => 'form-control', 'placeholder' => 'Offer Per User']) !!}--}}
    {{--@if($errors->has('usage_limit'))--}}
    {{--<p class="help-block">--}}
    {{--{{ $errors->first('usage_limit') }}--}}
    {{--</p>--}}
    {{--@endif--}}
    {{--</div>--}}

    {{--<div class="col-xs-12 form-group">--}}
    {{--<div class="checkbox">--}}
    {{--<label>--}}
    {{--<input id="status" name="discount_status" type="checkbox"--}}
    {{--value="true">--}}
    {{--Status (Active / Deactivate)--}}
    {{--</label>--}}
    {{--</div>--}}
    {{--</div>--}}

    {{--<div class="col-xs-12 form-group">--}}
    {{--<label>Valid Till</label>--}}

    {{--<div class="input-group date">--}}
    {{--<div class="input-group-addon">--}}
    {{--<i class="fa fa-calendar"></i>--}}
    {{--</div>--}}
    {{--<input type="text" name="valid_date" class="form-control pull-right" id="datepicker">--}}
    {{--</div>--}}
    {{--<!-- /.input group -->--}}
    {{--</div>--}}

    {{--<div class="col-xs-12 form-group">--}}
    {{--<label>Expire Date</label>--}}

    {{--<div class="input-group date">--}}
    {{--<div class="input-group-addon">--}}
    {{--<i class="fa fa-calendar"></i>--}}
    {{--</div>--}}
    {{--<input type="text" name="expire_date" class="form-control pull-right" id="datepicker1">--}}
    {{--</div>--}}
    {{--<!-- /.input group -->--}}
    {{--</div>--}}


    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Customer Group</th>
            <th>Discount Type</th>
            <th>Discount Value</th>
            <th>Minimum Order Quantity*</th>
            <th>Maximum Order Quantity*</th>
            <th>Usage Limit*</th>
            <th>Discount Status*</th>
            <th>Valid Till*</th>
            <th>Expire Date</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>
                <select disabled id="customer_group_id" name="customer_group_id"
                        class="form-control select2 select2-hidden-accessible"
                        style="width: 100%;" tabindex="-1" aria-hidden="true">
                    <option></option>
                    <option selected value=1>Default</option>
                </select>
            </td>
            <td>
                <select id="discount_type" name="discount_type" class="form-control select2 select2-hidden-accessible"
                        style="width: 100%;" tabindex="-1" aria-hidden="true">
                    <option></option>
                    <option value="percentage">Percentage / %</option>
                    <option value="cash">Cash / $</option>
                </select>
            </td>
            <td>
                {!! Form::number('discount_value', '', ['class' => 'form-control', 'placeholder' => 'Discount Value']) !!}
                @if($errors->has('discount_value'))
                    <p class="help-block">
                        {{ $errors->first('discount_value') }}
                    </p>
                @endif
            </td>
            <td>
                {!! Form::number('minimum_order_quantity', '', ['class' => 'form-control', 'placeholder' => 'Minimum Order Per User']) !!}
                @if($errors->has('minimum_order_quantity'))
                    <p class="help-block">
                        {{ $errors->first('minimum_order_quantity') }}
                    </p>
                @endif
            </td>
            <td>
                {!! Form::number('maximum_order_quantity', '', ['class' => 'form-control', 'placeholder' => 'Maximum Order Per User']) !!}
                @if($errors->has('maximum_order_quantity'))
                    <p class="help-block">
                        {{ $errors->first('maximum_order_quantity') }}
                    </p>
                @endif
            </td>
            <td>
                {!! Form::number('usage_limit', '', ['class' => 'form-control', 'placeholder' => 'Offer Per User']) !!}
                @if($errors->has('usage_limit'))
                    <p class="help-block">
                        {{ $errors->first('usage_limit') }}
                    </p>
                @endif
            </td>
            <td>
                <div class="checkbox">
                    <label>
                        <input id="status" name="discount_status" type="checkbox"
                               value="true">
                        Status (Active / Deactivate)
                    </label>
                </div>
            </td>
            <td>
                <div class="input-group date">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" name="valid_date" class="form-control pull-right" id="datepicker1">
                </div>
            </td>
            <td>
                <div class="input-group date">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" name="expire_date" class="form-control pull-right" id="datepicker1">
                </div>
            </td>
        </tr>
        </tbody>
    </table>
</div>