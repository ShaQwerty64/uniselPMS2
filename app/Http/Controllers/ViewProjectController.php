<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ViewProjectController extends Controller
{
    public function index ()
    {
        return view('projects.view');
    }

    public function something()
    {
        $admin->removeRole('topMan');
        $request->banner('"' . $admin->name . '" not a viewer now.');
        return redirect()->route('addadmin');
    }
}




