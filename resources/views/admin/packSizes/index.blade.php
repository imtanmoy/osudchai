@extends('admin.layouts.dashboard')

@section('content')
    <!-- Main content -->
    <section class="content">
    @include('admin.layouts.errors-and-messages')
    <!-- Default box -->
        <div class="box">
            <div class="box-body">
                <h2>PackSizes</h2>
                @if($packSizes->total() > 0)
                    <table class="table">
                        <thead>
                        <tr>
                            <td>PackSize name</td>
                            <td></td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($packSizes as $packSize)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.packSizes.show', $packSize->id) }}">{{ $packSize->name }}
                                        <strong>({{ $packSize->values->count() }})</strong></a>
                                </td>
                                <td>
                                    <form action="{{ route('admin.packSizes.destroy', $packSize->id) }}" method="post"
                                          class="form-horizontal">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="_method" value="delete">
                                        <div class="btn-group">
                                            <a href="{{ route('admin.packSizes.values.create', $packSize->id) }}"
                                               class="btn btn-default btn-sm"><i class="fa fa-plus"></i> Add values</a>
                                            <a href="{{ route('admin.packSizes.edit', $packSize->id) }}"
                                               class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> Edit</a>
                                            <button onclick="return confirm('Are you sure?')" type="submit"
                                                    class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Delete
                                            </button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="pull-left">{{ $packSizes->links() }}</div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="btn-group">
                            <a class="btn btn-sm btn-primary" href="{{ route('admin.packSizes.create') }}"><i
                                    class="fa fa-plus"></i> Create attribute</a>
                        </div>
                    </div>
                @else
                    <p class="alert alert-warning">No attribute yet. <a href="{{ route('admin.packSizes.create') }}">Create
                            one</a></p>
                @endif
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
@endsection
