<table class="table table-bordered mb-0">
    <thead>
        <tr>
            <th>#</th>
            <th>Tipo de negocio</th>
            <th>Telefono</th>
            <th>Nombre</th>
            <th>Total de pedidos</th>
            <th>Monto total</th>
        </tr>
    </thead>
    <tbody>
        <?php $contador = 1; foreach ($shops as $shop): ?>
            <?php
                $orders = App\Models\Order::selectRaw('COUNT(1) AS total_pedidos, SUM(grand_total) AS monto_total')
                    ->where('seller_id', $shop->id)
                    ->dateStart(request()->date_start)
                    ->dateEnd(request()->date_end)
                    ->first();

                $total_pedidos = $orders->total_pedidos;
                $monto_total = $orders->monto_total;
            ?>

            <tr>
                <td><?php echo $contador++; ?></td>
                <td><?php echo $shop->type; ?></td>
                <td><?php echo $shop->phone; ?></td>
                <td><?php echo $shop->name; ?></td>
                <td><?php echo $total_pedidos; ?></td>
                <td>Bs. <?php echo $monto_total ?? 0; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
