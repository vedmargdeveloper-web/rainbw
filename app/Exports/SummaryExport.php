<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;
use App\Models\Inquiry;
use App\Models\Quotation;
use App\Models\Booking;
use App\Models\Invoice;
use App\Models\PerformaInvoiceChallan;

class SummaryExport implements FromCollection, WithHeadings
{
    protected $type;
    protected $month;
    protected $year;

    public function __construct($type, $month, $year)
    {
        $this->type  = $type;
        $this->month = $month;
        $this->year  = $year;
    }

    public function collection()
    {
        switch ($this->type) {
            case 'Inquiry': $query = Inquiry::with('customer'); break;
            case 'P.I.': $query = Quotation::with(['quotationItem','customerType']); break;
            case 'Bookings': $query = Booking::with(['bookingItem','customerType']); break;
            case 'Invoices': $query = Invoice::with('customerType'); break;
            case 'Challans': $query = PerformaInvoiceChallan::with('customerType'); break;
            default: return collect();
        }

        if ($this->month) $query->whereMonth('created_at', $this->month);
        if ($this->year)  $query->whereYear('created_at', $this->year);

        $rows = $query->get()->map(function($item) {
            $customer = json_decode($item->customer_details, true) ?? [];
            $uniqueId = $item->unique_id ?? ($item->quotation_no ?? ($item->booking_no ?? ($item->invoice_no ?? '')));
            return [
                'Type'       => $this->type,
                'Client'     => $customer['company_name'] ?? '',
                'POC'        => $customer['contact_person_c'] ?? '',
                'Unique ID'  => $uniqueId,
                'Phone'      => $customer['cmobile'] ?? $item->phone ?? '',
                'Email'      => $customer['cemail'] ?? $item->email ?? '',
                'Whatsapp'   => $customer['cwhatsapp'] ?? '',
            ];
        });

        return collect($rows);
    }

    public function headings(): array
    {
        return ['Type','Client','POC','Unique ID','Phone','Email','Whatsapp'];
    }
}