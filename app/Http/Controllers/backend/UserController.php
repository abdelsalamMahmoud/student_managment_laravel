<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::whereNot('role','admin')->paginate(10);
        return view('dashboard.users.index',compact('users'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('dashboard.users.edit',compact('user'));
    }

    public function update(UpdateUserRequest $request,$id)
    {
        try{
            $user = User::findOrFail($id);
            $user->update([
                'name'=>$request->input('name'),
                'last_name'=>$request->input('last_name'),
            ]);
            return redirect()->route('users.index');
        }catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function delete($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return redirect()->route('users.index');
        }catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
