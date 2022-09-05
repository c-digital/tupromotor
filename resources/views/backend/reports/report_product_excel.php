<table class="table table-bordered mb-0">
    <thead>
        <tr>
            <th>#</th>
            <th>Nombre empresa</th>
            <th>Foto</th>
            <th>Codigo producto</th>
            <th>Nombre producto</th>
            <th>Cantidad vendida</th>
            <th>Monto vendido</th>
        </tr>
    </thead>
    <tbody>
        <?php $contador = 1; foreach ($products as $product): ?>
            <tr>
                <td><?php echo $contador++; ?></td>
                <td><?php echo $product->user->name; ?></td>
                <td>
                    <img height="100px" width="100px" src="<?php echo uploaded_asset($product->thumbnail_img); ?>" alt="">
                </td>
                <td><?php echo $product->id; ?></td>
                <td><?php echo $product->name; ?></td>
                <td><?php echo count_sales($product->id); ?></td>
                <td><?php echo amount_sales($product->id); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
