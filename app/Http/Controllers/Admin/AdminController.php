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
        $ttBusinessData = Invoice::selectRaw('MONTH(created_at) as month, SUM(total_amount) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

    // Ensure 12 months filled
        $ttBusinessData = array_replace(array_fill(1, 12, 0), $ttBusinessData);
        $ttBusinessData = array_values($ttBusinessData);

        // ===== GP % Data (Example using net_amount vs total_amount) =====
        $gpPercentData = Invoice::selectRaw('MONTH(created_at) as month, 
                (SUM(net_amount) / NULLIF(SUM(total_amount), 0)) * 100 as gp_percent')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('gp_percent', 'month')
            ->toArray();

        // Ensure 12 months filled
        $gpPercentData = array_replace(array_fill(1, 12, 0), $gpPercentData);
        $gpPercentData = array_map(fn($v) => round($v, 1), $gpPercentData);
        $gpPercentData = array_values($gpPercentData);

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
            'latestBooking'
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
                
                $inquiryCount = $inquiryQuery->count();
                $quotationCount = $quotationQuery->count();
                $quotationTotalAmount = $quotationQuery->sum('total_amount');
                $bookingCount = $bookingQuery->count();
                $bookingTotalAmount = $bookingQuery->sum('total_amount');
                $invoiceCount = $invoiceQuery->count();
                $invoiceTotal = $invoiceQuery->sum('total_amount');
                $challanCount = $challanQuery->count();
                $challanTotal = $challanQuery->sum('total_amount');
                
                $quotationNetAmount = Quotation::sum('net_amount');
                $bookingNetAmount = Booking::sum('net_amount');
                $invoiceNetAmount = Invoice::sum('net_amount');
                $challanNetAmount   = PerformaInvoiceChallan::sum('net_amount');

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
                $ttBusinessQuery = Invoice::selectRaw('MONTH(created_at) as month, SUM(total_amount) as total');
                $gpPercentQuery = Invoice::selectRaw('MONTH(created_at) as month, 
                    (SUM(net_amount) / NULLIF(SUM(total_amount), 0)) * 100 as gp_percent');
                    
                if (!empty($year)) {
                    $ttBusinessQuery->whereYear('created_at', $year);
                    $gpPercentQuery->whereYear('created_at', $year);
                }
                
                $ttBusinessData = $ttBusinessQuery->groupBy('month')
                    ->orderBy('month')
                    ->pluck('total', 'month')
                    ->toArray();
                    
                $gpPercentData = $gpPercentQuery->groupBy('month')
                    ->orderBy('month')
                    ->pluck('gp_percent', 'month')
                    ->toArray();
                    
                // Ensure 12 months filled
                $ttBusinessData = array_replace(array_fill(1, 12, 0), $ttBusinessData);
                $ttBusinessData = array_values($ttBusinessData);
                
                $gpPercentData = array_replace(array_fill(1, 12, 0), $gpPercentData);
                $gpPercentData = array_map(fn($v) => round($v, 1), $gpPercentData);
                $gpPercentData = array_values($gpPercentData);
                
                return response()->json([
                    'ttBusinessData' => $ttBusinessData,
                    'gpPercentData' => $gpPercentData
                ]);
                
            default:
                return response()->json(['error' => 'Invalid chart type'], 400);
        }
    }


//    public function search(Request $request)
// {
//     $term = $request->input('search');

//     // ===== Inquiries =====
//     $inquiries = Inquiry::with(['customer','leadstatus'])
//         ->whereHas('customer', fn($q) => $q->where('company_name', 'like', "%$term%"))
//         ->orWhere('unique_id', 'like', "%$term%")
//         ->get()
//         ->map(function ($item) {
//             return [
//                 'type'      => 'Inquiry',
//                 'client'    => $item->customer->company_name ?? '',
//                 'unique_id' => $item->unique_id,
//                 'phone'     => $item->customer->mobile ?? '',
//                 'email'     => $item->customer->email ?? '',
//                 'whatsapp'  => $item->customer->cwhatsapp ?? '',
//                 'status'    => $item->leadstatus->status ?? '',
//                 'id'        => $item->id,
//                 'edit_url'  => route('inquiry.edit', $item->id), // ✅ Laravel route
//             ];
//         });

//     // ===== Bookings =====
//     $bookings = Booking::with(['customerType'])
//         ->where('invoice_no', 'like', "%$term%")
//         ->orWhere('id', 'like', "%$term%")
//         ->get()
//         ->map(function ($item) {
//             return [
//                 'type'      => 'Booking',
//                 'client'    => $item->customerType->company_name ?? '',
//                 'unique_id' => $item->invoice_no,
//                 'phone'     => $item->customerType->mobile ?? '',
//                 'email'     => $item->customerType->email ?? '',
//                 'whatsapp'  => '',
//                 'status'    => 'N/A',
//                 'id'        => $item->id,
//                 'edit_url'  => route('booking.edit', $item->id), // ✅
//             ];
//         });

//     // ===== Quotations =====
//     $quotations = Quotation::with(['customer'])
//         ->where('invoice_no', 'like', "%$term%")
//         ->get()
//         ->map(function ($item) {
//             return [
//                 'type'      => 'Quotation',
//                 'client'    => $item->customer->company_name ?? '',
//                 'unique_id' => $item->invoice_no,
//                 'phone'     => $item->customer->mobile ?? '',
//                 'email'     => $item->customer->email ?? '',
//                 'whatsapp'  => '',
//                 'status'    => 'N/A',
//                 'id'        => $item->id,
//                 'edit_url'  => route('quotation.edit', $item->id), // ✅
//             ];
//         });

//     $results = $inquiries->merge($bookings)->merge($quotations);

//     return response()->json($results);
// }

public function search(Request $request)
{
    $term = $request->input('search');

    // ===== Inquiries =====
    $inquiries = Inquiry::query()
        ->where('unique_id', 'like', "%$term%")
        ->orWhere('customer_details->company_name', 'like', "%$term%")
        ->orWhere('customer_details->contact_person_c', 'like', "%$term%")
        ->orWhere('email', 'like', "%$term%")
        ->orWhere('phone', 'like', "%$term%")
        ->get()
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

    // ===== Bookings =====
    $bookings = Booking::query()
        ->where('invoice_no', 'like', "%$term%")
        ->orWhere('id', 'like', "%$term%")
        ->orWhere('customer_details->company_name', 'like', "%$term%")
        ->orWhere('customer_details->contact_person_c', 'like', "%$term%")
        ->get()
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

    // ===== Quotations =====
    $quotations = Quotation::query()
        ->where('invoice_no', 'like', "%$term%")
        ->orWhere('customer_details->company_name', 'like', "%$term%")
        ->orWhere('customer_details->contact_person_c', 'like', "%$term%")
        ->get()
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

    $results = $inquiries->merge($bookings)->merge($quotations);

    return response()->json($results);
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
