<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login Automotora</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="d-flex align-items-center py-4 bg-body-tertiary">
    <main class="form-signin w-100 m-auto container" style="max-width: 330px;">
        <!-- ACTION APUNTA AL CONTROLADOR EN LA CARPETA HERMANA -->
        <form action="../controllers/auth.php" method="POST">
            <h1 class="h3 mb-3 fw-normal text-center">Iniciar Sesión</h1>
            
            <?php if(isset($_GET['error'])): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
            <?php endif; ?>

            <div class="form-floating mb-2">
                <input type="email" name="email" class="form-control" id="floatingInput" required>
                <label for="floatingInput">Email</label>
            </div>
            <div class="form-floating mb-2">
                <input type="password" name="password" class="form-control" id="floatingPassword" required>
                <label for="floatingPassword">Contraseña</label>
            </div>

            <button class="btn btn-primary w-100 py-2" type="submit">Ingresar</button>
        </form>
    </main>
</body>
</html>