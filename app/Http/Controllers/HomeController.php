<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EditPage;
use App\Models\News;
use App\Models\Announcement;
use App\Models\Event;
use App\Models\Faculty;
use App\Models\Enquiry;
use App\Models\Course;
use App\Models\CV;
// use App\Models\homeQuery;
use App\Models\HomeQuery;
use App\Models\Meta;
use App\Models\Registration;
use DB;
use Redirect; 

class HomeController extends Controller
{
    public function action( $slug ) {
    	$result['editpage'] = EditPage::where('link_name',$slug)->first();
    	if(!empty($result) &&  $result['editpage'] !='' ){

    		return view ('page/page',$result);

    	}elseif($slug == 'Faculty'){

    		return view ('page/Faculity');

    	}elseif($slug == 'Affiliation-Accreditation'){

    		return view ('page/Affiliation');

    	}elseif($slug == 'Download'){

    		return view ('page/downloads');

    	}elseif($slug == 'Courses'){

			return view ('page/courses');

		}
		elseif($slug == 'Photos'){

			return view ('page/photos');

		}elseif($slug == 'Videos'){

			return view ('page/videos');

		}
		else{

    		return view ('page/home');

    	}

        

        return view ('page/page',$result);
    }
    public function registration(){
    	
    	return view ('page/registration');
    }
    public function registration_store(Request $request){

      $input =[
       "subject" => json_encode($request->subject),
      "name_hindi" => $request->name_hindi,
      "name_english" => $request->name_english,
      "mobile" => $request->mobile,
      "dob" => $request->dob,
      "father_husband" => $request->father_husband,
      "occupation" => $request->occupation,
      "address" => $request->address,
      "parmanent_address" => $request->parmanent_address,
      "current_address" => $request->current_address,
      "father_occupation" => $request->father_occupation,
      "marreied" => $request->marreied,
      "up_date" => $request->marreied,
      "mother_name" => $request->mother_name,
      "grade" => $request->grade,
      "reserved_category" => $request->reserved_category,
      "sm" => $request->sm,
      "nationality" => $request->nationality,
      "cast" => $request->cast,
      "subcast" => $request->subcast,
      "other_cast" => $request->other_cast,
      "staff_member" => $request->staff_member,
      "punishment" => $request->punishment,
      "last_school" => $request->last_school,
      "year" => $request->year,
      "is_under_graduate" => $request->is_under_graduate,
      "adminssion_before_any" => $request->adminssion_before_any];

    $input['high'] = json_encode(["high_year" => $request->high_year,
      "high_marks" => $request->high_marks,
      "high_grade" => $request->high_grade,
      "high_percent" => $request->high_percent,
      "high_board_name" => $request->high_board_name,
      "high_name_of_school" => $request->high_name_of_school,
      "high_institution" => $request->high_institution,
      "high_attempt" => $request->high_attempt]);

    $input['intermidate'] = json_encode(["intermidate_year" => $request->intermidate_year,
      "intermidate_marks" => $request->intermidate_marks,
      "intermidate_grade" => $request->intermidate_grade,
      "intermidate_percent" => $request->intermidate_percent,
      "intermidate_board_name" => $request->intermidate_board_name,
      "intermidate_name_of_school" => $request->intermidate_name_of_school,
      "intermidate_institution" => $request->intermidate_institution,
      "intermidate_attempt" => $request->intermidate_institution]);

    $input['ba'] = json_encode(["ba_year" => $request->ba_year,
      "ba_marks" => $request->ba_marks,
      "ba_grade" => $request->ba_grade,
      "ba_percent" => $request->ba_percent,
      "ba_board_name" => $request->ba_board_name,
      "ba_name_of_school" => $request->ba_name_of_school,
      "ba_institution" => $request->ba_institution,
      "ba_attempt" => $request->ba_attempt]);

     $input['ma'] = json_encode(["ma_year" => $request->ma_year,
      "ma_marks" => $request->ma_year,
      "ma_grade" => $request->ma_grade,
      "ma_percent" => $request->ma_percent,
      "ma_board_name" => $request->ma_percent,
      "ma_name_of_school" => $request->ma_name_of_school,
      "ma_institution" => $request->ma_institution,
      "ma_attempt" => $request->ma_attempt]);

     $input['other'] = json_encode(["other_year" => $request->other_year,
      "other_marks" => $request->other_marks,
      "other_grade" => $request->other_grade,
      "other_percent" => $request->other_grade,
      "other_board_name" => $request->other_board_name,
      "other_name_of_school" => $request->other_name_of_school,
      "other_institution" => $request->other_institution,
      "other_attempt" => $request->other_attempt]);
     $input['list'] = json_encode($request->list);
     $passport="";
     $staff_document="";
     $ncc_certificate="";
     $physical_disbale="";
     
     
      if($request->hasfile('passport')){

            $image = $request->file('passport');
            $ext = $image->extension();
            $image_name = time().'.'.$ext;
            $image->storeAs('/public/media',$image_name);
            $passport = $image_name;
       }
       if($request->hasfile('staff_document')){

            $image = $request->file('staff_document');
            $ext = $image->extension();
            $image_name = time().'.'.$ext;
            $image->storeAs('/public/media',$image_name);
            $staff_document = $image_name;
       }
       if($request->hasfile('ncc_certificate')){

            $image = $request->file('ncc_certificate');
            $ext = $image->extension();
            $image_name = time().'.'.$ext;
            $image->storeAs('/public/media',$image_name);
            $ncc_certificate = $image_name;
       }
       if($request->hasfile('physical_disbale')){

            $image = $request->file('physical_disbale');
            $ext = $image->extension();
            $image_name = time().'.'.$ext;
            $image->storeAs('/public/media',$image_name);
            $physical_disbale = $image_name;
       }
      
    // dd($request);
    
       $input['passport']= $passport;
       $input['physical_disbale']= $physical_disbale;
       $input['ncc_certificate']= $ncc_certificate;
       $input['staff_document']= $staff_document;
     Registration::create($input);

    return redirect()->back()->with('msg','Thank you for your registration. We will get back to you soon...');



    				/*	$this->validate($request, [
								'name_hindi' => 'required|string|max:100',
								'name_english' => 'required|string|max:100',
								'mobile' => 'required|numeric|digits_between:10,10',
								'dob' => 'required|date|date_format:Y-m-d',
								'father_husband' => 'required|string|max:100',
								'occupation' => 'required|string|max:100',
								'father_husband' => 'required|string|max:100',
								'occupation' => 'required|string|max:100',
								'address' => 'required|string|max:100',
								'parmanent_address' => 'required|string|max:100',
								'father_occupation' => 'required|string|max:100',
								'marreied' => 'required|string|max:100',
								'up_date' => 'required|string|max:100',
								'mother_name' => 'required|string|max:100',
								'current_address' => 'required|string|max:100',	
								'grade' => 'required|string|max:100',	
								'reserved_category' => 'required|string|max:100',	
								'general' => 'required|string|max:10',	
								'passport_photo' => 'required|string|max:10',	
								'nationality' => 'required|string|max:100',	
								'religion' => 'required|string|max:100',
								'subcast' => 'required|string|max:100',	
								'other_cast' => 'required|string|max:100',	
								'staff_document' => 'required|mimes:jpeg,jpg,png,gif,docx,pdf,xlsx|max:10000',
								'ncc_certificate' => 'required|mimes:jpeg,jpg,png,gif,docx,pdf,xlsx|max:10000',
								'punisment' => 'required|string|max:10',
								// 'father_husband' => 'required|string|max:100',

						]);
						*/
    	return view ('page/registration');
    }
    public function index( ) {
        return redirect()->route('admin.home');
    }

    public function our_gallery(){
    	return view ('page/photos');
    }
    public function our_video(){

    }

    public function view_course( $slug, $id ) {

    	$result['course'] =  Course::where('id',$id)->first();
        return view ('page/view-course', $result);
    }


    public function qif( Request $request ) {
    	$match = isset($_GET['pass']) ? $_GET['pass'] : 'no';
    	$message= '';
    	$unique_id = time();
    	if(session()->get('qif_pass') == $match){
    		// echo 'match';

    	}else{
    		session()->forget(['qif_pass']);
    	}
    	//dd();
    	
    	if( $request->all() ) {
    		$pass = Meta::where('meta_name', 'qif_password')->value('meta_value');
    		if( $request->password == $pass ) {
    			//$unique_id = time();
    			$request->session()->put('qif_pass', $unique_id);
    			return redirect('page/QIF?pass='.$unique_id);
    		}
    		else {
    			$message = 'Invalid password!';
    		}
    	}
    	// session()->forget(['qif_pass']);
    	//dd('xd');
    	return view ('page/QIF', ['message' => $message]);
    }

	public function view_news($slug, $id) {

        $result['news'] =  News::where('id',$id)->first();


		return view('page/newsDetail',$result);


	}
	public function announcementdetail($id){

        $result['announcement'] =  Announcement::where('id',$id)->first();


		return view('page/announcementDetail',$result);


	}

	public function eventdetail($id){

        $result['event'] =  Event::where('id',$id)->first();


		return view('page/eventDetail',$result);


	}

	public function facultydetail($id){

        $result['row'] =  Faculty::where('id',$id)->first();


		return view('page/facultyDetail',$result);


	}

	public function newss(){

        $result['newses'] =  News::all();


		return view('page/news',$result);


	}
	public function announcement(){

        $result['announcementes'] =  Announcement::all();


		return view('page/announcement',$result);


	}

	public function event(){


		return view('page/event');


	}

	public function sendYourEnquiry(){


		return view('page/sendYourEnquiry');

	}


	public function sendYourEnquirystore(Request $request) {

		$this->validate($request, [
								'name' => 'required|string|max:100',
								'email' => 'required|email|max:100',
								'tel_phone' => 'nullable|numeric|digits_between:6,15',
								'mobile' => 'required|numeric|digits_between:10,10',
								'gender' => 'required|in:Male,Female',
								'dob' => 'required|date|max:100',
								'address' => 'required|string|max:200',
								'country' => 'required|string|max:100',
								'state' => 'required|string|max:100',
								'message' => 'nullable|max:10000',
						]);

		$array = [
			'name' => strip_tags($request->name),
			'email' => $request->email,
			'dob' => $request->dob,
			'gender' => $request->gender,
			'address' => strip_tags($request->address),
			'country' => strip_tags($request->country),
			'state' => strip_tags($request->state),
			'phone' => $request->tel_phone,
			'mobile' => $request->mobile,
			'message' => strip_tags($request->message),
		];

		DB::table('enquiry')->insert($array);

        return Redirect::back()->with('message', 'Thank you for your query, we will get back to you soon!' );

    }


	public function sendYourcv(){


		return view('page/sendYourcv');

	}


	public function sendYourcvstore(Request $request){

    //    dd($request);


		$this->validate($request, [
								'department'  => 'required|string|max:100',
								'designation'  => 'required|string|max:100',
								'marital'  => 'required|string|max:100',
								'marital'  => 'required|string|max:100',
								'name' => 'required|string|max:100',
								'email' => 'required|email|max:100',
								'tel_phone' => 'nullable|numeric|digits_between:6,15',
								'mobile' => 'required|numeric|digits_between:10,10',
								'gender' => 'required|in:Male,Female',
								'dob' => 'required|date|max:100',
								'address' => 'required|string|max:200',
								'country' => 'required|string|max:100',
								'state' => 'required|string|max:100',
								'message' => 'nullable|max:10000',
								'file' => 'required|mimes:jpeg,jpg,png,gif,docx,pdf,xlsx|max:10000',
						]);
		if($request->hasfile('file')) {

            $file = $request->file('file');
            $ext = $file->extension();
            $file_name = time().'.'.$ext;
            $file->storeAs('/public/media',$file_name);
            $request->file = $file_name;

        }


		
		$array = [
			'department' => $request->department,
			'designation' => $request->designation,
			'name' => $request->name,
			'dob' => $request->dob,
			'gender' => $request->gender,
			'marital' => $request->marital,
			'fh_name' => $request->fh_name,
			'address' => $request->address,
			'state' => $request->state,
			'tel_no' => $request->tel_no,
			'mobile' => $request->mobile,
			'email' => $request->email,
			'country' => $request->country,
			'experience' => $request->experience,
			'qualifications' => $request->qualifications,
			'skills' => $request->skills,
			'noo' => $request->noo,
			'salary' => $request->salary,
			'current_industry' => $request->current_industry,
			'functional_area' => $request->functional_area,
			'preferred_location' => $request->preferred_location,
			'cv' => $request->file,
		];

		DB::table('cv')->insert($array);    

		return Redirect::back()->with('message', 'Thank you for applying, we will get back to you soon!' );
    }


	public function homeQuery(Request $request){

        // dd($request);

		$request->validate([
            'name'=>'required',
            'email'=>'required|email',
            'mobile'=>'required|min:11|numeric',
            'city'=>'required'
        ]);


        $modle =  DB::table('home_query');
		$array = [
			'name' => $request->name,
			'email' => $request->email,
			'mobile' => $request->mobile,
			'city' => $request->city,
		];

		$modle = DB::table('home_query')->insert($array);

        return Redirect::back()->with('message', 'Thank you for your query, we will get back to you soon!' );
    

    }

	public function enquirydelete($id){


        $enquiry = Enquiry::find($id);
        $enquiry->delete();

        $result['enquiry'] =  Enquiry::all();

        return Redirect::back()->with('message', 'Enquiry successfully deleted!');

    }

	public function cvdelete($id){

        $cv = CV::find($id);
        $cv->delete();

        $result['cv'] =  CV::all();

        return Redirect::back()->with('message', 'CV successfully deleted!');

    }

	public function homeQuerydelete($id){


        $homeQuery = HomeQuery::find($id);
        $homeQuery->delete();

        $result['homeQuery'] =  HomeQuery::all();

        return Redirect::back()->with('message', 'Enquiry successfully deleted!');

    }

 	


	


}

