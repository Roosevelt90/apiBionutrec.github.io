@extends('layouts.app', ['activePage' => 'db', 'titlePage' => __('Base de datos')])

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
                            <h3>Base de datos</h3>
                        </div>
                        <div class="pull-right">
                            <div class="btn-group">
                                <button onclick="exportTableToExcel('tbl_data_table', 'export_data')" class="btn btn-info">Exportar base de datos</button>
                            </div>
                            <div class="btn-group">
                                <button onclick="importModal()" class="btn btn-info">Importar base de datos</button>
                            </div>
                            <div class="btn-group">
                                <button onclick="addBD()" class="btn btn-info">Añadir contacto</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-container">

            <div class="row">
                <div class="col-xs-3 col-sm-3 col-md-3">
                    <div class="form-group">
                        <label for="typeField">Proyecto</label>
                        <select value="" onchange="selectProjectDB()" required title="Este campo es requerido" name="idProjectDB" id="idProjectDB" class="form-control ">
                            <option value="">Seleccione una opción</option>
                            @foreach ($projects as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <table id="tbl_data_table" class="table table-bordred table-striped">
                <thead id="theadDB">
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Tipo de documento</th>
                        <th>Número de documento</th>
                    </tr>
                </thead>
                <tbody id="tbodyDB">
                    <tr>
                        <td colspan="4" style="text-align: center;">
                            Sin datos
                        </td>
                    </tr>
                </tbody>

            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAsesores" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar contacto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="panel panel-default">
                    <input type="hidden" name="idProjectField" id="idProjectField">
                    <div class="panel-body">
                        <div class="table-container" style="margin-top: 5% !important;">
                            <form method="POST" id="formDB" action="#" role="form">
                                <div class="row" style="margin-bottom: 20px ;">
                                    <div class="col-xs-6 col-sm-6 col-md-6 offset-md-3 offset-sm-3 offset-xs-3">
                                        <div class="form-group">
                                            <label for="typeField">Proyecto</label>
                                            <select value="" onchange="selectProject()" required title="Este campo es requerido" name="idProject" id="idProject" class="form-control ">
                                                <option value="">Seleccione una opción</option>
                                                @foreach ($projects as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 col-sm-3 col-md-3">
                                        <div class="form-group">
                                            <label for="name">Nombre del contacto <span style="color: red">*</span></label>
                                            <input type="text" name="name" id="name" class="form-control" placeholder="" value="{{ old('name') }}">
                                        </div>
                                    </div>
                                    <div class="col-xs-3 col-sm-3 col-md-3">
                                        <div class="form-group">
                                            <label for="lastName">Apellido del contacto <span style="color: red">*</span></label>
                                            <input type="text" name="lastName" id="lastName" class="form-control" placeholder="" value="{{ old('name') }}">
                                        </div>
                                    </div>
                                    <div class="col-xs-3 col-sm-3 col-md-3" style="margin-top: -4%;">
                                        <div class="form-group">
                                            <label for="lastName">Tipo de documento <span style="color: red">*</span></label>
                                            <select name="id_type_identification" id="id_type_identification" class="form-control">
                                                <option value="">Seleccione una opción</option>
                                                @foreach ($typeIdentification as $item)
                                                <option {{ $item->id == old('id_type_identification') ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-3 col-sm-3 col-md-3">
                                        <div class="form-group">
                                            <label for="name">Número de identificación <span style="color: red">*</span></label>
                                            <input value="{{ old('number_identification') }}" type="number" name="number_identification" id="number_identification" class="form-control input-sm" placeholder="Número de identificación">
                                        </div>
                                    </div>

                                </div>
                                <div id="divCampos" style="display: flex;  justify-content: center; align-items: center;">

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="save()">Guardar</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalImport" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Importar base de datos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="panel panel-default">
                    <!-- <input type="hidden" name="idProjectField" id="idProjectField"> -->
                    <div class="panel-body">
                        <div class="table-container" style="margin-top: 5% !important;">
                            <form method="POST" id="formDB" action="#" role="form">
                                <div class="row" style="margin-bottom: 20px ;">
                                    <!-- <div class="col-xs-6 col-sm-6 col-md-6 offset-md-3 offset-sm-3 offset-xs-3"> -->
                                    <div class="col-xs-3 col-sm-3 col-md-3">
                                        <div class="form-group">
                                            <label for="typeField">Proyecto</label>
                                            <select value="" onchange="selectProjectImport()" required title="Este campo es requerido" name="idProjectImport" id="idProjectImport" class="form-control ">
                                                <option value="">Seleccione una opción</option>
                                                @foreach ($projects as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-3 col-sm-3 col-md-3">
                                        <div class="form-group">
                                            <label for="typeField">Separador</label>
                                            <select value="" onchange="loadCsv()" required title="Este campo es requerido" name="separador" id="separador" class="form-control ">
                                                <option value="">Seleccione una opción</option>
                                                <option value=";">Punto y coma (;)</option>
                                                <option value=",">Coma (,)</option>
                                                <option value=".">Punto (.)</option>
                                                <option value=":">Dos puntos (:)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xs-3 col-sm-3 col-md-3">
                                        <div style="padding-top: 5%">
                                            <label for="typeField">CSV</label>
                                            <input type="file" accept=".csv" name="fileImport" id="fileImport" onchange="loadCsv()">
                                        </div>
                                    </div>
                                </div>

                                <div id="divDataImport" style="display: flex;  justify-content: center; align-items: center;">

                                </div>

                                <div id="divCamposImport" style="display: flex;  justify-content: center; align-items: center;">

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <input id="sltFields" type="hidden" name="sltFields" value="[]">
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="saveImport()">Guardar</button>
            </div>
        </div>
    </div>
</div>

@endsection
@push('js')

<script src="{{ asset('js/db.js') }}"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
<style>
    .cls_div_campo {
        display: flex;
        width: 80%;


        flex-direction: column;
        justify-content: center;
        padding: 15px;
        border-radius: 15px;
    }
</style>
@endpush