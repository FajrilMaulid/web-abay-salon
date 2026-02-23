<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();

        // Stats
        $todayBookings   = Booking::whereDate('booking_date', $today)->count();
        $monthBookings   = Booking::whereDate('booking_date', '>=', $thisMonth)->count();
        $todayRevenue    = Booking::whereDate('booking_date', $today)->whereIn('status', ['confirmed', 'done'])->sum('total_price');
        $monthRevenue    = Booking::whereDate('booking_date', '>=', $thisMonth)->whereIn('status', ['confirmed', 'done'])->sum('total_price');

        // Pending
        $pendingCount = Booking::where('status', 'pending')->count();

        // Chart: last 7 days bookings
        $chartDays   = collect(range(6, 0))->map(fn($i) => Carbon::today()->subDays($i)->format('d M'));
        $chartCounts = collect(range(6, 0))->map(fn($i) => Booking::whereDate('booking_date', Carbon::today()->subDays($i))->count());

        // Chart: last 6 months revenue
        $chartMonths   = collect(range(5, 0))->map(fn($i) => Carbon::now()->subMonths($i)->format('M Y'));
        $chartRevenue  = collect(range(5, 0))->map(fn($i) => (float) Booking::where('booking_date', '>=', Carbon::now()->subMonths($i)->startOfMonth())
            ->where('booking_date', '<=', Carbon::now()->subMonths($i)->endOfMonth())
            ->whereIn('status', ['confirmed', 'done'])
            ->sum('total_price'));

        $bookingOpen = Setting::get('booking_open', '1') == '1';

        // Recent bookings
        $recentBookings = Booking::with('service')->orderBy('created_at', 'desc')->limit(5)->get();

        return view('admin.dashboard', compact(
            'todayBookings', 'monthBookings', 'todayRevenue', 'monthRevenue',
            'pendingCount', 'chartDays', 'chartCounts', 'chartMonths', 'chartRevenue',
            'bookingOpen', 'recentBookings'
        ));
    }
}
