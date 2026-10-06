<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Snack;

class SnackController extends Controller
{
    public function index()
    {
        $snacks = Snack::latest()->get();

        return view('snacks.index', compact('snacks'));
    }
}
