@extends('layouts.app', ['activePage' => 'survey', 'titlePage' => __('Encuestas')])
@section('content')
<div class="content" style="padding-top: 1px !important;">
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
                    <!--         <div class="panel-heading">
                        <h3 class="panel-title" style="text-align: center;">Nueva encuesta</h3>
                    </div> -->
                    <div class="panel-body">
                        <div class="table-container">

                            <!--      Wizard container        -->
                            <div class="wizard-container" style="padding-top: 1px !important">

                                <div class="card wizard-card" data-color="orange" id="wizardProfile">
                                    <form method="POST" action="{{ route('encuesta.store') }}" id="frm_survey" name="frm_survey" role="form">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="str_asesores" id="str_asesores" value="[]">
                                        <input type="hidden" name="str_campos" id="str_campos" value="[]">
                                        <div class="wizard-header">
                                            <h3>
                                                <b>Nueva encuesta</b>
                                            </h3>
                                        </div>
                                        <div class="wizard-navigation">
                                            <ul>
                                                <li style="text-align: center;"><a href="#about" data-toggle="tab">Información básica</a></li>
                                                <li style="text-align: center;"><a href="#account" data-toggle="tab">Campos</a></li>
                                            </ul>
                                            <div class="moving-tab" id="tab_1" style="padding: unset; height: 100%; width: 515.5px; transform: translate3d(0%, 0px, 0px); transition: all 0.3s ease-out 0s;">Información básica</div>
                                            <div class="moving-tab" id="tab_2" style="display: none; padding: unset; height: 100%; width: 515.5px; transform: translate3d(100%, 0px, 0px); transition: all 0.3s ease-out 0s;">Campos</div>
                                        </div>

                                        <div class="tab-content">
                                            <div class="tab-pane" id="about">
                                                <div class="row">
                                                    <div class="col-xs-3 col-sm-3 col-md-3">
                                                        <div class="form-group" style="    margin-top: 18% !important;">
                                                            <label style="    top: -28px !important;" for="name">Nombre de la encuesta</label>
                                                            <input type="text" required title="Este campo es requerido" name="name" id="name" class="form-control" placeholder="" value="{{ old('name') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-3 col-sm-3 col-md-3">
                                                        <div class="form-group">
                                                            <label for="idProject">Proyecto</label>
                                                            <select value="" required title="Este campo es requerido" name="idProject" id="idProject" class="form-control ">
                                                                <option value="">Seleccione una opción</option>
                                                                @foreach ($projects as $item)
                                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-3 col-sm-3 col-md-3">
                                                        <div class="form-group" style="    margin-top: 18% !important;">
                                                            <label style="    top: -28px !important;" for="date_begin">Fecha de inicio</label>
                                                            <input type="date" required title="Este campo es requerido" value="{{ old('date_begin') }}" name="date_begin" id="date_begin" class="form-control input-sm">
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-3 col-sm-3 col-md-3">
                                                        <div class="form-group" style="    margin-top: 18% !important;">
                                                            <label style="    top: -28px !important;" for="date_end">Fecha de finalización</label>
                                                            <input type="date" required title="Este campo es requerido" value="{{ old('date_end') }}" name="date_end" id="date_end" class="form-control input-sm">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row" style="margin-bottom: 15px !important;">
                                                    <div class="col-xs-12 col-sm-12 col-md-12 text-right">
                                                        <button class="btn btn-info " onclick="showAsesor()" type="button">
                                                            <span class="material-icons">
                                                                add_circle
                                                            </span>
                                                            Agrergar asesor
                                                        </button>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="tab-pane" id="account">
                                                <h4 class="info-text"> Campos de la encuesta </h4>

                                                <div style="display: flex; width: 100%">

                                                    <div style="width: 30%; border: 2px black solid">
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group" style="    margin-top: 18% !important;">
                                                                <label style="    top: -28px !important;" for="nameField">Nombre del campo</label>
                                                                <input type="text" name="nameField" id="nameField" class="form-control" placeholder="" value="">
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group">
                                                                <label for="">Tipo de campo</label>
                                                                <select value="" name="typeField" id="typeField" class="form-control ">
                                                                    <option value="">Seleccione una opción</option>
                                                                    @foreach ($typeQuestion as $item)
                                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12" id="div_values">

                                                            <div id="div_values_option">

                                                            </div>

                                                            <div id="div_values_option_2" style="text-align: end; margin-top: 5%; display: none">
                                                                <button onclick="addOption()" type="button">Agregar opción</button>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                                            <div class="form-group" style="margin-top: 20px !important;">
                                                                <input id="requerido" name="requerido" data-width="100" type="checkbox" data-onstyle="success" data-on="Si" data-off="No" data-toggle="toggle">
                                                                <label style="top: -28px !important;" for="requerido" class="form-check-label">Campo obligatorio</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12" style="text-align: center;">
                                                            <button class="btn btn-info " onclick="addField()" type="button" style="margin-top: 35px;">
                                                                <span class="material-icons">
                                                                    add_circle
                                                                </span>
                                                                Agregar campo
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div style="width: 70%; border: 2px black solid" id="div_cont_campos">

                                                        <!--  <div style="width: 96%; background-color: #E9E9E9; margin-left: 2%; margin-top: 10px; border-radius: 5px;">
                                                            <div style="display: flex; padding: 0 2%; flex-direction: column;">
                                                            
                                                                <div style="display: flex; justify-content: center;">
                                                                    <i style="width: 100px; background-color: #D7D7D7; text-align: center; cursor: pointer;" class="fas fa-chevron-up"></i>
                                                                </div>
                                                                
                                                                <div style="display: flex;">
                                                                    <div style="display: flex; justify-content: center; align-items: center; width: 5%;">
                                                                        Q1
                                                                    </div>
                                                                    <div style="display: flex; flex-direction: column; justify-content: start; width: 100%">
                                                                        <div>
                                                                            Cantidad de hijos
                                                                        </div>
                                                                        <div style="width: 50%;">
                                                                            <input class="form-control">
                                                                        </div>
                                                                        <div>
                                                                            Campo obligatorio: <b>Si</b>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div style="display: flex; justify-content: center;">
                                                                    <i style="width: 100px; background-color: #D7D7D7; text-align: center; cursor: pointer;" class="fas fa-chevron-down"></i>
                                                                </div>
                                                            </div>
                                                        </div> -->

                                                        <!--    <div style="width: 96%; background-color: #E9E9E9; margin-left: 2%; margin-top: 10px; border-radius: 5px;">
                                                            <div style="display: flex; padding: 0 2%; flex-direction: column;">
                                                                <div style="display: flex; justify-content: center;">
                                                                    <i style="width: 100px; background-color: #D7D7D7; text-align: center; cursor: pointer;" class="fas fa-chevron-up"></i>
                                                                </div>
                                                                <div style="display: flex;">
                                                                    <div style="display: flex; justify-content: center; align-items: center; width: 5%;">
                                                                        Q2
                                                                    </div>
                                                                    <div style="display: flex; flex-direction: column; justify-content: start; width: 100%">
                                                                        <div>
                                                                            Cantidad de hijos
                                                                        </div>
                                                                        <div style="width: 50%;">

                                                                            <div style="display: flex; height: 40px;">
                                                                                <div style="width: 10%; display: flex; justify-content: center; align-items: center; flex-direction: row;">
                                                                                    <div style="border: 1px solid #555; width: 13px; height: 13px; cursor: pointer;"></div>
                                                                                </div>
                                                                                <div style="width: 75%;"><input type="text" style="margin-left: 0px !important;" value="Opcion 1" class="form-check-input" id="option_1" name="options[]" onkeyup="keyUpValue(event,' + index + ')"></div>
                                                                                <div style="width: 15%;"><button type="button" class="btn btn-danger" ><i class="material-icons">delete</i></button></div>
                                                                            </div>

                                                                        </div>
                                                                        <div>
                                                                            Campo obligatorio: <b>Si</b>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div style="display: flex; justify-content: center;">
                                                                    <i style="width: 100px; background-color: #D7D7D7; text-align: center; cursor: pointer;" class="fas fa-chevron-down"></i>
                                                                </div>
                                                            </div>
                                                        </div> -->

                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="wizard-footer height-wizard">
                                            <div class="pull-right">
                                                <input type='button' class='btn btn-next btn-fill btn-warning btn-wd btn-sm' name='next' value='Siguiente' />
                                                <button onclick="onFinishTab()" type='button' class='btn btn-finish btn-fill btn-warning btn-wd btn-sm' name='finish' value=''>Finalizar</button>

                                            </div>
                                            <div class="pull-left">
                                                <input type='button' class='btn btn-previous btn-fill btn-default btn-wd btn-sm' name='previous' value='Atras' />
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>

                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalAsesores" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar asesor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Nueva encuesta</h3>
                    </div>
                    <div class="panel-body">
                        <div class="table-container">

                            <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <label for="idAsesor">Asesor</label>
                                        <select value="" name="idAsesor" id="idAsesor" class="form-control ">
                                            <option value="">Seleccione una opción</option>
                                            @foreach ($users as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }} {{ $item->last_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <button style="margin-top: 20%;" onclick="addAsesor()">Agrergar</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <table id="tbl_data_table" name="tbl_data_table" class="table table-bordred cls_tbl_asesores">
                                        <thead>
                                            <tr>
                                                <th>
                                                    Nombre
                                                </th>
                                                <th>
                                                    Apellido
                                                </th>
                                                <th>
                                                    Correo electrónico
                                                </th>
                                                <th>
                                                    Acciones
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody_asesores">

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
            </div>
        </div>
    </div>
</div>

@endsection
@push('js')
<link href="{{ asset('bootstrap-wizard/assets/css/gsdk-bootstrap-wizard.css') }}" rel="stylesheet" />
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<style>
    .loader {
        border: 16px solid #f3f3f3;
        /* Light grey */
        border-top: 16px solid #3498db;
        /* Blue */
        border-radius: 50%;
        width: 120px;
        height: 120px;
        animation: spin 2s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .toggle-handle {
        background-color: #1D1D1D !important;
    }

    p.clasificacion {
  position: relative;
  overflow: hidden;
  display: inline-block;
}

p.clasificacion input {
  position: absolute;
  top: -100px;
}

p.clasificacion label {
  float: right;
  color: #333;
}

p.clasificacion label:hover,
p.clasificacion label:hover ~ label,
p.clasificacion input:checked ~ label {
  color: #dd4;
}

</style>

<script src="{{ asset('bootstrap-wizard/assets/js/jquery.validate.wizard.js') }}"></script>
<script src="{{ asset('bootstrap-wizard/assets/js/jquery.bootstrap.wizard.js') }}"></script>
<script src="{{ asset('bootstrap-wizard/assets/js/gsdk-bootstrap-wizard.js') }}"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/randomcolor/0.4.2/randomColor.min.js"></script>
<script src="{{ asset('jquery-loading/dist/jquery.loading.min.js') }}"></script>
<script>
    $('.wizard-card').bootstrapWizard({
        'tabClass': 'nav nav-pills',
        'nextSelector': '.btn-next',
        'previousSelector': '.btn-previous',

        onInit: function(tab, navigation, index) {

            var $total = navigation.find('li').length;
            $width = 100 / $total;

            $display_width = $(document).width();

            console.log($total);

            if ($display_width < 600 && $total > 2) {
                $width = 50;
            }

            navigation.find('li').css('width', $width + '%');

        },
        onNext: function(tab, navigation, index) {
            /*       if (!name) {
                      Swal.fire(
                          'Error',
                          'El nombre del campo es requerido',
                          'info'
                      )
                      return false;
                  } */
            $("#tab_1").hide();
            $("#tab_2").show();
            $('#tab_2').css('transform', 'translate3d(100%, 0px, 0px)');
        },
        onPrevious: function(tab, navigation, index) {
            $("#tab_1").show();
            $("#tab_2").hide();
        },
        onTabClick: function(tab, navigation, index) {
            return false;
        },
        onTabShow: function(tab, navigation, index) {
            var $total = navigation.find('li').length;
            var $current = index + 1;

            var wizard = navigation.closest('.wizard-card');

            if ($current >= $total) {
                $(wizard).find('.btn-next').hide();
                $(wizard).find('.btn-finish').show();   
            } else {
                $(wizard).find('.btn-next').show();
                $(wizard).find('.btn-finish').hide();
            }
        }
    });

    function onFinishTab() {
        //alert(2);
        $("#frm_survey").submit();
    }
</script>
<script>
    var users = @json($users);
    $('.cls_disabled').prop('disabled', true);
</script>
<script src="{{ asset('js/create_survey.js') }}"></script>
@endpush