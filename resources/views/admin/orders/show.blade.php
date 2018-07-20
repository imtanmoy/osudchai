@inject('request', 'Illuminate\Http\Request')
@extends('admin.layouts.dashboard')

@section('content')
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <a href="" target="_blank" data-toggle="tooltip" title="" class="btn btn-info"
                   data-original-title="Print Invoice">
                    <i class="fa fa-print"></i>
                </a>
                <a href="{{route('admin.orders.deliveryNote', [$order->id])}}" target="_blank" data-toggle="tooltip"
                   title="" class="btn btn-info" data-original-title="Print Shipping List"
                   aria-describedby="tooltip662920">
                    <i class="fa fa-truck"></i>
                </a>
                <a href="" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Edit">
                    <i class="fa fa-pencil"></i>
                </a>
                <a href="" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="Cancel">
                    <i class="fa fa-reply"></i>
                </a>
            </div>
            <h3 class="page-title">Orders</h3>
        </div>
    </div>





    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-shopping-cart"></i> Order Details</h3>
                </div>
                <table class="table">
                    <tbody>
                    <tr>
                        <td>
                            <button data-toggle="tooltip" title="" class="btn btn-info btn-xs"
                                    data-original-title="Date Added"><i class="fa fa-calendar fa-fw"></i></button>
                        </td>
                        <td>{{$order->ordered_on}}</td>
                    </tr>
                    <tr>
                        <td>
                            <button data-toggle="tooltip" title="" class="btn btn-info btn-xs"
                                    data-original-title="Payment Method"><i class="fa fa-credit-card fa-fw"></i>
                            </button>
                        </td>
                        <td>{{$order->method->method}}</td>
                    </tr>
                    <tr>
                        <td>
                            <button data-toggle="tooltip" title="" class="btn btn-info btn-xs"
                                    data-original-title="Shipping Method"><i class="fa fa-truck fa-fw"></i></button>
                        </td>
                        <td>Flat Shipping Rate</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-user"></i> Customer Details</h3>
                </div>
                <table class="table">
                    <tbody>
                    <tr>
                        <td style="width: 1%;">
                            <button data-toggle="tooltip" title="" class="btn btn-info btn-xs"
                                    data-original-title="Customer"><i class="fa fa-user fa-fw"></i></button>
                        </td>
                        <td>
                            <a href="#"
                               target="_blank">{{$order->user->name}}</a></td>
                    </tr>
                    <tr>
                        <td>
                            <button data-toggle="tooltip" title="" class="btn btn-info btn-xs"
                                    data-original-title="Customer Group"><i class="fa fa-group fa-fw"></i></button>
                        </td>
                        <td>{{$order->user->customerGroup[0]->name}}</td>
                    </tr>
                    <tr>
                        <td>
                            <button data-toggle="tooltip" title="" class="btn btn-info btn-xs"
                                    data-original-title="E-Mail"><i class="fa fa-envelope-o fa-fw"></i></button>
                        </td>
                        <td><a href="mailto:{{$order->user->email}}">{{$order->user->email}}</a></td>
                    </tr>
                    <tr>
                        <td>
                            <button data-toggle="tooltip" title="" class="btn btn-info btn-xs"
                                    data-original-title="Telephone"><i class="fa fa-phone fa-fw"></i></button>
                        </td>
                        <td>{{$order->user->phone}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-user"></i> Shipping Address</h3>
                </div>
                <table class="table">
                    <tbody>
                    <tr>
                        <td>{{$order->address->address1}}</td>
                    </tr>
                    <tr>
                        <td>{{$order->address->address2}}</td>
                    </tr>
                    <tr>
                        <td>{{$order->address->area->name}}</td>
                    </tr>
                    <tr>
                        <td>{{$order->address->city->name}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-info-circle"></i> Order ({{$order->order_no}})</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <td class="text-left">Product</td>
                            <td class="text-right">Quantity</td>
                            <td class="text-right">Unit Price</td>
                            <td class="text-right">Discount</td>
                            <td class="text-right">Total</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td class="text-left"><a href="#">{{$item->name}}</a>
                                    <br>&nbsp;<small></small>
                                </td>
                                <td class="text-right">{{$item->quantity}}</td>
                                <td class="text-right">{{$item->unit_price}}</td>
                                <td class="text-right">{{$item->discount_amount}}</td>
                                <td class="text-right">{{$item->quantity * $item->unit_price}}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="4" class="text-right">Sub-Total</td>
                            <td class="text-right">{{$order->sub_total}} BDT</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-right">Flat Shipping Rate</td>
                            <td class="text-right">{{$order->shipping_cost}} BDT</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-right">Discount</td>
                            <td class="text-right">{{$order->discount_amount}} BDT</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-right">VAT (5%)</td>
                            <td class="text-right">{{$order->tax}} BDT</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-right">Total</td>
                            <td class="text-right">{{$order->total_amount}} BDT</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            @include('admin.orders.order_history')
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
        $(document).ready(function () {

        });
    </script>
@endsection
