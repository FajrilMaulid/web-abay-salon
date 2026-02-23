<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'salon_name'    => 'required|string|max:100',
            'salon_tagline' => 'nullable|string|max:200',
            'salon_address' => 'nullable|string',
            'salon_phone'   => 'nullable|string|max:20',
            'salon_email'   => 'nullable|email',
            'salon_hours'   => 'nullable|string',
            'maps_embed'    => 'nullable|url',
        ]);

        foreach (['salon_name', 'salon_tagline', 'salon_address', 'salon_phone', 'salon_email', 'salon_hours', 'maps_embed'] as $key) {
            if ($request->has($key)) {
                Setting::set($key, $request->input($key));
            }
        }

        return redirect()->route('admin.settings.index')->with('success', 'Pengaturan berhasil disimpan!');
    }

    public function toggleBooking(Request $request)
    {
        $current = Setting::get('booking_open', '1');
        $new = $current == '1' ? '0' : '1';
        Setting::set('booking_open', $new);
        $status = $new == '1' ? 'dibuka' : 'ditutup';
        return response()->json(['booking_open' => $new == '1', 'message' => "Pemesanan berhasil {$status}."]);
    }
}
