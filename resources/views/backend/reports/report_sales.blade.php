@extends('backend.layouts.app')

@section('content')
<div class="aiz-titlebar text-left mt-2 mb-3">
    <div class=" align-items-center">
       <h1 class="h3">{{translate('Reporte de ventas')}}</h1>
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
                            <label for="provider">Proveedor</label>
                            <select name="provider" class="select2 form-control">
                                <option value=""></option>
                                @foreach($providers as $provider)
                                    <option {{ request()->get('provider') == $provider->id ? 'selected' : '' }} value="{{ $provider->id }}">{{ $provider->name }}</option>
                                @endforeach
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

                <table class="table table-bordered mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Número de pedido</th>
                            <th>Tipo de negocio</th>
                            <th>NIT</th>
                            <th>Proveedor</th>
                            <th>Comisión</th>
                            <th>Total</th>
                            <th>Dirección de la tienda</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $order->code }}</td>
                                <td>{{ $order->seller->tipo ?? '' }}</td>
                                <td>{{ $order->seller->nit ?? '' }}</td>
                                <td>{{ $order->seller->user->name ?? '' }}</td>
                                <td>{{ commission($order->id) }}</td>
                                <td>Bs. {{ $order->grand_total ?? 0 }}</td>
                                <td>{{ $order->seller->address ?? '' }}</td>
                                <td>{{ $order->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @if(!request()->imprimir || request()->excel)
                    <div class="aiz-pagination mt-4">
                        {{ $orders->appends($_GET)->links() }}
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
