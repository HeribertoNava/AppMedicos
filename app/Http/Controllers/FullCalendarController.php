<?php

namespace App\Http\Controllers;

use App\Models\Citas;
use Illuminate\Http\Request;

class FullCalendarController extends Controller
{
    public function index()
    {
        $citas = Citas::with(['paciente', 'doctor'])->get();
        return view('citas.master', ['citas' => $citas]);
    }
}
