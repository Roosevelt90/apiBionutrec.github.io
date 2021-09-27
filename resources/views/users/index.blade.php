@extends('layouts.app', ['activePage' => 'users', 'titlePage' => __('Usuarios')])

@section('content')
<div class="content">

    <div class="container-fluid">
        <div class="row">

            <div class="col-lg-12 col-md-12 col-sm-12">
                @if (Session::has('success'))
                <div class="alert alert-info">
                    {{ Session::get('success') }}
                </div>
                @endif
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="pull-left">
                            <h3>Listado de usuario</h3>
                        </div>
                        <div class="pull-right">
                            <div class="btn-group">
                                <a href="{{ route('users.create') }}" class="btn btn-info">Añadir usuario</a>
                            </div>
                        </div>
                        <div class="table-container">
                            <table id="tbl_data_table" class="table table-bordred table-striped">
                                <thead>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Correo</th>
                                    <th>Rol</th>
                                    <th>Opciones</th>
                                </thead>
                                <tbody>
                                    @foreach ($users as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->lastName }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->nameRol() }}</td>
                                        <td>
                                            <a class="btn  btn-xs" data-toggle="tooltip" data-placement="top" title="Editar el usuario" href="{{ action('UserController@edit', $item->id) }}">
                                                <i class="fa fa-pencil" aria-hidden="true"></i>
                                            </a>
                                            @if ($item->active == 1)
                                            <form action="{{ action('UserController@destroy', $item->id) }}" method="post">
                                                {{ csrf_field() }}
                                                <input name="_method" type="hidden" value="DELETE">
                                                <button data-toggle="tooltip" data-placement="top" title="Desactivar el usuario" class="btn  btn-xs" type="submit">
                                                    <i class="fa fa-minus-circle"></i>
                                                </button>
                                            </form>
                                            @else
                                            <form action="{{ action('UserController@destroy', $item->id) }}" method="post">
                                                {{ csrf_field() }}
                                                <input name="_method" type="hidden" value="DELETE">
                                                <button data-toggle="tooltip" data-placement="top" title="Activar el usuario" class="btn  btn-xs" type="submit">
                                                    <i class="fa fa-check-circle"></i>
                                                    <!-- <i class="fa fa-trash-o" aria-hidden="true"></i> -->
                                                </button>
                                            </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>

            </div>



        </div>
    </div>
</div>



@endsection