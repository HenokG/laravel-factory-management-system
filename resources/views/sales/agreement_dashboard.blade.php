@extends("master")

@section("content")
    <div class="container-fluid">
        <div class="row mt-3">
            @include('sidebar')
            <div class="col-md-9">
                <h2>Agreements</h2>
                <ul class="my-3">
                    <li>Search Through Your Agreements</li>
                    <li>Click <i class="ion-android-download"></i> to View Agreement File</li>
                    <li>Click <i class="ion-ios-trash-outline"></i> to Delete an Agreement</li>
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
                        <th scope="col" onclick="sortTable(0, this)">Performa No</th>
                        <th scope="col" onclick="sortTable(1, this)">BelongsTo</th>
                        <th scope="col">Agreement File</th>
                        <th scope="col">Total Amount</th>
                        <th scope="col">Down Payment</th>
                        <th scope="col">Delivery Date</th>
                        <th scope="col">Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($agreements as $agreement)
                        <tr id="{{$agreement->id}}">
                            {{--<th scope="row"><a href="javascript:void(0)" o><span class="ion-ios-plus-empty"--}}
                                                                                 {{--data-toggle="modal"--}}
                                                                                 {{--data-target="#agreementModal"--}}
                                                                                 {{--onclick="populateModal({{$agreement->customer_id}}, {{$agreement->performa_no}})"></span></a>--}}
                            {{--</th>--}}
                            <td>{{$agreement->performa_no}}</td>
                            <td>{{$agreement->customer['name']}}</td>
                            <td><a href="{{$agreement->agreement_file == null ? '': asset('/uploads/agreement_files/'.$agreement->agreement_file)}}" download><span class="ion-android-download"></span></a></td>
                            <td>{{$agreement->total_amount}}</td>
                            <td>{{$agreement->down_payment}}</td>
                            <td>{{$agreement->delivery_date}}</td>
                            <td><a href="javascript:void(0)"><span class="ion-ios-trash-outline" onclick="deleteAgreement({{$agreement->id}})"></span></a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Agreement Edit Modal BEGIN-->
        <div class="modal fade" id="agreementModal" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Agreement</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="/create-agreement" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="">
                                <div class="form-row">
                                    <div class="form-group col-6">
                                        <label for="filePath">Agreement File</label>
                                        <input type="hidden" name="performa_no">
                                        <input type="hidden" name="customer_id">
                                        <input type="hidden" name="user_id" value="{{session()->get(\App\Util\FinalConstants::SESSION_LOGGEDINUSERID_LABEL)}}">
                                        <input type="file" id="filePath"
                                               class="form-control-file form-control-sm col-sm-12 col-md-6"
                                               name="file_path" required>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <input type="number" class="form-control" name="total_amount"
                                                   placeholder="Total Amount" min="0" step="0.01">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <input type="number" class="form-control" name="down_payment"
                                                   placeholder="Down Payment" min="0" step="0.01">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="deliveryDate">Delivery Date</label>
                                            <input type="date" class="form-control" name="delivery_date"
                                                   placeholder="Delivery Date">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn bg-primary-color" onclick="submitAddAgreementForm()">Add</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{--MODal end--}}
    </div>
    <script src="/js/agreements_dashboard.js"></script>
    <!-- Company Modal END -->

@endsection