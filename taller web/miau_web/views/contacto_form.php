<?php
require_once __DIR__ . '/../app/helpers.php';

// Configuración de la página
$titulo = 'Contacto';
$pagina_actual = 'contacto';
$mostrar_navegacion = is_logged_in();

$css_adicional = '
    .contact-container {
        max-width: 600px;
        margin: 0 auto;
    }

    .contact-form {
        background: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: var(--primary-color);
        font-size: 0.95rem;
    }

    .required {
        color: var(--danger-color);
    }

    .form-control {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #f8f9fa;
        box-sizing: border-box;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--secondary-color);
        box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
        background: white;
    }

    .form-control.error {
        border-color: var(--danger-color);
        box-shadow: 0 0 0 3px rgba(231, 76, 60, 0.1);
        background: #fff5f5;
    }

    .error-message {
        color: var(--danger-color);
        font-size: 0.85rem;
        margin-top: 5px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .success-message {
        background: #d4edda;
        color: #155724;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        border: 1px solid #c3e6cb;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-message {
        background: #f8d7da;
        color: #721c24;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        border: 1px solid #f5c6cb;
    }

    textarea.form-control {
        min-height: 120px;
        resize: vertical;
    }

    .btn-submit {
        background: var(--secondary-color);
        color: white;
        padding: 12px 30px;
        border: none;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 100%;
    }

    .btn-submit:hover:not(:disabled) {
        background: var(--primary-color);
        transform: translateY(-1px);
        box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
    }

    .btn-submit:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }

    .contact-info {
        background: white;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        margin-bottom: 30px;
    }

    .contact-info h3 {
        color: var(--primary-color);
        margin-bottom: 20px;
        font-size: 1.4rem;
    }

    .contact-item {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 15px;
        padding: 10px;
        border-radius: 8px;
        background: #f8f9fa;
    }

    .contact-icon {
        width: 40px;
        height: 40px;
        background: var(--secondary-color);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }

    .contact-details {
        flex: 1;
    }

    .contact-label {
        font-weight: 600;
        color: var(--primary-color);
        font-size: 0.9rem;
        margin-bottom: 2px;
    }

    .contact-value {
        color: #666;
        font-size: 0.95rem;
    }

    .form-help {
        background: #e3f2fd;
        border: 1px solid #bbdefb;
        border-radius: 6px;
        padding: 15px;
        margin-bottom: 20px;
        color: #1565c0;
        font-size: 0.9rem;
    }

    .char-counter {
        text-align: right;
        font-size: 0.8rem;
        color: #666;
        margin-top: 5px;
    }

    .char-counter.warning {
        color: var(--warning-color);
    }

    .char-counter.error {
        color: var(--danger-color);
    }
';

require_once __DIR__ . '/layout/header.php';
?>

<div class="content-wrapper">
    <div class="contact-container">
        <div class="page-title">📧 Contacto</div>
        
        <!-- Información de contacto -->
        <div class="contact-info">
            <h3>Información de Contacto</h3>
            <div class="contact-item">
                <div class="contact-icon">📍</div>
                <div class="contact-details">
                    <div class="contact-label">Dirección</div>
                    <div class="contact-value">Av. Principal 1234, Santiago, Chile</div>
                </div>
            </div>
            <div class="contact-item">
                <div class="contact-icon">📞</div>
                <div class="contact-details">
                    <div class="contact-label">Teléfono</div>
                    <div class="contact-value">+56 9 XXXX XXXX</div>
                </div>
            </div>
            <div class="contact-item">
                <div class="contact-icon">✉️</div>
                <div class="contact-details">
                    <div class="contact-label">Email</div>
                    <div class="contact-value">info@miautomotriz.cl</div>
                </div>
            </div>
            <div class="contact-item">
                <div class="contact-icon">🕐</div>
                <div class="contact-details">
                    <div class="contact-label">Horario de Atención</div>
                    <div class="contact-value">Lunes a Viernes: 8:00 - 18:00<br>Sábados: 8:00 - 13:00</div>
                </div>
            </div>
        </div>

        <!-- Formulario de contacto -->
        <div class="contact-form">
            <h3 style="margin-bottom: 20px; color: var(--primary-color);">Envíanos un Mensaje</h3>
            
            <div class="form-help">
                💡 <strong>Tip:</strong> Para consultas urgentes o emergencias mecánicas, te recomendamos llamar directamente a nuestro teléfono.
            </div>

            <!-- Mostrar mensaje de éxito -->
            <?php if (isset($exito) && $exito): ?>
                <div class="success-message">
                    ✅ <strong>¡Mensaje enviado exitosamente!</strong> Te contactaremos pronto.
                </div>
            <?php endif; ?>

            <!-- Mostrar mensaje de error general -->
            <?php if (isset($mensaje_error) && $mensaje_error): ?>
                <div class="form-message">
                    ⚠️ <?= h($mensaje_error) ?>
                </div>
            <?php endif; ?>

            <form method="POST" id="contactForm" novalidate>
                <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">

                <div class="form-group">
                    <label for="nombre">
                        Nombre completo <span class="required">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="nombre" 
                        name="nombre" 
                        class="form-control <?= isset($errores['nombre']) ? 'error' : '' ?>" 
                        value="<?= h($valores['nombre'] ?? '') ?>"
                        placeholder="Ingresa tu nombre completo"
                        maxlength="100"
                        required
                    >
                    <?php if (isset($errores['nombre'])): ?>
                        <div class="error-message">
                            ⚠️ <?= h($errores['nombre']) ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="email">
                        Correo electrónico <span class="required">*</span>
                    </label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="form-control <?= isset($errores['email']) ? 'error' : '' ?>" 
                        value="<?= h($valores['email'] ?? '') ?>"
                        placeholder="tu@email.com"
                        maxlength="150"
                        required
                    >
                    <?php if (isset($errores['email'])): ?>
                        <div class="error-message">
                            ⚠️ <?= h($errores['email']) ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="mensaje">
                        Mensaje <span class="required">*</span>
                    </label>
                    <textarea 
                        id="mensaje" 
                        name="mensaje" 
                        class="form-control <?= isset($errores['mensaje']) ? 'error' : '' ?>" 
                        placeholder="Describe tu consulta, problema o solicitud de cotización..."
                        maxlength="1000"
                        required
                    ><?= h($valores['mensaje'] ?? '') ?></textarea>
                    <div class="char-counter">
                        <span id="charCount">0</span>/1000 caracteres
                    </div>
                    <?php if (isset($errores['mensaje'])): ?>
                        <div class="error-message">
                            ⚠️ <?= h($errores['mensaje']) ?>
                        </div>
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn-submit" id="submitBtn">
                    📤 Enviar Mensaje
                </button>
            </form>
        </div>

        <?php if (is_logged_in()): ?>
            <div class="text-center mt-20">
                <a href="dashboard.php" class="btn-primary">← Volver al Panel</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
$js_adicional = '
    // Contador de caracteres para el mensaje
    const mensajeTextarea = document.getElementById("mensaje");
    const charCounter = document.getElementById("charCount");
    
    function updateCharCount() {
        const currentLength = mensajeTextarea.value.length;
        charCounter.textContent = currentLength;
        
        const counterElement = charCounter.parentElement;
        counterElement.classList.remove("warning", "error");
        
        if (currentLength > 800) {
            counterElement.classList.add("warning");
        }
        if (currentLength >= 1000) {
            counterElement.classList.add("error");
        }
    }
    
    mensajeTextarea.addEventListener("input", updateCharCount);
    
    // Inicializar contador
    updateCharCount();
    
    // Validación del formulario en tiempo real
    const form = document.getElementById("contactForm");
    const inputs = form.querySelectorAll("input, textarea");
    
    inputs.forEach(input => {
        input.addEventListener("blur", function() {
            validateField(this);
        });
        
        input.addEventListener("input", function() {
            if (this.classList.contains("error")) {
                validateField(this);
            }
        });
    });
    
    function validateField(field) {
        const value = field.value.trim();
        const fieldName = field.name;
        
        // Limpiar errores previos
        field.classList.remove("error");
        const errorElement = field.parentElement.querySelector(".error-message");
        if (errorElement && !errorElement.textContent.includes("⚠️")) {
            errorElement.remove();
        }
        
        let isValid = true;
        let errorMessage = "";
        
        // Validaciones específicas
        switch(fieldName) {
            case "nombre":
                if (!value) {
                    isValid = false;
                    errorMessage = "El nombre es obligatorio.";
                } else if (value.length < 2) {
                    isValid = false;
                    errorMessage = "El nombre debe tener al menos 2 caracteres.";
                }
                break;
                
            case "email":
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!value) {
                    isValid = false;
                    errorMessage = "El correo electrónico es obligatorio.";
                } else if (!emailRegex.test(value)) {
                    isValid = false;
                    errorMessage = "El formato del correo electrónico no es válido.";
                }
                break;
                
            case "mensaje":
                if (!value) {
                    isValid = false;
                    errorMessage = "El mensaje es obligatorio.";
                } else if (value.length < 10) {
                    isValid = false;
                    errorMessage = "El mensaje debe tener al menos 10 caracteres.";
                }
                break;
        }
        
        if (!isValid) {
            field.classList.add("error");
            if (!field.parentElement.querySelector(".error-message")) {
                const errorDiv = document.createElement("div");
                errorDiv.className = "error-message";
                errorDiv.innerHTML = "⚠️ " + errorMessage;
                field.parentElement.appendChild(errorDiv);
            }
        }
        
        return isValid;
    }
    
    // Prevenir envío si hay errores
    form.addEventListener("submit", function(e) {
        let formIsValid = true;
        
        inputs.forEach(input => {
            if (!validateField(input)) {
                formIsValid = false;
            }
        });
        
        if (!formIsValid) {
            e.preventDefault();
            
            // Enfocar el primer campo con error
            const firstError = form.querySelector(".form-control.error");
            if (firstError) {
                firstError.focus();
            }
        } else {
            // Deshabilitar botón para evitar doble envío
            const submitBtn = document.getElementById("submitBtn");
            submitBtn.disabled = true;
            submitBtn.textContent = "Enviando...";
        }
    });
';

require_once __DIR__ . '/layout/footer.php';
?>