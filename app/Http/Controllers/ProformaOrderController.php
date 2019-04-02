<?php

namespace App\Http\Controllers;

use App\Util\DBHelper;
use App\ProformaOrder;
use App\ProformaEntry;
use App\ProformaPackage;
use App\Util\FinalConstants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProformaOrderController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        DBHelper::connectToDB(Session::get(FinalConstants::SESSION_COMPANYID_LABEL));

        $xorders = ProformaOrder::on(Session::get(FinalConstants::SESSION_COMPANYID_LABEL))->get()->all();
        return view('sales.proformas', [
            'proformas' => $xorders
        ]);
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
        DBHelper::connectToDB(Session::get(FinalConstants::SESSION_COMPANYID_LABEL));

        $order = new ProformaOrder();
        $order->note = $request->get('excel')['note'];
        $order->fsno = $request->get('excel')['info']['fs'];
        $order->company_name = $request->get('excel')['info']['company'];
        $order->delivery_date = $request->get('excel')['info']['delivery date'];
        $order->delivery_date_et = $request->get('excel')['info']['delivery date eth'];
        $order = ProformaOrder::on(Session::get(FinalConstants::SESSION_COMPANYID_LABEL))->create($order->toArray());

        foreach ($request->get('excel')['orders'] as $packageObj) {

            $package = new ProformaPackage();
            $package->proforma_no = $order->proforma_no;
            $package->name = $packageObj["name"];
            key_exists("m2", $packageObj) ? $package->unit_price = $packageObj["m2"] : '';
            key_exists("M2", $packageObj) ? $package->unit_price = $packageObj["M2"] : '';
            key_exists("bullnose", $packageObj) ? $package->bullnose = $packageObj["bullnose"] : '';
            key_exists("Bullnose", $packageObj) ? $package->bullnose = $packageObj["Bullnose"] : '';
            key_exists("groove", $packageObj) ? $package->groove = $packageObj["groove"] : '';
            key_exists("Groove", $packageObj) ? $package->groove = $packageObj["Groove"] : '';
            $latest_packageid = ProformaPackage::on(Session::get(FinalConstants::SESSION_COMPANYID_LABEL))->create($package->toArray())->id;

            foreach ($packageObj["data"] as $entryJSON) {
                $entry = new ProformaEntry();
                $entry->package_id = $latest_packageid;
                $entry->index = $entryJSON[0];
                $entry->length = $entryJSON[1];
                $entry->width = $entryJSON[2];
                $entry->thick = $entryJSON[3];
                $entry->pcs = $entryJSON[4];
                $entry->remark = $entryJSON[5] ?? '';
                ProformaEntry::on(Session::get(FinalConstants::SESSION_COMPANYID_LABEL))->create($entry->toArray());
            }
        }
        return 'success';
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProformaOrder $xorder
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        DBHelper::connectToDB(Session::get(FinalConstants::SESSION_COMPANYID_LABEL));

        $order = ProformaOrder::on(Session::get(FinalConstants::SESSION_COMPANYID_LABEL))->where('proforma_no', $id)->first();
        $whole_array = [];
        $packages = ProformaPackage::on(Session::get(FinalConstants::SESSION_COMPANYID_LABEL))->where([
            'proforma_no' => $order->proforma_no
        ])->get();

        foreach ($packages as $package) {
            $data_array = [];
            $xorder_entries = ProformaEntry::on(Session::get(FinalConstants::SESSION_COMPANYID_LABEL))->where('package_id', $package->id)->get();

            foreach ($xorder_entries as $xorder_entry) {
                $temp_xorder_entry = [$xorder_entry->index, $xorder_entry->length,
                    $xorder_entry->width, $xorder_entry->thick, $xorder_entry->pcs, $xorder_entry->remark,
                ];
                array_push($data_array, $temp_xorder_entry);
            }
            $package["data"] = $data_array;
            array_push($whole_array, array_except($package, ['id', 'proforma_no', 'created_at', 'updated_at']));
        }
        return view('sales.proforma', [
            'proforma' => json_encode($whole_array),
            'order' => $order
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProformaOrder $xorder
     * @return \Illuminate\Http\Response
     */
    public function edit(ProformaOrder $xorder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\ProformaOrder $xorder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProformaOrder $xorder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProformaOrder $xorder
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProformaOrder $xorder)
    {
        //
    }
}
