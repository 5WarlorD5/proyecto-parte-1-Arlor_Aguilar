/* CONSTANTES DE LA API */
// URL base de la API
const BASE_API_URL = "http://localhost/proyecto-parte-1-Arlor_Aguilar/API/public";

// Endpoints para las diferentes operaciones
const API_URL = `${BASE_API_URL}/prendas`; // Endpoint para operaciones CRUD de prendas
const API_MARCAS = `${BASE_API_URL}/reportes/marcas-con-ventas`; // Endpoint para marcas con ventas
const API_VENDIDAS = `${BASE_API_URL}/reportes/prendas-stock`; // Endpoint para prendas vendidas y stock
const API_TOP_MARCAS = `${BASE_API_URL}/reportes/top5-marcas`; // Endpoint para top 5 marcas
const API_ALL_MARCAS = `${BASE_API_URL}/marcas`; // Endpoint para todas las marcas

/* EVENTO PRINCIPAL */
// Se ejecuta cuando el DOM está completamente cargado
document.addEventListener('DOMContentLoaded', () => {
    // Carga inicial de todos los datos
    cargarPrendas();          // Carga la tabla principal de prendas
    cargarMarcas();           // Carga las marcas con ventas
    cargarVendidas();         // Carga las prendas vendidas y stock
    cargarTopMarcas();        // Carga el top 5 de marcas
    cargarOpcionesMarcas();   // Carga las opciones del select de marcas

    // Asigna el evento submit al formulario de prendas
    document.getElementById('formPrenda').addEventListener('submit', guardarPrenda);
});

/* FUNCIONES DE CARGA (GET) */
/**
 * Carga todas las prendas desde la API y las muestra en la tabla principal
 */
function cargarPrendas() {
    fetch(API_URL)
        .then(response => response.json())
        .then(prendas => {
            const tbody = document.querySelector('#tablaPrendas tbody');
            tbody.innerHTML = ''; // Limpia la tabla
            
            // Por cada prenda, crea una fila en la tabla
            prendas.forEach(prenda => {
                tbody.innerHTML += `
                    <tr>
                        <td>${prenda.id}</td>
                        <td>${prenda.nombre}</td>
                        <td>${prenda.marca_nombre || 'Sin marca'}</td>
                        <td>${prenda.precio}</td>
                        <td>${prenda.stock}</td>
                        <td>
                            <!-- Botones de acciones -->
                            <button class="btn btn-sm btn-outline-primary me-1" onclick="editarPrenda(${prenda.id})" title="Editar">
                                <i class="fas fa-pen"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger" onclick="eliminarPrenda(${prenda.id})" title="Eliminar">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });
        })
        .catch(error => console.error('Error al cargar prendas:', error));
}

/**
 * Carga las marcas que tienen ventas en la tabla correspondiente
 */
function cargarMarcas() {
    fetch(API_MARCAS)
        .then(r => r.json())
        .then(data => {
            const tbody = document.querySelector('#tablaMarcas tbody');
            tbody.innerHTML = '';
            data.forEach(m => {
                tbody.innerHTML += `<tr><td>${m.nombre}</td></tr>`;
            });
        })
        .catch(error => console.error('Error al cargar marcas con ventas:', error));
}

/**
 * Carga las prendas vendidas y el stock restante
 */
function cargarVendidas() {
    fetch(API_URL)
        .then(res => res.json())
        .then(prendas => {
            fetch(API_VENDIDAS)
                .then(r => r.json())
                .then(stockRestante => {
                    const tbody = document.querySelector('#tablaVendidas tbody');
                    tbody.innerHTML = '';
                    
                    // Combina datos de prendas originales con stock restante
                    stockRestante.forEach(prendaRestante => {
                        const prendaOriginal = prendas.find(p => p.id === prendaRestante.id);
                        // Calcula cuántas se vendieron (stock original - stock restante)
                        const vendidas = prendaOriginal
                            ? prendaOriginal.stock - parseInt(prendaRestante.stock_restante)
                            : 'Desconocido';
                        const stock = prendaRestante.stock_restante;

                        tbody.innerHTML += `
                            <tr>
                                <td>${prendaRestante.nombre}</td>
                                <td>${vendidas}</td>
                                <td>${stock}</td>
                            </tr>
                        `;
                    });
                });
        })
        .catch(error => console.error('Error al cargar prendas vendidas y stock:', error));
}

/**
 * Carga el top 5 de marcas por ventas
 */
function cargarTopMarcas() {
    fetch(API_TOP_MARCAS)
        .then(r => r.json())
        .then(data => {
            const tbody = document.querySelector('#tablaTopMarcas tbody');
            tbody.innerHTML = '';
            data.forEach(i => {
                tbody.innerHTML += `
                    <tr>
                        <td>${i.nombre}</td>
                        <td>${i.total_ventas ?? i.ventas}</td>
                    </tr>
                `;
            });
        })
        .catch(error => console.error('Error al cargar top marcas:', error));
}

/* FUNCIONES AUXILIARES */
/**
 * Prepara el formulario para agregar una nueva prenda
 * - Limpia el formulario
 * - Restablece el ID (para indicar que es nueva)
 * - Actualiza los textos del modal
 */
function prepararFormularioAgregar() {
    document.getElementById('formPrenda').reset();
    document.getElementById('idPrenda').value = '';
    document.getElementById('modalPrendaLabel').textContent = 'Agregar Prenda';
    document.getElementById('btnSubmit').textContent = 'Guardar';
}

/**
 * Carga los datos de una prenda para editarla
 * @param {number} id - ID de la prenda a editar
 */
function editarPrenda(id) {
    fetch(`${API_URL}/${id}`)
      .then(res => res.json())
      .then(p => {
        // Actualiza el título y botón del modal
        document.getElementById('modalPrendaLabel').textContent = 'Editar Prenda';
        document.getElementById('btnSubmit').textContent = 'Actualizar';
  
        // Rellena el formulario con los datos de la prenda
        document.getElementById('idPrenda').value = p.id;
        document.getElementById('nombre').value = p.nombre;
        document.getElementById('marca').value = p.marca_nombre;
        document.getElementById('nuevaMarca').value = '';
        document.getElementById('precio').value = p.precio;
        document.getElementById('stock').value = p.stock;
  
        // Muestra el modal
        const modal = new bootstrap.Modal(document.getElementById('modalPrenda'));
        modal.show();
      })
      .catch(error => {
        console.error("Error al obtener prenda:", error);
        alert("No se pudo cargar la prenda para editar.");
      });
}

/**
 * Carga todas las marcas en el select del formulario
 */
function cargarOpcionesMarcas() {
    fetch(API_ALL_MARCAS)
        .then(r => r.json())
        .then(marcas => {
            const select = document.getElementById('marca');
            if (!select) return;
            
            // Guarda el valor actual para restaurarlo después
            const valorActual = select.value;
            select.innerHTML = '';
            
            // Agrega cada marca como opción
            marcas.forEach(m => {
                const option = document.createElement('option');
                option.value = m.nombre;
                option.textContent = m.nombre;
                select.appendChild(option);
            });
            
            // Restaura el valor seleccionado si existía
            if (valorActual) select.value = valorActual;
        });
}

/* FUNCIONES CRUD */
/**
 * Guarda una prenda (nueva o editada) en la base de datos
 * @param {Event} e - Evento del formulario
 */
function guardarPrenda(e) {
    e.preventDefault(); // Evita el envío tradicional del formulario

    // Obtiene los valores del formulario
    const id = document.getElementById('idPrenda').value;
    const nombre = document.getElementById('nombre').value;
    const selectMarca = document.getElementById('marca').value;
    const nuevaMarcaInput = document.getElementById('nuevaMarca').value.trim();
    // Prioriza la nueva marca si se especificó
    const nombreMarcaFinal = nuevaMarcaInput || selectMarca;
    const precio = parseFloat(document.getElementById('precio').value);
    const stock = parseInt(document.getElementById('stock').value);

    // Primero verifica si la marca ya existe
    fetch(API_ALL_MARCAS)
        .then(res => res.json())
        .then(marcas => {
            const marcaExistente = marcas.find(m => m.nombre.toLowerCase() === nombreMarcaFinal.toLowerCase());
            
            if (marcaExistente) {
                // Si la marca existe, envía la prenda con el ID de la marca existente
                enviarPrenda(id, nombre, marcaExistente.id, precio, stock);
            } else {
                // Si la marca no existe, primero la crea
                fetch(API_ALL_MARCAS, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ nombre: nombreMarcaFinal })
                })
                .then(res => res.json())
                .then(data => {
                    const nuevaMarcaId = data.id;
                    cargarOpcionesMarcas(); // Actualiza el select de marcas
                    enviarPrenda(id, nombre, nuevaMarcaId, precio, stock);
                });
            }
        });
}

/**
 * Envía la prenda a la API para guardarla (POST para nueva, PUT para edición)
 * @param {number|null} id - ID de la prenda (null si es nueva)
 * @param {string} nombre - Nombre de la prenda
 * @param {number} id_marca - ID de la marca
 * @param {number} precio - Precio de la prenda
 * @param {number} stock - Cantidad en stock
 */
function enviarPrenda(id, nombre, id_marca, precio, stock) {
    const prenda = { nombre, id_marca, precio, stock };
    const url = id ? `${API_URL}/${id}` : API_URL; // URL depende si es edición o nueva
    const method = id ? 'PUT' : 'POST'; // Método HTTP depende si es edición o nueva
  
    fetch(url, {
      method,
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(prenda)
    })
      .then(res => {
        if (!res.ok) throw new Error('Error al guardar');
        return res.json();
      })
      .then(() => {
        // Recarga todas las listas después de guardar
        cargarPrendas();
        cargarVendidas();
        cargarMarcas();
        cargarTopMarcas();
  
        // Cierra el modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('modalPrenda'));
        modal.hide();
      })
      .catch(error => {
        console.error('Error al guardar prenda:', error);
        alert('No se pudo guardar la prenda.');
      });
}

/**
 * Elimina una prenda después de confirmación
 * @param {number} id - ID de la prenda a eliminar
 */
function eliminarPrenda(id) {
    if (confirm('¿Eliminar esta prenda?')) {
      fetch(`${API_URL}/${id}`, { method: 'DELETE' })
        .then(res => {
          if (!res.ok) throw new Error("No se pudo eliminar");
          return res.json();
        })
        .then(() => {
          alert('Prenda eliminada exitosamente');
          // Recarga todas las listas después de eliminar
          cargarPrendas();
          cargarVendidas();
          cargarMarcas();
          cargarTopMarcas();
        })
        .catch(error => {
          console.error('Error al eliminar prenda:', error);
          alert('No se pudo eliminar la prenda.');
        });
    }
}