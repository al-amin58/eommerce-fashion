<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Properties;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Inertia\ResponseFactory;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response|ResponseFactory
     */
    public function __invoke(Request $request)
    {

        $orderData = Order::selectRaw('MONTHNAME(created_at) as month, SUM(cart_total_price) as total')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

// Transform the query results into a format that can be used by VueApexCharts
        $data = [];
        foreach ($orderData as $order) {
            $data[] = [
                'x' => $order->month,
                'y' => $order->total,
            ];
        }


//        $sevenDaysOrders = DB::table('orders')
//            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
//            ->where('created_at', '>=', Carbon::now()->subDays(7))
//            ->groupBy('date', 'created_at') // Add created_at to the GROUP BY clause
//            ->orderBy('date', 'ASC')
//            ->get();


        $userCounts = DB::table('users')
            ->select(DB::raw("DATE_FORMAT(created_at, '%M') as month"), DB::raw('COUNT(*) as count'))
            ->where('created_at', '>', date('Y'))
            ->groupBy('month')
            ->orderByRaw("FIELD(month, 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December')")
            ->get();


        $userData = [];
        foreach ($userCounts as $user) {
            $userData[] = [
                'x' => $user->month,
                'y' => $user->count,
            ];
        }



//        $sevenDaysOrders = DB::table('orders')
//            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
//            ->where('created_at', '>=', Carbon::now()->subDays(7))
//            ->groupBy('date', 'created_at')
//            ->orderBy('date', 'ASC')
//            ->get();


//        return $sevenDaysOrders;



        return inertia('Dashboard',[
            'info' =>[
                'totalSeals' => Order::where('order_status', 'pending')->sum('cart_total_price'),
                'totalOrder' => Order::count(),
                'totalCustomer' => User::where('type', 'customer')->count(),
                'totalProducts' => Product::count(),
                'data' => $data,
                'lastYearUsers' => $userData
            ]
        ]);
    }

    public function profile(){
        return inertia('Profile',[
            'user' => Auth::user()
        ]);
    }



}
