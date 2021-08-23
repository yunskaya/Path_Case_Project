<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function index(){

        $order = Order::all();

        if ($order) 
            return response($order,200);
        else 
            return response(['message'=>'Order Not Found.'],404);

    }
    public function show(Order $order)
    {
        // $order = Order::find($id);

        // if ($order) 
        //     return response($order,200);
        // else 
        //     return response(['message'=>'Order Not Found.'],404);
            
        return response($order,200);
    }
    
    public function store(Request $request)
    {

        $validator = $request->validate([
            'orderCode'=>'required|integer|unique:orders',
            'productId'=>'required|integer',
            'quantity'=>'required|integer',
            'address'=>'required|string',
            'shippingDate'=>'required|date',
        ]);

        // $input =  $request->all();
        // $order = Order::create($input);
        
        $order = new Order();
        
        $order->orderCode = $request->orderCode;
        $order->productId = $request->productId;
        $order->quantity = $request->quantity;
        $order->address = $request->address;
        $order->shippingDate = date('Y-m-d H:i:s' , strtotime($request->shippingDate));
        $order->save();

        return response([
            'data' => $order,
            'message' => 'Order Created.'
        ], 201);

    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'orderCode'=>'required|integer|unique:orders',
            'productId'=>'required|integer',
            'quantity'=>'required|integer',
            'address'=>'required|string',
            'shippingDate'=>'required',
        ]);
        // $input =  $request->all();
        // $order->update($input);
        $now_date =carbon::now()->format('Y-m-d');
        $shippingDate=date('Y-m-d',strtotime($order->shippingDate));
        
        if ($now_date>$shippingDate) {
            return response([
                'data' => $order,
                'message' => 'Order has been sent.'
            ], 400);
        }

        $order->orderCode = $request->orderCode;
        $order->productId = $request->productId;
        $order->quantity = $request->quantity;
        $order->address = $request->address;
        $order->shippingDate = date('Y-m-d H:i:s' , strtotime($request->shippingDate));
        $order->save();

        return response([
            'data' => $order,
            'message' => 'Order Updated.'
        ], 200);
    }

}
