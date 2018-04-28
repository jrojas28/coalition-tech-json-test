<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
  
  public function create() {
    $data = [
      'previouslySubmittedProducts' => Storage::exists('products.json') ? json_decode(Storage::get('products.json')) : null,
    ];
    return view('products.form', $data);
  }
  
  public function api__store(Request $request) {
    $productArr = array_merge($request->only(['name', 'stock', 'price']), ['created_at' => Carbon::now()->toDateTimeString()]);
    
    if(!Storage::exists('products.json')) {
      $productArr['id'] = 1;
      $jsonProduct = json_encode($productArr);
      Storage::put('products.json', '[' . $jsonProduct. ']');
    }
    else {
      $content = Storage::get('products.json');
      //Find the last ID
      //We add 4 becase we'd have -- id": as the last numbers
      $lastIdIndex = strpos("id", $content) + 4;
      $lastId = intval(substr($content, $lastIdIndex, 1));
      $productArr['id'] = $lastId + 1;
      $jsonProduct = json_encode($productArr);
      $newContent = substr($content, 0, -1) . "," . $jsonProduct . "]";
      Storage::put('products.json', $newContent);
    }
    return $jsonProduct;
  }

//   public function api__update(Request $request) {
    
//   }
}
