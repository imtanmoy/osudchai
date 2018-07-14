@extends('admin.layouts.dashboard')

@section('content')
    <!-- Main content -->
    <section class="content">
        @include('admin.layouts.errors-and-messages')
        <div class="box">
            <form action="{{ route('admin.packSizes.values.store', $packSize->id) }}" method="post" class="form">
                <div class="box-body">
                    <div class="row">
                        {{ csrf_field() }}
                        <div class="col-md-12">
                            <h2>Set value for: <strong>{{ $packSize->name }}</strong></h2>
                            <div class="form-group">
                                <label for="value">PackSize value <span class="text-danger">*</span></label>
                                <input type="text" name="value" id="value" placeholder="PackSize value" class="form-control" value="{!! old('value')  !!}">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <div class="btn-group">
                        <a href="{{ route('admin.packSizes.show', $packSize->id) }}" class="btn btn-default btn-sm">Back</a>
                        <button type="submit" class="btn btn-primary btn-sm">Create</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
@endsection
