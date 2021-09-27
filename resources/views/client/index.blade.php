@extends('layouts.app', ['activePage' => 'client', 'titlePage' => __('Clientes')])

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
   
                        <div class="table-container">
                            <table id="tbl_data_table" class="table table-bordred table-striped">
                                <thead>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Tipo de identificación</th>
                                    <th>Número de identificación</th>
                                </thead>
                                <tbody>
                                    @foreach ($users as $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->lastName }}</td>
                                        <td>{{ $item->nameTypeIdentification() }}</td>
                                        <td>{{ $item->number_identification }}</td>                                       
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