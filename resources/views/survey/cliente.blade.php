@extends('layouts.app_cliente')

@section('content')
<div class="content" style="margin-top: 1px;">
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
                <div class="alert alert-info" style="margin-top: 20px;">
                    {{ Session::get('success') }}
                </div>
                @endif
                

                <div class="panel panel-default" style="margin-top: 40px;">
                    <div class="panel-heading" style="margin-bottom: 20px;">
                        <h3 class="panel-title" style="text-align: center;">{{ $survey->name }}</h3>
                    </div>
                    <div class="panel-body">
                        <div class="table-container">
                            <form method="POST" id="formSurvey" action="/encuesta/storeCliente" role="form">
                                {{ csrf_field() }}
                                <input type="hidden" name="idSurvey" id="idSurvey" class="" placeholder="" value="{{ $idHash }}">
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
                                    <div class="col-xs-3 col-sm-3 col-md-3">
                                        <div class="form-group">
                                            <label for="lastName">Tipo de documento <span style="color: red">*</span></label>
                                            <select name="id_type_identification" id="id_type_identification" class="form-control">
                                                <option value="">Seleccione una opción</option>
                                                @foreach ($typeIdentification as $item)
                                                <option {{ ( $item->id == old('id_type_identification')) ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->name }}</option>
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
                                <hr>
                                <h4 style="text-align: center;">Preguntas</h4>

                                <div style="display: flex; flex-direction: column; justify-content: center; align-items: center;">
                                    @foreach ($fields as $item)
                                    @switch($item->id_type)
                                    @case(1)
                                    <div class="form-group cls_div_campo">
                                        <div class="cls_width_50">
                                            <label for="{{ $item->name_id }}">{{ $item->name }}
                                                @if($item->required == 1)
                                                <span style="color: red">*</span>
                                                @endif
                                            </label>
                                        </div>
                                        <input value="" type="text" name="{{ $item->name_id }}" id="{{ $item->name_id }}" class="form-control input-sm cls_width_50" placeholder="{{ $item->name }}">
                                    </div>
                                    @break
                                    @case(2)
                                    <div class="form-group cls_div_campo">
                                        <div class="cls_width_50">
                                            <label for="{{ $item->name_id }}">{{ $item->name }}
                                                @if($item->required == 1)
                                                <span style="color: red">*</span>
                                                @endif
                                            </label>
                                        </div>
                                        <input value="" type="number" name="{{ $item->name_id }}" id="{{ $item->name_id }}" class="form-control input-sm cls_width_50" placeholder="{{ $item->name }}">
                                    </div>
                                    @break
                                    @case(3)
                                    <div class="form-group cls_div_campo">
                                        <div class="cls_width_50">
                                            <label for="{{ $item->name_id }}">{{ $item->name }}
                                                @if($item->required == 1)
                                                <span style="color: red">*</span>
                                                @endif
                                            </label>
                                        </div>
                                        <div class="form-check cls_width_50" style="padding-left: inherit;">
                                            @foreach(explode(',', $item->values) as $info)
                                            <div class="radio">
                                                <label><input type="radio" value="{{trim($info)}}" name="{{ $item->name_id }}" id="{{ $item->name_id }}" style="margin-right: 5px;">{{trim($info)}}</label>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @break
                                    @case(4)
                                    <div class="form-group cls_div_campo">
                                        <div class="cls_width_50">
                                            <label for="{{ $item->name_id }}">{{ $item->name }}
                                                @if($item->required == 1)
                                                    <span style="color: red">*</span>
                                                @endif
                                            </label>
                                        </div>
                                        @foreach(explode(',', $item->values) as $info)
                                        <div class="form-check cls_width_50">
                                            <input type="checkbox" class="form-check-input" value="{{trim($info)}}" name="{{ $item->name_id }}[]" id="{{trim($info)}}">
                                            <label class="form-check-label" for="{{trim($info)}}">{{trim($info)}}</label>
                                        </div>
                                        @endforeach
                                    </div>
                                    @break
                                    @case(5)
                                    <div class="form-group cls_div_campo">
                                        <div class="cls_width_50">
                                            <label for="{{ $item->name_id }}">{{ $item->name }}
                                                @if($item->required == 1)
                                                    <span style="color: red">*</span>
                                                @endif
                                            </label>
                                        </div>
                                        <input value="" type="date" name="{{ $item->name_id }}" id="{{ $item->name_id }}" class="cls_width_50 form-control input-sm" placeholder="{{ $item->name }}">
                                    </div>
                                    @break
                                    @case(6)
                                    <div class="form-group cls_div_campo">
                                        <div class="cls_width_50">
                                            <label for="{{ $item->name_id }}">{{ $item->name }}
                                                @if($item->required == 1)
                                                    <span style="color: red">*</span>
                                                @endif
                                            </label>
                                        </div>

                                        <input value="" type="tel" name="{{ $item->name_id }}" id="{{ $item->name_id }}" class="cls_width_50 form-control input-sm" placeholder="{{ $item->name }}">
                                    </div>
                                    @break
                                    @case(7)
                                   <div class="form-group cls_div_campo">
                                        <div class="cls_width_50">
                                            <label for="{{ $item->name_id }}">{{ $item->name }}
                                                @if($item->required == 1)
                                                    <span style="color: red">*</span>
                                                @endif
                                            </label>
                                        </div>
                                        <p class="{{ $item->name_id }}">
                                            <input id="{{ $item->name_id }}1" type="radio" name="{{ $item->name_id }}" value="5">
                                            <label for="{{ $item->name_id }}1">★</label>
                                            <input id="{{ $item->name_id }}2" type="radio" name="{{ $item->name_id }}" value="4">
                                            <label for="{{ $item->name_id }}2">★</label>
                                            <input id="{{ $item->name_id }}3" type="radio" name="{{ $item->name_id }}" value="3">
                                            <label for="{{ $item->name_id }}3">★</label>
                                            <input id="{{ $item->name_id }}4" type="radio" name="{{ $item->name_id }}" value="2">
                                            <label for="{{ $item->name_id }}4">★</label>
                                            <input id="{{ $item->name_id }}5" type="radio" name="{{ $item->name_id }}" value="1">
                                            <label for="{{ $item->name_id }}5">★</label>
                                        </p>
                                        <input value="" type="text" name="{{ $item->name_id }}_text" id="{{ $item->name_id }}_text" class="cls_width_50 form-control input-sm" placeholder="Agregue su justificación">
                                    <style>
                                        p.{{ $item->name_id }} {
                                        position: relative;
                                        overflow: hidden;
                                        display: inline-block;
                                        }

                                        p.{{ $item->name_id }} input {
                                        position: absolute;
                                        top: -100px;
                                        }

                                        p.{{ $item->name_id }} label {
                                        float: right;
                                        color: #333;
                                        }

                                        p.{{ $item->name_id }} label:hover,
                                        p.{{ $item->name_id }} label:hover ~ label,
                                        p.{{ $item->name_id }} input:checked ~ label {
                                        color: #dd4;
                                        }
                                    </style>
                                      <!--   <input value="" type="tel" name="{{ $item->name_id }}" id="{{ $item->name_id }}" class="cls_width_50 form-control input-sm" placeholder="{{ $item->name }}"> -->
                                    </div> 
                                    @break
                                    @endswitch
                                    @endforeach
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                        <button class="btn btn-success" type="submit">Guardar</button>
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
@push('js')
<script>
    var idSurvey = '{{$idHash}}';
    var fields = @json($fields);
</script>
<script src="{{ asset('js/cliente_survey.js') }}"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<!-- Initialize the plugin: -->
<script type="text/javascript">
    $(document).ready(function() {
        //$('.example-getting-started').multiselect();
        $('select').selectpicker();
    });
</script>
@endpush
@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
<style>
    .cls_div_campo {
        display: flex;
        width: 80%;
        background-color: #E9E9E9;
        align-items: center;
        flex-direction: column;
        justify-content: center;
        padding: 15px;
        border-radius: 15px;
    }

    .cls_width_50 {
        width: 50%;
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
@endpush