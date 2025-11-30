<?php
require_once __DIR__ . '/../app/helpers.php';

// Configuración de la página
$titulo = 'Login Administrador';
$css_adicional = '
    :root {
        --login-primary: #2c3e50;
        --login-secondary: #34495e;
        --login-accent: #3498db;
        --login-bg: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
    }

    body {
        background: var(--login-bg);
        background-attachment: fixed;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .login-container {
        background: white;
        border-radius: 15px;
        box-shadow: 0 20px 60px rgba(44, 62, 80, 0.3);
        overflow: hidden;
        width: 100%;
        max-width: 400px;
        margin: 20px;
    }

    .login-header {
        background: var(--login-primary);
        color: white;
        padding: 30px 20px;
        text-align: center;
        position: relative;
    }

    .login-header::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.1) 50%, transparent 70%);
    }

    .login-header h1 {
        font-size: 1.8rem;
        font-weight: 300;
        margin-bottom: 10px;
    }

    .login-subtitle {
        opacity: 0.9;
        font-size: 0.95rem;
    }

    .role-badge {
        background: var(--login-accent);
        color: white;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.8rem;
        margin-top: 10px;
        display: inline-block;
    }

    .login-form {
        padding: 40px 30px;
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: var(--login-primary);
        font-size: 0.95rem;
    }

    .form-control {
        width: 100%;
        padding: 15px;
        border: 2px solid #e0e6ed;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #f8f9fa;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--login-accent);
        box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        background: white;
    }

    .btn-login {
        width: 100%;
        padding: 15px;
        background: var(--login-primary);
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 10px;
    }

    .btn-login:hover {
        background: var(--login-secondary);
        transform: translateY(-1px);
        box-shadow: 0 5px 15px rgba(44, 62, 80, 0.3);
    }

    .login-footer {
        background: #f8f9fa;
        padding: 20px 30px;
        text-align: center;
        border-top: 1px solid #e9ecef;
    }

    .back-link {
        color: var(--login-primary);
        text-decoration: none;
        font-size: 0.9rem;
    }

    .back-link:hover {
        text-decoration: underline;
    }

    .error-message {
        background: #f8d7da;
        color: #721c24;
        padding: 15px;
        border-radius: 6px;
        margin-bottom: 20px;
        border: 1px solid #f5c6cb;
        font-size: 0.95rem;
    }

    .admin-icon {
        font-size: 3rem;
        margin-bottom: 10px;
        opacity: 0.8;
    }
';

require_once __DIR__ . '/layout/header.php';
?>

<div class="login-container">
    <div class="login-header">
        <div class="admin-icon">👨‍💼</div>
        <h1>Panel de Administración</h1>
        <p class="login-subtitle">Acceso para administradores del sistema</p>
        <span class="role-badge">ADMINISTRADOR</span>
    </div>

    <form method="POST" class="login-form">
        <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
        
        <?php if (isset($error_mensaje)): ?>
            <div class="error-message">
                <?= h($error_mensaje) ?>
            </div>
        <?php endif; ?>

        <div class="form-group">
            <label for="username">Usuario Administrador</label>
            <input 
                type="text" 
                id="username" 
                name="username" 
                class="form-control" 
                placeholder="Ingrese su usuario"
                value="<?= h($valores['username'] ?? '') ?>"
                required 
                autocomplete="username"
            >
        </div>

        <div class="form-group">
            <label for="password">Contraseña</label>
            <input 
                type="password" 
                id="password" 
                name="password" 
                class="form-control" 
                placeholder="Ingrese su contraseña"
                required 
                autocomplete="current-password"
            >
        </div>

        <button type="submit" class="btn-login">
            Acceder al Sistema
        </button>
    </form>

    <div class="login-footer">
        <a href="login.php" class="back-link">← Volver a selección de rol</a>
        
        <!-- Información para desarrollo -->
        <div style="margin-top: 15px; padding: 10px; background: #e3f2fd; border-radius: 5px; font-size: 0.8rem; color: #1565c0;">
            <strong>Usuario de prueba:</strong><br>
            Usuario: <code>admin_demo</code><br>
            Contraseña: <code>admin123</code>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/layout/footer.php'; ?>