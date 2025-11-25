<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->get('period', 'month'); // day, week, month, year
        
        $salesData = $this->getSalesData($period);
        $topProducts = $this->getTopProducts();
        $customerStats = $this->getCustomerStats();
        
        return view('admin.reports.index', compact('salesData', 'topProducts', 'customerStats', 'period'));
    }

    public function sales(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->subMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));
        
        $orders = Order::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', '!=', 'cancelled')
            ->with('orderItems.product')
            ->get();
        
        $totalSales = $orders->sum('total_amount');
        $totalOrders = $orders->count();
        $averageOrderValue = $totalOrders > 0 ? $totalSales / $totalOrders : 0;
        
        return view('admin.reports.sales', compact('orders', 'totalSales', 'totalOrders', 'averageOrderValue', 'startDate', 'endDate'));
    }

    public function products()
    {
        $products = Product::withCount('orderItems')
            ->withSum('orderItems', 'quantity')
            ->orderBy('order_items_sum_quantity', 'desc')
            ->paginate(20);
        
        return view('admin.reports.products', compact('products'));
    }

    private function getSalesData(string $period): array
    {
        $now = Carbon::now();
        
        switch ($period) {
            case 'day':
                $startDate = $now->copy()->subDays(30);
                $format = 'Y-m-d';
                $groupBy = DB::raw('DATE(created_at)');
                break;
            case 'week':
                $startDate = $now->copy()->subWeeks(12);
                $format = 'Y-W';
                $groupBy = DB::raw('YEAR(created_at), WEEK(created_at)');
                break;
            case 'month':
                $startDate = $now->copy()->subMonths(12);
                $format = 'Y-m';
                $groupBy = DB::raw('YEAR(created_at), MONTH(created_at)');
                break;
            default:
                $startDate = $now->copy()->subYears(5);
                $format = 'Y';
                $groupBy = DB::raw('YEAR(created_at)');
        }
        
        $sales = Order::where('status', '!=', 'cancelled')
            ->where('created_at', '>=', $startDate)
            ->select(
                $groupBy . ' as period',
                DB::raw('SUM(total_amount) as total'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('period')
            ->orderBy('period')
            ->get();
        
        return [
            'labels' => $sales->pluck('period')->toArray(),
            'revenue' => $sales->pluck('total')->toArray(),
            'orders' => $sales->pluck('count')->toArray(),
        ];
    }

    private function getTopProducts(int $limit = 10): array
    {
        return Product::withCount(['orderItems as total_sold' => function ($query) {
            $query->select(DB::raw('SUM(quantity)'));
        }])
        ->orderBy('total_sold', 'desc')
        ->limit($limit)
        ->get()
        ->toArray();
    }

    private function getCustomerStats(): array
    {
        return [
            'total' => User::where('role', 'customer')->count(),
            'new_this_month' => User::where('role', 'customer')
                ->whereMonth('created_at', Carbon::now()->month)
                ->count(),
            'active' => User::where('role', 'customer')
                ->whereHas('orders', function ($query) {
                    $query->where('created_at', '>=', Carbon::now()->subMonth());
                })
                ->count(),
        ];
    }
}
