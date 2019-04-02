<?php

namespace App\Http\Controllers\APIControllers;

use App\Http\Controllers\Controller;
use App\OrderDescription;
use App\Util\DBHelper;
use Illuminate\Http\Request;

class OrderDescriptionController extends Controller
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
        DBHelper::connectToDB($request->company_id);
        $order = OrderDescription::on($request->company_id)->create($request->except('company_id'));

        return $order;
    }

    //recieve array of order descriptions saved offline on mobile
    //and sent to server at once and save
    public function multiStore(Request $request)
    {
        $company_id = $request->toArray()[0]['company_id'];
        $performa_no = $request[0]['performa_no'];
        DBHelper::connectToDB($company_id);
        $order_descriptions = $request->toArray();
        foreach ($order_descriptions as $order_description) {
            //remove company_id from the request body
            unset($order_description['id']);
            unset($order_description['company_id']);
            $order = OrderDescription::on($company_id)->create($order_description);
        }

        return $performa_no;
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
    public function destroy(Request $request, $id)
    {
        DBHelper::connectToDB($request->company_id);
        $order_description = OrderDescription::on($request->company_id)->find($id);
        $order_description->update(['active' => 0]);
        return $order_description;
    }
}
