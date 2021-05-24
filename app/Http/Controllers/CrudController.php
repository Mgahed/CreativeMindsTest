<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CrudController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('index', compact('users'));
    }

    public function create_form()
    {
        return view('create');
    }

    public function create(Request $request)
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        $user = User::Create([
            'email' => $request->email,
            'mobile_number' => $request->mobile_number,
            'username' => $request->username,
            'password' => Hash::make(json_encode($pass)),
        ]);
        if ($user) {
            return redirect()->route('crud.index')->with('success', 'New User Created');
        } else {
            return redirect()->back()->with('fail', 'Cant Create a user');
        }
    }

    public function update_form($id)
    {
        $user = User::find($id);
        return view('update', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if ($user) {
            $user->update([
                'email' => $request->email,
                'mobile_number' => $request->mobile_number,
                'username' => $request->username,
            ]);
            return redirect()->route('crud.index')->with('success', 'Edited Success');
        } else {
            return redirect()->back()->with('fail', 'Cant Update');
        }
    }

    public function delete($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return redirect()->route('crud.index')->with('success', 'Deleted Successfully');
        } else {
            return redirect()->back()->with('fail', 'Cant Delete');
        }
    }
}
