@extends("master")

@section("content")
    <div class="container-fluid">
        <div class="row mt-3 justify-content-center">
            @include('sidebar')
            <div class="col-md-9">
                <h2>Delivery No Orders</h2>
                <ul class="my-3">
                    <li>Delivery No Orders Imported From Excel Files</li>
                    <li>Click '<b>View Detail</b>' to View a Detailed Orders List</li>
                </ul>

                <div class="input-group mb-2">
                    <input class="form-control py-2 border-right-0 border" type="search" placeholder="Search Companies"
                           id="filter-table" onkeyup="filterCompaniesTable()">
                    <span class="input-group-append">
                        <button class="btn btn-outline-secondary border-left-0 border" type="button">
                            <i class="ion-ios-search-strong"></i>
                        </button>
                    </span>
                </div>

                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">Delivery No</th>
                        <th scope="col" onclick="sortTable(1, this)">Company Name</th>
                        <th scope="col">Delivery Date</th>
                        <th scope="col">Delivery Date ETH</th>
                        <th scope="col">Fs.No</th>
                        <th scope="col">Imported Date</th>
                        <th scope="col">View Detail</th>
                        @if(session()->get(\App\Util\FinalConstants::SESSION_DEPARTMENT_LABEL) != \App\Util\FinalConstants::DEPARTMENT_PRODUCTION_MANAGEMENT_LABEL)
                            <th scope="col">Send To Production</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($deliveries as $order)
                        <tr id="{{$order->delivery_no}}">
                            <th scope="row">
                                {{$order->created_at->year . $order->delivery_no}}
                            </th>
                            <td>{{ $order->company_name }}</td>
                            <td>{{$order->delivery_date}}</td>
                            <td>{{$order->delivery_date_et}}</td>
                            <td>{{$order->FsNo}}</td>
                            <td>{{$order->created_at}}</td>
                            <td><a href="delivery/{{$order->delivery_no}}">
                                    <button class="btn btn-sm btn-primary" type="button">View</button>
                                </a>
                            </td>
                            @if(session()->get(\App\Util\FinalConstants::SESSION_DEPARTMENT_LABEL) != \App\Util\FinalConstants::DEPARTMENT_PRODUCTION_MANAGEMENT_LABEL)
                                <td>
                                    @if(!$order->sent_to_production)
                                        <button class="btn btn-sm btn-primary" type="button"
                                                onclick="sendToProduction({{  $order->delivery_no }})">Send
                                        </button>
                                    @else
                                        <i class="ion-ios-checkmark-empty"></i>
                                        <i class="ion-ios-checkmark-empty"></i>
                                        <i>Already Sent</i>
                                    @endif
                                </td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        
        function filterCompaniesTable() {
            let tableRows = $("tr");
            for (let i = 0; i < tableRows.length; i++) {
                let td = tableRows[i].getElementsByTagName("td")[0];
                if (td) {
                    if (td.innerHTML.toUpperCase().indexOf($("#filter-table").val().toUpperCase()) > -1) {
                        tableRows[i].style.display = "";
                    } else {
                        tableRows[i].style.display = "none";
                    }
                }
            }
        }

        function sendToProduction(id) {
            $.ajax({
                url: 'delivery/' + id,
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (data) {
                    console.log(data);
                    if (data === 'sent') {
                        notify("Successfully Sent To Production! :)");
                        setTimeout(function () {
                            window.location.reload(true);
                        }, 1200);
                    }
                },
                error: function (data) {
                    console.log(data);
                }
            });
        }
    </script>

@endsection