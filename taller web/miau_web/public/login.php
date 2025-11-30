<?php
/**
 * Controlador de Login para MIAUtomotriz
 * 
 * Maneja tanto la visualización como el procesamiento de los formularios
 * de login diferenciados por rol (Administrador y Mecánico)
 */

require_once __DIR__ . '/../app/config.php';
require_once __DIR__ . '/../app/helpers.php';
require_once __DIR__ . '/../app/auth_service.php';

// Si ya está logueado, redirigir al dashboard
if (is_logged_in()) {
    redirect('/../views/dashboard.php');
}

// Variables para la vista
$rol = $_GET['rol'] ?? '';
$error_mensaje = '';
$valores = ['username' => ''];

// Procesar formulario si es POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $resultado = procesar_login($_POST);
    
    if ($resultado['ok']) {
        // Login exitoso
        login_user($resultado['usuario']);
        
        // Registrar intento exitoso
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        registrar_intento_login($resultado['usuario']['username'], true, $ip);
        
        redirect('dashboard.php');
    } else {
        // Login fallido
        $error_mensaje = $resultado['error'];
        $valores['username'] = $_POST['username'] ?? '';
        
        // Registrar intento fallido
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        registrar_intento_login($_POST['username'] ?? 'unknown', false, $ip);
    }
}

// Determinar qué vista mostrar según el rol
if ($rol === 'admin') {
    // Mostrar login de administrador
    require_once __DIR__ . '/../views/login_admin.php';
} elseif ($rol === 'mecanico') {
    // Mostrar login de mecánico
    require_once __DIR__ . '/../views/login_mecanico.php';
} else {
    // Mostrar selección de rol
    require_once __DIR__ . '/../views/layout/header.php';
    ?>
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .role-selector {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
            overflow: hidden;
            width: 100%;
            max-width: 500px;
            margin: 20px;
        }

        .selector-header {
            background: var(--primary-color);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }

        .selector-title {
            font-size: 2rem;
            font-weight: 300;
            margin-bottom: 10px;
        }

        .selector-subtitle {
            opacity: 0.9;
            font-size: 1rem;
        }

        .role-options {
            padding: 40px 30px;
            display: grid;
            gap: 20px;
        }

        .role-option {
            display: block;
            text-decoration: none;
            color: inherit;
            padding: 25px;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            transition: all 0.3s ease;
            text-align: center;
        }

        .role-option:hover {
            border-color: var(--secondary-color);
            box-shadow: 0 5px 20px rgba(52, 152, 219, 0.1);
            transform: translateY(-2px);
            text-decoration: none;
            color: inherit;
        }

        .role-icon {
            font-size: 3rem;
            margin-bottom: 15px;
        }

        .role-title {
            font-size: 1.4rem;
            font-weight: 600;
            margin-bottom: 10px;
            color: var(--primary-color);
        }

        .role-description {
            color: #666;
            line-height: 1.5;
        }

        .admin-option:hover {
            border-color: #2c3e50;
            box-shadow: 0 5px 20px rgba(44, 62, 80, 0.1);
        }

        .mechanic-option:hover {
            border-color: #27ae60;
            box-shadow: 0 5px 20px rgba(39, 174, 96, 0.1);
        }
    </style>

    <div class="role-selector">
        <div class="selector-header">
            <div style="font-size: 3rem; margin-bottom: 15px;">🚗</div>
            <h1 class="selector-title">MIAUtomotriz</h1>
            <p class="selector-subtitle">Selecciona tu tipo de acceso</p>
        </div>

        <div class="role-options">
            <a href="login.php?rol=admin" class="role-option admin-option">
                <div class="role-icon">👨‍💼</div>
                <div class="role-title">Soy Administrador</div>
                <div class="role-description">
                    Acceso completo al sistema de gestión, reportes y configuración del taller.
                </div>
            </a>

            <a href="login.php?rol=mecanico" class="role-option mechanic-option">
                <div class="role-icon">🔧</div>
                <div class="role-title">Soy Mecánico</div>
                <div class="role-description">
                    Acceso operativo para gestionar reparaciones, inventario y atención a clientes.
                </div>
            </a>
        </div>

        <div style="text-align: center; padding: 20px; border-top: 1px solid #e9ecef; background: #f8f9fa;">
            <div style="margin-bottom: 15px;">
                <strong>¿Eres un cliente?</strong>
            </div>
            <a href="contacto.php" style="color: var(--secondary-color); text-decoration: none;">
                📧 Contáctanos aquí
            </a>
        </div>
    </div>

    <?php
    require_once __DIR__ . '/../views/layout/footer.php';
}