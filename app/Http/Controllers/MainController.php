<?php

namespace App\Http\Controllers;


use SMSGatewayMe\Client\Model\SendMessageRequest;
use Artesaos\SEOTools\Facades\SEOTools;
use SMSGatewayMe\Client\Configuration;
use SMSGatewayMe\Client\Api\MessageApi;
use Artesaos\SEOTools\Facades\SEOMeta;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use SMSGatewayMe\Client\ApiClient;
use App\Mail\SendOrderToClent;
use App\Exports\OrderExport;
use Spatie\Searchable\Search;
use Illuminate\Http\Request;
use App\Mail\UnderOrderMail;
use Illuminate\Support\Str;
use Softon\Sms\Facades\Sms;
use App\UnderOrderProduct;
use App\FixingDetail;
use App\SubCategory;
use App\FixingOrder;
use App\Category;
use App\Product;
use App\Order;
use PDF;


class MainController extends Controller
{
    public function main () {
        $popularCategories = Category::where('is_popular', 1)->get();

        // SEOMeta::setTitle($detail->name);
        SEOMeta::setDescription(__("we are professionally engaged in the repair of electronic equipment more than 15 years, providing quality service at a reasonable price"));
        SEOTools::setDescription(__("we are professionally engaged in the repair of electronic equipment more than 15 years, providing quality service at a reasonable price"));
        return view('pages.main', compact('popularCategories'));
    }
    public function contacts()
    {
        SEOMeta::setTitle(__("contacts"));
        SEOMeta::setDescription(__("we are professionally engaged in the repair of electronic equipment more than 15 years, providing quality service at a reasonable price"));
        // SEOMeta::setCanonical();
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
    if($request->ajax()){
        if(request('query')){
            $query = request('query');
        }else{
            $query = request('query2');
        }
        $products = Product::query();
        $products = $products->where('name', 'LIKE', "%$query%");
         if(isset(request()->manufacturer)){
               $products = $products->whereIn('manufacturer', request()->manufacturer);

        }
        if(isset(request()->model)){
               $products = $products->whereIn('model', request()->model);

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
        if(request()->order){
            $order = request()->order;
        }else{
            $order = 'ASC';
        }
          $products = $products->where('name', 'LIKE', "%$query%")->orderBy('price',$order)->paginate(request()->per_page)->onEachSide(2);
           return view('components.market.sort', compact('products'));
        }else{
           $searchResults = (new Search())
                ->registerModel(Product::class, 'name')
                ->registerModel(FixingDetail::class, 'name')
                ->perform($request->input('query'));
                $results = $searchResults;
            $search = $request->input('query');

            $results = Product::where('name', 'LIKE', '%' . $search . '%')->orderBy('price','ASC')->paginate(12);

            return view('components.search', compact('searchResults', 'results'));
        }
    }

    public function searchAjax(Request $request){
            // dd(request('query2'));
        if($request->ajax()) {
            if(request('query')){

            // $data = (new Search())
            // ->registerModel(FixingDetail::class, 'name')
            // ->registerModel(Product::class, 'name')
            // ->search(request('query') );
             $products = Product::where('name', 'LIKE', '%' . request('query') . '%')->orderBy('price','ASC')->paginate(3);
             $fixing_details = FixingDetail::where('name', 'LIKE', '%' . request('query') . '%')->paginate(3);
            return view('components.search-ajax',compact('products','fixing_details'));
            } else {
                return false;
            }
        }
    }

    public function sendFeedback()
    {
        $details = request()->all();

        \Mail::to(config('params.emails'))->send(new \App\Mail\FeedbackMail($details));

        return 'Сообщение успешно отправлено.';
    }

    public function gravy()
    {
        $products = Product::where('color_id', null)->orWhere('quality_id', null)->get();
        return view('vendor.voyager.EmptyProducts.gravy', compact('products'));
    }
    public function OrderHandle()
    {
        $orders = Order::where('order_status_id', 1)->get();
        return view('vendor.voyager.Orders.gravy', compact('orders'));
    }
    public function OrderPayment()
    {
        $orders = Order::where('order_status_id', 2)->get();
        return view('vendor.voyager.Orders.gravypayment', compact('orders'));
    }

    public function FixingOrderHandle()
    {
        $orders = FixingOrder::where('order_status_id', 1)->get();
        return view('vendor.voyager.FixingOrders.gravy', compact('orders'));
    }

    public function FixingOrderPayment()
    {
        $orders = FixingOrder::where('order_status_id', 2)->get();
        return view('vendor.voyager.FixingOrders.gravypayment', compact('orders'));
    }

    public function thanks()
    {
        return view('emails.thanks');
    }

    public function sms()
    {
        // $sms = Sms::gateway('nexmo')->send('999163844','sms.test',['from'=>'Promarket.lv']);
        // dd($sms);
            $order = Order::where('id', 28)->first();
            $products = $order->products;
            // dd($order);
            // $order = $order->toArray();
            $pdf = \PDF::loadView('sms.pdf1', ['order' => $order, 'products' => $products]);
            // return $pdf->stream();
            // return view('sms.pdf2',['order' => $order, 'products' => $products]);
            return $pdf->stream();
    }

    public function smsToClient($type, $order_id)
    {

        // return view('sms.to-client');
        $order = Order::where('id',$order_id)->first();
        $products = $order->products;
        if($type == 'cash'){
            $sms = Sms::gateway('nexmo')->send($order->telephone,'sms.to-client',['from'=>'Promarket.lv']);
            // dd($sms);
        }elseif($type == 'card'){
            $email = $order->email;
            $pdf = \PDF::loadView('sms.pdf2', ['order' => $order, 'products' => $products])->setOptions(['defaultFont' => 'sans-serif']);
            // dd($pdf->stream());
            $send = Mail::send(['sms.pdf2' => 'sms.pdf2'], ['order' => $order], function($message)use($order,$email, $pdf)
                {
                         $message->to($email);
                         $message->subject('PAVADZĪME');
                         $message->attachData($pdf->output(), "pavadzime.pdf");
                });
            $order->updated_at = $order->updated_at;
            $order->date_send = 'AV'.date("dmy").$order->id;
            $order->save();
            // dd($send);
            $sms = Sms::gateway('nexmo')->send($order->telephone,'sms.to-client',['from'=>'Promarket.lv']);
            // return $pdf->download('pdf');

            // dd($sms);
        }
        return redirect()->back()->with('success', 'Message sent successfully!');
    }
    public function underOrder(Request $req)
    {
        $newUnderOrderProduct = new UnderOrderProduct();
        $newUnderOrderProduct->name = $req->name;
        $newUnderOrderProduct->product_id = $req->product_id;
        $newUnderOrderProduct->email = $req->email;
        $newUnderOrderProduct->is_sent = 0;
        $newUnderOrderProduct->save();
        return redirect()->back();
    }

    public function sendMessages() {
        $underOrderProducts = UnderOrderProduct::where('is_sent', 0)->get();

        foreach($underOrderProducts as $orderProduct) {
            $product = Product::find($orderProduct->product_id);
            if ($product->quantity > 0) {
                $order = clone $orderProduct;
                $order->product = $product;
                Mail::to($orderProduct->email)->send(new UnderOrderMail($order));
                $orderProduct->is_sent = 1;
                $orderProduct->save();
            }

        }


    }
    public function exportView()
    {
        return view('vendor.voyager.Orders.export');
    }
    public function exportExcel(){
        $date = request('month').'-'.request('year');
        return Excel::download(new OrderExport($date), 'orders.xlsx');
        // dd($export);
    }

}
