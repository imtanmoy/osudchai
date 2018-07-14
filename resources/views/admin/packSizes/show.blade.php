@extends('admin.layouts.dashboard')

@section('content')
    <!-- Main content -->
    <section class="content">
    @include('admin.layouts.errors-and-messages')
    <!-- Default box -->
        <div class="box">
            <div class="box-body">
                <h2>PackSizes</h2>
                <table class="table">
                    <thead>
                    <tr>
                        <td>PackSize name</td>
                        <td></td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{ $packSize->name }}</td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
                @if(!$values->isEmpty())
                    <table class="table table-striped" style="margin-left: 35px">
                        <thead>
                        <tr>
                            <td>PackSize Values</td>
                            <td></td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($values as $item)
                            <tr>
                                <td>{{ $item->value }}</td>
                                <td>
                                    <form
                                        action="{{ route('admin.packSizes.values.destroy', [$packSize->id, $item->id]) }}"
                                        class="form-horizontal" method="post">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="_method" value="delete">
                                        <div class="btn-group">
                                            <button onclick="return confirm('Are you sure?')" type="submit"
                                                    class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Remove
                                            </button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <div class="btn-group">
                    <a href="{{ route('admin.packSizes.values.create', $packSize->id) }}"
                       class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add values</a>
                    <a href="{{ route('admin.packSizes.index') }}" class="btn btn-default btn-sm">Back</a>
                </div>
            </div>
        </div>
        <!-- /.box -->
    </section>
    <!-- /.content -->
@endsection
