/**
 * dashboard.js - Clase 4
 * 
 * PROPÓSITO:
 * Inicializar todos los gráficos de Chart.js con datos provenientes de PHP.
 * 
 * FUNCIONAMIENTO:
 * 1. PHP ejecuta las consultas SQL y prepara los datos
 * 2. PHP convierte los datos a JSON usando json_encode()
 * 3. JavaScript recibe esos datos en variables globales
 * 4. Chart.js los usa para renderizar los gráficos
 * 
 * BUENAS PRÁCTICAS IMPLEMENTADAS:
 * ✓ Todo el código JS en archivo externo (NO inline en HTML)
 * ✓ DOMContentLoaded para asegurar que el DOM esté listo
 * ✓ Funciones modulares y reutilizables
 * ✓ Comentarios descriptivos
 */

document.addEventListener('DOMContentLoaded', () => {
    // Inicializar todos los gráficos
    inicializarGraficoEstadoVehiculos();
    inicializarGraficoAverias();
    inicializarGraficoIngresos();
    inicializarGraficoRepuestos();
    
    // Configurar filtro de tabla
    configurarFiltroTabla();
});

/**
 * ========================================
 * GRÁFICO 1: Estado de Vehículos (Barras Verticales)
 * ========================================
 * 
 * Muestra cuántos vehículos hay en cada estado.
 * Tipo: Gráfico de barras vertical
 * Datos: Variable global datosEstadoVehiculos
 */
function inicializarGraficoEstadoVehiculos() {
    const ctx = document.getElementById('graficoEstadoVehiculos');
    
    if (!ctx) {
        console.error('Canvas graficoEstadoVehiculos no encontrado');
        return;
    }
    
    // Extraer labels (estados) y valores (cantidades) del array PHP
    const labels = datosEstadoVehiculos.map(item => 
        item.estado.replace('_', ' ').toUpperCase()
    );
    const valores = datosEstadoVehiculos.map(item => parseInt(item.cantidad));
    
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Cantidad de Vehículos',
                data: valores,
                backgroundColor: [
                    'rgba(54, 162, 235, 0.8)',   // Azul
                    'rgba(255, 206, 86, 0.8)',   // Amarillo
                    'rgba(75, 192, 192, 0.8)',   // Verde agua
                    'rgba(255, 99, 132, 0.8)'    // Rojo
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: 'Distribución por Estado'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0 // Solo números enteros
                    }
                }
            }
        }
    });
}

/**
 * ========================================
 * GRÁFICO 2: Averías Más Comunes (Torta/Dona)
 * ========================================
 * 
 * Muestra la distribución porcentual de tipos de averías.
 * Tipo: Gráfico de torta (pie)
 * Datos: Variable global datosAveriasMasComunes
 */
function inicializarGraficoAverias() {
    const ctx = document.getElementById('graficoAverias');
    
    if (!ctx) {
        console.error('Canvas graficoAverias no encontrado');
        return;
    }
    
    const labels = datosAveriasMasComunes.map(item => item.tipo_averia || 'Sin especificar');
    const valores = datosAveriasMasComunes.map(item => parseInt(item.cantidad));
    
    // Paleta de colores variada
    const colores = [
        'rgba(255, 99, 132, 0.8)',
        'rgba(54, 162, 235, 0.8)',
        'rgba(255, 206, 86, 0.8)',
        'rgba(75, 192, 192, 0.8)',
        'rgba(153, 102, 255, 0.8)',
        'rgba(255, 159, 64, 0.8)',
        'rgba(201, 203, 207, 0.8)',
        'rgba(83, 211, 87, 0.8)'
    ];
    
    new Chart(ctx, {
        type: 'doughnut', // Puede cambiar a 'pie' si prefieren torta completa
        data: {
            labels: labels,
            datasets: [{
                label: 'Cantidad',
                data: valores,
                backgroundColor: colores,
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        boxWidth: 15,
                        padding: 10
                    }
                },
                title: {
                    display: true,
                    text: 'Tipos de Fallas Más Frecuentes'
                }
            }
        }
    });
}

/**
 * ========================================
 * GRÁFICO 3: Ingresos Mensuales (Líneas)
 * ========================================
 * 
 * Muestra la evolución de ingresos en los últimos 12 meses.
 * Tipo: Gráfico de líneas
 * Datos: Variable global datosIngresosMensuales
 */
function inicializarGraficoIngresos() {
    const ctx = document.getElementById('graficoIngresos');
    
    if (!ctx) {
        console.error('Canvas graficoIngresos no encontrado');
        return;
    }
    
    const labels = datosIngresosMensuales.map(item => item.mes);
    const valores = datosIngresosMensuales.map(item => parseFloat(item.total));
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Ingresos ($)',
                data: valores,
                fill: true,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 3,
                tension: 0.3, // Curva suave
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true
                },
                title: {
                    display: true,
                    text: 'Evolución de Facturación'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            // Formatear números con separador de miles
                            return '$' + value.toLocaleString('es-CL');
                        }
                    }
                }
            }
        }
    });
}

/**
 * ========================================
 * GRÁFICO 4: Repuestos Más Usados (Barras Horizontales)
 * ========================================
 * 
 * Muestra los repuestos más utilizados en orden descendente.
 * Tipo: Gráfico de barras horizontal
 * Datos: Variable global datosRepuestosMasUsados
 */
function inicializarGraficoRepuestos() {
    const ctx = document.getElementById('graficoRepuestos');
    
    if (!ctx) {
        console.error('Canvas graficoRepuestos no encontrado');
        return;
    }
    
    const labels = datosRepuestosMasUsados.map(item => item.nombre);
    const valores = datosRepuestosMasUsados.map(item => parseInt(item.total_usado));
    
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Unidades Usadas',
                data: valores,
                backgroundColor: 'rgba(255, 159, 64, 0.8)',
                borderColor: 'rgba(255, 159, 64, 1)',
                borderWidth: 2
            }]
        },
        options: {
            indexAxis: 'y', // Esto hace que las barras sean horizontales
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: 'Consumo de Inventario'
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });
}

/**
 * ========================================
 * FUNCIÓN: Filtro de Tabla en Tiempo Real
 * ========================================
 * 
 * Permite buscar en la tabla sin recargar la página.
 * Oculta las filas que no coincidan con el término de búsqueda.
 */
function configurarFiltroTabla() {
    const input = document.getElementById('filtroInput');
    
    if (!input) {
        console.warn('Input de filtro no encontrado');
        return;
    }
    
    input.addEventListener('keyup', (e) => {
        const termino = e.target.value.toLowerCase().trim();
        const filas = document.querySelectorAll('#tablaCuerpo tr');

        filas.forEach(fila => {
            const textoFila = fila.innerText.toLowerCase();
            
            if (textoFila.includes(termino)) {
                fila.style.display = ''; // Mostrar
            } else {
                fila.style.display = 'none'; // Ocultar
            }
        });
    });
}

/**
 * ========================================
 * NOTAS PARA LOS ALUMNOS:
 * ========================================
 * 
 * 1. EXTENSIBILIDAD:
 *    Si quieren agregar más gráficos, sigan este patrón:
 *    - Crear método en DashboardService.php
 *    - Obtener datos en dashboard.php
 *    - Pasar a JS con json_encode
 *    - Crear función inicializar...
 * 
 * 2. TIPOS DE GRÁFICOS DISPONIBLES EN CHART.JS:
 *    - bar: Barras verticales
 *    - line: Líneas
 *    - pie: Torta completa
 *    - doughnut: Dona (torta con hueco)
 *    - radar: Gráfico de radar
 *    - polarArea: Área polar
 * 
 * 3. PERSONALIZACIÓN:
 *    Pueden modificar colores, títulos, leyendas en la sección 'options'
 *    de cada gráfico.
 * 
 * 4. DEBUGGING:
 *    Si un gráfico no aparece:
 *    - Abrir consola del navegador (F12)
 *    - Verificar que las variables datosXXX tengan datos
 *    - Revisar errores de console.error
 */