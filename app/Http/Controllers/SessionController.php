<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Company;
use App\User;
use App\Util\DBHelper;
use App\Util\FinalConstants;
use App\Util\UsersUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class SessionController extends Controller
{

    public function index()
    {
        return redirect("/login");
    }


    public function create()
    {
        if (Session::has(FinalConstants::SESSION_LOGGEDINUSER_LABEL) && Session::has(FinalConstants::SESSION_COMPANYID_LABEL)) {
            return redirect('/customers');
        } else if (Session::has(FinalConstants::SESSION_LOGGEDIN_ADMIN_LABEL)) {
            return redirect('/companies');
        }
        return view('login');
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'username' => 'required',
            'password' => 'required|min:4'
        ]);

        $admin = Admin::where('username', $request->username)->first();

        //if admin account is found check for password and
        //pass them through but if not found check for user login
        if ($admin) {

            if ($admin && Hash::check($request->password, $admin->password)) {

                $admin->login();

                return redirect('/companies');

            } else {

                return back()->withInput()->withErrors([
                    'message' => 'Improper Credentials'
                ]);

            }

        }

        $user_company_name = UsersUtil::getCompanyFromUserEmail($request->username);

        $user_company = Company::where(['name' => $user_company_name])->first();

        //Does the company exist at all in our database if not well...
        if (!$user_company) {
            return redirect()->back()->withErrors([
                'Company Doesn\'t Exist!'
            ]);
        }

        $valid_user_company = Company::where(['status' => FinalConstants::COMPANY_STATUS_APPROVED])->first();

        //is company approved if not well...
        if (!$valid_user_company) {
            return redirect()->back()->withErrors([
                'Company Has Been Suspended!'
            ]);
        }

        $user_company_id = Company::where('name', '=', $user_company_name)->first()->id;
        DBHelper::connectToDB($user_company_id);

        $user = User::on($user_company_id)->where('username', $request->username)->first();

        if (!$user) {
            return redirect("/login")->withErrors([
                'Email Address Not Found!'
            ]);
        }

        if ($user && Hash::check($request->password, $user->password)) {
            $user->login();
        } else {
            return back()->withInput()->withErrors([
                'message' => 'Improper Credentials'
            ]);
        }
        if (Session::get(FinalConstants::SESSION_DEPARTMENT_LABEL) === FinalConstants::DEPARTMENT_SALES_LABEL) {

            return redirect('/customers');

        } else if (Session::get(FinalConstants::SESSION_DEPARTMENT_LABEL) == FinalConstants::DEPARTMENT_PRODUCTION_MANAGEMENT_LABEL) {

            return redirect('/deliveries');

        }

    }

    public function destroy()
    {
        Session::flush();
        return redirect('/');
    }

}
