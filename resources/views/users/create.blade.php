@extends('layouts.app', ['activePage' => 'users', 'titlePage' => __('Usuarios')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">


                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Error!</strong> Revise los campos obligatorios.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (Session::has('success'))
                        <div class="alert alert-info">
                            {{ Session::get('success') }}
                        </div>
                    @endif
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Nuevo usuario</h3>
                        </div>
                        <div class="panel-body">
                            <div class="table-container">
                                <form method="POST" action="{{ route('users.store') }}" role="form">
                                    {{ csrf_field() }}
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <input type="text" name="name" id="name" class="form-control input-sm"
                                                    placeholder="Nombre del usuario" value="{{ old('name') }}">
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <input type="text"  value="{{ old('last_name') }}" name="last_name" id="last_name"
                                                    class="form-control input-sm" placeholder="Apellido del usuario">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <select  value="{{ old('id_type_identification') }}" name="id_type_identification" id="id_type_identification" class="form-control">
                                                    <option value="">Seleccione una opción</option>
                                                    @foreach ($typeIdentification as $item)
                                                        <option {{ ( $item->id == old('id_type_identification')) ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <input value="{{ old('number_identification') }}"  type="number" name="number_identification" id="number_identification" class="form-control input-sm"
                                                    placeholder="Número de identificación">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <select name="id_rol"  value="{{ old('id_rol') }}" id="id_rol" class="form-control">
                                                    <option value="">Seleccione una opción</option>
                                                    @foreach ($roles as $item)
                                                        <option  {{ ( $item->id == old('id_rol')) ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <input type="email" value="{{ old('email') }}"  name="email" id="email" class="form-control input-sm"
                                                    placeholder="Correo electrónico">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <input type="password" name="password" id="password" class="form-control input-sm"
                                                    placeholder="Password">
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control input-sm"
                                                    placeholder="Repetir password">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <input type="submit" value="Guardar" class="btn btn-success btn-block">
                                            <a href="{{ route('users.index') }}" class="btn btn-info btn-block">Atrás</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>


                </div>
            </div>
        </div>
    </div>



@endsection
