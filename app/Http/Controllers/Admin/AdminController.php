<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Hash;
use App\Models\User;
use App\Models\Registration;
use App\Models\Invoice;
use App\Models\Booking;
use App\Models\Quotation;
use App\Models\Pitch;
use App\Models\PerformaInvoiceChallan;
use App\Models\Inquiry;
use Carbon\Carbon;
use App\Models\LeadStatusLog;
use Illuminate\Support\Facades\DB;
use Rap2hpoutre\FastExcel\FastExcel;


class AdminController extends Controller
{
    

    public function index() {
        if(Auth::check()){
            return redirect()->route('admin.home');
            die();
        }
        return view('admin/login');
    }

    public function login( Request $request ) {

        $this->validate($request, ['email' => 'required|email', 'password' => 'required']);


        if( Auth::attempt(['email' => $request->email, 'password' => $request->password, 'role' => 'admin']) ) {
            return redirect()->route('admin.home');
        }elseif( Auth::attempt(['email' => $request->email, 'password' => $request->password, 'role' => 'teacher']) ) {
            return redirect()->route('teacher.home');
        }

        return redirect()->back()->with('message', 'Invalid Email or password!');

    }

       public function searchPincode( Request $request ) {

        // if( !$request->ajax() )
        //     return;
            
        if( !$request->pincode )
            return;

        $headers = array(
                            'Accept: application/json',
                            'Content-Type: application/json',
                    );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://www.postalpincode.in/api/pincode/' . $request->pincode );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        //$body = '{}';
        //curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); 
        //curl_setopt($ch, CURLOPT_POSTFIELDS,$body);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        $json = json_decode($result);

        if( !isset( $json->Status ) || $json->Status !== 'Success' )
            return response()->json(['error' => true, 'message' => 'Pincode not found!']);

        if( !isset( $json->PostOffice ) || !$json->PostOffice )
            return response()->json(['error' => true, 'message' => 'Pincode not found!']);

        if( count($json->PostOffice) < 1 )
            return response()->json(['error' => true, 'message' => 'Pincode not found!']);

        $data = [
                    'pincode' => $request->pincode,
                    'city' => $json->PostOffice[0]->District,
                    'state' => $json->PostOffice[0]->State,
                    'country' => $json->PostOffice[0]->Country,
                ];

        return response()->json(['error' => false, 'data' => $data]);
    }

     private function formatIndianCurrency($amount)
    {
        if ($amount >= 10000000) {
            return '₹' . round($amount / 10000000, 2) . ' Cr';
        } elseif ($amount >= 100000) {
            return '₹' . round($amount / 100000, 2) . ' Lakh';
        } else {
            return '₹' . number_format($amount);
        }
    }

    // public function home(){
    //     $title = 'Dashboard';
    //     return view(_template('dashboard.index'),['title'=>$title]);
    // }
     public function home(Request $request){
        $title = 'Dashboard';
        $currentDate = Carbon::now();
        $invoiceCount = Invoice::count();
        $invoiceTotal   = Invoice::sum('total_amount');
        $bookingCount = Booking::count();
        $bookingTotalAmount = Booking::sum('total_amount');
        $quotationCount = Quotation::count();
        $quotationTotalAmount = Quotation::sum('total_amount');
        $quotationNetAmount = Quotation::sum('net_amount');
        $bookingNetAmount = Booking::sum('net_amount');
        $invoiceNetAmount = Invoice::sum('net_amount');
        $challanNetAmount   = PerformaInvoiceChallan::sum('net_amount');
        $pitchCount = Pitch::count();
        $pitchTotalAmount = Pitch::sum('total_grand_amount');
        $inquiryCount = Inquiry::count();
        $challanCount   = PerformaInvoiceChallan::count(); 
        $challanTotal   = PerformaInvoiceChallan::sum('total_amount');
        $latestInquiries = Inquiry::with(['customer','address'])->orderBy('id','DESC')->limit(5)->get();

      $overallGP = DB::table('invoices')
        ->join('invoice_items', 'invoices.id', '=', 'invoice_items.invoice_id')
        ->join('items', 'invoice_items.item_id', '=', 'items.id')
        ->selectRaw('
            SUM((invoice_items.gross_amount * items.profit_margin) / 100) as total_gp,
            SUM(invoice_items.gross_amount) as total_sales
        ')
        ->first();

        $overallGPValue = $overallGP->total_gp ?? 0;
        $overallSales   = $overallGP->total_sales ?? 0;
        $overallGPPercent = $overallSales > 0 
            ? round(($overallGPValue / $overallSales) * 100, 1) 
            : 0;
    // dd($overallGPPercent);

        $latestBooking = Booking::with(['customerType', 'inquiry', 'quotaiton.occasion', 'bookingItem'])
        ->where('billing_date', '>', $currentDate)
        ->latest('id')
        ->take(5)
        ->get();
        
         $summary = [
        'Inquiry' => [
            'qty' => $inquiryCount,
            'amt' => '',
            'conv' => $inquiryCount
        ],
        'P.I.' => [
            'qty' => $quotationCount,
            'amt' => $quotationNetAmount,
            'conv' => $inquiryCount > 0 ? round(($quotationCount / $inquiryCount) * 100) . '%' : '0%'
        ],
        'Bookings' => [
            'qty' => $bookingCount,
            'amt' => $bookingNetAmount,
            'conv' => $inquiryCount > 0 ? round(($bookingCount / $inquiryCount) * 100) . '%' : '0%'
        ],
        'Invoices' => [
            'qty' => $invoiceCount,
            'amt' => $invoiceNetAmount,
            'conv' => $inquiryCount > 0 ? round(($invoiceCount / $inquiryCount) * 100) . '%' : '0%'
        ],
        'Challans' => [
            'qty' => $challanCount,
            'amt' => $challanNetAmount,
            'conv' => $inquiryCount > 0 ? round(($challanCount / $inquiryCount) * 100) . '%' : '0%'
        ],
    ];

    //status of inqury
   
    $leadStatusCounts = Inquiry::with('leadstatus')
        ->get()
        ->groupBy(function ($inquiry) {
            return $inquiry->leadstatus ? $inquiry->leadstatus->status : '';
        })->map(function ($group) {
            return $group->     count();
        })->toArray();
        $leadStatusLabels = array_keys($leadStatusCounts);
        $leadStatusData   = array_values($leadStatusCounts);

    //LossBusiness status
        $lossReasons = [
            'Closed: Event Cancelled',
            'Closed: Event Postponed',
            'Closed: Requirement Cancelled',
            'Closed: Not Responding',
            'Closed: Out of Stock',
            'Closed: Not Viable for Either',
            'Closed: Raising Another PI',
            'Closed: Payment Terms Issue',
            'Closed: Budget Constraints',
            'Closed: Rejected - Poor Quality',
            'Closed: Went to Competition',
        ];

    // Group inquiries by formatted loss reason
    $lossBusiness = Inquiry::with('leadstatus')
    ->whereHas('leadstatus', fn($q) => $q->whereIn('status', $lossReasons))->get()
    ->groupBy(fn($inquiry) => $inquiry->leadstatus->status)
    ->map(fn($items) => $items->count())
    ->toArray();

    $totalInquiries = Inquiry::count();
    // Final array for chart
    $lossBusinessFinal = [];
    foreach ($lossReasons as $reason) {
        $qty = $lossBusiness[$reason] ?? 0;
        $lossBusinessFinal[] = [
            'head'    => $reason,
            'qty'     => $qty,
            'percent' => $totalInquiries > 0 ? round(($qty / $totalInquiries) * 100, 1) : 0,
        ];
    }


    // ===== Total Business Data (Sales per Month) =====
  
    // Monthly Sales (Gross Amount)
       $ttBusinessData = \DB::table('invoices')
            ->join('invoice_items', 'invoices.id', '=', 'invoice_items.invoice_id')
            ->selectRaw('MONTH(invoices.created_at) as month, SUM(invoice_items.gross_amount) as total')
            ->groupBy(\DB::raw('MONTH(invoices.created_at)'))
            ->orderBy(\DB::raw('MONTH(invoices.created_at)'))
            ->pluck('total', 'month')
            ->toArray();

        // Ensure 12 months filled
        $ttBusinessData = array_replace(array_fill(1, 12, 0), $ttBusinessData);
        $ttBusinessData = array_values($ttBusinessData);

        // Monthly GP (absolute value)
        $monthlyGP = \DB::table('invoices')
            ->join('invoice_items', 'invoices.id', '=', 'invoice_items.invoice_id')
            ->join('items', 'invoice_items.item_id', '=', 'items.id')
            ->selectRaw('MONTH(invoices.created_at) as month, SUM((invoice_items.gross_amount * items.profit_margin) / 100) as total_gp')
            ->groupBy(\DB::raw('MONTH(invoices.created_at)'))
            ->orderBy(\DB::raw('MONTH(invoices.created_at)'))
            ->pluck('total_gp', 'month')
            ->toArray();


        $monthlyGP = array_replace(array_fill(1, 12, 0), $monthlyGP);
        $monthlyGP = array_values($monthlyGP);

        // Monthly GP % (based on above)
        $gpPercentData = [];
        foreach (range(1, 12) as $i) {
            $sales = $ttBusinessData[$i - 1] ?? 0;
            $gp    = $monthlyGP[$i - 1] ?? 0;

            $gpPercentData[] = $sales > 0 ? round(($gp / $sales) * 100, 1) : 0;
        }


         $overallGPValueFormatted = $this->formatIndianCurrency($overallGPValue);

        // Pass everything to view
        return view(_template('dashboard.index'), compact(
            'title',
            'invoiceCount',
            'bookingCount',
            'bookingTotalAmount',
            'quotationCount',
            'quotationTotalAmount',
            'pitchCount',
            'pitchTotalAmount',
            'inquiryCount',
            'ttBusinessData',
            'gpPercentData',
            'leadStatusLabels',
            'leadStatusData',
            'invoiceTotal',
            'summary',
            'lossBusinessFinal',
            'totalInquiries',
            'latestInquiries',
            'latestBooking',
            'overallGPValue',
            'overallGPPercent',
            'overallSales',
            'overallGPValueFormatted'
        ));
    }

    public function filterChart(Request $request){
        $chartType = $request->input('chartType');
        $month = $request->input('month');
        $year = $request->input('year');
        
        // Initialize queries based on chart type
        switch ($chartType) {
           
            case 'summary':
                $inquiryQuery = Inquiry::query();
                $quotationQuery = Quotation::query();
                $bookingQuery = Booking::query();
                $invoiceQuery = Invoice::query();
                $challanQuery = PerformaInvoiceChallan::query();

                // Apply filters
                if (!empty($month)) {
                    $inquiryQuery->whereMonth('created_at', $month);
                    $quotationQuery->whereMonth('created_at', $month);
                    $bookingQuery->whereMonth('created_at', $month);
                    $invoiceQuery->whereMonth('created_at', $month);
                    $challanQuery->whereMonth('created_at', $month);
                }

                if (!empty($year)) {
                    $inquiryQuery->whereYear('created_at', $year);
                    $quotationQuery->whereYear('created_at', $year);
                    $bookingQuery->whereYear('created_at', $year);
                    $invoiceQuery->whereYear('created_at', $year);
                    $challanQuery->whereYear('created_at', $year);
                }

                // Counts
                $inquiryCount = $inquiryQuery->count();
                $quotationCount = $quotationQuery->count();
                $bookingCount = $bookingQuery->count();
                $invoiceCount = $invoiceQuery->count();
                $challanCount = $challanQuery->count();

                // **Net amount filtered**
                $quotationNetAmount = $quotationQuery->sum('net_amount');
                $bookingNetAmount   = $bookingQuery->sum('net_amount');
                $invoiceNetAmount   = $invoiceQuery->sum('net_amount');
                $challanNetAmount   = $challanQuery->sum('net_amount');

                $summary = [
                    'Inquiry' => [
                        'qty' => $inquiryCount,
                        'amt' => 0,
                        'conv' => $inquiryCount
                    ],
                    'P.I.' => [
                        'qty' => $quotationCount,
                        'amt' => $quotationNetAmount,
                        'conv' => $inquiryCount > 0 ? round(($quotationCount / $inquiryCount) * 100) . '%' : '0%'
                    ],
                    'Bookings' => [
                        'qty' => $bookingCount,
                        'amt' => $bookingNetAmount,
                        'conv' => $inquiryCount > 0 ? round(($bookingCount / $inquiryCount) * 100) . '%' : '0%'
                    ],
                    'Invoices' => [
                        'qty' => $invoiceCount,
                        'amt' => $invoiceNetAmount,
                        'conv' => $inquiryCount > 0 ? round(($invoiceCount / $inquiryCount) * 100) . '%' : '0%'
                    ],
                    'Challans' => [
                        'qty' => $challanCount,
                        'amt' => $challanNetAmount,
                        'conv' => $inquiryCount > 0 ? round(($challanCount / $inquiryCount) * 100) . '%' : '0%'
                    ],
                ];

                $labels = [];
                $qtyValues = [];

                foreach ($summary as $key => $item) {
                    if ($item['amt'] && $item['amt'] > 0) {
                        $labels[] = "{$key} ({$item['qty']}, ₹" . number_format($item['amt']) . ")";
                    } else {
                        $labels[] = "{$key} ({$item['qty']})";
                    }
                    $qtyValues[] = $item['qty'];
                }

                return response()->json([
                    'labels' => $labels,
                    'qtyValues' => $qtyValues
                ]);

                
            case 'leadStatus':
                $query = Inquiry::with('leadstatus');
                
                if (!empty($month)) {
                    $query->whereMonth('created_at', $month);
                }
                
                if (!empty($year)) {
                    $query->whereYear('created_at', $year);
                }
                
                $leadStatusCounts = $query->get()
                    ->groupBy(function ($inquiry) {
                        return $inquiry->leadstatus ? $inquiry->leadstatus->status : '';
                    })->map(function ($group) {
                        return $group->count();
                    })->toArray();
                    
                return response()->json([
                    'labels' => array_keys($leadStatusCounts),
                    'data' => array_values($leadStatusCounts)
                ]);
           
            case 'lossBusiness':
            $lossReasons = [
                'Closed: Event Cancelled',
                'Closed: Event Postponed',
                'Closed: Requirement Cancelled',
                'Closed: Not Responding',
                'Closed: Out of Stock',
                'Closed: Not Viable for Either',
                'Closed: Raising Another PI',
                'Closed: Payment Terms Issue',
                'Closed: Budget Constraints',
                'Closed: Rejected - Poor Quality',
                'Closed: Went to Competition',
            ];

            // Build query first (with filters)
            $query = Inquiry::with('leadstatus')
                ->whereHas('leadstatus', fn($q) => $q->whereIn('status', $lossReasons))
                ->when(!empty($month), fn($q) => $q->whereMonth('created_at', $month))
                ->when(!empty($year), fn($q) => $q->whereYear('created_at', $year));

            // Total inquiries count with filters
            $inquiryCount = (clone $query)->count();

            // Grouped counts by loss reason
            $lossBusiness = $query->get()
                ->groupBy(fn($inquiry) => $inquiry->leadstatus->status)
                ->map(fn($items) => $items->count())
                ->toArray();

            // Format response
            $lossBusinessFinal = [];
            foreach ($lossReasons as $reason) {
                $qty = $lossBusiness[$reason] ?? 0;
                $lossBusinessFinal[] = [
                    'head'    => $reason,
                    'qty'     => $qty,
                    'percent' => $inquiryCount > 0 ? round(($qty / $inquiryCount) * 100, 1) : 0,
                ];
                
            }
           
            return response()->json($lossBusinessFinal);
                
            case 'financial':
                // Total Business (Sales)
                $ttBusinessQuery = Invoice::join('invoice_items', 'invoices.id', '=', 'invoice_items.invoice_id')
                    ->selectRaw('MONTH(invoices.created_at) as month, SUM(invoice_items.gross_amount) as total');

                // GP Value
                $gpValueQuery = Invoice::join('invoice_items', 'invoices.id', '=', 'invoice_items.invoice_id')
                    ->join('items', 'invoice_items.item_id', '=', 'items.id')
                    ->selectRaw('MONTH(invoices.created_at) as month, SUM((invoice_items.gross_amount * items.profit_margin) / 100) as gp_value');

                if (!empty($year)) {
                    $ttBusinessQuery->whereYear('invoices.created_at', $year);
                    $gpValueQuery->whereYear('invoices.created_at', $year);
                }

                // Sales data
                $ttBusinessData = $ttBusinessQuery->groupBy(\DB::raw('MONTH(invoices.created_at)'))
                    ->orderBy(\DB::raw('MONTH(invoices.created_at)'))
                    ->pluck('total', 'month')
                    ->toArray();

                // GP Value data
                $gpValueData = $gpValueQuery->groupBy(\DB::raw('MONTH(invoices.created_at)'))
                    ->orderBy(\DB::raw('MONTH(invoices.created_at)'))
                    ->pluck('gp_value', 'month')
                    ->toArray();

                // Fill missing months
                $ttBusinessData = array_replace(array_fill(1, 12, 0), $ttBusinessData);
                $ttBusinessData = array_values($ttBusinessData);

                $gpValueData = array_replace(array_fill(1, 12, 0), $gpValueData);
                $gpValueData = array_values($gpValueData);

                // GP % calculation
                $gpPercentData = [];
                foreach (range(1, 12) as $i) {
                    $sales = $ttBusinessData[$i - 1] ?? 0;
                    $gp    = $gpValueData[$i - 1] ?? 0;

                    $gpPercentData[] = $sales > 0 ? round(($gp / $sales) * 100, 1) : 0;
                }

                return response()->json([
                    'ttBusinessData' => $ttBusinessData,
                    'gpValueData'    => $gpValueData,
                    'gpPercentData'  => $gpPercentData,
                ]);
                
            default:
                return response()->json(['error' => 'Invalid chart type'], 400);
        }
    }





    public function summaryDetails(Request $request)
    {
        $type  = $request->input('type'); // Inquiry, P.I., Bookings, Invoices, Challans
        $month = $request->input('month');
        $year  = $request->input('year');

        // ==== Base Query ====
        switch ($type) {
            case 'Inquiry':
                $query = Inquiry::with(['customer','leadstatus']);
                break;
            // case 'P.I.':
            //     $query = Quotation::with(['quotationItem','customerType','occasion']);
            //     break;
            // case 'Bookings':
            //     $query = Booking::with(['bookingItem','customerType','quotaiton.occasion']);
            //     break;
            case 'P.I.':
            $query = Quotation::with(['quotationItem','customerType','occasion'])
                 ->select('quotations.*')
                ->selectSub(function ($query) {
                    $query->from('quotations_items as qi')
                        ->join('items as i', 'qi.item_id', '=', 'i.id')
                        ->selectRaw('SUM((qi.gross_amount * i.profit_margin) / 100)')
                        ->whereColumn('qi.invoice_id', 'quotations.id');
                }, 'total_gp');
            break;

        case 'Bookings':
            $query = Booking::with(['bookingItem','customerType','quotaiton.occasion'])
                ->select('bookings.*')
                ->selectSub(function ($q) {
                    $q->from('bookings_items as bi')
                      ->join('items as i', 'bi.item_id', '=', 'i.id')
                      ->selectRaw('SUM((bi.gross_amount * i.profit_margin) / 100)')
                      ->whereColumn('bi.invoice_id', 'bookings.id');
                }, 'total_gp');
            break;
            case 'Invoices':
                $query = Invoice::with('customerType');
                break;
            case 'Challans':
                $query = PerformaInvoiceChallan::with('customerType');
                break;
            default:
                return response()->json([], 400);
        }

        // ==== Filters ====
        if ($month) $query->whereMonth('created_at', $month);
        if ($year)  $query->whereYear('created_at', $year);

        $rows = $query->get()->map(function($item) use ($type) {

            $customer = json_decode($item->customer_details ?? '{}', true) ?? [];
            $venue    = json_decode($item->delivery_details ?? '{}', true) ?? [];
            $status   = $item->leadstatus->status ?? '';

            switch ($type) {
                case 'Inquiry':
                    return [
                        'client'     => $item->customer->company_name ?? '',
                        'unique_id'  => $item->unique_id,
                        'phone'      => $customer['cmobile'] ?? '',
                        'email'      => $item->customer->email ?? '',
                        'whatsapp'   => $item->customer->cwhatsapp ?? '',
                        'leadstatus' => $status,
                        'edit_url'   => route('inquiry.edit', $item->id),
                    ];

                case 'P.I.':
                    return [
                        'quotation_id' => $item->invoice_no .'.'. $item->pitch_count,
                        'client'       => $customer['company_name'] ?? '',
                        'poc'          => is_numeric($customer['contact_person_c'] ?? '') 
                                            ? ($customer['select_two_name'] ?? '') 
                                            : ($customer['contact_person_c'] ?? ''),
                        'mobile'       => $customer['cmobile'] ?? '',
                        'duration'     => '', // you can calculate if available
                        'venue'        => $venue['dvenue_name'] ?? '',
                        'city'         => $venue['dcity'] ?? '',
                        'readyness'    => $customer['creadyness'] ?? '',
                        'ticket_size'  => $item->net_amount, 
                        'gp'           => $item->total_gp, 
                        'edit_url'     => route('quotation.edit', $item->id),
                    ];

                case 'Bookings':
                    return [
                        'booking_no'  => $item->invoice_no ?? '',
                        'quotation_id'=> $item->quotaiton->invoice_no ?? '',
                        'client'      => $customer['company_name'] ?? '',
                        'poc'         => is_numeric($customer['contact_person_c'] ?? '') 
                                            ? ($customer['select_two_name'] ?? '') 
                                            : ($customer['contact_person_c'] ?? ''),
                        'mobile'      => $customer['cmobile'] ?? '',
                        'date'        => $item->billing_date ? date('d-m-Y', strtotime($item->billing_date)) : '',
                        'readyness'   => $customer['creadyness'] ?? '',
                        'venue'       => $venue['dvenue_name'] ?? '',
                        'occasion'    => $item->quotaiton->occasion->occasion ?? '',
                        'ticket_size' => $item->net_amount,
                        'gp'           => $item->total_gp, 
                        'items'       => $item->bookingItem->pluck('item')->implode(', '),
                        'edit_url'    => route('booking.edit', $item->id),
                    ];

                case 'Invoices':
                    return [
                        'invoice_no' => $item->invoice_no ?? '',
                        'client'     => $customer['company_name'] ?? '',
                        'amount'     => $item->total_amount ?? '',
                        'date'       => $item->billing_date ? date('d-m-Y', strtotime($item->billing_date)) : '',
                        'edit_url'   => route('invoice.edit', $item->id),
                    ];

                case 'Challans':
                    return [
                        'challan_type' => $item->challan_type,
                        'challan_no'   => $item->challan_no,
                        'ref_pi_no'    => $item->ref_pi_no ?? '',
                        'billing_date' => $item->billing_date ? date('d-m-Y', strtotime($item->billing_date)) : '',
                        'customer_type'=> $item->customerType->type ?? '',
                        'edit_url'     => route('challan.edit', $item->id),
                    ];
            }

            return [];
        });

        // ==== Response ====
        return response()->json([
            'type'    => $type,
            'columns' => match($type) {
                'Inquiry'  => ['S/No.', 'Client Name', 'Unique ID', 'Phone No', 'Email', 'Whatsapp', 'Lead Status', 'Action'],
                'P.I.'     => ['S/No.', 'Quotation Id', 'Client', 'POC', 'Mobile', 'Duration', 'Venue', 'City', 'Readyness', 'Ticket Size', 'GP', 'Action'],
                'Bookings' => ['S/No.', 'Booking No', 'Quotation Id', 'Client Name', 'Contact Person', 'Mobile', 'Booking Date', 'Readyness', 'Venue', 'Occasion',  'Ticket Size', 'GP', 'Items', 'Action'],
                'Invoices' => ['S/No.', 'Invoice No', 'Client', 'Amount', 'Date', 'Action'],
                'Challans' => ['S/No.', 'Challan Type', 'Challan No', 'Ref PI No', 'Billing Date', 'Customer Type', 'Action'],
                default    => []
            },
            'rows'    => $rows,
        ]);
    }


    public function exportSummary(Request $request)
    {
        $type  = $request->input('type');
        $month = $request->input('month');
        $year  = $request->input('year');

        // ==== Base Query ====
        switch ($type) {
            case 'Inquiry':
                $query = Inquiry::with(['customer','leadstatus']);
                $columns = ['S/No.', 'Client Name', 'Unique ID', 'Phone No', 'Email', 'Whatsapp', 'Lead Status'];
                break;

            // case 'P.I.':
            //     $query = Quotation::with(['quotationItem','customerType','occasion']);
            //     $columns = ['S/No.', 'Quotation Id', 'Client', 'POC', 'Mobile', 'Duration', 'Venue', 'City', 'Readyness', 'Ticket Size', 'GP'];
            //     break;

            // case 'Bookings':
            //     $query = Booking::with(['bookingItem','customerType','quotaiton.occasion']);
            //     $columns = ['S/No.', 'Booking No', 'Quotation Id', 'Client Name', 'Contact Person', 'Mobile', 'Booking Date', 'Readyness', 'Venue', 'Occasion', 'Total Amount', 'Items'];
            //     break;
             case 'P.I.':
                $query = Quotation::with(['quotationItem','customerType','occasion'])
                    ->select('quotations.*')
                    ->selectSub(function ($query) {
                        $query->from('quotations_items as qi')
                            ->join('items as i', 'qi.item_id', '=', 'i.id')
                            ->selectRaw('SUM((qi.gross_amount * i.profit_margin) / 100)')
                            ->whereColumn('qi.invoice_id', 'quotations.id');
                    }, 'total_gp');
                break;

            case 'Bookings':
                $query = Booking::with(['bookingItem','customerType','quotaiton.occasion'])
                    ->select('bookings.*')
                    ->selectSub(function ($q) {
                        $q->from('bookings_items as bi')
                        ->join('items as i', 'bi.item_id', '=', 'i.id')
                        ->selectRaw('SUM((bi.gross_amount * i.profit_margin) / 100)')
                        ->whereColumn('bi.invoice_id', 'bookings.id');
                    }, 'total_gp');
                break;

            case 'Invoices':
                $query = Invoice::with('customerType');
                $columns = ['S/No.', 'Invoice No', 'Client', 'Amount', 'Date'];
                break;

            case 'Challans':
                $query = PerformaInvoiceChallan::with('customerType');
                $columns = ['S/No.', 'Challan Type', 'Challan No', 'Ref PI No', 'Billing Date', 'Customer Type'];
                break;

            default:
                return back()->with('error','Invalid type');
        }

        // ==== Filters ====
        if ($month) $query->whereMonth('created_at', $month);
        if ($year)  $query->whereYear('created_at', $year);

        // ==== Prepare Rows ====
        $rows = $query->get()->map(function($item, $i) use ($type) {
            $customer = json_decode($item->customer_details ?? '{}', true) ?? [];
            $venue    = json_decode($item->delivery_details ?? '{}', true) ?? [];
            $status   = $item->leadstatus->status ?? '';

            switch ($type) {
                case 'Inquiry':
                    return [
                        'S/No.'       => $i + 1,
                        'Client Name' => $item->customer->company_name ?? '',
                        'Unique ID'   => $item->unique_id,
                        'Phone No'    => $customer['cmobile'] ?? '',
                        'Email'       => $item->customer->email ?? '',
                        'Whatsapp'    => $item->customer->cwhatsapp ?? '',
                        'Lead Status' => $status,
                    ];

                case 'P.I.':
                    return [
                        'S/No.'        => $i + 1,
                        'Quotation Id' => $item->invoice_no .'.'. $item->pitch_count,
                        'Client'       => $customer['company_name'] ?? '',
                        'POC'          => is_numeric($customer['contact_person_c'] ?? '') 
                                            ? ($customer['select_two_name'] ?? '') 
                                            : ($customer['contact_person_c'] ?? ''),
                        'Mobile'       => $customer['cmobile'] ?? '',
                        'Duration'     => '',
                        'Venue'        => $venue['dvenue_name'] ?? '',
                        'City'         => $venue['dcity'] ?? '',
                        'Readyness'    => $customer['creadyness'] ?? '',
                        'Ticket Size'  => $item->net_amount,
                        'gp'           => $item->total_gp, 
                    ];

                case 'Bookings':
                    return [
                        'S/No.'       => $i + 1,
                        'Booking No'  => $item->invoice_no ?? '',
                        'Quotation Id'=> $item->quotaiton->invoice_no ?? '',
                        'Client Name' => $customer['company_name'] ?? '',
                        'Contact Person'=> is_numeric($customer['contact_person_c'] ?? '') 
                                            ? ($customer['select_two_name'] ?? '') 
                                            : ($customer['contact_person_c'] ?? ''),
                        'Mobile'      => $customer['cmobile'] ?? '',
                        'Booking Date'=> $item->billing_date ? date('d-m-Y', strtotime($item->billing_date)) : '',
                        'Readyness'   => $customer['creadyness'] ?? '',
                        'Venue'       => $venue['dvenue_name'] ?? '',
                        'Occasion'    => $item->quotaiton->occasion->occasion ?? '',
                        // 'Total Amount'=> $item->total_amount,
                        'Ticket Size'  => $item->net_amount,
                         'gp'           => $item->total_gp, 
                        'Items'       => $item->bookingItem->pluck('item')->implode(', '),
                        
                    ];

                case 'Invoices':
                    return [
                        'S/No.'     => $i + 1,
                        'Invoice No'=> $item->invoice_no ?? '',
                        'Client'    => $customer['company_name'] ?? '',
                        'Amount'    => $item->total_amount ?? '',
                        'Date'      => $item->billing_date ? date('d-m-Y', strtotime($item->billing_date)) : '',
                    ];

                case 'Challans':
                    return [
                        'S/No.'        => $i + 1,
                        'Challan Type' => $item->challan_type,
                        'Challan No'   => $item->challan_no,
                        'Ref PI No'    => $item->ref_pi_no ?? '',
                        'Billing Date' => $item->billing_date ? date('d-m-Y', strtotime($item->billing_date)) : '',
                        'Customer Type'=> $item->customerType->type ?? '',
                    ];
            }
        });

        // ==== Filename & Download ====
        $filename = $type.'_summary_'.now()->format('Y-m-d_H-i').'.xlsx';
        return (new FastExcel($rows))->download($filename);
    }

    public function leadStatusDetails(Request $request)
    {
        $status = $request->input('type'); // status name from chart
        $month  = $request->input('month');
        $year   = $request->input('year');

        $query = Inquiry::with(['customer','leadstatus'])
            ->whereHas('leadstatus', function($q) use ($status) {
                $q->where('status', $status);
            });

        if ($month) $query->whereMonth('created_at', $month);
        if ($year)  $query->whereYear('created_at', $year);

        $rows = $query->get()->map(function($item) {
            $customer = json_decode($item->customer_details ?? '{}', true) ?? [];
            return [
                'type'      => $item->leadstatus->status ?? '',
                'client'    => $item->customer->company_name ?? '',
                'poc'       => $customer['contact_person_c'] ?? '',
                'unique_id' => $item->unique_id ?? '',
                'phone'     => $customer['cmobile'] ?? '',
                'email'     => $item->customer->email ?? '',
                'whatsapp'  => $item->customer->cwhatsapp ?? '',
                'edit_url'  => route('inquiry.edit', $item->id),
            ];
        });

        return response()->json($rows);
    }


    public function exportLeadStatus(Request $request)
    {
        $status = $request->input('type');
        $month  = $request->input('month');
        $year   = $request->input('year');

        $query = Inquiry::with(['customer','leadstatus'])
            ->whereHas('leadstatus', fn($q) => $q->where('status', $status));

        if ($month) $query->whereMonth('created_at', $month);
        if ($year)  $query->whereYear('created_at', $year);

        $rows = $query->get()->map(function($item, $i) {
            $customer = json_decode($item->customer_details ?? '{}', true) ?? [];
            return [
                'S/No.'     => $i+1,
                'Type'      => $item->leadstatus->status ?? '',
                'Client'    => $item->customer->company_name ?? '',
                'POC'       => $customer['contact_person_c'] ?? '',
                'Unique ID' => $item->unique_id ?? '',
                'Phone'     => $customer['cmobile'] ?? '',
                'Email'     => $item->customer->email ?? '',
                'Whatsapp'  => $item->customer->cwhatsapp ?? '',
            ];
        });

        $filename = 'LeadStatus_'.$status.'_'.now()->format('Y-m-d_H-i').'.xlsx';
        return (new \Rap2hpoutre\FastExcel\FastExcel($rows))->download($filename);
    }

  public function lossBusinessDetails(Request $request)
    {
        $reason = $request->get('reason');
        $month  = $request->get('month');
        $year   = $request->get('year');

        $query = Inquiry::with(['customer','leadstatus'])
            ->whereHas('leadstatus', fn($q) => $q->where('status', $reason));

        if ($month) $query->whereMonth('created_at', $month);
        if ($year)  $query->whereYear('created_at', $year);

        $rows = $query->get()->map(function($item, $i) {
            $customer = json_decode($item->customer_details ?? '{}', true) ?? [];
            return [
                'client'     => $item->customer->company_name ?? '',
                'poc'        => $item->customer->poc ?? '',
                'unique_id'  => $item->unique_id,
                'phone'      => $customer['cmobile'] ?? $item->customer->phone ?? '',
                'email'      => $item->customer->email ?? '',
                'whatsapp'   => $customer['cwhatsapp'] ?? $item->customer->whatsapp ?? '',
                'edit_url'   => route('inquiry.edit', $item->id),
            ];
        });

        return response()->json($rows);
    }

    public function lossBusinessExport(Request $request)
    {
        $reason = $request->get('reason');
        $month  = $request->get('month');
        $year   = $request->get('year');

        $query = Inquiry::with(['customer','leadstatus'])
            ->whereHas('leadstatus', fn($q) => $q->where('status', $reason));

        if ($month) $query->whereMonth('created_at', $month);
        if ($year)  $query->whereYear('created_at', $year);

        $rows = $query->get()->map(function($item, $i) {
            $customer = json_decode($item->customer_details ?? '{}', true) ?? [];
            return [
                'Client'     => $item->customer->company_name ?? '',
                'Unique ID'  => $item->unique_id,
                'Phone'      => $customer['cmobile'] ?? $item->customer->phone ?? '',
                'Email'      => $item->customer->email ?? '',
                'Whatsapp'   => $customer['cwhatsapp'] ?? $item->customer->whatsapp ?? '',
                'Reason'     => $item->leadstatus->status ?? '',
            ];
        });

        return (new FastExcel($rows))->download("LossBusiness-{$reason}.xlsx");
    }

        public function exportFinancialChartCSV(Request $request) {
            $selectedYear = $request->year; // optional
            $months = ['Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec','Jan','Feb','Mar'];

            // Determine financial years
            if (!$selectedYear) {
                $minYear = \DB::table('invoices')->min(\DB::raw('YEAR(created_at)'));
                $maxYear = \DB::table('invoices')->max(\DB::raw('YEAR(created_at)'));
            } else {
                $minYear = $maxYear = $selectedYear;
            }

            // Build header
            $header = ['Financial Year'];
            foreach ($months as $month) {
                $header[] = $month.' TT';
                $header[] = $month.' GP';
                $header[] = $month.' GP%';
            }

            $data = [];

            for ($year = $minYear; $year <= $maxYear; $year++) {
                $financialYear = $year.'-'.($year + 1);
                $row = [$financialYear];

                foreach ($months as $index => $monthName) {
                    $m = $index + 4;
                    $currentYear = $year;
                    if ($m > 12) {
                        $m -= 12;
                        $currentYear += 1;
                    }

                    $query = \DB::table('invoices')
                        ->join('invoice_items', 'invoices.id', '=', 'invoice_items.invoice_id');

                    $ttBusiness = (clone $query)
                        ->whereMonth('invoices.created_at', $m)
                        ->whereYear('invoices.created_at', $currentYear)
                        ->sum('invoice_items.gross_amount');

                    $gp = (clone $query)
                        ->join('items', 'invoice_items.item_id', '=', 'items.id')
                        ->whereMonth('invoices.created_at', $m)
                        ->whereYear('invoices.created_at', $currentYear)
                        ->selectRaw('SUM((invoice_items.gross_amount * items.profit_margin)/100) as gp')
                        ->pluck('gp')->first() ?? 0;

                    $gpPercent = $ttBusiness > 0 ? round(($gp / $ttBusiness) * 100, 1) : 0;

                    $row = array_merge($row, [$ttBusiness, $gp, $gpPercent]);
                }

                $data[] = $row;
            }

            // Export CSV
            $filename = "Financial-Chart.csv";
            $handle = fopen('php://output', 'w');
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="'.$filename.'"');

            fputcsv($handle, $header);

            foreach ($data as $row) {
                fputcsv($handle, $row);
            }

            fclose($handle);
            exit;
        }


    public function search(Request $request)
    {
        $term = trim($request->input('search'));

        // ===== Inquiries =====
        $inquiries = Inquiry::query()
            ->where(function ($q) use ($term) {
                $q->where('unique_id', 'like', "%{$term}%")
                ->orWhere('email', 'like', "%{$term}%")
                ->orWhere('phone', 'like', "%{$term}%");
            })
            ->get()
            ->filter(function($item) use ($term) {
                $customer = json_decode($item->customer_details, true) ?? [];
                $company = $customer['company_name'] ?? '';
                $poc = $customer['contact_person_c'] ?? '';

                return stripos($company, $term) !== false ||
                    stripos($poc, $term) !== false ||
                    stripos($item->unique_id, $term) !== false ||
                    stripos($item->email, $term) !== false ||
                    stripos($item->phone, $term) !== false;
            })
            ->map(function ($item) {
                $customer = json_decode($item->customer_details, true) ?? [];
                return [
                    'type'      => 'Inquiry',
                    'client'    => $customer['company_name'] ?? '',
                    'unique_id' => $item->unique_id,
                    'phone'     => $customer['cmobile'] ?? $item->phone ?? '',
                    'poc'       => $customer['contact_person_c'] ?? '',
                    'email'     => $customer['cemail'] ?? $item->email ?? '',
                    'whatsapp'  => $customer['cwhatsapp'] ?? '',
                    'status'    => $item->status_id ?? '',
                    'id'        => $item->id,
                    'edit_url'  => route('inquiry.edit', $item->id),
                ];
            });

        $inquiries = collect($inquiries);

        // ===== Bookings =====
        $bookings = Booking::query()
            ->where('invoice_no', 'like', "%{$term}%")
            ->orWhere('id', 'like', "%{$term}%")
            ->get()
            ->filter(function($item) use ($term) {
                $customer = json_decode($item->customer_details, true) ?? [];
                $company = $customer['company_name'] ?? '';
                $poc = $customer['contact_person_c'] ?? '';

                return stripos($company, $term) !== false ||
                    stripos($poc, $term) !== false ||
                    stripos($item->invoice_no, $term) !== false ||
                    stripos((string)$item->id, $term) !== false;
            })
            ->map(function ($item) {
                $customer = json_decode($item->customer_details, true) ?? [];
                return [
                    'type'      => 'Booking',
                    'client'    => $customer['company_name'] ?? '',
                    'unique_id' => $item->invoice_no,
                    'phone'     => $customer['cmobile'] ?? '',
                    'poc'       => $customer['contact_person_c'] ?? '',
                    'email'     => $customer['cemail'] ?? '',
                    'whatsapp'  => $customer['cwhatsapp'] ?? '',
                    'status'    => $item->lead_status ?? 'N/A',
                    'id'        => $item->id,
                    'edit_url'  => route('booking.edit', $item->id),
                ];
            });

        $bookings = collect($bookings);

        // ===== Quotations =====
        $quotations = Quotation::query()
            ->where('invoice_no', 'like', "%{$term}%")
            ->get()
            ->filter(function($item) use ($term) {
                $customer = json_decode($item->customer_details, true) ?? [];
                $company = $customer['company_name'] ?? '';
                $poc = $customer['contact_person_c'] ?? '';

                return stripos($company, $term) !== false ||
                    stripos($poc, $term) !== false ||
                    stripos($item->invoice_no, $term) !== false;
            })
            ->map(function ($item) {
                $customer = json_decode($item->customer_details, true) ?? [];
                return [
                    'type'      => 'Quotation',
                    'client'    => $customer['company_name'] ?? '',
                    'unique_id' => $item->invoice_no,
                    'phone'     => $customer['cmobile'] ?? '',
                    'poc'       => $customer['contact_person_c'] ?? '',
                    'email'     => $customer['cemail'] ?? '',
                    'whatsapp'  => $customer['cwhatsapp'] ?? '',
                    'status'    => $item->lead_status ?? 'N/A',
                    'id'        => $item->id,
                    'edit_url'  => route('quotation.edit', $item->id),
                ];
            });

        $quotations = collect($quotations);

        // ===== Merge all collections =====
        $results = $inquiries->merge($bookings)->merge($quotations);

        return response()->json($results->values());
    }




    public function teachers(){

        return view('admin/setting/all_teacher');
    }

    public function registration(){
        $registration = Registration::get();
        return view('admin/registration/index',['registrations'=>$registration]);
    }
    public function registration_view($id){
        $registration = Registration::where('id',$id)->first();
        return view('admin/registration/view',['registration'=>$registration]);
    }
    public function registration_delete(){
        $registration = Registration::get();
        return view('admin/registration/index',['registrations'=>$registration]);
    }

    public function createteacher(){

        return view('admin/setting/createteacher');
    }

    public function edit_teacher(){

        return view('admin/setting/edit_teacher');
    }


    public function createteacherstore(Request $request){


        $this->validate($request, [
                    'name' => 'required|max:255|string',
                    'email' => 'required|max:255|email|unique:users',
                    'mobile' => 'required|max:255|digits:10',
                    'department' => 'required',
                    'password' => 'required|min:8|max:255'
            ],
            [
                    'name.required' => 'Name is required *',
                    'name.max' => 'Name can have upto 255 characters!',
                    'email.required' => 'Email is required *',
                    'email.max' => 'Email can have upto 255 characters!',
                    'email.email' => 'Email must be valid!',
                    'email.unique' => 'Email already exist!',
            ]);

            $user = new User();
            $user->role = 'teacher';
            $user->name = $request->name;
            $user->department = $request->department;
            $user->email = $request->email;
            $user->password = Hash::make( $request->password );
            $user->s_password =  $request->password ;
            $user->mobile = $request->mobile;
            $user->save();

        return redirect()->back()->with('message', 'Teacher Created');

    }

    public function logout(){
        Auth::logout();
        return redirect()->route('admin');
    }

    
}
