<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('adminlte/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <title>Delivery Note {{$order->order_no}}</title>
</head>
<body>
<div class="container">
    <div style="page-break-after: always;">
        <h1>Delivery Note {{$order->order_no}}</h1>
        <table class="table table-bordered">
            <thead>
            <tr>
                <td colspan="2">Order Details</td>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td style="width: 50%;">
                    <b>Date Added: </b>{{$order->ordered_on}}<br/>
                    <b>Order ID:</b> {{$order->order_no}}<br/>
                    <b>Shipping Method: </b> Flat Shipping Rate<br/>
                </td>
            </tr>
            </tbody>
        </table>
        <table class="table table-bordered">
            <thead>
            <tr>
                <td style="width: 50%;"><b>Shipping Address</b></td>
                <td style="width: 50%;"><b>Contact</b></td>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{{$order->address->address1}}<br/>
                    {{$order->address->address2}}<br/>
                    <b>Area:</b> {{$order->address->area->name}}<br/>
                    <b>City:</b> {{$order->address->city->name}}
                </td>
                <td>{{$order->user->name}}<br/>
                    {{$order->user->phone}}
                </td>
            </tr>
            </tbody>
        </table>
        <table class="table table-bordered">
            <thead>
            <tr>
                <td><b>Product</b></td>
                <td><b>Product Qty</b></td>
                <td><b>Price</b></td>
            </tr>
            </thead>
            <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td>{{$item->name}}</td>
                    <td>{{$item->quantity}}</td>
                    <td>{{$item->quantity * $item->unit_price}}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="2" class="text-right">Sub-Total</td>
                <td class="text-right">{{$order->sub_total}} BDT</td>
            </tr>
            <tr>
                <td colspan="2" class="text-right">Flat Shipping Rate</td>
                <td class="text-right">{{$order->shipping_cost}} BDT</td>
            </tr>
            <tr>
                <td colspan="2" class="text-right">Discount</td>
                <td class="text-right">{{$order->discount_amount}} BDT</td>
            </tr>
            <tr>
                <td colspan="2" class="text-right">VAT (5%)</td>
                <td class="text-right">{{$order->tax}} BDT</td>
            </tr>
            <tr>
                <td colspan="2" class="text-right">Total</td>
                <td class="text-right">{{$order->total_amount}} BDT</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
