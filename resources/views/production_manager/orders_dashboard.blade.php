@extends("master")

@section("content")
    <div class="container-fluid">
        <div class="row mt-3">
            @include('sidebar')
            <div class="col-md-9">
                {{--<h2 class="my-4">Orders Assigned To You By Factory Manager</h2>--}}
                <h2 class="my-4">Orders</h2>
                <button class="btn btn-sm bg-primary-color mb-4" data-toggle="modal" data-target="#obstacleModal">Submit
                    Obstacle
                </button>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">Performa No</th>
                        <th scope="col" onclick="sortTable(0, this)">Belongs To</th>
                        <th scope="col" onclick="sortTable(1, this)"
                        >Ordered By
                        </th>
                        {{--<th scope="col">Agreement</th>--}}
                        <th scope="col">Ordered Date</th>
                        <th scope="col">Delivery No</th>
                        <th scope="col">Delivery Date</th>
                        <th scope="col">Scheduled Production Date</th>
                        <th scope="col">Production Status</th>
                        <th scope="col">Delivered Percentage</th>
                        <th scope="col">Is Ready For Delivery</th>
                        <th scope="col">Delayed By</th>
                        <th scope="col">View Order Description</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                        {{--give tr an id of order performa no so to make it easy to delete on ajax successfull delete operation--}}
                        <a href="#">
                            <tr id="{{$order->performa_no}}">
                                <th scope="row">{{$order->performa_no}}</th>
                                <td>{{$order->customer['name']}}</td>
                                <td>{{$order->user['username']}}</td>
                                <td>{{$order->created_at}}</td>
                                <td>{{$order->delivery_no}}</td>
                                <td>{{$order->delivery_date}}</td>
                                <td>{{$order->scheduled_production_date}}</td>
                                <td>{{$order->production_status}}</td>
                                <td>{{$order->delivered_percentage}}</td>
                                <td>{{$order->is_ready_for_delivery}}</td>
                                <td>{{$order->delayed_by}}</td>
                                <td><a href="order-description?id={{$order->performa_no}}"><i class="ion-ios-more"></i></a></td>
                            </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{--OBSTACLE MODAL--}}

    <div class="modal fade" id="obstacleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Obstacle Submition Form</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="obstacle" id="obstacleForm">
                        {{csrf_field()}}
                        <div class="">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <input type="text" class="form-control" name="type"
                                           placeholder="Obstacle Type">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="from">From DateTime</label>
                                    <input type="datetime-local" id="from" class="form-control" name="from" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="to">To DateTime</label>
                                    <input type="datetime-local" class="form-control"
                                           name="to" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="solution">Solution/Action Taken</label>
                                    <textarea name="solution" id="solution" cols="20" rows="5"></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn bg-primary-color" onclick="submitObstacle();">Save</button>
                </div>
            </div>
        </div>
    </div>

    {{--OBSTACLE MODAL--}}
    <script>
        function submitObstacle() {
            $("#obstacleForm").submit();
        }
    </script>
    <!-- Company Modal END -->

@endsection