<?php

namespace App\Http\Controllers;

use App\Models\Snack;
//use Illuminate\Http\Request;

class SnackController extends Controller
{
    public function index(){
        $snacks=Snack::where('is_available', true)->latest()->get();
        return view('snacks.index', compact('snacks'));
    }
}
