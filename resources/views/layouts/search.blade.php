<div class="row mb-3">
    <div class="col-md-6">
        <input type="text" id="searchInput" class="form-control" placeholder="Buscar impresora por modelo...">
    </div>
</div>

<div id="searchResults" class="mt-3" style="display: none;">
    <div id="noResults" class="alert alert-info" style="display: none;">
        No se encontraron resultados para la búsqueda
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Modelo</th>
                <th>Copias/día</th>
                <th>Copias/mes</th>
                <th>Copias/año</th>
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
                                searchResultsBody.innerHTML += `
                                    <tr>
                                        <td>${impresora.modelo}</td>
                                        <td>${impresora.copias_dia || 0}</td>
                                        <td>${impresora.copias_mes || 0}</td>
                                        <td>${impresora.copias_anio || 0}</td>
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
