<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Funzione che ritorna la vista del template welcome
    public function index() {
        return view('welcome');
    }
}