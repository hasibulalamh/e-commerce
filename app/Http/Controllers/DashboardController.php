<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function dashboard()
    {
        try {
            // Dashboard statistics
            $totalRevenue = Order::where('status', 'completed')->sum('total');
            $totalOrders = Order::count();
            $totalProducts = Product::count();
            $totalCustomers = User::where('role', 'customer')->count();
            $totalCategories = Category::count();
            $totalBrands = Brand::count();
            
            // Recent orders
            $recentOrders = Order::with(['customer', 'orderDetails.product'])
                ->latest()
                ->take(5)
                ->get();

            // Top selling products
            $topProducts = Product::withCount('orderDetails')
                ->orderBy('order_details_count', 'desc')
                ->take(5)
                ->get();

            // Monthly revenue data for chart
            $monthlyRevenue = Order::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(total) as total')
                ->where('status', 'completed')
                ->groupBy('year', 'month')
                ->orderBy('year', 'asc')
                ->orderBy('month', 'asc')
                ->get();

            $monthlyLabels = [];
            $monthlyData = [];
            
            foreach ($monthlyRevenue as $revenue) {
                $date = \DateTime::createFromFormat('!m', $revenue->month);
                $monthName = $date->format('M');
                $monthlyLabels[] = $monthName . ' ' . $revenue->year;
                $monthlyData[] = $revenue->total;
            }

            return view('backend.dashboard', [
                'totalRevenue' => $totalRevenue,
                'totalOrders' => $totalOrders,
                'totalProducts' => $totalProducts,
                'totalCustomers' => $totalCustomers,
                'totalCategories' => $totalCategories,
                'totalBrands' => $totalBrands,
                'recentOrders' => $recentOrders,
                'topProducts' => $topProducts,
                'monthlyLabels' => $monthlyLabels,
                'monthlyData' => $monthlyData,
                'error' => null
            ]);
            
        } catch (\Exception $e) {
            // Log the error
            Log::error('Dashboard Error: ' . $e->getMessage());
            
            // Return view with default values and error message
            return view('backend.dashboard', [
                'totalRevenue' => 0,
                'totalOrders' => 0,
                'totalProducts' => 0,
                'totalCustomers' => 0,
                'totalCategories' => 0,
                'totalBrands' => 0,
                'recentOrders' => collect(),
                'topProducts' => collect(),
                'monthlyLabels' => [],
                'monthlyData' => [],
                'error' => 'Unable to load dashboard data. Please try again later.'
            ]);
        }
    }
}