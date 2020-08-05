@extends('layouts.plantilla')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Generar Clientes</h2>
    </div>
</div>
<br>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <ol class="breadcrumb">
            <form action="{{route('buscar')}}" method="POST">
                {!! csrf_field()!!}
                <div class="col-lg-6">
                    <br>
                    <label>Ingresar el Codigo de Cliente</label>
                    <div class="form-group">
                        <input type="text" name="codCliente" class="form-control" placeholder="codigo cliente" value="{{$codCliente}}">
                    </div>
                    <br>
                    <div class="col-lg-4">
                        <button type="submit" class="btn btn-primary block full-width m-b">Buscar</button>
                    </div>
                </div>
            </form>
        </ol>
    </div>
</div>
@endsection