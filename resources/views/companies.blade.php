@extends("master")

@section("content")

    <div class="container-fluid">
        <div class="row col-sm-10 offset-sm-1 col-md-8 offset-md-2">
            <table class="table table-hover" style="margin-top: 6rem;">
                <thead>
                <tr>
                    <th scope="col">Company ID</th>
                    <th scope="col">Logo</th>
                    <th scope="col">Company Name</th>
                    <th scope="col">Status</th>
                    <th scope="col">Edit</th>
                    <th scope="col">Delete</th>
                </tr>
                </thead>
                <tbody>
                @foreach($companies as $company)
                    <tr class="{{$company->id}}">
                        <th scope="row">{{$company->id}}</th>
                        <td><img src="{{$company->logo == null ? '': asset('/uploads/company_logos'.$company->logo)}}"
                                 width="20em"
                                 style="max-height: 1em;"/></td>
                        <td>{{$company->name}}</td>
                        <td>{{$company->status}}</td>
                        <td><a href="#"><span class="ion-ios-compose-outline" data-toggle="modal"
                                              data-target="#editCompanyModal{{$company->id}}"></span></a></td>
                        <td><a href="/company/"><span class="ion-ios-trash-outline" data-toggle="modal"
                                                      data-target="#deleteCompanyModal{{$company->id}}"></a></span></td>
                    </tr>

                    <!-- Delete Company Confirmation Modal BEGINS-->
                    <div class="modal fade" id="deleteCompanyModal{{$company->id}}" tabindex="-1" role="dialog"
                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Confirm?</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p class="text-muted">you're about to delete a company! can't be undone</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn btn-primary"
                                            onclick="deleteCompany({{$company->id}})">
                                        Confirm
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Delete Company Confirmation Modal ENDS -->

                    <!-- Edit Company Modal BEGIN-->
                    <div class="modal fade" id="editCompanyModal{{$company->id}}" tabindex="-1" role="dialog"
                         aria-labelledby="exampleModalLabel"
                         aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit Company Info</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="/company/{{$company->id}}" id="{{$company->id}}"
                                          enctype="multipart/form-data">
                                        {{method_field('PATCH')}}
                                        {{csrf_field()}}
                                        <div class="">
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <input type="text" class="form-control" name="name"
                                                           placeholder="Company Name" value="{{$company->name}}">
                                                    <select name="status" class="mt-3">
                                                        <option value="Approved" {{$company->status == 'Approved' ? 'selected': ''}}>
                                                            Approved
                                                        </option>
                                                        <option value="Suspended" {{$company->status == 'Suspended' ? 'selected': ''}}>
                                                            Suspended
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <input type="text" class="form-control" name="owner_name"
                                                           placeholder="Owner Name" value="{{$company->owner_name}}">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <input type="text" class="form-control"
                                                           name="manager_name"
                                                           placeholder="Manager Name" required
                                                           value="{{$company->manager_name}}">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <div class="input-group">
                                                        <span class="input-group-text">+251</span>
                                                        <input type="number" class="form-control" name="owner_tel"
                                                               placeholder="Owner Telephone No"
                                                               value="{{$company->owner_tel}}" min="0">
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <div class="input-group">
                                                        <span class="input-group-text">+251</span>
                                                        <input type="number" class="form-control"
                                                               name="manager_tel"
                                                               placeholder="Manager Telephone No" required
                                                               value="{{$company->manager_tel}}" min="0"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <input type="email" class="form-control"
                                                           name="owner_email"
                                                           placeholder="Owner Email Address"
                                                           value="{{$company->owner_email}}">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <input type="email" class="form-control"
                                                           name="manager_email"
                                                           placeholder="Manager Email Address" required
                                                           value="{{$company->manager_email}}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="companyLogo">Company Logo</label>
                                                <input type="file"
                                                       class="form-control-file form-control-sm col-sm-12 col-md-6"
                                                       name="logo">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn bg-primary-color"
                                            onclick="updateCompany({{$company->id}})">Save
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Edit Company Modal END -->

                @endforeach
                </tbody>
            </table>
        </div>

        <!-- Edit Password BEGINS -->
        <div class="row col-sm-10 offset-sm-1 col-md-8 offset-md-2" style="margin-top: 4rem;">
            <div class="col-sm-12 justify-content-center">
                <h3 class="text-center">Edit Password</h3>
                <div class="form-group row mt-5">
                    <label for="labelForChooseUser" class="col-sm-1 col-form-label">User</label>
                    <div class="col-sm-10 col-md-4">
                        <select class="custom-select" name="select_user">
                            <option selected>Select User</option>
                            @foreach($users as $usersArray)
                                @foreach($usersArray as $user)
                                    <option value="{{$user->id}}">{{$user->companyName() . " _____ " . $user->username}}</option>
                                    <h3>{{$user}}</h3>
                                @endforeach
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-10 col-md-5">
                        <input type="password" class="form-control" id="editPassword" name="new_password"
                               placeholder="New Password">
                    </div>
                    <button type="button" class="btn px-3 btn-sm bg-primary-color" onclick="updatePassword()">Save
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Password ENDS -->
    <script src="/js/dashboard.js"></script>
@endsection