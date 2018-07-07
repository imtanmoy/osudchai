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
        @if (count($product->attributes) > 0)
            @foreach ($product->attributes as $attribute)
                <tr>
                    <td class="text-center">{{$attribute->attribute_name->name}}</td>
                    <td class="text-center">{{$attribute->value}}</td>
                    <td class="text-center">
                        <input data-id="{{$attribute->id}}" type="button" id="oldrowDel" class="btn btn-danger btn-sm"
                               value="Delete">
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="2">@lang('global.app_no_entries_in_table')</td>
            </tr>
        @endif
        </tbody>
    </table>

</div>
<div class="box-footer clearfix">
    <button id="addAttribute" class="btn btn-primary pull-right">+Add</button>
</div>
