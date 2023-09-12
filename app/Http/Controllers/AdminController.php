<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Orders;
use App\Models\OrderDetails;
use App\Models\User;
use App\Models\Categories;
use App\Models\CateItems;
use \Carbon\Carbon;
use DB;
class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $totalView = Products::sum('view');
        $revenue= Orders::sum('total');
        $orders= Orders::count();
        $totalPro= OrderDetails::sum('number');
        $date = Carbon::now();
        $orders = Orders::where('status', '=', 0)->orderBy('id','desc')->limit('5')->get();
        $cate= Categories::all();
        $chartPro=[];
        foreach ($cate as $key =>$c){
            $qty= $c->Products->sum('quantity');
            $name=$c->name;
            $chartPro[++$key]=[$name, $qty];
        }
        $higest_resolved=DB::select(DB::raw('SELECT product_id,SUM(number) as number_total,product_name, price
        FROM order_details GROUP by product_id ORDER by number_total DESC limit 7'));
        return view('admin.pages.index', compact('totalView','revenue','orders','totalPro','date', 'chartPro','higest_resolved'));
        
    }

    public function inventoryStatistics()
    {
        $cate= Categories::all();
        $chartPro=[];
        foreach ($cate as $key =>$c){
            $qty= $c->Products->sum('quantity');
            $price= $c->Products->sum('price');
            $name=$c->name;
            $id=$c->id;
            $chartPro[++$key]=[$id, $name, $qty, $price];
        }
        
        $totalQuantityPro = Products::all()->sum('quantity');
        $totalPricePro=DB::select(DB::raw('SELECT SUM(quantity* price) as priceTotal FROM products '));
        $topQuantityPro = Products::orderBy('quantity', 'DESC')->limit(5)->get();
        $botQuantityPro = Products::orderBy('quantity', 'ASC')->limit(5)->get();
        return view('admin.pages.inventory.index', compact('chartPro','totalQuantityPro','totalPricePro', 'topQuantityPro','botQuantityPro'));
    }

    public function inventoryByCate($id)
    {
        $cateItems= CateItems::where('cate_id',$id)->get();
        $totalProduct = Categories::where('id',$id)->first()->Products->sum('quantity');
        $totalPrice= Categories::where('id',$id)->first()->Products->sum('price');
        $topQuantityPro = Products::orderBy('quantity', 'DESC')->limit(5)->get();
        $botQuantityPro = Products::orderBy('quantity', 'ASC')->limit(5)->get();
        return view('admin.pages.inventory.cateItems', compact('cateItems','totalProduct', 'totalPrice', 'topQuantityPro','botQuantityPro'));
    }

    public function inventoryByPro($id)
    {
        $products= Products::where('cate_id',$id)->get();
        $topQuantityPro = Products::orderBy('quantity', 'DESC')->limit(5)->get();
        $botQuantityPro = Products::orderBy('quantity', 'ASC')->limit(5)->get();
        return view('admin.pages.inventory.products', compact('products', 'topQuantityPro','botQuantityPro'));
    }

    public function revenue()
    {
        $type = 'all';
        $revenue= Orders::all();
        $totalView = Products::sum('view');
        $totalPro= OrderDetails::sum('number');
        $revenueWeek = Orders::select('*')->whereBetween('created_at', [Carbon::now()->subWeek(), Carbon::now()] )->get();
        $revenueMonth  = Orders::select('*')->whereBetween('created_at',  [Carbon::now()->subMonth(), Carbon::now()])->get();
        $revenueDay  = Orders::select('*')->whereBetween('created_at',  [Carbon::now()->subDay(), Carbon::now()])->get();
        $date = Carbon::now();
        $higest_resolved=DB::select(DB::raw('SELECT product_id,SUM(number) as number_total,product_name, price
        FROM order_details GROUP by product_id ORDER by number_total DESC limit 7'));
        $lowest_resolved=DB::select(DB::raw('SELECT product_id,SUM(number) as number_total,product_name, price
        FROM order_details GROUP by product_id ORDER by number_total ASC limit 7'));

        $resolved = DB::table('orders')
                ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                ->select('order_details.product_id as id')
                ->pluck('id');
        $no_resolved = Products::whereNotIn('id', $resolved)->get();

        return view('admin.pages.revenue.index', compact('revenue', 'revenueWeek','revenueMonth', 'revenueDay', 'date', 'totalView', 'totalPro', 'higest_resolved', 'lowest_resolved', 'no_resolved', 'type'));

    }

    public function revenueByWeek()
    {
        $type = 'week';
        $totalView = Products::select('*')->whereBetween('updated_at', [Carbon::now()->subWeek(), Carbon::now()] )->get()->sum('view');
        $revenue = Orders::whereBetween('created_at', [Carbon::now()->subWeek(), Carbon::now()] )->get();
        $totalPro = DB::table('orders')
                ->whereBetween('orders.created_at', [Carbon::now()->subWeek(), Carbon::now()] )
                ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                ->select('order_details.*','orders.id')
                ->get()->sum('number');
        $date = Carbon::now();

        $higest_resolved = DB::table('orders')
                ->whereBetween('orders.created_at', [Carbon::now()->subWeek(), Carbon::now()] )
                ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                ->join('products', 'order_details.product_id', '=', 'products.id')
                ->select('products.*','order_details.product_name','orders.id', DB::raw( 'SUM(order_details.number) as number_total'))
                ->groupBy('products.id')
                ->orderBy('number_total', 'DESC')
                ->take(7)
                ->get();

        $lowest_resolved = DB::table('orders')
                ->whereBetween('orders.created_at', [Carbon::now()->subWeek(), Carbon::now()] )
                ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                ->join('products', 'order_details.product_id', '=', 'products.id')
                ->select('products.*','order_details.product_name','orders.id', DB::raw( 'SUM(order_details.number) as number_total'))
                ->groupBy('products.id')
                ->orderBy('number_total', 'ASC')
                ->take(7)
                ->get();
                    
        $resolved = DB::table('orders')
                ->whereBetween('orders.created_at', [Carbon::now()->subWeek(), Carbon::now()] )
                ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                ->select('order_details.product_id as id')
                ->pluck('id');
        $no_resolved = Products::whereNotIn('id', $resolved)->get();
        
        return view('admin.pages.revenue.index', compact('revenue', 'date', 'totalView', 'totalPro', 'higest_resolved', 'lowest_resolved', 'no_resolved', 'type'));

    }

    public function revenueByMonth()
    {
        $type = 'month';
        $totalView = Products::select('*')->whereBetween('updated_at', [Carbon::now()->subMonth(), Carbon::now()] )->get()->sum('view');
        $revenue = Orders::whereBetween('created_at', [Carbon::now()->subMonth(), Carbon::now()] )->get();
        $totalPro = DB::table('orders')
                ->whereBetween('orders.created_at', [Carbon::now()->subMonth(), Carbon::now()] )
                ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                ->select('order_details.*','orders.id')
                ->get()->sum('number');
        $date = Carbon::now();
       
        $higest_resolved = DB::table('orders')
                ->whereBetween('orders.created_at', [Carbon::now()->subMonth(), Carbon::now()] )
                ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                ->join('products', 'order_details.product_id', '=', 'products.id')
                ->select('products.*','order_details.product_name','orders.id', DB::raw( 'SUM(order_details.number) as number_total'))
                ->groupBy('products.id')
                ->orderBy('number_total', 'DESC')
                ->take(7)
                ->get();

        $lowest_resolved = DB::table('orders')
                ->whereBetween('orders.created_at', [Carbon::now()->subMonth(), Carbon::now()] )
                ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                ->join('products', 'order_details.product_id', '=', 'products.id')
                ->select('products.*','order_details.product_name','orders.id', DB::raw( 'SUM(order_details.number) as number_total'))
                ->groupBy('products.id')
                ->orderBy('number_total', 'ASC')
                ->take(7)
                ->get();

        $resolved = DB::table('orders')
                ->whereBetween('orders.created_at', [Carbon::now()->subMonth(), Carbon::now()] )
                ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                ->select('order_details.product_id as id')
                ->pluck('id');
        $no_resolved = Products::whereNotIn('id', $resolved)->get();

        return view('admin.pages.revenue.index', compact('revenue', 'date', 'totalView', 'totalPro', 'higest_resolved', 'lowest_resolved', 'no_resolved', 'type'));

    }

    public function revenueByDay()
    {
        $type = 'day';
        $totalView = Products::select('*')->whereBetween('updated_at', [Carbon::now()->subDay(), Carbon::now()] )->get()->sum('view');
        $revenue = Orders::whereBetween('created_at', [Carbon::now()->subDay(), Carbon::now()] )->get();
        $totalPro = DB::table('orders')
                ->whereBetween('orders.created_at', [Carbon::now()->subDay(), Carbon::now()] )
                ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                ->select('order_details.*','orders.id')
                ->get()->sum('number');
        $date = Carbon::now();
       
        $higest_resolved = DB::table('orders')
                ->whereBetween('orders.created_at', [Carbon::now()->subDay(), Carbon::now()] )
                ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                ->join('products', 'order_details.product_id', '=', 'products.id')
                ->select('products.*','order_details.product_name','orders.id', DB::raw( 'SUM(order_details.number) as number_total'))
                ->groupBy('products.id')
                ->orderBy('number_total', 'DESC')
                ->take(7)
                ->get();

        $lowest_resolved = DB::table('orders')
                ->whereBetween('orders.created_at', [Carbon::now()->subDay(), Carbon::now()] )
                ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                ->join('products', 'order_details.product_id', '=', 'products.id')
                ->select('products.*','order_details.product_name','orders.id', DB::raw( 'SUM(order_details.number) as number_total'))
                ->groupBy('products.id')
                ->orderBy('number_total', 'ASC')
                ->take(7)
                ->get();
        
        $resolved = DB::table('orders')
                ->whereBetween('orders.created_at', [Carbon::now()->subDay(), Carbon::now()] )
                ->join('order_details', 'orders.id', '=', 'order_details.order_id')
                ->select('order_details.product_id as id')
                ->pluck('id');
        $no_resolved = Products::whereNotIn('id', $resolved)->get();

        return view('admin.pages.revenue.index', compact('revenue', 'date', 'totalView', 'totalPro', 'higest_resolved', 'lowest_resolved', 'no_resolved', 'type'));

    }
    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    
    public function destroy($id)
    {
        //
    }
}
