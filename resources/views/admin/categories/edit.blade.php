@extends('admin.layouts.dashboard')

@section('content')
    <h3 class="page-title">Category</h3>

    {!! Form::model($category, ['method' => 'PUT','files' => true, 'route' => ['admin.categories.update', $category->id]]) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_edit')
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="{{$errors->has('name')? 'col-xs-6 form-group has-error': 'col-xs-6 form-group'}}">
                    {!! Form::label('name', 'Name*', ['class' => 'control-label']) !!}
                    {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('name'))
                        <p class="help-block">
                            {{ $errors->first('name') }}
                        </p>
                    @endif
                </div>

                <div class="col-xs-6 form-group">
                    <div class="form-group">
                        <label>Parent Category</label>
                        <select name="parent_id" class="form-control select2" style="width: 100%;">
                            {{--<option selected="selected" value="0">Select</option>--}}
                            {{--@foreach($categories as $category)--}}
                            {{--<option value="{{$category->id}}">{{$category->name}}</option>--}}
                            {{--@endforeach--}}
                            @if ($category->parent_id == 0)
                                <option selected="selected" value="0">Select</option>
                            @else
                                <option value="0">Select</option>
                            @endif
                            @foreach($categories as $cat)
                                @if($category->parent_id == $cat->id)
                                    <option selected value="{{$cat->id}}">{{$cat->name}}</option>
                                @else
                                    <option value="{{$cat->id}}">{{$cat->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="{{$errors->has('order')? 'col-xs-12 form-group has-error': 'col-xs-12 form-group'}}">
                    {!! Form::label('order', 'Order*', ['class' => 'control-label']) !!}
                    {!! Form::number('order', old('order'), ['class' => 'form-control', 'placeholder' => 'order', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('order'))
                        <span class="help-block">
                            {{ $errors->first('order') }}
                        </span>
                    @endif
                </div>
            </div>
            

            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('is_active', 'Active', ['class' => 'control-label']) !!}
                    @if($category->is_active == 0)
                        {!! Form::checkbox('is_active', 1, false) !!}
                    @else
                        {!! Form::checkbox('is_active', 1, true) !!}
                    @endif

                </div>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <button id="cancelBtn" class="btn btn-primary">Cancel</button>
            {!! Form::submit(trans('global.app_update'), ['class' => 'btn btn-success']) !!}

            <button id="deleteBtn" class="btn btn-danger pull-right" data-id="{{$category->id}}">Delete
            </button>
        </div>
    </div>

    {!! Form::close() !!}
@stop


@section('javascript')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#deleteBtn").click(function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            $.confirm({
                title: 'Confirm!',
                content: 'Delete Category',
                buttons: {
                    confirm: function () {
                        $.ajax({
                            url: '/admin/categories/' + "{{$category->id}}",
                            type: 'DELETE',
                            dataType: 'json',
                            data: {method: '_DELETE', submit: true}
                        }).always(function (data) {
                            window.location.href = "{{route('admin.categories.index')}}";
                        });
                    },
                    cancel: function () {

                    }
                }
            });
        });

        $('#cancelBtn').click(function (e) {
            e.preventDefault();
            window.location.href = "{{route('admin.categories.index')}}";
        });
    </script>
@endsection
