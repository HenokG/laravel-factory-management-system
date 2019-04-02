<?php

namespace App\Http\Controllers;

use App\Agreement;
use App\Util\DBHelper;
use App\Util\FinalConstants;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AgreementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $db_name = Session::get(FinalConstants::SESSION_COMPANYID_LABEL);
        DBHelper::connectToDB($db_name);
        $agreements = Agreement::on($db_name)->where('active', 1)->get();

        return view('sales/agreement_dashboard')->with([
            'agreements' => $agreements
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
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
        $this->validate($request, [
            'customer_id' => 'required',
            'performa_no' => 'required',
            'agreement_file' => 'required',
            'delivery_date' => 'required'
        ]);

        $db_name = Session::get(FinalConstants::SESSION_COMPANYID_LABEL);
        DBHelper::connectToDB($db_name);

        //check if any agreements exist with the given performa_no
        if (Agreement::on($db_name)->where('performa_no', $request->performa_no)->first()) {
            return redirect()->back()->withErrors([
                'Order Already Has An Agreement'
            ]);
        }

        try {

            $agreement_file = $request->file('agreement_file');
            //if agreement_file is submitted
            if (!is_null($agreement_file)) {
                $agreement_fileName = $request->performa_no.'.'.$agreement_file->getClientOriginalExtension();
                $agreement_file->move(public_path('/uploads/agreement_files'), $agreement_fileName);

                $agreement = $request->all();
                $agreement['agreement_file'] = $agreement_fileName;
                Agreement::on($db_name)->create($agreement);
            }

        } catch (QueryException $exception) {
            return redirect()->back()->withInput()->withErrors([
                'message' => 'Agreement Error'.$exception
            ]);
        }

        return redirect('/agreements')->with([
            'notification_message' => 'Agreement Created!'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Agreement  $agreement
     * @return \Illuminate\Http\Response
     */
    public function show(Agreement $agreement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Agreement  $agreement
     * @return \Illuminate\Http\Response
     */
    public function edit(Agreement $agreement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Agreement  $agreement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Agreement $agreement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Agreement  $agreement
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $db_name = Session::get(FinalConstants::SESSION_COMPANYID_LABEL);
        DBHelper::connectToDB($db_name);
        $agreement = Agreement::on($db_name)->find($id);
        $agreement->active = 0;
        $agreement->save();
        return ['notification_message' => 'Agreement Deleted!'];
    }
}
