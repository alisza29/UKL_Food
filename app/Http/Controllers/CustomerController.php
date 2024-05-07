<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ordermodel;
use App\Models\detailmodel;
use App\Models\foodmodel;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['getfood', 'order']]);
    }

    public function getfood() // get food cust & admin
    {
        $dt_food = foodmodel::get();
        return response()->json($dt_food);
    }

    public function semuaorder() //get semua order punya admin aja
    {
        $orders = ordermodel::with('order_detail')->get();

        $response = [
            'status' => true,
            'data' => $orders,
            'message' => 'Order list has retrieved'
        ];

        return response()->json($response);
    }

    public function satuorder($id) //get order by id punya admin aja
    {
        $dt_detail = ordermodel::where('id_order', $id)->first();
        return response()->json($dt_detail);
    }

    public function order(Request $req) //cust
    {
        $validator = Validator::make($req->all(), [
            'name' => 'required',
            'table_number' => 'required|numeric',
            'order_date' => 'required|date',
            'order_detail.*.id_food' => 'required|exists:food,id_food',
            'order_detail.*.price' => 'required|numeric',
            'order_detail.*.quantity' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $order = ordermodel::create([
            'name' => $req->name,
            'table_number' => $req->table_number,
            'order_date' => $req->order_date,
        ]);

        if ($order) {
            foreach ($req->order_detail as $detail) {
                detailmodel::create([
                    'id_order' => $order->id,
                    'id_food' => $detail['id_food'],
                    'price' => $detail['price'],
                    'quantity' => $detail['quantity'],
                ]);
            }
            return response()->json([
                'status' => true,
                'data' => [
                    'id' => $order->id,
                    'name' => $order->name,
                    'table_number' => $order->table_number,
                    'order_date' => $order->order_date,
                    'createdAt' => $order->created_at,
                    'updatedAt' => $order->updated_at,
                ],
                'message' => 'Order list has created'
            ]);
        } else {
            return response()->json(['status' => 0]);
        }
    }
}