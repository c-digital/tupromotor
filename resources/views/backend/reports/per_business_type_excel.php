<table class="table table-bordered mb-0">
    <thead>
        <tr>
            <th>#</th>
            <th>Tipo de negocio</th>
            <th>Nombre</th>
            <th>Telefono</th>
            <th>Direccion</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        <?php $contador = 1; foreach ($shops as $shop): ?>
            <tr>
                <td><?php echo $contador++; ?></td>
                <td><?php echo $shop->type; ?></td>
                <td><?php echo $shop->name; ?></td>
                <td><?php echo $shop->phone; ?></td>
                <td><?php echo $shop->address; ?></td>
                <td><?php echo $shop->approved = 1 ? 'Activo' : 'Inactivo'; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
