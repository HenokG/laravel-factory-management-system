<?php

namespace App\Http\Controllers\APIControllers;

use App\CustomerCompany;
use App\Util\DBHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class CustomerCompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        DBHelper::connectToDB($request->company_id);
        $active_customers = CustomerCompany::on($request->company_id)->where('active', 1)->get();

        //modify img url for loading in mobile service
        foreach ($active_customers as $active_customer){
            $active_customer->logo = '/uploads/customer_company_logos/' . $active_customer->logo;
        }
        return $active_customers;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->tin_no = str_replace('"', '', $request->tin_no);
        $request->owner_name = str_replace('"', '', $request->owner_name);
        $request->fax = str_replace('"', '', $request->fax);
        $request->manager_tel = str_replace('"', '', $request->manager_tel);
        $request->name = str_replace('"', '', $request->name);
        $request->owner_email = str_replace('"', '', $request->owner_email);
        $request->owner_tel = str_replace('"', '', $request->owner_tel);
        $request->manager_email = str_replace('"', '', $request->manager_email);
        $request->manager_name = str_replace('"', '', $request->manager_name);

        $db_name = $request->company_id;
        DBHelper::connectToDB($db_name);
        //check for logo submition then upload
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoName = $request['name'] . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('uploads\customer_company_logos'), str_replace('"', '', $logoName));
            $customer_company = new CustomerCompany();
            $customer_company->tin_no = $request->tin_no;
            $customer_company->owner_name = $request->owner_name;
            $customer_company->fax = $request->fax;
            $customer_company->manager_tel = $request->manager_tel;
            $customer_company->name = $request->name;
            $customer_company->owner_email = $request->owner_email;
            $customer_company->owner_tel = $request->owner_tel;
            $customer_company->manager_email = $request->manager_email;
            $customer_company->manager_name = $request->manager_name;
            $customer_company->logo =  str_replace('"', '', $logoName);
            Log::info(collect($customer_company));
            $new_customer = CustomerCompany::on($db_name)->create(collect($customer_company)->all());
            return $new_customer;
        }else{
            $new_customer = CustomerCompany::on($db_name)->create($request->except(['company_id', 'id']));
            return $new_customer;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DBHelper::connectToDB($request->company_id);
        $customer = CustomerCompany::on($request->company_id)->find($id);
        $customer->update($request->except('company_id', 'id', 'active'));
        return $customer;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        DBHelper::connectToDB($request->company_id);
        $customer = CustomerCompany::on($request->company_id)->find($id);
        $customer->update(['active' => 0]);
        return $customer;
    }
}
