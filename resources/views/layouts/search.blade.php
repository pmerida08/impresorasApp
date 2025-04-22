<div class="row mb-3">
    <div class="col-md-6">
        <input type="text" id="searchInput" class="form-control" placeholder="Buscar impresora ">
    </div>
</div>

<div id="searchResults" class="mt-3" style="display: none;">
    <div id="noResults" class="alert alert-info" style="display: none;">
        No se encontraron resultados para la búsqueda
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Tipo</th>
                <th>Ubicación</th>
                <th>Usuario</th>
                <th>Observaciones</th>
                <th>Nombre Reserva DHCP</th>
                <th>Nombre Cola HACOS</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="searchResultsBody">
        </tbody>
    </table>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const searchResults = document.getElementById('searchResults');
        const searchResultsBody = document.getElementById('searchResultsBody');
        const noResults = document.getElementById('noResults');
        let searchTimeout;

        // Function to handle delete confirmation
        function confirmDelete(event) {
            event.preventDefault();
            if (confirm('¿Está seguro que desea eliminar esta impresora?')) {
                event.target.submit();
            }
        }

        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value.trim();

            if (query.length === 0) {
                searchResults.style.display = 'none';
                noResults.style.display = 'none';
                return;
            }

            searchTimeout = setTimeout(() => {
                if (query.length >= 2) {
                    fetch(`/impresoras/buscar?q=${encodeURIComponent(query)}`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Error en la búsqueda');
                            }
                            return response.json();
                        })
                        .then(data => {
                            searchResultsBody.innerHTML = '';
                            searchResults.style.display = 'block';

                            if (data.length > 0) {
                                noResults.style.display = 'none';
                                data.forEach(impresora => {
                                    const row = document.createElement('tr');
                                    row.innerHTML = `
                                        <td>${impresora.tipo}</td>
                                        <td>${impresora.ubicacion}</td>
                                        <td>${impresora.usuario}</td>
                                        <td>${impresora.observaciones}</td>
                                        <td>${impresora.nombre_reserva_dhcp}</td>
                                        <td>${impresora.nombre_cola_hacos}</td>
                                        <td>
                                            
                                                <a href="/impresoras/${impresora.id}" class="btn btn-primary btn-sm" title="Ver detalles">
                                                    <i class="fa fa-fw fa-eye"></i>
                                                    Ver detalles
                                                </a>
                                                <a href="/impresoras/${impresora.id}/edit" class="btn btn-secondary btn-sm" title="Editar">
                                                    <i class="fa fa-fw fa-edit"></i>
                                                    Editar
                                                </a>
                                                <form action="/impresoras/${impresora.id}" method="POST" style="display: inline;" onsubmit="return confirmDelete(event);">
                                                    <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                                                        <i class="fa fa-fw fa-trash"></i>
                                                        Eliminar
                                                    </button>
                                                </form>
                                          
                                        </td>
                                    `;
                                    searchResultsBody.appendChild(row);
                                });
                            } else {
                                noResults.style.display = 'block';
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            searchResults.style.display = 'none';
                            noResults.style.display = 'none';
                        });
                } else {
                    searchResults.style.display = 'none';
                    noResults.style.display = 'none';
                }
            }, 300);
        });
    });
</script>
