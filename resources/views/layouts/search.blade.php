<div class="row mb-3">
    <div class="col-md-6">
        <input type="text" id="searchInput" class="form-control" placeholder="Buscar impresora ">
    </div>
</div>

<div id="searchResults" class="mt-3" style="display: none;">
    <div id="noResults" class="alert alert-info" style="display: none;">
        No se encontraron resultados para la búsqueda
    </div>
    <table class="table table-striped w-100">
        <colgroup>
            <col style="width: 15%">
            <col style="width: 15%">
            <col style="width: 15%">
            <col style="width: 12%">
            <col style="width: 12%">
            <col style="width: 8%">
            <col style="width: 23%">
        </colgroup>
        <thead>
            <style>
                .table td,
                .table th {
                    padding: 1rem 1.5rem;
                }

                .table td {
                    white-space: nowrap;
                }

                .table {
                    margin-bottom: 0;
                }

                .table td:last-child {
                    text-align: right;
                }

                .table th:last-child {
                    text-align: right;
                }
            </style>
            <tr>
                <th class="px-3">Tipo</th>
                <th class="px-3">Ubicación</th>
                <th class="px-3">Usuario</th>
                <th class="px-3">Sede</th>
                <th class="px-3">Nº Contrato</th>
                <th class="px-3">Color</th>
                <th class="px-3">Acciones</th>
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
                                        <td class="align-middle">${impresora.tipo}</td>
                                        <td class="align-middle">${impresora.ubicacion}</td>
                                        <td class="align-middle">${impresora.usuario}</td>
                                        <td class="align-middle">${impresora.sede}</td>
                                        <td class="align-middle">${impresora.num_contrato}</td>
                                        <td class="align-middle">${impresora.color ? 'Sí' : 'No'}</td>
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
                                        </td>`

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
