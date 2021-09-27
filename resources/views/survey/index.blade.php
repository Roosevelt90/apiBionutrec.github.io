@extends('layouts.app', ['activePage' => 'survey', 'titlePage' => __('Encuestas')])

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
                            <h3>Listado de encuestas</h3>
                        </div>
                        <div class="pull-right">
                            <div class="btn-group">
                                <a href="{{ route('encuesta.create') }}" class="btn btn-info">Añadir encuesta</a>
                            </div>
                        </div>
                        <div class="table-container">
                            <table id="tbl_data_table" class="table table-bordred table-striped">
                                <thead>
                                    <th>Nombre</th>
                                    <th>Opciones</th>
                                </thead>
                                <tbody>
                                    @foreach ($survey as $item)
                                    <tr>
                                        <td>{{ $item->name }} {{ $item->date_begin_format() }} - {{ date('Y-m-d') }}</td>
                                        <td>
                                        @if($item->date_begin_format() < date('Y-m-d') && $item->date_end_format() > date('Y-m-d'))
                                        <a class="btn  btn-xs" target="_blank" href="{{ action('SurveyController@survey', $item->idHash()) }}">
                                            Gestionar
                                        </a>
                                        @else
                                        <form action="{{ action('SurveyController@destroy', $item->id) }}" method="post">
                                            {{ csrf_field() }}
                                            <input name="_method" type="hidden" value="DELETE">
                                            <button class="btn  btn-xs" type="submit">
                                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                                            </button>
                                        </form>
                                        @endif
                                        
                                        <a class="btn  btn-xs" href="{{ action('SurveyController@edit', $item->id) }}">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </a>
                              
                                  

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
@push('js')
<script src="{{ asset('js/project.js') }}"></script>
@endpush