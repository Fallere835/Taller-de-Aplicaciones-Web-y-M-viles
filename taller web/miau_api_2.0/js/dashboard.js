// js/dashboard.js
document.addEventListener('DOMContentLoaded', () => {
    cargarGrafico();
    configurarFiltroTabla();
});

// 1. Cargar Gráfico con Fetch
function cargarGrafico() {
    fetch('../api/reparaciones.php?action=chart')
        .then(res => res.json())
        .then(datos => {
            const estados = datos.map(d => d.estado);
            const cantidades = datos.map(d => d.cantidad);

            const ctx = document.getElementById('miGrafico').getContext('2d');
            new Chart(ctx, {
                type: 'bar', // O 'pie', 'doughnut'
                data: {
                    labels: estados,
                    datasets: [{
                        label: 'Vehículos por Estado',
                        data: cantidades,
                        backgroundColor: ['#007bff', '#28a745', '#dc3545', '#ffc107']
                    }]
                }
            });
        });
}

// 2. Filtro Interactivo (Sin recargar página)
function configurarFiltroTabla() {
    const input = document.getElementById('filtroInput');
    
    input.addEventListener('keyup', (e) => {
        const termino = e.target.value.toLowerCase();
        const filas = document.querySelectorAll('#tablaReparaciones tbody tr');

        filas.forEach(fila => {
            const textoFila = fila.innerText.toLowerCase();
            if (textoFila.includes(termino)) {
                fila.classList.remove('fila-oculta');
            } else {
                fila.classList.add('fila-oculta');
            }
        });
    });
}