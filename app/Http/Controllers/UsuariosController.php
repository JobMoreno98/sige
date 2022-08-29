<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\user;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios = User::orderBy('name')->get();
        return view('usuarios.index')->with('usuarios',$usuarios);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('usuarios.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $retorno = array('Error'    => array(),
                         'Success'  => array());

        # Validar que las contraseñas sean las mimsas
        if( $request['password'] != $request['password_confirmation'])
            $retorno['Error'][] = "La contraseña y la confirmacion de contraseña no son iguales.";

        # Validar que el usuario no exita
        $existe = User::where('email',$request['email'])->get();
        if(count($existe) > 0)
            $retorno['Error'][] = "El email ya está previamente registrado.";

        if( !count($retorno['Error']) > 0){
            $nuevo = User::create([
                                    'name' => $request['name'],
                                    'email' => $request['email'],
                                    'password' => Hash::make($request['password']),
                                ]);

            $retorno['Success'][] = "Usuario {$request['email']} registrado";
        }

        $usuarios = User::orderBy('name')->get();

        return view('usuarios.index')->with('usuarios', $usuarios)
                                    ->with('retorno', $retorno);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //$usuario = User::where('id', $id)->get();
        $roles = [];
        $usuario = User::leftjoin('model_has_roles','model_has_roles.model_id','users.id')
            ->where('users.id',$id)
            //->where('model_has_roles.model_type','App\Models\User')
            ->first();
        $roles[] = array('id' => 0, 'name' => 'Seleccione un Rol', 'selected' => '');
        foreach (Role::orderBy('name')->get() as $rol) {
            $elemento = array(
                'id' => $rol->id,
                'name' => $rol->name,
                'selected' => '',
            );
            if (isset($usuario->role_id)) {
                if ($usuario->role_id == $rol->id) {
                    $elemento['selected'] = 'selected';
                }
            }

            $roles[] = $elemento;
        }
        return view('usuarios.edit')
            ->with('usuario', $usuario)
            ->with('roles', $roles);
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
        $data = [];
        $usuarios = User::all();
        $retorno = array('Error'    => array(),
                         'Success'  => array());

        # Validar que las contraseñas sean las mimsas
        if ($request['password'] &&  $request['password_confirmation']) {
            if ($request['password'] != $request['password_confirmation']) {
                $retorno['Error'][] = "La contraseña y la confirmacion de contraseña no son iguales.";
            } else {
                $data['password'] = Hash::make($request['password']);
            }
        }
        if ($request['name'] == '') {
            $retorno['Error'][] = 'El nombre del usuario es necesario.';
        }
        if ($request['email'] == '') {
            $retorno['Error'][] = 'El email del usuario es necesario.';
        }
        if ($request['rol'] == 'Seleccione un Rol') {
            $retorno['Error'][] = 'El rol del usuario es necesario.';
        }

        if (count($retorno['Error']) == 0) {
            $user = User::findOrFail($id);
            $user->email = $request['email'];
            $user->name = $request['name'];
            $user->role = $request['rol'];
            if ($request['password']) {
                $user->password = bcrypt($request['password']);
            }
            $user->save();
            $user->syncRoles(); # Se borran todos los anteriores
            $user->syncRoles([$request['rol']]); # se asignan todos lo que esten en el array
            $retorno['Success'][] = 'Usuario editado con éxito.';
        }

        return view('usuarios.index')
            ->with('usuarios', $usuarios)
            ->with('retorno', $retorno);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
