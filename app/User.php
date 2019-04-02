<?php

namespace App;


use App\Util\FinalConstants;
use App\Util\UsersUtil;
use Illuminate\Support\Facades\Session;

class User extends CustomModel
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    public function changeDB($conn)
    {
        $this->connection = $conn;
    }

    public function departmentName()
    {
        return $this->belongsTo(\App\Department::class, 'department_id');
    }

    public function companyName()
    {
        return UsersUtil::getCompanyFromUserEmail($this->username);
    }

    public function login()
    {
        Session::put(FinalConstants::SESSION_LOGGEDINUSER_LABEL, $this->username);
        Session::put(FinalConstants::SESSION_LOGGEDINUSERID_LABEL, $this->id);
        $user_company_name = UsersUtil::getCompanyFromUserEmail($this->username);
        $user_company_id = Company::where('name', '=', $user_company_name)->first()->id;
        Session::put(FinalConstants::SESSION_COMPANYID_LABEL, $user_company_id);
        if ($this->departmentName->name) {
            Session::put('department', $this->departmentName->name);
        }
    }
}
