<?php

namespace App;

use App\Util\FinalConstants;
use Illuminate\Support\Facades\Session;

class Admin extends CustomModel
{

    public function login()
    {
        Session::put(FinalConstants::SESSION_LOGGEDIN_ADMIN_LABEL, $this->username);
        Session::put(FinalConstants::SESSION_LOGGEDIN_ADMINID_LABEL, $this->id);
    }

}
