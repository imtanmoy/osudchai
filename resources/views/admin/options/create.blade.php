@extends('admin.layouts.dashboard')

@section('content')
    <!-- Main content -->
    <section class="content">
        @include('admin.layouts.errors-and-messages')
        <div class="box">
            <form action="{{ route('admin.options.store') }}" method="post" class="form">
                <div class="box-body">
                    <div class="row">
                        {{ csrf_field() }}
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Option name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" placeholder="Option name" class="form-control"
                                       value="{!! old('name')  !!}">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="btn-group">
                        <a href="{{ route('admin.options.index') }}" class="btn btn-default">Back</a>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
@endsection
