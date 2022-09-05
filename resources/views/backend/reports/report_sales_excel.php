<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Numero de pedido</th>
            <th>Tipo de negocio</th>
            <th>NIT</th>
            <th>Proveedor</th>
            <th>Comision</th>
            <th>Total</th>
            <th>Direccion de la tienda</th>
            <th>Fecha</th>
        </tr>
    </thead>
    <tbody>
        <?php $contador = 1; foreach ($orders as $order): ?>
            <tr>
                <td><?php echo $contador; ?></td>
                <td><?php echo $order->code; ?></td>
                <td><?php echo $order->seller->tipo ?? ''; ?></td>
                <td><?php echo $order->seller->nit ?? ''; ?></td>
                <td><?php echo $order->seller->user->name ?? ''; ?></td>
                <td><?php echo commission($order->id); ?></td>
                <td>Bs. <?php echo $order->grand_total ?? 0; ?></td>
                <td><?php echo $order->seller->address ?? ''; ?></td>
                <td><?php echo $order->created_at; ?></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>
