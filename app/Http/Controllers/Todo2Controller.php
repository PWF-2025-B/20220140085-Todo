<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo2;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;

class Todo2Controller extends Controller
{
    public function index()
    {
        $todos = Todo2::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();

        

        $todosCompleted = Todo2::where('user_id', auth()->user()->id)
            ->where('is_done', true)
            ->count();

        return view('todo.index', compact('todos'));
    }

    public function create()
    {
        $categories = \App\Models\Category::all();
        return view('todo.create', compact('categories'));
    }


    public function edit(Todo2 $todo)
{
    if (auth()->user()->id == $todo->user_id) {
        $categories = Category::all(); // Ambil semua kategori
        return view('todo.edit', compact('todo', 'categories')); // Kirim data kategori ke view
    } else {
        return redirect()->route('todo.index')->with('danger', 'You are not authorized to edit this todo!');
    }
}

    public function update(Request $request, Todo2 $todo)
    {
        $request->validate([
            'title' => 'required|max:255',
            'category_id' => 'required',
        ]);

        $todo->update([
            'title' => ucfirst($request->title),
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('todo.index')->with('success', 'Todo updated successfully!');
    }

    public function complete(Todo2 $todo)
    {
        if (auth()->user()->id == $todo->user_id) {
            $todo->update([
                'is_done' => true,
            ]);

            return redirect()->route('todo.index')->with('success', 'Todo completed successfully!');
        } else {
            return redirect()->route('todo.index')->with('danger', 'You are not authorized to complete this todo!');
        }
    }

    public function uncomplete(Todo2 $todo)
    {
        if (auth()->user()->id == $todo->user_id) {
            $todo->update([
                'is_done' => false,
            ]);

            return redirect()->route('todo.index')->with('success', 'Todo uncompleted successfully!');
        } else {
            return redirect()->route('todo.index')->with('danger', 'You are not authorized to uncomplete this todo!');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'category_id' => 'required',
        ]);

        Todo2::create([
            'title' => $request->input('title'),
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
        ]);

        return redirect()->route('todo.index')->with('success', 'Todo created successfully.');
    }

    public function destroy(Todo2 $todo)
    {
        if (auth()->user()->id == $todo->user_id) {
            $todo->delete();
            return redirect()->route('todo.index')->with('success', 'Todo deleted successfully!');
        } else {
            return redirect()->route('todo.index')->with('danger', 'You are not authorized to delete this todo!');
        }
    }

    public function destroyCompleted()
    {
        $todosCompleted = Todo2::where('user_id', auth()->user()->id)
            ->where('is_done', true)
            ->get();

        foreach ($todosCompleted as $todo) {
            $todo->delete();
        }

        return redirect()->route('todo.index')->with('success', 'All completed todos deleted successfully!');
    }
}
