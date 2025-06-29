<!-- 
    <div class="container mt-5">
        <h1 class="text-center mb-4">Gestión de Productos</h1>

        <div class="d-flex justify-content-end mb-3">
            <a href="agregar.php" class="btn btn-success">Agregar nuevo producto</a>
        </div>

        <div class="table-responsive">
            <table class="table table-dark table-striped table-bordered align-middle text-center">
                <thead class="table-danger">
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th style="width: 200px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['nombre']) ?></td>
                        <td><?= htmlspecialchars($row['descripcion']) ?></td>
                        <td>$<?= number_format($row['precio'], 0, ',', '.') ?></td>
                        <td>
                            <a href="editar.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="eliminar.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm"
                            onclick="return confirm('¿Seguro que deseas eliminar este producto?')">Eliminar</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div> -->