<?php
 
 
function _app( $app = 'app' ) {
	return 'admin/app/' . $app;
}
 
function _template( $file = 'index' ) {
	return 'admin/' . $file;
}
function _image( $file = 'index' ) {
	return url('public/storage/' . $file);
}
 

function isAdmin(){
	if(Auth::check() && Auth::User()->role== 'admin'){
		return true;
	} else{
		return false;
	}
}

function getFinancialYear($inputDate,$format="Y"){
    $date=date_create($inputDate);
    if (date_format($date,"m") >= 4) {//On or After April (FY is current year - next year)
        $financial_year = (date_format($date,$format)) . '-' . (date_format($date,$format)+1);
    } else {//On or Before March (FY is previous year - current year)
        $financial_year = (date_format($date,$format)-1) . '-' . date_format($date,$format);
    }
    return $financial_year;
}

function getFinancialFullYear($inputDate,$format="Y"){
    
    $year = date('Y', strtotime($inputDate));
    $dateMonth = date('d-m', strtotime($inputDate));
    if( date('Y-m-d') <= date('Y-m-d', strtotime("$year-03-31")) ) {
        $currentYear = $year - 1;
        return ['start_year'=>(int)$currentYear,'end_year'=>(int)$year];
    }
    else {
        return ['start_year'=>(int)$year,'end_year'=> 1 + $year];
    }
    
    
    $date=date_create($inputDate);
    if (date_format($date,"m") >= 4) {//On or After April (FY is current year - next year)
        $start_year = (date_format($date,$format));
        $end_year   = (date_format($date,$format)+1); 
    } else {//On or Before March (FY is previous year - current year)
        $start_year = (date_format($date,$format));
        $end_year   = (date_format($date,$format)+1); 
    }
    return ['start_year'=>(int)$start_year,'end_year'=>(int)$end_year];
}  

function store_lead_status($inquiry_id,$lead_status){
				$lead = App\Models\Lead::where('id',$lead_status)->first();
                App\Models\LeadStatusLog::create(['user_id'=>Auth::id(),'inquires_id'=>$inquiry_id,'status'=>$lead->lead]);
                if($lead_status == 4 ){
					abort(redirect(route('booking.create')));	
				}
}
 

function isPermission($user_id){
	$user_id = Auth::id();
	//$user_id = 7;
	$current_route_name = request()->route()->getName();
	//echo $current_route_name;
	//dd('xd');
	$permission = App\Models\Permission::where('user_id',$user_id)->first();
	$valid_route = [];
	if($permission){
			$valid = json_decode($permission->permissions,true);
			if(empty($valid )){
				return false;
			}else{
				foreach($valid as $v){
					$valid_route[] = $v['route'];
				}
				if(in_array($current_route_name, $valid_route)){
					return true;
				}else{
					abort( response('Unauthorized', 401) );
				}
			}
			//dd();
	}else{
		return true;
	}

	//dd($permission);
	//echo ;
	dd(Auth::id());
}	  
 
function getIndianCurrency(float $number)
        {
            $decimal = round($number - ($no = floor($number)), 2) * 100;
            $hundred = null;
            $digits_length = strlen($no);
            $i = 0;
            $str = array();
            $words = array(0 => '', 1 => 'one', 2 => 'two',
                3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
                7 => 'seven', 8 => 'eight', 9 => 'nine',
                10 => 'ten', 11 => 'eleven', 12 => 'twelve',
                13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
                16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
                19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
                40 => 'forty', 50 => 'fifty', 60 => 'sixty',
                70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
            $digits = array('', 'hundred','thousand','lakh', 'crore');
            while( $i < $digits_length ) {
                $divider = ($i == 2) ? 10 : 100;
                $number = floor($no % $divider);
                $no = floor($no / $divider);
                $i += $divider == 10 ? 1 : 2;
                if ($number) {
                    $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                    $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                    $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
                } else $str[] = null;
            }
            $Rupees = implode('', array_reverse($str));
            $paise = ($decimal > 0) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
            return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
        }

?>