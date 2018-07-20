<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-comment-o"></i> Order History</h3>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <td class="text-left">Date Added</td>
                    <td class="text-left">Comment</td>
                    <td class="text-left">Status</td>
                </tr>
                </thead>
                <tbody>
                @foreach($order->statuses as $status)
                    <tr>
                        <td class="text-left">{{$status->created_at->format('d/m/Y')}}</td>
                        <td class="text-left">{{$status->pivot->comment}}</td>
                        <td class="text-left">{{$status->name}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <br>
    <div class="panel-body">
        <form class="form-horizontal" action="{{route('admin.orders.statuses', $order->id)}}" method="POST">
            <fieldset>
                <legend>Add Order History</legend>
                @method('post')
                @csrf
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-order-status">Order Status</label>
                    <div class="col-sm-10">
                        <select name="order_status_id" id="input-order-status" class="form-control">
                            <option></option>
                            @foreach($orderStatuses as $orderStatus)
                                <option value="{{$orderStatus->id}}">{{$orderStatus->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-comment">Comment</label>
                    <div class="col-sm-10">
                        <textarea name="comment" rows="8" id="input-comment" class="form-control"></textarea>
                    </div>
                </div>

            </fieldset>
            <div class="text-right">
                <button type="submit" id="button-history" data-loading-text="Loading..." class="btn btn-primary"><i
                        class="fa fa-plus-circle"></i> Add History
                </button>
            </div>
        </form>
    </div>
</div>
