<?php

namespace App\Http\Controllers\APIControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Util\DBHelper;
use App\ProformaOrder;
use League\Flysystem\Config;

class OrderController extends Controller
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
        $order = ProformaOrder::on($request->company_id)->create($request->only('delivery_date', 'delivery_no', 'customer_id', 'user_id'));

        return $order;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        DBHelper::connectToDB($request->company_id);
        return ProformaOrder::on($request->company_id)->find($id);
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
        $order = ProformaOrder::on($request->company_id)->find($id);
        $order->update($request->except('company_id'));
        return $order;        
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
        $order = ProformaOrder::on($request->company_id)->find($id);
        $order->update(['active' => 0]);
        $order->agreement()->update(['active' => 0]);
        return $order;
    }
    
    public function performaNos(Request $request, $company_id)
    {
        DBHelper::connectToDB($company_id);
        $performa_nos = ProformaOrder::on($company_id)->active()->where('customer_id', $request->customer_id)->pluck('performa_no');
        return $performa_nos;
    }
}
