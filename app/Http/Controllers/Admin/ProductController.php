<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $per_page = $request->query('per_page') ? $request->query('per_page') : 10;

        return Product::paginate($per_page);
    }

    public function uploadImage($image)
    {
        $exploded_base64 = explode(',', $image);
        $decoded_base64  = base64_decode($exploded_base64[1]);
        $extention = $this->string_between_two_string($exploded_base64[0], '/', ';');
        
        $fileName = 'pro_'.time().'.'.$extention;
        $path = storage_path('app/public/').$fileName;
    
        file_put_contents($path,$decoded_base64);   
        
        return $fileName;
    }

    public function string_between_two_string($str, $starting_word, $ending_word){
        $arr = explode($starting_word, $str);
        if (isset($arr[1])){
            $arr = explode($ending_word, $arr[1]);
            return $arr[0];
        }
        return '';
    }

    public function show(Product $product)
    {
        return $product;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'is_refill' => 'required',
            'price' => 'required',
        ]);

        $image_req = str_contains($request->image,'base64');

        if($image_req){
            $fileName = $this->uploadImage($request->image);
        }

        $created = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'is_refill' => $request->is_refill,
            'image' => $image_req ? $fileName : null ,
            'price' => $request->price
        ]);

        return $created;
    }

    public function update(Product $product,Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
        ]);

        if(str_contains($request->image,'base64')){
            if($product->image){
                Storage::delete('app/public/updloads/'.$product->image);
            }

            $product->image =  $this->uploadImage($request->image);
        }

        $product->name = $request->name;
        $product->is_refill = $request->is_refill;
        $product->description = $request->description;
        $product->price = $request->price;
    
        $product->save();

        return 'success';

    }

    public function delete(Product $product)
    {
        if($product->image){
            Storage::delete('app/public/updloads/'.$product->image);
        }
        $product->delete();
    }

}
