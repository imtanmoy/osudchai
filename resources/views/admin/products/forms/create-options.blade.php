<h3>Make combinations</h3>
<div class="form-group">
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Option</th>
            <th>Option Value</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @include('admin.products.forms.options')
        <tr>
            <td>
                <select disabled id="option_id" name="option_id"
                        class="form-control select2"
                        style="width: 100%;">
                    <option></option>
                    <option selected value=1>Default</option>
                </select>
            </td>
            <td>
                <select id="option_value" name="option_value" class="form-control select2"
                        style="width: 100%;">
                    <option></option>
                </select>
            </td>
            <td>
                {!! Form::number('quantity', '', ['class' => 'form-control', 'placeholder' => 'Quantity', 'required'=> '']) !!}
                @if($errors->has('quantity'))
                    <p class="help-block">
                        {{ $errors->first('quantity') }}
                    </p>
                @endif
            </td>
            <td>
                {!! Form::number('price', '', ['class' => 'form-control', 'placeholder' => 'Price', 'required'=> '']) !!}
                @if($errors->has('price'))
                    <p class="help-block">
                        {{ $errors->first('price') }}
                    </p>
                @endif
            </td>
            <td>

            </td>
        </tr>
        </tbody>
    </table>
</div>
<div class="box-footer">
    <div class="btn-group">
        <button type="button" class="btn btn-sm btn-default">Back</button>
        <button id="createCombinationBtn" type="submit" class="btn btn-sm btn-primary" disabled="disabled">Create
            combination
        </button>
    </div>
</div>
