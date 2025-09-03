<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use Carbon\Carbon;

class BookingCalendarController extends Controller
{
    public function index()
    {
        return view('admin.calendar.index', [
            'title' => 'Booking Calendar'
        ]);
    }

    public function events(Request $request)
    {
        $start = $request->start;
        $end   = $request->end;

        // Fetch all bookings between calendar range
        $bookings = Booking::with(['customerType','inquiry','quotaiton.occasion','bookingItem'])->whereBetween('billing_date', [$start, $end])->get();

        $events = [];

        foreach ($bookings as $booking) {
            $customer = json_decode($booking->customer_details, true);
            $venue    = json_decode($booking->delivery_details, true);

            $events[] = [
                'id'          => $booking->id,
                'title'       => $customer['company_name'] ?? 'Booking #' . $booking->invoice_no,
                'start'       => $booking->billing_date,
                'end'         => Carbon::parse($booking->billing_date)->addDay()->toDateString(),
                'allDay'      => true,

                // Custom props
                'booking_no'  => $booking->invoice_no,
                'quotation_no'=> '', // if you have relation, map here
                'client_name' => $customer['company_name'] ?? '',
                'contact_name'=> is_numeric($customer['contact_person_c'] ?? '')
                                ? ($customer['select_two_name'] ?? '')
                                : ($customer['contact_person_c'] ?? ''),
                'mobile'      => $customer['cmobile'] ?? '',
                'venue'       => $venue['dvenue_name'] ?? '',
                'occasion'    => $booking->occasion->occasion ?? '' ,
                'total_amount'=> $booking->total_amount ?? 0, 
                'total_tax'=> $booking->total_tax ?? 0 , 
                'items'       => $booking->bookingItem->map(function($item) {
                                return $item->item ?? '';
                                })->implode(', '),
                'color'       => $this->getEventColor($booking->total_amount),
                'textColor'   => '#ffffff',
            ];
        }

        return response()->json($events);
    }

    private function getEventColor($amount)
    {
        if ($amount > 50000) return '#d32f2f'; // red
        if ($amount > 20000) return '#f57c00'; // orange
        if ($amount > 10000) return '#689f38'; // green
        return '#7b1fa2'; // purple
    }

    public function show($id)
    {
        $booking  = Booking::findOrFail($id);
        $customer = json_decode($booking->customer_details, true);
        $venue    = json_decode($booking->delivery_details, true);

        return response()->json([
            'booking_no'   => $booking->invoice_no,
            'quotation_no' => '',
            'client_name'  => $customer['company_name'] ?? '',
            'contact_name' => is_numeric($customer['contact_person_c'] ?? '')
                            ? ($customer['select_two_name'] ?? '')
                            : ($customer['contact_person_c'] ?? ''),
            'mobile'       => $customer['cmobile'] ?? '',
            'venue'        => $venue['dvenue_name'] ?? '',
            'occasion'    => $booking->occasion->occasion ?? '' ,
            'total_amount' => $booking->total_amount ?? '',
            'total_tax'=> $booking->total_tax ?? 0 , 
            'items'       => $booking->bookingItem->map(function($item) {
                                return $item->item ?? '';
                                })->implode(', '),
            'date'         => $booking->billing_date,
        ]);
    }
}
