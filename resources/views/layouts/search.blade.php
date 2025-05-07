<div class="row mb-3">
    <div class="col-md-6 d-flex">
        <input type="text" id="searchInput" class="form-control" placeholder="Buscar impresora">
        <button class="btn btn-secondary ms-2 d-flex align-items-center" type="button" data-bs-toggle="collapse"
            data-bs-target="#filterCollapse" aria-expanded="false" aria-controls="filterCollapse">
            <i class="bi bi-funnel me-2"></i> Filtrar
        </button>
    </div>


    <div class="collapse mt-2" id="filterCollapse">
        <div class="card card-body">
            <div class="d-flex flex-wrap">
                <div class="form-check me-3">
                    <input class="form-check-input" type="radio" name="filter" id="filterTipo" value="tipo"
                        checked>
                    <label class="form-check-label" for="filterTipo">Tipo</label>
                </div>

                <div class="form-check me-3">
                    <input class="form-check-input" type="radio" name="filter" id="filterUbicacion"
                        value="ubicacion">
                    <label class="form-check-label" for="filterUbicacion">Ubicación</label>
                </div>

                <div class="form-check me-3">
                    <input class="form-check-input" type="radio" name="filter" id="filterIP" value="ip">
                    <label class="form-check-label" for="filterIP">IP</label>
                </div>

                <div class="form-check me-3">
                    <input class="form-check-input" type="radio" name="filter" id="filterUsuario" value="usuario">
                    <label class="form-check-label" for="filterUsuario">Usuario</label>
                </div>

                <div class="form-check me-3">
                    <input class="form-check-input" type="radio" name="filter" id="filterSede" value="sede_rcja">
                    <label class="form-check-label" for="filterSede">Sede RCJA</label>
                </div>

                <div class="form-check me-3">
                    <input class="form-check-input" type="radio" name="filter" id="filterOrganismo"
                        value="organismo">
                    <label class="form-check-label" for="filterOrganismo">Organismo</label>
                </div>

                <div class="form-check me-3">
                    <input class="form-check-input" type="radio" name="filter" id="filterContrato" value="contrato">
                    <label class="form-check-label" for="filterContrato">Contrato</label>
                </div>

                <div class="form-check me-3">
                    <input class="form-check-input" type="radio" name="filter" id="filterNumSerie" value="num_serie">
                    <label class="form-check-label" for="filterNumSerie">Nº de serie</label>
                </div>

                <div class="form-check me-3">
                    <input class="form-check-input" type="radio" name="filter" id="filterColor" value="color">
                    <label class="form-check-label" for="filterColor">Color</label>
                </div>

                {{-- <div class="form-check me-3">
                    <input class="form-check-input" type="radio" name="filter" id="filterActivo" value="activo">
                    <label class="form-check-label" for="filterActivo">Activo</label>
                </div> --}}
            </div>
            <div class="mt-2">
                <strong>Filtro activo:</strong> <span id="activeFilterLabel">Tipo</span>
            </div>
        </div>
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

                .table td:last-child,
                .table th:last-child {
                    text-align: right;
                }

                .estado-circle {
                    display: inline-block;
                    width: 12px;
                    height: 12px;
                    border-radius: 50%;
                    background-color: gray;
                }

                .estado-circle.activo {
                    background-color: #28a745;
                    /* verde */
                }

                .estado-circle.inactivo {
                    background-color: #dc3545;
                    /* rojo */
                }
            </style>
            <tr>
                <th class="px-3">Tipo</th>
                <th class="px-3">Ubicación</th>
                <th class="px-3">IP</th>
                <th class="px-3">Usuario</th>
                <th class="px-3">Sede RCJA</th>
                <th class="px-3">Organismo</th>
                <th class="px-3">Contrato</th>
                <th class="px-3">Nº de serie</th>
                <th class="px-3">Color</th>
                <th class="px-3">Activo</th>
                <th class="px-3">Acciones</th>
            </tr>
        </thead>
        <tbody id="searchResultsBody"></tbody>
    </table>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const searchResults = document.getElementById('searchResults');
        const searchResultsBody = document.getElementById('searchResultsBody');
        const noResults = document.getElementById('noResults');
        const filterRadios = document.querySelectorAll('input[name="filter"]');

        let searchTimeout;
        let currentFilter = 'tipo';

        function updateActiveFilterLabel(value) {
            const selectedFilter = document.querySelector(`input[value="${value}"]`);
            if (selectedFilter) {
                activeFilterLabel.textContent = selectedFilter.nextElementSibling.textContent;
            }
        }

        function confirmDelete(event) {
            event.preventDefault();
            if (confirm('¿Está seguro que desea eliminar esta impresora?')) {
                event.target.submit();
            }
        }

        function performSearch() {
            const query = searchInput.value.trim();

            if (query.length === 0) {
                searchResults.style.display = 'none';
                noResults.style.display = 'none';
                return;
            }

            if (query.length !== 0) {
                fetch(
                        `/impresoras/buscar?q=${encodeURIComponent(query)}&f=${encodeURIComponent(currentFilter)}`
                    )
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
                                    <td class="align-middle">${impresora.tipo ?? ""}</td>
                                    <td class="align-middle">${impresora.ubicacion ?? ""}</td>
                                    <td class="align-middle">${impresora.ip ?? ""}</td>
                                    <td class="align-middle">${impresora.usuario ?? ""}</td>
                                    <td class="align-middle">${impresora.sede_rcja ?? ""}</td>
                                    <td class="align-middle">${impresora.organismo ?? ""}</td>
                                    <td class="align-middle">${impresora.contrato ?? ""}</td>
                                    <td class="align-middle">${impresora.num_serie ?? "No registrado"}</td>
                                    <td class="align-middle">${impresora.color ? 'Sí' : 'No'}</td>
                                    <td class="px-3 text-center">
                                                <span class="estado-circle ${impresora.activo ? 'activo' : 'inactivo'}" title="${impresora.activo ? 'activo' : 'inactivo'}">
                                                </span>
                                    </td>
                                    <td>
                                        ${impresora.activo ? `
                                        <a href="/impresoras/${impresora.id}" class="btn btn-primary btn-sm" title="Ver detalles">
                                        <i class="fa fa-fw fa-eye"></i> Ver detalles
                                        </a>` : ''}
                                        
                                        <a href="/impresoras/${impresora.id}/edit" class="btn btn-secondary btn-sm" title="Editar">
                                            <i class="fa fa-fw fa-edit"></i> Editar
                                        </a>
                                        <form action="/impresoras/${impresora.id}" method="POST" style="display: inline;" onsubmit="return confirmDelete(event);">
                                            <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                                                <i class="fa fa-fw fa-trash"></i> Eliminar
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
        }

        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(performSearch, 300);
        });

        filterRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                currentFilter = this.value;
                updateActiveFilterLabel(this.value);
                performSearch();
            });
        });
    });
</script>
