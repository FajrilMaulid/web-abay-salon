<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with('service');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('date')) {
            $query->whereDate('booking_date', $request->date);
        }

        $bookings = $query->orderBy('booking_date', 'desc')->orderBy('booking_time', 'asc')->get();
        return view('admin.bookings.index', compact('bookings'));
    }

    public function create()
    {
        $services = Service::where('active', true)->get();
        return view('admin.bookings.create', compact('services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name'  => 'required|string|max:100',
            'phone'          => 'required|string|max:20',
            'service_id'     => 'required|exists:services,id',
            'booking_date'   => 'required|date',
            'booking_time'   => 'required',
            'payment_method' => 'required|in:cash,transfer,qris',
            'notes'          => 'nullable|string',
            'status'         => 'required|in:pending,confirmed,done,cancelled',
        ]);

        $service = Service::findOrFail($validated['service_id']);

        Booking::create([
            'booking_code'   => Booking::generateCode(),
            'customer_name'  => $validated['customer_name'],
            'phone'          => $validated['phone'],
            'service_id'     => $validated['service_id'],
            'booking_date'   => $validated['booking_date'],
            'booking_time'   => $validated['booking_time'],
            'payment_method' => $validated['payment_method'],
            'status'         => $validated['status'],
            'total_price'    => $service->price,
            'notes'          => $validated['notes'] ?? null,
            'is_manual'      => true,
        ]);

        return redirect()->route('admin.bookings.index')->with('success', 'Booking manual berhasil dibuat!');
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate(['status' => 'required|in:pending,confirmed,done,cancelled']);
        $booking->update(['status' => $request->status]);

        if ($request->ajax()) {
            return response()->json(['success' => true, 'status' => $booking->status]);
        }

        return redirect()->route('admin.bookings.index')->with('success', 'Status booking diperbarui!');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('admin.bookings.index')->with('success', 'Booking berhasil dihapus!');
    }
}
