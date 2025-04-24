<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo2;
use Illuminate\Support\Facades\Auth;
class Todo2Controller extends Controller

{
    public function index()
    {
        //todos #todos = Todo2::all();
        $todos = Todo2::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        // dd
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

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
        
        ]);

        $todo = Todo2::create([
            'title' => $request->input('title'),
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('todo.index')->with('success', 'Todo created successfully.');
    }

   
}
