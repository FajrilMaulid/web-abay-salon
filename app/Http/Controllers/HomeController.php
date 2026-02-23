<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Setting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $services = Service::where('active', true)->get();
        $bookingOpen = Setting::get('booking_open', '1') == '1';
        $salonName   = Setting::get('salon_name', 'Salon Cantik');
        $salonTagline = Setting::get('salon_tagline', 'Tampil Cantik, Percaya Diri Setiap Hari');
        $salonAddress = Setting::get('salon_address', '');
        $salonPhone  = Setting::get('salon_phone', '');
        $salonHours  = Setting::get('salon_hours', '');
        $mapsEmbed   = Setting::get('maps_embed', '');

        return view('home.index', compact(
            'services', 'bookingOpen', 'salonName', 'salonTagline',
            'salonAddress', 'salonPhone', 'salonHours', 'mapsEmbed'
        ));
    }
}
