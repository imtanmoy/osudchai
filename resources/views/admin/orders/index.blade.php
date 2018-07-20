@inject('request', 'Illuminate\Http\Request')
@extends('admin.layouts.dashboard')

@section('content')
    <h3 class="page-title">Orders</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_list')
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-hover table-bordered table-striped datatable text-center">
                <thead>
                <tr>
                    <th>Order NO</th>
                    <th>Payment Status</th>
                    <th>Shipping Status</th>
                    <th>Total</th>
                    <th>Date Added</th>
                    <th>Date Shipped</th>
                    <th>Action</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var table = undefined;
        $(document).ready(function () {
            table = $('.datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!!route('admin.datatable.orders')!!}',
                columns: [
                    {data: 'order_no', name: 'order_no'},
                    {data: 'payment_status', name: 'payment_status'},
                    {data: 'shipping_status', name: 'shipping_status'},
                    {data: 'total_amount', name: 'total_amount'},
                    {data: 'ordered_on', name: 'ordered_on'},
                    {data: 'shipped_on', name: 'shipped_on'},
                    {data: 'action', name: 'action'},
                ]
            });
        });
    </script>
@endsection
