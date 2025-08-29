<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdHomeController extends Controller
{
    

    public function announcements(){

        return view('admin/home/announcements');
    }

    public function linkedit(){

        
        return view('admin/home/linkedit');
    }

    
}
