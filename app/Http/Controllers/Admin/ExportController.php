<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Font;

class ExportController extends Controller
{
    public function index()
    {
        return view('admin.export.index');
    }

    public function export(Request $request)
    {
        $request->validate([
            'period' => 'required|in:daily,weekly,monthly',
            'date'   => 'required|date',
        ]);

        $date   = Carbon::parse($request->date);
        $period = $request->period;

        switch ($period) {
            case 'daily':
                $start    = $date->copy()->startOfDay();
                $end      = $date->copy()->endOfDay();
                $filename = 'booking_harian_' . $date->format('Y-m-d');
                break;
            case 'weekly':
                $start    = $date->copy()->startOfWeek();
                $end      = $date->copy()->endOfWeek();
                $filename = 'booking_mingguan_' . $start->format('Y-m-d') . '_sd_' . $end->format('Y-m-d');
                break;
            case 'monthly':
                $start    = $date->copy()->startOfMonth();
                $end      = $date->copy()->endOfMonth();
                $filename = 'booking_bulanan_' . $date->format('Y-m');
                break;
        }

        $bookings = Booking::with('service')
            ->whereBetween('booking_date', [$start, $end])
            ->orderBy('booking_date')
            ->orderBy('booking_time')
            ->get();

        // Create spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Booking');

        // Title row
        $sheet->mergeCells('A1:H1');
        $sheet->setCellValue('A1', 'LAPORAN DATA BOOKING - ' . strtoupper($period));
        $sheet->getStyle('A1')->applyFromArray([
            'font'      => ['bold' => true, 'size' => 14, 'color' => ['rgb' => 'FFFFFF']],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'C2185B']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        // Period row
        $sheet->mergeCells('A2:H2');
        $sheet->setCellValue('A2', 'Periode: ' . $start->format('d M Y') . ' s/d ' . $end->format('d M Y'));
        $sheet->getStyle('A2')->applyFromArray([
            'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E91E63']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        // Header
        $headers = ['No', 'Kode Booking', 'Nama Pelanggan', 'No. Telepon', 'Jasa', 'Tanggal', 'Jam', 'Metode Bayar', 'Total', 'Status'];
        $sheet->fromArray($headers, null, 'A3');
        $headerStyle = [
            'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '880E4F']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        ];
        $sheet->getStyle('A3:J3')->applyFromArray($headerStyle);

        // Data rows
        $row = 4;
        $totalRevenue = 0;
        foreach ($bookings as $i => $booking) {
            $sheet->fromArray([
                $i + 1,
                $booking->booking_code,
                $booking->customer_name,
                $booking->phone,
                $booking->service->name ?? '-',
                $booking->booking_date->format('d M Y'),
                $booking->booking_time,
                strtoupper($booking->payment_method),
                (float) $booking->total_price,
                strtoupper($booking->status),
            ], null, 'A' . $row);

            // Color by status
            $statusColor = match($booking->status) {
                'done'      => 'E8F5E9',
                'confirmed' => 'E3F2FD',
                'cancelled' => 'FFEBEE',
                default     => 'FFF9C4',
            };
            $sheet->getStyle('A'.$row.':J'.$row)->applyFromArray([
                'fill'    => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $statusColor]],
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'DDDDDD']]],
            ]);

            if (in_array($booking->status, ['confirmed', 'done'])) {
                $totalRevenue += $booking->total_price;
            }
            $row++;
        }

        // Summary row
        $sheet->mergeCells('A'.$row.':H'.$row);
        $sheet->setCellValue('A'.$row, 'TOTAL PENDAPATAN (Confirmed + Done)');
        $sheet->setCellValue('I'.$row, $totalRevenue);
        $sheet->getStyle('A'.$row.':J'.$row)->applyFromArray([
            'font'      => ['bold' => true],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FCE4EC']],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_MEDIUM]],
        ]);

        // Auto-size columns
        foreach (range('A', 'J') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Number format for price
        $sheet->getStyle('I4:I'.$row)->getNumberFormat()->setFormatCode('"Rp "#,##0');

        // Stream
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }
}
