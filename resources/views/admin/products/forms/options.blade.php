<a class="btn btn-default" href="{{route('admin.products.options', $product->id)}}">Add New Option</a>
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
    @if(!$productOptions->isEmpty())
        @foreach($productOptions as $pa)
            <tr>
                @foreach($pa->optionValues as $item)
                    <td>{{ $item->option->name }}</td>
                    <td>{{ $item->value }}</td>
                @endforeach
                <td>{{ $pa->quantity }}</td>
                <td>{{ $pa->price }}</td>
                <td class="btn-group">
                    <a
                        onclick="return confirm('Are you sure?')"
                        href="{{ route('admin.products.edit', [$product->id, 'combination' => 1, 'delete' => 1, 'pa' => $pa->id]) }}"
                        class="btn btn-sm btn-danger">
                        <i class="fa fa-trash"></i> Delete
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@else
    <p class="alert alert-warning">No combination yet.</p>
@endif
