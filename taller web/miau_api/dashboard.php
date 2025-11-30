<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Protección: Si no hay login, fuera.
    exit;
}
?>
<!DOCTYPE html>
<html>
<head><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body class="container mt-5">
    <h1>Bienvenido, <?= htmlspecialchars($_SESSION['user_name']) ?></h1>
    <p>Rol: <span class="badge bg-secondary"><?= $_SESSION['user_rol'] ?></span></p>

    <div class="row mt-4">
        <?php if ($_SESSION['user_rol'] == 'admin'): ?>
            <div class="col-md-4">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-header">Administración</div>
                    <div class="card-body">
                        <p class="card-text">Gestionar Usuarios y Finanzas.</p>
                        <a href="#" class="btn btn-light">Ir a Gestión</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($_SESSION['user_rol'] == 'admin' || $_SESSION['user_rol'] == 'mecanico'): ?>
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-header">Taller</div>
                    <div class="card-body">
                        <p class="card-text">Gestionar Vehículos y Reparaciones.</p>
                        <a href="#" class="btn btn-light">Ver Taller</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <a href="logout.php" class="btn btn-outline-dark mt-3">Cerrar Sesión</a>
</body>
</html>