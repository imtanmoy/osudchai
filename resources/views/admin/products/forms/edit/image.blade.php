<div class="container">
    <div class="row">
        @if(!isset($product->cover))
            <div class="col-xs-12 form-group">
                <label for="cover">Cover Image</label>
                <input type="file" name="cover" id="cover">
            </div>
        @endif
    </div>

    <div class="row">
        @if(isset($product->cover))
            <div class='col-md-3 gallery-item'>
                <img class="img-responsive" alt="" src="{{ asset("storage/".$product->cover->src) }}"/>
                <div class="edit">
                    <a onclick="return confirm('Are you sure?')"
                       href="{{ route('admin.products.images.remove', ['id'=>$product->id,'iid' => $product->cover->id]) }}"><i
                                class="fa fa-pencil fa-lg"></i></a>
                </div>
                <div class='text-center'>
                    {{--<small class='text-muted'>{{$product->cover->name}}</small>--}}
                </div>
            </div>
        @endif
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-xs-12 form-group">
            <label for="otherImgs">Other Images</label>
            <input type="file" name="images[]" id="otherImgs" multiple>
        </div>
    </div>
    <div class="row">
        <div class='list-group gallery'>
            @foreach($product->images as $image)
                <div class='col-md-3 gallery-item'>
                    <img class="img-responsive" alt="" src="{{asset("storage/".$image->src)}}"/>
                    <div class="edit">
                        <a onclick="return confirm('Are you sure?')"
                           href="{{ route('admin.products.images.remove', ['id'=>$product->id,'iid' => $image->id]) }}"><i
                                    class="fa fa-pencil fa-lg"></i></a></div>
                    <div class='text-center'>
                        {{--<small class='text-muted'>{{$image->name}}</small>--}}
                    </div>
                </div>
            @endforeach
        </div> <!-- list-group / end -->
    </div> <!-- row / end -->
</div> <!-- container / end -->



@push('styles')
    <style>
        .gallery {
            display: inline-block;
            margin-top: 20px;
        }

        .gallery-item {
            position: relative;
            display: inline-block;
            float: left;
            max-height: 300px;
        }

        .gallery-item:hover .edit {
            display: block;
        }

        .edit {
            padding-top: 7px;
            padding-right: 20px;
            position: absolute;
            right: 0;
            top: 0;
            display: none;
        }

        .edit a {
            color: #000;
        }
    </style>
@endpush

@push('scripts')
    <script>

    </script>
@endpush