        </div>
    </main>

    <!-- Footer -->
    <footer class="main-footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h4>MIAUtomotriz</h4>
                    <p>Sistema de gestión para talleres mecánicos</p>
                </div>
                
                <div class="footer-section">
                    <h5>Enlaces</h5>
                    <ul class="footer-links">
                        <?php if (is_logged_in()): ?>
                            <li><a href="dashboard.php">Panel Principal</a></li>
                            <li><a href="contacto.php">Contacto</a></li>
                        <?php else: ?>
                            <li><a href="login.php">Iniciar Sesión</a></li>
                            <li><a href="contacto.php">Contacto</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h5>Contacto</h5>
                    <p>Email: info@miautomotriz.cl</p>
                    <p>Teléfono: +56 9 XXXX XXXX</p>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; <?= date('Y') ?> MIAUtomotriz - Proyecto Automotora. Todos los derechos reservados.</p>
                <p class="footer-version">Versión 1.0 - Desarrollo Web PHP</p>
            </div>
        </div>
    </footer>

    <style>
        /* Estilos específicos del footer */
        .main-footer {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--dark-color) 100%);
            color: white;
            margin-top: auto;
            padding: 40px 0 20px;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin-bottom: 30px;
        }

        .footer-section h4,
        .footer-section h5 {
            margin-bottom: 15px;
            font-weight: 600;
        }

        .footer-section h4 {
            font-size: 1.4rem;
            color: var(--secondary-color);
        }

        .footer-section h5 {
            font-size: 1.1rem;
        }

        .footer-section p {
            margin-bottom: 8px;
            opacity: 0.9;
            line-height: 1.6;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 8px;
        }

        .footer-links a {
            color: white;
            text-decoration: none;
            opacity: 0.9;
            transition: opacity 0.3s ease;
        }

        .footer-links a:hover {
            opacity: 1;
            text-decoration: underline;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.2);
            padding-top: 20px;
            text-align: center;
        }

        .footer-bottom p {
            margin-bottom: 5px;
            font-size: 0.9rem;
            opacity: 0.8;
        }

        .footer-version {
            font-size: 0.8rem !important;
            opacity: 0.6 !important;
        }

        /* Responsive del footer */
        @media (max-width: 768px) {
            .footer-content {
                grid-template-columns: 1fr;
                text-align: center;
                gap: 20px;
            }
            
            .main-footer {
                padding: 30px 0 15px;
            }
        }
    </style>

    <!-- JavaScript básico para funcionalidades comunes -->
    <script>
        // Función para mostrar/ocultar alerts automáticamente
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                // Auto-ocultar alerts de éxito después de 5 segundos
                if (alert.classList.contains('alert-success')) {
                    setTimeout(function() {
                        alert.style.opacity = '0';
                        setTimeout(function() {
                            alert.style.display = 'none';
                        }, 500);
                    }, 5000);
                }
            });
        });

        // Función para confirmación de acciones destructivas
        function confirmarAccion(mensaje = '¿Estás seguro de realizar esta acción?') {
            return confirm(mensaje);
        }

        // Función para validación básica de formularios
        function validarFormulario(formId) {
            const form = document.getElementById(formId);
            if (!form) return true;

            const requiredFields = form.querySelectorAll('[required]');
            let esValido = true;

            requiredFields.forEach(function(field) {
                if (!field.value.trim()) {
                    field.classList.add('error');
                    esValido = false;
                } else {
                    field.classList.remove('error');
                }
            });

            return esValido;
        }

        // Añadir clase de error a campos inválidos
        document.addEventListener('DOMContentLoaded', function() {
            const style = document.createElement('style');
            style.textContent = `
                .error {
                    border-color: var(--danger-color) !important;
                    box-shadow: 0 0 0 0.2rem rgba(231, 76, 60, 0.25) !important;
                }
            `;
            document.head.appendChild(style);
        });
    </script>

    <!-- JavaScript adicional específico de cada página -->
    <?php if (isset($js_adicional)): ?>
        <script><?= $js_adicional ?></script>
    <?php endif; ?>

</body>
</html>