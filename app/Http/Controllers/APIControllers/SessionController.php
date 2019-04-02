<?php

namespace App\Http\Controllers\APIControllers;

use App\Company;
use App\User;
use App\Util\DBHelper;
use App\Util\UsersUtil;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;

class SessionController extends Controller
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'username' => 'required',
            'password' => 'required|min:4'
        ]);

        $user_company_name = UsersUtil::getCompanyFromUserEmail($request->username);

        $user_company = Company::where(['name' => $user_company_name, 'status' => 'Approved'])->first();

        //Does the company exist at all in our database if not well...
        if (!$user_company) {
            return response('Please Provide A Valid Company Address!', 300);
        }

        $user_company_id = Company::where('name', '=', $user_company_name)->first()->id;
        DBHelper::connectToDB($user_company_id);

        $user = User::on($user_company_id)->where('username', $request->username)->first();

        if (!$user) {
            return response('Email Address Not Found!', 300);
        }

        //if password matches
        if ($user && Hash::check($request->password, $user->password)) {
            //add company id to result so for the consecutive requests company id is accepted
            return $user->toArray() + ['company_id' => $user_company_id];
        }

        return response('Improper Credentials', 300);

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
