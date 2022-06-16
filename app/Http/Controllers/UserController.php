<?php
/**
 * @project     MSDS Fontera
 * @category    Authentication
 * @author      Fajar Agus Maulana
 * @copyright   Copyright (c) 2022, https://github.com/fajaramaulana/
 * @link 		https://github.com/fajaramaulana/
*/

namespace App\Http\Controllers;

use App\Models\Departement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::paginate(10);
        return view('admin.user.index', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->id !== 1){
            return redirect()->route('user.index');
        }
        $departement = Departement::all();
        return view('admin.user.create', compact('departement'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3|max:50',
            'email' => 'required|email|unique:users,email',
            'departement_id' => 'required',
            'password' => 'required|min:8'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'departement_id' => $request->departement_id,
            'password' => bcrypt($request->password)
        ]);

        return redirect()->route('user.index')->with('success', 'User Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->id !== 1){
            return redirect()->route('user.index');
        }
        $departements = Departement::all();
        $user = User::find($id);
        return view('admin.user.edit', compact('user', 'departements'));
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
        if ($_POST['password'] == '') {
            $this->validate($request, [
                'name' => 'required|min:3|max:50',
                'departement_id' => 'required'
            ]);
            $user_data = [
                'name' => $request->name,
                'tipe' => $request->tipe,
                'departement_id' => $request->departement_id
            ];
        } else {
            $this->validate($request, [
                'name' => 'required|min:3|max:50',
                'password' => 'required|min:8',
                'departement_id' => 'required'
            ]);
            $user_data = [
                'name' => $request->name,
                'tipe' => $request->tipe,
                'password' => bcrypt($request->password),
                'departement_id' => $request->departement_id
            ];
        }




        $user = User::find($id);
        $user->update($user_data);

        return redirect()->route('user.index')->with('success', "Berhasil Di Update");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find(@$id);
        $user->delete();

        return redirect()->back()->with('success', 'User Berhasil Dihapus');
    }
}
