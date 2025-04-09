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
            </tr>
        </thead>
        <tbody id="searchResultsBody">
        </tbody>
    </table>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');
        const searchResults = document.getElementById('searchResults');
        const searchResultsBody = document.getElementById('searchResultsBody');
        const noResults = document.getElementById('noResults');
        let searchTimeout;

        searchInput.addEventListener('input', function () {
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
                                    searchResultsBody.innerHTML += `
                                    <tr>
                                        <td>${impresora.tipo}</td>
                                        <td>${impresora.ubicacion}</td>
                                        <td>${impresora.usuario}</td>
                                        <td>${impresora.observaciones}</td>
                                        <td>${impresora.nombre_reserva_dhcp}</td>
                                        <td>${impresora.nombre_cola_hacos}</td>
                                    </tr>
                                `;
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