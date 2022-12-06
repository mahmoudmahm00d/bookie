<?php

namespace App\Http\Controllers;

use App\Models\Borrow;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('is_admin')->except('wallet');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('users.index', ['users' => $users]);
    }

    public function borrows($id)
    {
        $borrows = Borrow::where('user_id', '=', $id)->get();
        return view('borrows.index', ['borrows' => $borrows]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        if (!$user) {
            throw new NotFoundHttpException();
        }

        return view('users.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            throw new NotFoundHttpException();
        }

        $fields = $request->validate([
            'wallet' => ['required', 'regex:((^(\d+)(\.?)(\d+)$)|^(\d)$)']
        ]);

        $user->update($fields);
        return redirect('/users')->with('message', 'Wallet Updated Successfully!');
    }

    public function wallet()
    {
        $user = Auth::user();
        $wallet = User::find($user->id)->wallet;
        return view('users.wallet', ['wallet' => $wallet]);
    }
}
