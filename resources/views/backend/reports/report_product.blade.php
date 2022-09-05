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
                        <div class="col">
                            <label for="producto">Producto</label>
                            <select name="producto" class="select2 form-control">
                                <option value=""></option>
                                @foreach($products as $producto)
                                    <option {{ request()->get('producto') == $producto->id ? 'selected' : '' }} value="{{ $producto->id }}">{{ $producto->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col">
                            <label for="proveedor">Proveedor</label>
                            <select name="proveedor" class="select2 form-control">
                                <option value=""></option>
                                @foreach($providers as $provider)
                                    <option {{ request()->get('proveedor') == $provider->id ? 'selected' : '' }} value="{{ $provider->id }}">{{ $provider->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col">
                            <button class="btn btn-primary btn-block mt-4" type="submit">{{ translate('Filter') }}</button>
                        </div>

                        <div class="col">
                            <a href="{{ request()->fullUrlWithQuery(['imprimir' => 1]) }}" class="btn btn-primary btn-block mt-4">{{ translate('Imprimir') }}</a>
                        </div>

                        <div class="col">
                            <a href="{{ request()->fullUrlWithQuery(['excel' => 1]) }}" class="btn btn-primary btn-block mt-4">{{ translate('Excel') }}</a>
                        </div>
                    </div>
                </form>

                <table class="table table-bordered mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre empresa</th>
                            <th>Foto</th>
                            <th>Código producto</th>
                            <th>Nombre producto</th>
                            <th>Cantidad vendida</th>
                            <th>Monto vendido</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $product->user->name }}</td>
                                <td>
                                    <img height="100px" width="100px" src="{{ uploaded_asset($product->thumbnail_img) }}" alt="">
                                </td>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ count_sales($product->id) }}</td>
                                <td>{{ amount_sales($product->id) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @if(!request()->imprimir)
                    <div class="aiz-pagination mt-4">
                        {{ $products->links() }}
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
