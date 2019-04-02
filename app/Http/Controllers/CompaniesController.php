<?php

namespace App\Http\Controllers;

use App\Company;
use App\User;
use App\Util\DBHelper;
use App\Util\FinalConstants;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CompaniesController extends Controller
{
    public function index()
    {

        $companies = Company::whereRaw('status="Approved" OR status="Suspended"')->get();

        //send users data for password editing by admin
        $users = array();

        //concatenate every companies user by going through each
        //database and getting users from that company
        foreach ($companies as $company) {
            DBHelper::connectToDB($company->id);
            $user = User::on($company->id)->get(['id', 'username']);
            array_push($users, $user);
        }

        return view('companies', [
            'companies' => $companies,
            'users' => $users
        ]);
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|min:2',
            'manager_name' => 'required|min:2',
            'manager_email' => 'required|email',
            'manager_tel' => 'required|min:9|max:12',
            'owner_name' => 'nullable|min:2',
            'owner_email' => 'nullable|email',
            'owner_tel' => 'nullable|min:9|max:12',
            'password' => 'required|min:4|confirmed'
        ]);

        try {

            //if logo is submitted
            if ($request->hasFile('logo')) {
                $logo = $request->file('logo');
                $logoName = $request->name . time() . '.' . $logo->getClientOriginalExtension();
                $logo->move(public_path('/uploads/company_logos'), $logoName);

                $company = $request->except(['password', 'password_confirmation']);
                $company['logo'] = $logoName;
                $id = Company::create($company)->id;
            } else {
                $id = Company::create($request->except(['password', 'password_confirmation']))->id;
            }

            DB::statement("CREATE DATABASE `" . $id . "`");
            DBHelper::connectToDB($id);
            DBHelper::createTablesForNewCompany($id);
            DBHelper::initializeDefaultEntries($id);
            DBHelper::setDefaultAccounts($id);

            //if there is an admin signed in
            if (Session::get(FinalConstants::SESSION_LOGGEDIN_ADMINID_LABEL)) {

                return redirect('/companies');

            }

            $user = User::on($id)->where('username', 'sales@' . Company::find($id)->name . '.com')->first();

            $user->login();

        } catch (QueryException $exception) {
            return redirect()->back()->withInput()->withErrors([
                'message' => 'Company Already Registered!' . $exception
            ]);
        }

        //if user is sales
        if (FinalConstants::DEPARTMENT_SALES_LABEL == $user->departmentName['name']) {
            return redirect("/customers");
        } else if (FinalConstants::DEPARTMENT_FACTORY_MANAGEMENT_LABEL == $user->departmentName['name']) {
            return redirect("/factorymanager/orders");
        } else if (FinalConstants::DEPARTMENT_PRODUCTION_MANAGEMENT_LABEL == $user->departmentName['name']) {
            return redirect('/shiftmanager/orders');
        }

        return 'not working';

    }


    public function create()
    {
        if (Session::has(FinalConstants::SESSION_LOGGEDINUSER_LABEL) || Session::has(FinalConstants::SESSION_LOGGEDIN_ADMINID_LABEL)) {

            if (Session::has(FinalConstants::SESSION_LOGGEDINUSER_LABEL)) {

                return redirect('/customers');

            }
            return redirect('/companies');
        }
        return view('signup');
    }

    public function show($company)
    {
        return Company::find($company);
    }

    public function update($company, Request $request)
    {
        $logo = $request->file('logo');
        //if logo is submitted
        if (!is_null($logo)) {
            $logoName = $request->name . time() . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('/uploads/company_logos'), $logoName);

            $requestCopy = $request->all();
            $requestCopy['logo'] = $logoName;

            $company = Company::findOrFail($company);
            $company->update($requestCopy);
        } else {
            $company = Company::findOrFail($company);
            $company->update($request->all());
        }
        return back();
    }


    public function destroy($company)
    {
        $company = Company::find($company);
        $company->status = "Deleted";
        $company->save();
        return $company;
    }

}