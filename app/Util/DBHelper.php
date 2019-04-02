<?php
/**
 * Created by PhpStorm.
 * User: Henok G
 * Date: 8/30/2018
 * Time: 4:10 PM
 */

namespace App\Util;


use App\Company;
use App\Department;
use App\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;

class DBHelper
{

    //because every company has its own database we need to switch between
    //each one for connection and this method switches between the given db_name
    public static function connectToDB($db_name)
    {
        $new_connection_parameters = [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => $db_name,
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
        ];
        Config::set("database.connections.$db_name", $new_connection_parameters);
    }

    //setup tables for each company database
    public static function createTablesForNewCompany($id)
    {

        //create departments table
        Schema::connection($id)->create('departments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        //create users table
        Schema::connection($id)->create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->unique();
            $table->integer('department_id')->nullable();
            $table->string('password');
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        //create proforma orders table
        Schema::connection($id)->create('proforma_orders', function (Blueprint $table) {
            $table->increments('proforma_no');
            $table->string('company_name');
            $table->string('delivery_date')->nullable();
            $table->string('delivery_date_et')->nullable();
            $table->string('fsno')->nullable();
            $table->string('note')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        //create proforma package table
        Schema::connection($id)->create('proforma_packages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('proforma_no');
            $table->string('name');
            $table->double('unit_price');
            $table->double('bullnose')->nullable();
            $table->double('groove')->nullable();
            $table->timestamps();
        });

        //create proforma entry table
        Schema::connection($id)->create('proforma_entries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('package_id');
            $table->integer('index');
            $table->double('length');
            $table->double('width');
            $table->double('thick');
            $table->integer('pcs');
            $table->string('remark')->default('');
            $table->timestamps();
        });

        //create delivery orders table
        Schema::connection($id)->create('delivery_orders', function (Blueprint $table) {
            $table->increments('delivery_no');
            $table->string('company_name');
            $table->string('delivery_date')->nullable();
            $table->string('delivery_date_et')->nullable();
            $table->string('fsno')->nullable();
            $table->string('note')->nullable();
            $table->boolean('sent_to_production')->default(false);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        //create delivery package table
        Schema::connection($id)->create('delivery_packages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('delivery_no');
            $table->string('name');
            $table->double('unit_price');
            $table->double('bullnose')->nullable();
            $table->double('groove')->nullable();
            $table->timestamps();
        });

        //create delivery entry table
        Schema::connection($id)->create('delivery_entries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('package_id');
            $table->integer('index');
            $table->double('length');
            $table->double('width');
            $table->double('thick');
            $table->integer('pcs');
            $table->string('remark')->default('');
            $table->timestamps();
        });

        //create customer_company table
        Schema::connection($id)->create('customer_companies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('tin_no')->nullable();
            $table->string('logo')->nullable();
            $table->string('fax')->nullable();
            $table->string('manager_name');
            $table->string('manager_email');
            $table->integer('manager_tel');
            $table->string('owner_name')->nullable();
            $table->string('owner_email')->nullable();
            $table->integer('owner_tel')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        //create agreements table
        Schema::connection($id)->create('agreements', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('performa_no');
            $table->integer('customer_id');
            $table->integer('user_id');
            $table->string('agreement_file');
            $table->double('total_amount');
            $table->double('down_payment');
            $table->date('delivery_date');
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

    }

    //create default entries for the tables
    public static function initializeDefaultEntries($id)
    {
        //enter a factory Management Department
        $department = new Department();
        $department->changeDB($id);
        $department->name = FinalConstants::DEPARTMENT_FACTORY_MANAGEMENT_LABEL;
        $department->save();

        //enter a shift Management Department
        $department = new Department();
        $department->changeDB($id);
        $department->name = FinalConstants::DEPARTMENT_PRODUCTION_MANAGEMENT_LABEL;
        $department->save();

        //enter a default Sales Department
        $department = new Department();
        $department->changeDB($id);
        $department->name = FinalConstants::DEPARTMENT_SALES_LABEL;
        $department->save();

        //enter a default Secretary Department
        $department = new Department();
        $department->changeDB($id);
        $department->name = FinalConstants::DEPARTMENT_SECRETARY_LABEL;
        $department->save();

    }

    public static function setDefaultAccounts($id)
    {
        //initialize default sales account
        $user = new User();
        $user->changeDB($id);
        $user->username = 'sales@' . Company::find($id)->name . '.com';
        $user->password = bcrypt('sales');
        $user->department_id = Department::on($id)->where('name', FinalConstants::DEPARTMENT_SALES_LABEL)->first()->id;
        $user->save();

        //initialize default production manager account
        $user = new User();
        $user->changeDB($id);
        $user->username = 'productionmanager@' . Company::find($id)->name . '.com';
        $user->password = bcrypt('production');
        $user->department_id = Department::on($id)->where('name', FinalConstants::DEPARTMENT_PRODUCTION_MANAGEMENT_LABEL)->first()->id;
        $user->save();

    }

}