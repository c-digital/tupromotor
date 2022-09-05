<table class="table table-bordered mb-0">
    <thead>
        <tr>
            <th>#</th>
            <th>Pedido</th>
            <th>Tipo de negocio</th>
            <th>NIT</th>
            <th>Nombre</th>
            <th>Proveedor</th>
            <th>Estatus</th>
            <th>Monto a cancelar</th>
            <th>Fecha</th>
        </tr>
    </thead>
    <tbody>
        <?php $contador = 1; foreach ($orders as $order): ?>
            <tr>
                <td><?php echo $contador++; ?></td>
                <td><?php echo $order->code; ?></td>
                <td><?php echo $order->seller->user->type ?? null; ?></td>
                <td><?php echo $order->seller->nit ?? null; ?></td>
                <td><?php echo $order->seller->name ?? null; ?></td>
                <td><?php echo $order->seller->user->name ?? null; ?></td>
                <td>
                    <?php if($order->status == null): ?>
                        En espera
                    <?php elseif($order->status == 1): ?>
                        Aprobada
                    <?php else: ?>
                        Rechazada
                    <?php endif; ?>
                </td>
                <td>Bs. <?php echo $order->grand_total; ?></td>
                <td><?php echo $order->created_at; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
