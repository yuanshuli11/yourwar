<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MailController extends Controller
{
     public function index(Request $request)
    {
         

      
        return view('/mail/index');

    }
}
