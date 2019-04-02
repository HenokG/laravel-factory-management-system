<?php
/**
 * Created by PhpStorm.
 * User: Henok G
 * Date: 8/30/2018
 * Time: 10:15 PM
 */

namespace App\Util;


use App\Company;

class UsersUtil
{
    public static function getCompanyFromUserEmail($email)
    {
        $regex = '/@([a-z A-Z0-9_]*)./';
        preg_match_all($regex, $email, $match);
        return $match[1][0];
    }
}