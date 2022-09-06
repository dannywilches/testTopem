<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bills;
use App\Models\BillsDetail;
use DB;

class BillsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bills = Bills::all();
        return $bills;
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
        $last_bill = DB::table('bill')->max('bill_number');

        $bill = new Bills();
        $bill->bill_number = $last_bill+1;
        $bill->date_bill = now();
        $bill->customer = $request->customer;
        $bill->vendor = $request->vendor;

        $bill->save();
        $bill_id = $bill->id;

        $total_value = 0;
        foreach ($request->list_items as $value) {
            $bill_detail = new BillsDetail();
            $bill_detail->item_description = $value["item_description"];
            $bill_detail->quantity = intval($value["quantity"]);
            $bill_detail->unit_value = intval($value["unit_value"]);
            $bill_detail->total_value = intval($value["total_value"]);
            $bill_detail->bill_id = $bill_id;
            $bill_detail->save();

            $total_value += ($value["total_value"]);
        }
        $total_iva = ($total_value*19)/100;
        $total_before_iva = $total_value-$total_iva;

        $bill->value_before_iva = $total_before_iva;
        $bill->iva = $total_iva;
        $bill->total_value = $total_value;

        $bill->save();
        // return response()->json([], 200, 'Factura registrada');
        return [$bill, $bill_detail];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bill = Bills::with('ItemBills')->find($id);
        return $bill;
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
        $total_value = 0;
        foreach ($request->list_items as $value) {
            $bill_detail = BillsDetail::find($value["id"]);
            if ($bill_detail == null) {
                $bill_detail = new BillsDetail();
                $bill_detail->bill_id = $id;
            }
            $bill_detail->item_description = $value["item_description"];
            $bill_detail->quantity = intval($value["quantity"]);
            $bill_detail->unit_value = intval($value["unit_value"]);
            $bill_detail->total_value = intval($value["total_value"]);
            $bill_detail->save();

            $total_value += ($value["total_value"]);
        }
        $total_iva = ($total_value*19)/100;
        $total_before_iva = $total_value-$total_iva;

        $bill = Bills::find($id);
        $bill->customer = $request->customer;
        $bill->vendor = $request->vendor;
        $bill->value_before_iva = $total_before_iva;
        $bill->iva = $total_iva;
        $bill->total_value = $total_value;

        $bill->save();
        // return response()->json([], 200, 'Factura registrada');
        return [$bill, $bill_detail];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bill = Bills::find($id);
        $bill->delete();
        return response()->json($bill, 200);
    }
}
