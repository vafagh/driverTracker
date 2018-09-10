<?php

namespace App\Http\Controllers;

use App\User;
use App\Ride;
use App\Transaction;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    public function index()
    {
        $users = User::with('transactions')
            ->orderBy('id', 'desc')
            ->get();
        $transactions = Transaction::with('user')
                ->orderBy('id', 'desc')
                ->paginate(20);
        return view('auth.users',compact('users','transactions'));
    }

    public function store(Request $request)
    {
        $user = new User;

        if($request->file('avatar')!=NULL){
            $image = time().'.'. $request->file('avatar')->getClientOriginalExtension();
            $request->file('avatar')->move(public_path('img/user'), $image);
            $user->image = $image;
        }
        $user->name = $request->fname;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role_id = $request->role_id;
        $user->save();
        Transaction::log(Route::getCurrentRoute()->getName(),'',$user);

        return redirect('/users/')->with('status', $user->name." added!");
    }

    public function show($user_id)
    {
        $user = User::find($user_id);
        $transactions = $user->transactions()
                ->orderBy('id', 'desc')
                ->paginate(30);

        return view('auth.show',compact('user','transactions'));
    }

    public function update(Request $request)
    {
        $user = User::find($request->id);
        if($request->file('avatar')!=NULL){
            $image = time().'.'. $request->file('avatar')->getClientOriginalExtension();
            $request->file('avatar')->move(public_path('img/user'), $image);
            $user->image = $image;
        }
        if($request->password!=NULL){
            $user->password = Hash::make($request->password);
        }
        $user->role_id = $request->role;
        $user->name = $request->fname;
        $user->email = $request->email;
        $user->save();
        Transaction::log(Route::getCurrentRoute()->getName(),User::find($request->id),$user);

        return redirect('/users/')->with('status', $user->fname." Updated!");
    }

    public function destroy(User $user)
    {
        // User::destroy($user->id);
        // Transaction::log(Route::getCurrentRoute()->getName(),$user,false);

        return redirect('users')->with('danger', " The action is not save and case losing data");
    }
}
