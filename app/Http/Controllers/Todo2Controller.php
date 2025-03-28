<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo2;
use Illuminate\Support\Facades\Auth;
class Todo2Controller extends Controller

{
    public function index()
    {
        $todos = Todo2::all();
        // $todos = Todo2::where('user_id', Auth::id())->get();
        dd($todos);
        return view('todo.index',);
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
