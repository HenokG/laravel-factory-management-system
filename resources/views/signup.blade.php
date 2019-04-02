@extends("master")

@section("content")

    <form method="POST" action="/company" enctype="multipart/form-data" id="signUpForm">
        {{csrf_field()}}
        {{method_field('PUT')}}
        <div class="col-md-6 offset-3" style="margin-top: 10rem;">
            <h1 class="text-center mb-5">Sign Up</h1>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" id="companyName" name="name" placeholder="Company Name *" value="{{ old('name', '') }}">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" id="ownerName" name="owner_name" placeholder="Owner Name" value="{{ old('owner_name', '') }}">
                </div>
                <div class="form-group col-md-6">
                    <input type="text" class="form-control" id="managerName" name="manager_name" placeholder="Manager Name *" value="{{ old('manager_name', '') }}" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <div class="input-group">
                        <span class="input-group-text">+251</span>
                        <input type="number" class="form-control" id="ownerTel" name="owner_tel" placeholder="Owner Telephone No" value="{{ old('owner_tel', '') }}" min="9">
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <div class="input-group">
                        <span class="input-group-text">+251</span>
                        <input type="number" class="form-control" id="managerTel" name="manager_tel" placeholder="Manager Telephone No *" value="{{ old('manager_tel', '') }}" required minlength="9"/>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="email" class="form-control" id="ownerEmail" name="owner_email" placeholder="Owner Email Address" value="{{ old('owner_email', '') }}">
                </div>
                <div class="form-group col-md-6">
                    <input type="email" class="form-control" id="managerEmail" name="manager_email" placeholder="Manager Email Address *" value="{{ old('manager_email', '') }}" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password *" required minlength="4" oninput="OnPasswordUpdated(this)">
                </div>
                <div class="form-group col-md-6">
                    <input type="password" class="form-control" invalid id="passwordConfirmation" name="password_confirmation" placeholder="Confirm Password *" required minlength="4" oninput="OnPasswordUpdated(this)">
                </div>
            </div>
            <div class="form-group">
                <label for="companyLogo">Company Logo</label>
                <input type="file" class="form-control-file form-control-sm col-sm-12 col-md-6" id="companyLogo" name="logo" value="{{ old('logo', '') }}">
            </div>
            <button type="submit" class="btn bg-primary-color">Sign Up</button>
        </div>
    </form>

    <script>
        function OnPasswordUpdated(el) {
            $("#signUpForm").addClass('was-validated');
            if ($(el).val().length <= 3) {
                $(el).prop(':invalid');
                $(el).addClass('was-validated');
            }

        }
    </script>

@endsection()
