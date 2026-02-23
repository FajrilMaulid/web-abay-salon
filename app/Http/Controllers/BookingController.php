<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function create()
    {
        $bookingOpen = Setting::get('booking_open', '1') == '1';
        if (!$bookingOpen) {
            return redirect()->route('home')->with('booking_closed', 'Maaf, pemesanan untuk hari ini telah ditutup oleh admin. Silakan coba lagi besok.');
        }

        $services = Service::where('active', true)->get();
        return view('booking.create', compact('services'));
    }

    public function store(Request $request)
    {
        $bookingOpen = Setting::get('booking_open', '1') == '1';
        if (!$bookingOpen) {
            return redirect()->route('home')->with('booking_closed', 'Maaf, pemesanan untuk hari ini telah ditutup oleh admin.');
        }

        $validated = $request->validate([
            'customer_name'  => 'required|string|max:100',
            'phone'          => 'required|string|max:20',
            'service_id'     => 'required|exists:services,id',
            'booking_date'   => 'required|date|after_or_equal:today',
            'booking_time'   => 'required',
            'payment_method' => 'required|in:cash,transfer,qris',
        ], [
            'customer_name.required'  => 'Nama pelanggan wajib diisi.',
            'phone.required'          => 'Nomor telepon wajib diisi.',
            'service_id.required'     => 'Jasa wajib dipilih.',
            'booking_date.required'   => 'Tanggal booking wajib diisi.',
            'booking_date.after_or_equal' => 'Tanggal booking tidak boleh di masa lalu.',
            'booking_time.required'   => 'Jam booking wajib diisi.',
            'payment_method.required' => 'Metode pembayaran wajib dipilih.',
        ]);

        $service = Service::findOrFail($validated['service_id']);

        $booking = Booking::create([
            'booking_code'   => Booking::generateCode(),
            'customer_name'  => $validated['customer_name'],
            'phone'          => $validated['phone'],
            'service_id'     => $validated['service_id'],
            'booking_date'   => $validated['booking_date'],
            'booking_time'   => $validated['booking_time'],
            'payment_method' => $validated['payment_method'],
            'total_price'    => $service->price,
            'status'         => 'pending',
        ]);

        return redirect()->route('booking.success', $booking->booking_code);
    }

    public function success($code)
    {
        $booking = Booking::where('booking_code', $code)->with('service')->firstOrFail();
        return view('booking.success', compact('booking'));
    }
}
