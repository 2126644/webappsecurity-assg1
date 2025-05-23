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
        $users = User::all();
        return view('admin.dashboard', compact('users'));
    }

    public function toggleUser(User $user)
    {
        $this->ensureIsAdmin();
        $user->status = ! $user->status;
        $user->save();
        return back();
    }

    public function userTodos(User $user)
    {
        $this->ensureIsAdmin();
        $todos = $user->todos;
        return view('admin.todos', compact('user', 'todos'));
    }

    public function destroyUser(User $user)
    {
        $this->ensureIsAdmin();
        $user->delete();
        return back()->with('status', 'User deleted.');
    }
}
