@extends("master")

@section("content")
    <div class="container-fluid">
        <div class="row mt-3 justify-content-center">
            @include('sidebar')
            <div class="col-md-9">
                <h2>Proformas</h2>
                <ul class="my-3">
                    <li>Proformas Imported From Excel Files</li>
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

                <table class="table table-hover my-3">
                    <thead>
                    <tr>
                        <th scope="col">Proforma No</th>
                        <th scope="col" onclick="sortTable(1, this)">Company Name</th>
                        <th scope="col">Delivery Date</th>
                        <th scope="col">Delivery Date ETH</th>
                        <th scope="col">Fs.No</th>
                        <th scope="col">Imported Date</th>
                        <th scope="col">View Detail</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($proformas as $order)
                        {{--give tr an id of order performa no so to make it easy to delete on ajax successfull delete operation--}}
                        <tr id="{{$order->proforma_no}}">
                            <th scope="row">
                                {{$order->created_at->year . $order->proforma_no}}
                            </th>
                            <td>{{$order->company_name}}</td>
                            <td>{{$order->delivery_date}}</td>
                            <td>{{$order->delivery_date_et}}</td>
                            <td>{{$order->fsno}}</td>
                            <td>{{$order->created_at}}</td>
                            <td><a href="proforma/{{$order->proforma_no}}">
                                    <button class="btn btn-sm btn-primary" type="button">View</button>
                                </a>
                            </td>
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

    </script>

@endsection