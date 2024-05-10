<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // ambil data user
        $users = DB::table('users')
        // searching dan paginate
        ->when($request->input('name'), function($query, $name){
            return $query->where('name', 'like', '%'.$name.'%');
        })
        // format tampilan pada halaman index
        ->select('id', 'name','email', 'phone', DB::raw('DATE_FORMAT(created_at, "%d %M %Y")as created_at'))
        // paginate
        ->orderBy('id','desc')
        ->paginate(10);
        // lempar ke halaman index
        return view('pages.users.index', compact('users'));
    }

    public function create() {
        return view('pages.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store( StoreUserRequest $request)
    {
        //add new user
        User::create([
            'name' =>$request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'roles' => $request['roles'],
            'phone' => $request['phone'],
            'address' => $request['address'],
        ]);
        return redirect(route('user.index'))->with('success', 'New User Successfully');
    }

    public function  edit(User $user)
    {
        // edit page
        return view('pages.users.edit')->with('user', $user);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        //update
        $validate = $request->validated();
        $user->update($validate);
        return redirect()->route('user.index')->with('success','Edit User Successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //delete
        $user->delete();
        return redirect()->route('user.index')->with('success', 'Delete User Successfully');
    }
}
