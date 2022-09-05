@extends('backend.layouts.app')

@section('content')
<div class="aiz-titlebar text-left mt-2 mb-3">
    <div class=" align-items-center">
       <h1 class="h3">{{translate('Reporte de órdenes por estado')}}</h1>
    </div>
</div>

<div class="row">
    <div class="col-md-12 mx-auto">
        <div class="card">
            <div class="card-body">
                <form method="GET">
                    <div class="form-group row">
                        <div class="col-md-2">
                            <label for="tipo_negocio">Tipo negocio</label>
                            <select name="tipo_negocio" class="form-control">
                                <option value=""></option>
                                <option {{ request()->tipo_negocio == 'Tienda' ? 'selected' : '' }} value="Tienda">Tienda</option>
                                <option {{ request()->tipo_negocio == 'Restaurante' ? 'selected' : '' }} value="Restaurante">Restaurante</option>
                                <option {{ request()->tipo_negocio == 'Licorería' ? 'selected' : '' }} value="Licorería">Licorería</option>
                                <option {{ request()->tipo_negocio == 'Hogar' ? 'selected' : '' }} value="Hogar">Hogar</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label for="status">Estado</label>
                            <select name="status" class="form-control">
                                <option value=""></option>
                                <option {{ request()->get('status') == 'Activo' }} value="Activo">Activo</option>
                                <option {{ request()->get('status') == 'Inactivo' }} value="Inactivo">Inactivo</option>
                                <option {{ request()->get('status') == 'Bloqueado' }} value="Bloqueado">Bloqueado</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <button class="btn btn-primary btn-block mt-4" type="submit">{{ translate('Filter') }}</button>
                        </div>

                        <div class="col-md-2">
                            <a href="{{ request()->fullUrlWithQuery(['imprimir' => 1]) }}" class="btn btn-primary btn-block mt-4">{{ translate('Imprimir') }}</a>
                        </div>

                        <div class="col-md-2">
                            <a href="{{ request()->fullUrlWithQuery(['excel' => 1]) }}" class="btn btn-primary btn-block mt-4">{{ translate('Excel') }}</a>
                        </div>
                    </div>
                </form>

                <div class="row">
                    <div class="col">
                        <div class="card bg-info">
                            <div class="card-body text-center">
                                <h4>Tiendas</h4>
                                <h4>{{ $stores }}</h4>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="card bg-success">
                            <div class="card-body text-center">
                                <h6>Restaurantes</h6>
                                <h4>{{ $restaurants }}</h4>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="card bg-danger">
                            <div class="card-body text-center">
                                <h4>Licorerías</h4>
                                <h4>{{ $liquors }}</h4>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="card bg-warning">
                            <div class="card-body text-center">
                                <h4>Negocios</h4>
                                <h4>{{ $business }}</h4>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="card bg-primary">
                            <div class="card-body text-center">
                                <h4>Hogar</h4>
                                <h4>{{ $place }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <table class="table table-bordered mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tipo de negocio</th>
                            <th>Nombre</th>
                            <th>Teléfono</th>
                            <th>Dirección</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($shops as $shop)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $shop->type }}</td>
                                <td>{{ $shop->name }}</td>
                                <td>{{ $shop->phone }}</td>
                                <td>{{ $shop->address }}</td>
                                <td>{{ $shop->approved = 1 ? 'Activo' : 'Inactivo' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @if(!request()->imprimir)
                    <div class="aiz-pagination mt-4">
                        {{ $shops->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@if(request()->imprimir)
    <script>
        window.print();
    </script>
@endif


@endsection
