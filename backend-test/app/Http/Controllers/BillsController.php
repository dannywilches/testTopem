<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bills;
use App\Models\BillsDetail;
use DB;

class BillsController extends Controller
{
    /**
     * Funcioón que devuelve todas las facturas en el sistema
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
     * Función para crear facturas nuevas, donde se realiza primero la creación de la factura,
     * una vez creada se guardan los items en la tabla auxiliar y una vez calculados los valores
     * los actualiza en la tabla principal
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
        return response()->json('Factura registrada', 201);
    }

    /**
     * Trae la información de la factura solicita de acuerdo al parametro enviado junto con
     * la información detallada de la factura
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
     * Actualiza la información de la factura y sus respectivos elementos, en caso de agregarse
     * mas elementos son ingresados también
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
        return response()->json('Factura actualizada', 201);
    }

    /**
     * Elimina la factura indicada por parametro
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bills_detail = BillsDetail::where('bill_id', $id)->delete();
        $bill = Bills::find($id);
        $bill->delete();
        return response()->json('Factura eliminada', 201);
    }
}
