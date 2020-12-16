<?php

namespace App\Http\Controllers;

use App\Category;
use App\FixingDetail;

use App\Product;
use App\SubCategory;
use Illuminate\Http\Request;

class MarketController extends Controller
{
    public function shopMain($categoryCode, $subCategoryCode)
    {
       $category = '';
       $mainCategory = Category::where('code', $categoryCode)->first();
       foreach ($mainCategory->subCategories as $sub) {
           if ($sub->code == $subCategoryCode){
               $category = $sub;
           }
       }


       $products = $category->products()->withTranslations()->paginate(10);

       return view('pages.market.main', ['category' => $category,'products'=>$products, 'nds' => 0.85]);
    }
    public function sortAjax($categoryCode, $subCategoryCode)
    {
       // $category = SubCategory::where('code', $subCategoryCode)->first();
        $query = request('query2');
        $category = '';
       $mainCategory = Category::where('code', $categoryCode)->first();
       foreach ($mainCategory->subCategories as $sub) {
           if ($sub->code == $subCategoryCode){
               $category = $sub;
           }
       }
        $products = $category->products();

        if(isset(request()->attrs)){
            foreach(request()->attrs as $key => $val){
               $products = $products->whereIn($key, $val);
            }

        }
        if(isset(request()->color)){
               $products = $products->whereIn('color_id', request()->color);
        }
        if(isset(request()->quantity)){
        $c=count(request()->quantity);
          if($c == 1){
            foreach(request()->quantity as $quantity){
              if($quantity == 0){
                $products = $products->where('quantity', 0);

              }else{
                // dd($quantity);
              $products = $products->where('quantity','>=', $quantity);
              }
            }
          }else{
              $products = $products->where('quantity','>=', 0);
          }
        }
        if(isset(request()->min_price) && isset(request()->max_price)){
          $products = $products->where('price','>=', request()->min_price);
          $products = $products->where('price','<=', request()->max_price);
        }
          $products = $products->where('name', 'LIKE', "%$query%")->orderBy('price',request()->order)->paginate(request()->per_page)->onEachSide(2);

       return view('components.market.sort',compact('products'));
    }

    public function shopInner($categoryCode, $subcategoryCode, $modelCode)
    {
        $details='';
        $accessuars='';
        $product = Product::where('code', $modelCode)->with('translations')->first();
        $product->installation = FixingDetail::where('id', $product->fixing_id)->with('translations')->first();
        $detail_cats = SubCategory::where('category_id', 18)->get();
        foreach($detail_cats as $det){
            $details = $det->products();
        }
        $access_cats = SubCategory::where('category_id', 18)->get();
        foreach($access_cats as $acc){
            $accessuars = $acc->products();
        }

        return view('pages.market.product', compact('product','details','accessuars'));
    }
}
