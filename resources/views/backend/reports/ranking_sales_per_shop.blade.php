@extends('backend.layouts.app')

@section('content')
<div class="aiz-titlebar text-left mt-2 mb-3">
    <div class=" align-items-center">
       <h1 class="h3">{{translate('Ránking de ventas por tienda')}}</h1>
    </div>
</div>

<div class="row">
    <div class="col-md-12 mx-auto">
        <div class="card">
            <div class="card-body">
                <form method="GET">
                    <div class="form-group row">
                        <div class="col-md-3">
                            <label for="date_start">Fecha inicio</label>
                            <input type="date" class="form-control" name="date_start">
                        </div>

                        <div class="col-md-3">
                            <label for="date_end">Fecha fin</label>
                            <input type="date" class="form-control" name="date_end">
                        </div>

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
                            <button class="btn btn-primary btn-block mt-4" type="submit">{{ translate('Filter') }}</button>
                        </div>

                        <div class="col-md-2">
                            <a class="btn btn-primary btn-block mt-4" href="{{ request()->fullUrlWithQuery(['imprimir' => 1]) }}">{{ translate('Imprimir') }}</a>
                        </div>

                        <div class="col-md-2">
                            <a class="btn btn-primary btn-block mt-4" href="{{ request()->fullUrlWithQuery(['excel' => 1]) }}">{{ translate('Excel') }}</a>
                        </div>
                    </div>
                </form>

                <table class="table table-bordered mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tipo de negocio</th>
                            <th>Teléfono</th>
                            <th>Nombre</th>
                            <th>Total de pedidos</th>
                            <th>Monto total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($shops as $shop)
                            @php
                                $orders = App\Models\Order::selectRaw('COUNT(1) AS total_pedidos, SUM(grand_total) AS monto_total')
                                    ->where('seller_id', $shop->id)
                                    ->dateStart(request()->date_start)
                                    ->dateEnd(request()->date_end)
                                    ->first();

                                $total_pedidos = $orders->total_pedidos;
                                $monto_total = $orders->monto_total;
                            @endphp

                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $shop->type }}</td>
                                <td>{{ $shop->phone }}</td>
                                <td>{{ $shop->name }}</td>
                                <td>{{ $total_pedidos }}</td>
                                <td>Bs. {{ $monto_total ?? 0 }}</td>
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
