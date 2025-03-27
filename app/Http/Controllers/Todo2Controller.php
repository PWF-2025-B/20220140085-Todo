<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo2;
class Todo2Controller extends Controller
{
    public function index()
    {
        $todos = Todo2::where('user_id', auth()->id())->get();
        dd($todos);
        return view('todo.index', compact('todos'));
    }
    

    public function create()
    {
        return view('todo.create');
    }


    public function edit()
    {
        return view('todo.edit');
    }

   
}
