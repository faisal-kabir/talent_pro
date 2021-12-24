<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\product;
use Exception;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function allProducts()
    {
        try{
            $data=Product::get();
            return ProductController::makeResponse(true,null,$data);
        } catch (Exception $e){
            return ProductController::makeResponse(false,null,null);
        }
    }

    public function store(Request $request)
    {
        try{
            $data=Product::create($request->all());
            return ProductController::makeResponse(true,null,$data);
        } catch (Exception $e){
            return ProductController::makeResponse(false,'Please input valid data',null);
        }
    }



    public function update(Request $request,$id)
    {   
        $pro = Product::find($id);
        if($pro==null){
            return ProductController::makeResponse(false,'Product not found',null);
        }
        try{
            $data = [
                'name' => $request->name,
                'details' => $request->details,
                'price' => $request->price,
            ];
            $pro->update($data);
            return ProductController::makeResponse(true,null,$request->all());
        } catch (Exception $e){
            return ProductController::makeResponse(false,'Please input valid data',null);
        }
    }

    public function delete($id)
    {   
        $pro = Product::find($id);
        if($pro==null){
            return ProductController::makeResponse(false,'Product not found',null);
        }
        try{
            $pro->delete();
            return ProductController::makeResponse(true,null,null);
        } catch (Exception $e){
            return ProductController::makeResponse(false,'Please input valid data',null);
        }
    }


    static function makeResponse(bool $status,$message,$data){
        return response()->json(
            [
                'status'=>$status,
                'message'=> $message==null ? ($status ? 'success' : 'error') : $message,
                'data'=>$data
            ],
            200
        );
    }
}
