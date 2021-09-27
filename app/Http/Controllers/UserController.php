<?php

namespace App\Http\Controllers;

use App\User;
use App\Rol;
use App\TypeIdentification;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        //dd($users);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Rol::all();
        $typeIdentification = TypeIdentification::all();
        return view('users.create', compact('roles', 'typeIdentification'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $data = $request->all();
        $flagError = false;
        $arrError =  [];
        if ($data['password'] != $data['password_confirmation']) {
            $flagError = true;
            $arrError[] = 'Las contraseñas no coinciden';
        }

        if ($flagError == true) {
            return back()->withInput($request->input())
                ->withErrors($arrError);
        }
        $data['password'] = Hash::make($data['password']);
        $data['name'] = ucwords($data['name']);
        $data['last_name'] = ucwords($data['last_name']);
        User::create($data);
        return redirect()->route('users.index')->with('success', 'Registro creado satisfactoriamente');
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
        $roles = Rol::all();
        $typeIdentification = TypeIdentification::all();
        $user = User::find($id);
        return view('users.edit', compact('roles', 'typeIdentification', 'user'));
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
        $this->validate($request, ['name' => 'required']);

        User::find($id)->update($request->all());
        return redirect()->route('users.index')->with('success', 'Registro actualizado satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //User::find($id)->delete();
        $user = User::find($id);
        $status = $user->active;
        $msg = '';
        if($status == 1){
            $msg = 'Se desactivo el usuario satisfactoriamente';
            $status = 0;
        }else{
            $msg = 'Se activo el usuario satisfactoriamente';
            $status = 1;
        }
        $user->active = $status;
        $user->save();
        return redirect()->route('users.index')->with('success', $msg);
    }
}
