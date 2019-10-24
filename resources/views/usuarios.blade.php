@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Listado de Usuarios</div>

                <div class="card-body">
                    <usuarios-table-component></usuarios-table-component>
                </div>
            </div>
        </div>
    </div>

    <usuario-form-component></usuario-form-component>
</div>
@endsection
