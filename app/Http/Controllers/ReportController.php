<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CommissionHistory;
use App\Models\Wallet;
use App\Models\Seller;
use App\Models\User;
use App\Models\Search;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Shop;
use Auth;

class ReportController extends Controller
{
    public function report_sales(Request $request)
    {
        if ($request->excel) {
            header("Pragma: public");
            header("Expires: 0");
            $filename = "reporte-de-ventas.xls";
            header("Content-type: application/x-msdownload");
            header("Content-Disposition: attachment; filename=$filename");
            header("Pragma: no-cache");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        }

        $orders = Order::dateStart($request->date_start)
            ->dateEnd($request->date_end)
            ->provider($request->provider)
            ->paginate();

        if ($request->imprimir || $request->excel) {
            $orders = Order::dateStart($request->date_start)
                ->dateEnd($request->date_end)
                ->provider($request->provider)
                ->get();
        }

        $providers = User::where('user_type', 'seller')
            ->get();

        if ($request->excel) {
            include resource_path() . '/views/backend/reports/report_sales_excel.php';
            exit;
        }

        return view('backend.reports.report_sales', compact('orders', 'providers'));
    }

    public function report_product(Request $request)
    {
        if ($request->excel) {
            header("Pragma: public");
            header("Expires: 0");
            $filename = "reporte-de-producto.xls";
            header("Content-type: application/x-msdownload");
            header("Content-Disposition: attachment; filename=$filename");
            header("Pragma: no-cache");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        }

        $providers = User::where('user_type', 'seller')
            ->get();

        $products = Product::paginate();

        if ($request->imprimir || $request->excel) {
            $products = Product::get();
        }

        if ($request->excel) {
            include resource_path() . '/views/backend/reports/report_product_excel.php';
            exit;
        }

        return view('backend.reports.report_product', compact('products', 'providers'));
    }

    public function ranking_sales_per_shop(Request $request)
    {
        if ($request->excel) {
            header("Pragma: public");
            header("Expires: 0");
            $filename = "reporte-compras-por-tienda.xls";
            header("Content-type: application/x-msdownload");
            header("Content-Disposition: attachment; filename=$filename");
            header("Pragma: no-cache");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        }

        $shops = User::tipoNegocio($request->tipo_negocio)
            ->paginate();

        if ($request->imprimir || $request->excel) {
            $shops = User::tipoNegocio($request->tipo_negocio)
                ->get();
        }

        if ($request->excel) {
            include resource_path() . '/views/backend/reports/ranking_sales_per_shop_excel.php';
            exit;
        }

        return view('backend.reports.ranking_sales_per_shop', compact('shops'));
    }

    public function per_business_type(Request $request)
    {
        if ($request->excel) {
            header("Pragma: public");
            header("Expires: 0");
            $filename = "reporte-por-tipo-de-negocio.xls";
            header("Content-type: application/x-msdownload");
            header("Content-Disposition: attachment; filename=$filename");
            header("Pragma: no-cache");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        }

        $shops = User::tipoNegocio($request->tipo_negocio)
            ->estado($request->estado)
            ->paginate();

        if ($request->imprimir || $request->excel) {
            $shops = User::tipoNegocio($request->tipo_negocio)
                ->estado($request->estado)
                ->get();
        }

        $stores = User::where('type', 'Tienda')->count();
        $restaurants = User::where('type', 'Restaurante')->count();
        $liquors = User::where('type', 'Licerería')->count();
        $business = User::where('type', 'Negocio')->count();
        $place = User::where('type', 'Hogar')->count();

        if ($request->excel) {
            include resource_path() . '/views/backend/reports/per_business_type_excel.php';
            exit;
        }

        return view('backend.reports.per_business_type', compact('shops', 'stores', 'restaurants', 'business', 'place', 'liquors'));
    }

    public function orders_per_status(Request $request)
    {
        if ($request->excel) {
            header("Pragma: public");
            header("Expires: 0");
            $filename = "reporte-de-ordenes-por-estado.xls";
            header("Content-type: application/x-msdownload");
            header("Content-Disposition: attachment; filename=$filename");
            header("Pragma: no-cache");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        }

        $orders = Order::dateStart($request->date_start)
            ->dateEnd($request->date_end)
            ->provider($request->provider)
            ->status($request->status)
            ->paginate();

        $providers = User::where('user_type', 'seller')
            ->get();

        if ($request->imprimir || $request->excel) {
            $orders = Order::dateStart($request->date_start)
                ->dateEnd($request->date_end)
                ->provider($request->provider)
                ->status($request->status)
                ->get();
        }

        if ($request->excel) {
            include resource_path() . '/views/backend/reports/orders_per_status_excel.php';
            exit;
        }

        return view('backend.reports.orders_per_status', compact('orders', 'providers'));
    }

    public function stock_report(Request $request)
    {
        $sort_by =null;
        $products = Product::orderBy('created_at', 'desc');
        if ($request->has('category_id')){
            $sort_by = $request->category_id;
            $products = $products->where('category_id', $sort_by);
        }
        $products = $products->paginate(15);
        return view('backend.reports.stock_report', compact('products','sort_by'));
    }

    public function in_house_sale_report(Request $request)
    {
        $sort_by =null;
        $products = Product::orderBy('num_of_sale', 'desc')->where('added_by', 'admin');
        if ($request->has('category_id')){
            $sort_by = $request->category_id;
            $products = $products->where('category_id', $sort_by);
        }
        $products = $products->paginate(15);
        return view('backend.reports.in_house_sale_report', compact('products','sort_by'));
    }

    public function seller_sale_report(Request $request)
    {
        $sort_by =null;
        $sellers = Seller::orderBy('created_at', 'desc');
        if ($request->has('verification_status')){
            $sort_by = $request->verification_status;
            $sellers = $sellers->where('verification_status', $sort_by);
        }
        $sellers = $sellers->paginate(10);
        return view('backend.reports.seller_sale_report', compact('sellers','sort_by'));
    }

    public function wish_report(Request $request)
    {
        $sort_by =null;
        $products = Product::orderBy('created_at', 'desc');
        if ($request->has('category_id')){
            $sort_by = $request->category_id;
            $products = $products->where('category_id', $sort_by);
        }
        $products = $products->paginate(10);
        return view('backend.reports.wish_report', compact('products','sort_by'));
    }

    public function user_search_report(Request $request){
        $searches = Search::orderBy('count', 'desc')->paginate(10);
        return view('backend.reports.user_search_report', compact('searches'));
    }
    
    public function commission_history(Request $request) {
        $seller_id = null;
        $date_range = null;
        
        if(Auth::user()->user_type == 'seller') {
            $seller_id = Auth::user()->id;
        } if($request->seller_id) {
            $seller_id = $request->seller_id;
        }
        
        $commission_history = CommissionHistory::selectRaw('SUM(admin_commission) AS admin_commission, SUM(seller_earning) AS seller_earning, order_id, created_at')->orderBy('created_at', 'desc');
        
        if ($request->date_range) {
            $date_range = $request->date_range;
            $date_range1 = explode(" / ", $request->date_range);
            $commission_history = $commission_history->where('created_at', '>=', $date_range1[0]);
            $commission_history = $commission_history->where('created_at', '<=', $date_range1[1]);
        }
        if ($seller_id){
            
            $commission_history = $commission_history->where('seller_id', '=', $seller_id);
        }
        
        $commission_history = $commission_history->groupBy('order_id')->paginate(10);
        if(Auth::user()->user_type == 'seller') {
            return view('frontend.user.seller.reports.commission_history_report', compact('commission_history', 'seller_id', 'date_range'));
        }
        return view('backend.reports.commission_history_report', compact('commission_history', 'seller_id', 'date_range'));
    }
    
    public function wallet_transaction_history(Request $request) {
        $user_id = null;
        $date_range = null;
        
        if($request->user_id) {
            $user_id = $request->user_id;
        }
        
        $users_with_wallet = User::whereIn('id', function($query) {
            $query->select('user_id')->from(with(new Wallet)->getTable());
        })->get();

        $wallet_history = Wallet::orderBy('created_at', 'desc');
        
        if ($request->date_range) {
            $date_range = $request->date_range;
            $date_range1 = explode(" / ", $request->date_range);
            $wallet_history = $wallet_history->where('created_at', '>=', $date_range1[0]);
            $wallet_history = $wallet_history->where('created_at', '<=', $date_range1[1]);
        }
        if ($user_id){
            $wallet_history = $wallet_history->where('user_id', '=', $user_id);
        }
        
        $wallets = $wallet_history->paginate(10);

        return view('backend.reports.wallet_history_report', compact('wallets', 'users_with_wallet', 'user_id', 'date_range'));
    }
}
