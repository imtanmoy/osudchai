<a class="btn btn-default" href="{{route('admin.products.options', $product->id)}}">Add New Option</a>
<table class="table table-bordered">
    <thead>
    <tr>
        <th>Option</th>
        <th>Option Value</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Stock Status</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    @if(!$productOptions->isEmpty())
        @foreach($productOptions as $productOption)
            <tr>
                <td>{{ $productOption->option->name }}</td>
                <td>{{ $productOption->optionValue->value }}</td>
                <td>{{ $productOption->quantity }}</td>
                <td>{{ $productOption->price }}</td>
                <td>{{ $productOption->stock_status }}</td>
                <td class="btn-group">
                    <a
                            onclick="return confirm('Are you sure?')"
                            href="{{ route('admin.products.edit', [$product->id, 'combination' => 1, 'delete' => 1, 'pa' => $productOption->id]) }}"
                            class="btn btn-sm btn-danger">
                        <i class="fa fa-trash"></i> Delete
                    </a>
                    <a
                            href="{{ route('admin.products.options.edit', [$product->id,$productOption->id]) }}"
                            class="btn btn-sm btn-info">
                        <i class="fa fa-trash"></i> Edit
                    </a>
                </td>
            </tr>
        @endforeach
    @else
        <p class="alert alert-warning">No combination yet.</p>
    @endif
    </tbody>
</table>
