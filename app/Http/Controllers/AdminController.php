<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // at the top of every admin action check the logged-in user’s role_id. 
    // if it isn’t 1 (Admin), abort with a 403
    protected function ensureIsAdmin()
    {
        if (Auth::user()->role_id !== 1) {
            abort(403, 'Unauthorized');
        }
    }

    public function dashboard()
    {
        $this->ensureIsAdmin();
        return view('admin.dashboard');
    }

    public function users()
    {
        $this->ensureIsAdmin();
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function toggleUser(User $user)
    {
        $this->ensureIsAdmin();
        $user->active = ! $user->active;
        $user->save();
        return redirect()->route('admin.users.index');
    }

    public function userTodos(User $user)
    {
        $this->ensureIsAdmin();
        $todos = $user->todos; 
        return view('admin.users.todos', compact('user','todos'));
    }
}
