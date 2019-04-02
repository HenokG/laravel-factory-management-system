<?php

namespace App\Http\Controllers;

use App\Company;
use App\User;
use App\Util\DBHelper;
use App\Util\FinalConstants;
use App\Util\UsersUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
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
    public function update(Request $request, $user)
    {
        //get the username from request then retrieve company name from
        //username
        $company_name = UsersUtil::getCompanyFromUserEmail($request->username);
        //get company id from company name
        $company_id = Company::where('name', $company_name)->first()->id;

        //use company id to connect to the database(which is company id)
        DBHelper::connectToDB($company_id);

        $user = User::on($company_id)->find($user);
        $user->password = bcrypt($request->password);
        $user->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public static function logIn(Request $request)
    {
        
    }
}
