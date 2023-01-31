<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Exports\JuradosExport;
use Maatwebsite\Excel\Facades\Excel;

class DownloadCsvController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function download()
    {
        
        return Excel::download(new JuradosExport,'prueba.xlsx');
    }

}
