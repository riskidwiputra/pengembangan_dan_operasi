<?php

namespace App\Http\Controllers;

use App\Models\Tasks;
use Illuminate\Console\View\Components\Task;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    public function create()
    {
        return view('tasks.create');
    }
 
    public function store(Request $request)
    {
        Tasks::create($request->validated());
 
        return redirect()->route('tasks');
    }
}


