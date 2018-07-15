@if(!$productOptions->isEmpty())
    @foreach($productOptions as $pa)
        <tr>
            {{--@foreach($pa->optionValues as $item)--}}
                {{--<td>{{ $item->option->name }}</td>--}}
                {{--<td>{{ $item->value }}</td>--}}
            {{--@endforeach--}}
            @dd($pa->optionValues)
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
@else
    <p class="alert alert-warning">No combination yet.</p>
@endif
