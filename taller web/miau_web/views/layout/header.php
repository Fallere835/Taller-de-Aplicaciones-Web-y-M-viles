<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($titulo) ? h($titulo) . ' - ' : '' ?>MIAUtomotriz</title>
    
    <!-- CSS Base para el sistema -->
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --success-color: #27ae60;
            --warning-color: #f39c12;
            --danger-color: #e74c3c;
            --dark-color: #34495e;
            --light-color: #ecf0f1;
            --white-color: #ffffff;
            
            /* Colores específicos para roles */
            --admin-primary: #2c3e50;
            --admin-secondary: #34495e;
            --mechanic-primary: #27ae60;
            --mechanic-secondary: #2ecc71;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header principal */
        .main-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--dark-color) 100%);
            color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo-placeholder {
            width: 50px;
            height: 50px;
            background: rgba(255,255,255,0.2);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .brand-name {
            font-size: 2rem;
            font-weight: bold;
            letter-spacing: -0.5px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-details {
            text-align: right;
        }

        .user-name {
            font-weight: 600;
            font-size: 1.1rem;
        }

        .user-role {
            font-size: 0.9rem;
            opacity: 0.8;
        }

        .logout-btn {
            background: rgba(231, 76, 60, 0.8);
            color: white;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 0.9rem;
            transition: background 0.3s ease;
        }

        .logout-btn:hover {
            background: rgba(231, 76, 60, 1);
        }

        /* Navegación */
        .main-nav {
            background: rgba(0,0,0,0.1);
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        .nav-content {
            display: flex;
            justify-content: center;
            padding: 0.5rem 0;
        }

        .nav-links {
            display: flex;
            gap: 30px;
            list-style: none;
        }

        .nav-links li a {
            color: white;
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 4px;
            transition: background 0.3s ease;
            font-size: 0.95rem;
        }

        .nav-links li a:hover,
        .nav-links li a.active {
            background: rgba(255,255,255,0.2);
        }

        /* Contenido principal */
        .main-content {
            flex: 1;
            padding: 30px 0;
        }

        .content-wrapper {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
            padding: 30px;
            margin-bottom: 30px;
        }

        .page-title {
            font-size: 2.2rem;
            font-weight: 300;
            color: var(--primary-color);
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 3px solid var(--secondary-color);
        }

        /* Alerts y mensajes */
        .alert {
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 0.95rem;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert-warning {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        .alert-info {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            .user-info {
                flex-direction: column;
                gap: 10px;
            }

            .nav-links {
                flex-direction: column;
                gap: 10px;
                text-align: center;
            }

            .brand-name {
                font-size: 1.5rem;
            }

            .content-wrapper {
                padding: 20px;
            }

            .page-title {
                font-size: 1.8rem;
            }
        }

        /* Utilidades */
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .mb-20 { margin-bottom: 20px; }
        .mt-20 { margin-top: 20px; }
    </style>
    
    <!-- CSS adicional específico de cada página -->
    <?php if (isset($css_adicional)): ?>
        <style><?= $css_adicional ?></style>
    <?php endif; ?>
</head>
<body>
    <!-- Header principal -->
    <header class="main-header">
        <div class="container">
            <div class="header-content">
                <div class="logo-section">
                    <div class="logo-placeholder">
                        🚗
                    </div>
                    <h1 class="brand-name">MIAUtomotriz</h1>
                </div>
                
                <?php if (is_logged_in()): ?>
                    <?php $usuario = get_logged_user(); ?>
                    <div class="user-info">
                        <div class="user-details">
                            <div class="user-name"><?= h($usuario['nombre_completo']) ?></div>
                            <div class="user-role"><?= h($usuario['rol']) ?></div>
                        </div>
                        <a href="logout.php" class="logout-btn">Cerrar Sesión</a>
                    </div>
                <?php endif; ?>
            </div>
            
            <?php if (is_logged_in() && isset($mostrar_navegacion) && $mostrar_navegacion): ?>
                <nav class="main-nav">
                    <div class="nav-content">
                        <ul class="nav-links">
                            <li><a href="dashboard.php" <?= ($pagina_actual ?? '') === 'dashboard' ? 'class="active"' : '' ?>>Panel Principal</a></li>
                            <li><a href="ordenes.php" <?= ($pagina_actual ?? '') === 'ordenes' ? 'class="active"' : '' ?>>Mis Reparaciones</a></li>
                            <li><a href="facturas.php" <?= ($pagina_actual ?? '') === 'facturas' ? 'class="active"' : '' ?>>Mis Facturas</a></li>
                            <li><a href="cotizaciones.php" <?= ($pagina_actual ?? '') === 'cotizaciones' ? 'class="active"' : '' ?>>Mis Cotizaciones</a></li>
                            <li><a href="clientes.php" <?= ($pagina_actual ?? '') === 'clientes' ? 'class="active"' : '' ?>>Clientes</a></li>
                            <li><a href="inventario.php" <?= ($pagina_actual ?? '') === 'inventario' ? 'class="active"' : '' ?>>Inventario</a></li>
                            <li><a href="reportes.php" <?= ($pagina_actual ?? '') === 'reportes' ? 'class="active"' : '' ?>>Reportes</a></li>
                            <li><a href="contacto.php" <?= ($pagina_actual ?? '') === 'contacto' ? 'class="active"' : '' ?>>Contacto</a></li>
                        </ul>
                    </div>
                </nav>
            <?php endif; ?>
        </div>
    </header>

    <!-- Contenido principal -->
    <main class="main-content">
        <div class="container">