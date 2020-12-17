<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Spatie\Searchable\Search;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\FixingDetail;
use App\Category;
use App\SubCategory;
use App\Product;


class MainController extends Controller
{
    public function main () {
        $popularCategories = Category::where('is_popular', 1)->get();
        return view('pages.main', compact('popularCategories'));
    }
    public function contacts()
    {
        $our_teams = \DB::table('our_team')->get();
        $service_centers = \DB::table('service_centers')->get();

        return view('pages.contacts', compact('our_teams','service_centers'));
    }
    public function about()
    {
        return view('pages.about');
    }
    public function delivery()
    {
        return view('pages.delivery');
    }
    public function responsibility()
    {
        return view('pages.responsibility');
    }
    public function guarantee()
    {
        return view('pages.guarantee');
    }

    public function search(Request $request)
    {
       $searchResults = (new Search())
            ->registerModel(Product::class, 'name')
            ->registerModel(FixingDetail::class, 'name')
            ->perform($request->input('query'));

        return view('components.search', compact('searchResults'));
    }

    public function searchAjax(Request $request){
            // dd(request('query2'));
        if($request->ajax()) {
            if(request('query')){

            $data = (new Search())
            ->registerModel(FixingDetail::class, 'name')
            ->registerModel(Product::class, 'name')
            ->perform($request->input('query'));

            return view('components.search-ajax',compact('data'));
            }elseif(request('query2')) {
                // // dd(request('query2'));
                // $category = '';
                // $query = request('query2');
                // $mainCategory = Category::where('code', request('category'))->first();
                // foreach ($mainCategory->subCategories as $sub) {
                //    if ($sub->code == request('subcategory')){
                //        $category = $sub;
                //    }
                // }
                // // if($query == 0){
                //  // $products = $category->products()->withTranslations()->paginate(12);
                // // }else{
                //  $products = $category->products()->where('name', 'LIKE', "%$query%")->withTranslations()->paginate(12);
                // // }
                //  // dd($products);
                // return view('components.market.sort',compact('products'));
            }
        }
    }

    public function sendFeedback()
    {
        $details = request()->all();

        \Mail::to('giyosiddinmirzaboyev@gmail.com')->send(new \App\Mail\FeedbackMail($details));

        return 'Сообщение успешно отправлено.';
    }

    public function gravy()
    {
        $products = Product::where('color_id', null)->orWhere('quality_id', null)->get();
        return view('vendor.voyager.EmptyProducts.gravy', compact('products'));
    }


}
