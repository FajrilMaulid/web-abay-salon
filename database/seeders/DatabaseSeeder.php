<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin default
        Admin::create([
            'name'     => 'Admin Salon',
            'email'    => 'admin@salon.com',
            'password' => bcrypt('admin123'),
        ]);

        // Services / Katalog Jasa
        $services = [
            [
                'name'        => 'Potong Rambut',
                'description' => 'Potong rambut profesional sesuai keinginan Anda dengan hasil rapi dan stylish.',
                'price'       => 50000,
                'duration'    => 45,
                'active'      => true,
            ],
            [
                'name'        => 'Creambath',
                'description' => 'Perawatan rambut intensif dengan krim khusus untuk melembapkan dan menutrisi rambut.',
                'price'       => 120000,
                'duration'    => 60,
                'active'      => true,
            ],
            [
                'name'        => 'Smoothing',
                'description' => 'Meluruskan dan melembutkan rambut dengan teknik smoothing terkini tahan lama.',
                'price'       => 350000,
                'duration'    => 180,
                'active'      => true,
            ],
            [
                'name'        => 'Facial',
                'description' => 'Perawatan wajah komprehensif untuk kulit bersih, cerah, dan sehat.',
                'price'       => 150000,
                'duration'    => 90,
                'active'      => true,
            ],
            [
                'name'        => 'Manicure & Pedicure',
                'description' => 'Perawatan kuku tangan dan kaki dengan cat kuku pilihan terlengkap.',
                'price'       => 100000,
                'duration'    => 75,
                'active'      => true,
            ],
            [
                'name'        => 'Hair Coloring',
                'description' => 'Pewarnaan rambut dengan cat berkualitas, tersedia berbagai pilihan warna modern.',
                'price'       => 250000,
                'duration'    => 120,
                'active'      => true,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }

        // Settings
        $settings = [
            ['key' => 'booking_open',   'value' => '1'],
            ['key' => 'salon_name',     'value' => 'Salon Cantik'],
            ['key' => 'salon_tagline',  'value' => 'Tampil Cantik, Percaya Diri Setiap Hari'],
            ['key' => 'salon_address',  'value' => 'Jl. Kecantikan Indah No. 88, Jakarta Selatan'],
            ['key' => 'salon_phone',    'value' => '+62 812-3456-7890'],
            ['key' => 'salon_email',    'value' => 'info@saloncantik.com'],
            ['key' => 'salon_hours',    'value' => 'Senin - Sabtu: 09.00 - 20.00 | Minggu: 10.00 - 18.00'],
            ['key' => 'maps_embed',     'value' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.521260322283!2d106.8195613!3d-6.194741!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwMTEnNDEuMSJTIDEwNsKwNDknMTIuNCJF!5e0!3m2!1sen!2sid!4v1718000000!5m2!1sen!2sid'],
        ];

        foreach ($settings as $s) {
            Setting::updateOrCreate(['key' => $s['key']], ['value' => $s['value']]);
        }
    }
}
