<?php

namespace App\Http\Controllers;

use App\Models\KelompokSoal;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile(){
        $user = auth()->user();
        return view('pages.profile',compact('user'));
    }

    public function updateProfile(Request $request){
        $data = $request->validate([
            'email' => 'email|required|unique:users,email,' . auth()->user()->id,
            'password' => 'confirmed'
        ]);
        if ($request->password){
            $data['password'] = bcrypt($request->password);
        } else {
            unset($data['password']);
        }
        $user = auth()->user();
        $user->update($data);
        return redirect()->back()->with('success','Berhasil Update Profile');
    }

    public function index()
    {
        $user = User::where('id','!=',auth()->user()->id)->get();
        return view('pages.user.index', compact('user'));
    }

    public function add()
    {
        $user = new User();
        return view('pages.user.add', compact('user'));
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('pages.user.add', compact('user'));
    }

    public function addPost(Request $request)
    {
        $request->validate([
            'email' => 'email|required|unique:users,email',
            'password' => 'required|confirmed'
        ]);
        $password = bcrypt($request->password);
        User::create(array_merge($request->except('password'),['password' => $password]));
        return redirect()->route('dashboard.user');
    }

    public function editPost(Request $request, $id)
    {
        $data = $request->validate([
            'email' => 'email|required|unique:users,email,' . $id,
            'password' => 'confirmed'
        ]);
        if ($request->password){
            $data['password'] = bcrypt($request->password);
        } else {
            unset($data['password']);
        }
        $user = User::find($id);
        $user->update($data);
        return redirect()->route('dashboard.user');
    }

    public function deleteUser($id)
    {
        $user = User::find($id);
        $user->delete();
    }

}
