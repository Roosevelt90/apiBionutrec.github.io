@extends('layouts.app', ['activePage' => 'project', 'titlePage' => __('Proyectos')])

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
                            <h3>Listado de proyectos</h3>
                        </div>
                        <div class="pull-right">
                            <div class="btn-group">
                                <a href="{{ route('project.create') }}" class="btn btn-info">Añadir proyecto</a>
                            </div>
                        </div>
                        <div class="table-container">
                            <table id="tbl_data_table" class="table table-bordred table-striped">
                                <thead>
                                    <th>Nombre</th>
                                    <th>Opciones</th>
                                </thead>
                                <tbody>
                                    @foreach ($projects as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            <a class="btn  btn-xs" href="{{ action('ProjectController@edit', $item->id) }}">
                                                <i class="fa fa-pencil" aria-hidden="true"></i>
                                            </a>
                                            <button class="btn btn-info " onclick="showFields({{$item->id}})" type="button">                                                     
                                                            Agregar campos
                                                        </button>
                                            @if ($item->deleted_at == null)
                                            <form action="{{ action('ProjectController@destroy', $item->id) }}" method="post">
                                                {{ csrf_field() }}
                                                <input name="_method" type="hidden" value="DELETE">
                                                <button class="btn  btn-xs" type="submit">
                                                    <i class="fa fa-minus-circle"></i>
                                                </button>
                                            </form>
                                            @else
                                            <form action="{{ action('ProjectController@destroy', $item->id) }}" method="post">
                                                {{ csrf_field() }}
                                                <input name="_method" type="hidden" value="DELETE">
                                                <button class="btn  btn-xs" type="submit">
                                                    <i class="fa fa-check-circle"></i>
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

<input type="hidden" name="str_campos" id="str_campos" value="[]">
<!-- Modal -->
<div class="modal fade" id="modalAsesores" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar campos personalizados</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="panel panel-default">

                    <input type="hidden"   name="idProjectField" id="idProjectField" >
                    <div class="panel-body">
                        <div class="table-container" style="margin-top: 5% !important;">
                            <div class="row">
                                <div class="col-xs-3 col-sm-3 col-md-3">
                                    <div class="form-group" style="margin-top: 25% !important;">
                                        <label style="    top: -28px !important;" for="nameField">Nombre del campo</label>
                                        <input type="text" required title="Este campo es requerido" name="nameField" id="nameField" class="form-control" placeholder="" value="{{ old('name') }}">
                                    </div>
                                </div>
                                <div class="col-xs-3 col-sm-3 col-md-3">
                                    <div class="form-group">
                                        <label for="typeField">Tipo de campo</label>
                                        <select value="" required title="Este campo es requerido" name="typeField" id="typeField" class="form-control ">
                                            <option value="">Seleccione una opción</option>
                                            @foreach ($typeQuestion as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-3 col-sm-3 col-md-3">
                                                            <div class="form-group" style="margin-top: 20px !important;">
                                                            <label style="top: -28px !important;" for="validacion" class="form-check-label">Campo de validación</label>
                                                                <input id="validacion" name="validacion" data-width="100" type="checkbox" data-onstyle="success" data-on="Si" data-off="No" data-toggle="toggle">                                                                
                                                            </div>
                                                        </div>
                                <div class="col-xs-3 col-sm-3 col-md-3">
                                    <div id="div_values_option">

                                    </div>
                                </div>
                                <div class="col-xs-3 col-sm-3 col-md-3">
                                    <div id="div_values_option_2" style="text-align: end; margin-top: 25%; display: none">
                                        <button onclick="addOption()" type="button">Agregar opción</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12" style="text-align: center;">
                                    <button class="btn btn-info " onclick="addField()" type="button" style="margin-top: 35px;">
                                        <span class="material-icons">
                                            add_circle
                                        </span>
                                        Agregar campos personalizados
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-11 col-sm-11 col-md-11" style="text-align: center;">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>
                                                    Nombre del campo
                                                </th>
                                                <th>
                                                    Tipo del campo
                                                </th>
                                                <th>
                                                    Campo de validación
                                                </th>
                                                <th>
                                                    Valores
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="div_cont_campos">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="saveField()">Guardar campos</button>
            </div>
        </div>
    </div>
</div>

@endsection
@push('js')
<script src="{{ asset('js/project.js') }}"></script>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
@endpush