<?php
/**
 * Created by PhpStorm.
 * User: Henok G
 * Date: 8/30/2018
 * Time: 5:16 PM
 */

namespace App\Util;


class FinalConstants
{

    const DEPARTMENT_SALES_LABEL = "Sales";
    const DEPARTMENT_FACTORY_MANAGEMENT_LABEL = "Factory Management";
    const DEPARTMENT_PRODUCTION_MANAGEMENT_LABEL = "Production Management";
    const DEPARTMENT_SECRETARY_LABEL = "Secretary";
    //users
    const SESSION_LOGGEDINUSER_LABEL = "loggedInUser";
    const SESSION_DEPARTMENT_LABEL = "department";
    const SESSION_COMPANYID_LABEL = "companyId";
    const SESSION_LOGGEDINUSERID_LABEL = 'loggedInUserId';
    //admins
    const SESSION_LOGGEDIN_ADMIN_LABEL = 'loggedInAdmin';
    const SESSION_LOGGEDIN_ADMINID_LABEL = 'loggedInAdminId';

    //app configs
    const PAGINATION_ITEM_COUNT = 10;

    //database migration enums
    //company table enums
    const COMPANY_STATUS_APPROVED = 'Approved';
    const COMPANY_STATUS_SUSPENDED = 'Suspended';
    const COMPANY_STATUS_DELETED = 'Deleted';

    //admin table enums
    const ADMIN_PRIVILEGE_SUPPORT = 'Support';
    const ADMIN_PRIVILEGE_DEVELOPER = 'Developer';

}