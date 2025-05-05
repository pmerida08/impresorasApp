<?php

namespace App\Http\Controllers;

use App\Models\Impresora;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ImpresoraRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class ImpresoraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $impresoras = Impresora::paginate(15);

        return view('impresora.index', compact('impresoras'))
            ->with('i', ($request->input('page', 1) - 1) * $impresoras->perPage())
            ->with('pagination', 'pagination::bootstrap-5');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $impresora = new Impresora();

        return view('impresora.create', compact('impresora'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ImpresoraRequest $request): RedirectResponse
    {
        Impresora::create($request->validated());

        return Redirect::route('impresoras.index')
            ->with('success', 'Impresora creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $impresora = Impresora::find($id);

        return view('impresora.show', compact('impresora'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $impresora = Impresora::find($id);

        return view('impresora.edit', compact('impresora'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ImpresoraRequest $request, Impresora $impresora): RedirectResponse
    {
        $impresora->update($request->validated());

        var_dump($request->validated());

        return Redirect::route('impresoras.index')
            ->with('success', 'Impresora actualizada correctamente.');
    }

    public function buscar(Request $request)
    {
        $filter = $request->input('f');
        $query = $request->input('q');
        $sanitizedQuery = str_replace('%', '', $query);

        // Lista de filtros permitidos
        $allowedFilters = ['tipo', 'ubicacion', 'ip', 'usuario', 'sede_rcja', 'organismo', 'contrato', 'color', 'num_serie'];

        if (!in_array($filter, $allowedFilters)) {
            return response()->json([], 400);
        }

        $impresoras = Impresora::query();

        if ($filter === 'color') {
            $impresoras->where('color', 1);
        } elseif ($filter === 'bw') {
            $impresoras->where('color', 0);
        } else {
            $impresoras->where($filter, 'LIKE', '%' . $sanitizedQuery . '%');
        }

        $result = $impresoras->select('id', 'tipo', 'ubicacion', 'ip', 'usuario', 'sede_rcja', 'organismo', 'contrato', 'num_serie', 'color')->get();

        return response()->json($result);
    }

    public function destroy($id): RedirectResponse
    {
        Impresora::find($id)->delete();

        return Redirect::route('impresoras.index')
            ->with('success', 'Impresora borrada correctamente.');
    }

    public function test()
    {
        return view('impresora.test');
    }

    public function importar(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048'
        ], [
            'csv_file.required' => 'El archivo CSV es obligatorio.',
            'csv_file.file' => 'El archivo debe ser un fichero válido.',
            'csv_file.mimes' => 'El archivo debe ser de tipo CSV o TXT.',
            'csv_file.max' => 'El archivo no debe ser mayor de 2MB.'
        ]);

        try {
            $file = $request->file('csv_file');
            $csvData = array_map('str_getcsv', file($file->getRealPath()));

            // Saltamos la primera fila directamente sin usarla como headers
            array_shift($csvData);

            // Definimos los headers manualmente
            $headers = ['ip', 'sede_rcja', 'tipo', 'contrato', 'organismo', 'descripcion', 'num_serie'];
            $headerCount = count($headers);
            $importedCount = 0;
            $errors = [];

            foreach ($csvData as $index => $row) {
                $rowNumber = $index + 2; // +2 porque empezamos desde la segunda fila

                // Skip empty rows
                if (empty(array_filter($row))) {
                    continue;
                }

                // Validate row length
                if (count($row) !== $headerCount) {
                    $errors[] = "Fila {$rowNumber}: Número incorrecto de columnas";
                    continue;
                }

                $data = array_combine($headers, $row);

                // Validate individual fields
                $rowValidation = Validator::make($data, [
                    'ip' => 'required|ip',
                    'sede_rcja' => 'required|string|max:255',
                    'tipo' => 'required|string|max:255',
                    'organismo' => 'nullable|string|max:255',
                    'num_serie' => 'required|string|max:24',
                    'descripcion' => 'nullable|string|max:1000',
                    'contrato' => 'required|string|max:255'
                ]);

                if ($rowValidation->fails()) {
                    $errors[] = "Fila {$rowNumber}: " . implode(', ', $rowValidation->errors()->all());
                    continue;
                }

                try {
                    // Check if impresora with same IP already exists
                    $existingImpresora = Impresora::where('ip', $data['ip'])->first();

                    if ($existingImpresora) {
                        // Update existing record
                        $existingImpresora->update([
                            'sede_rcja' => $data['sede_rcja'],
                            'tipo' => $data['tipo'],
                            'organismo' => $data['organismo'] ?? null,
                            'contrato' => $data['contrato'],
                            'descripcion' => $data['descripcion'] ?? null,
                            'num_serie' => $data['num_serie'],
                        ]);
                    } else {
                        // Create new record
                        Impresora::create([
                            'ip' => $data['ip'],
                            'sede_rcja' => $data['sede_rcja'],
                            'tipo' => $data['tipo'],
                            'organismo' => $data['organismo'] ?? null,
                            'contrato' => $data['contrato'], // Corregido de num_contrato a contrato
                            'descripcion' => $data['descripcion'] ?? null,
                            'num_serie' => $data['num_serie'],
                        ]);
                    }

                    $importedCount++;
                } catch (\Exception $e) {
                    $errors[] = "Fila {$rowNumber}: Error al guardar en la base de datos - " . $e->getMessage();
                }
            }

            $response = [
                'message' => "Importación completada. {$importedCount} registros procesados correctamente."
            ];

            if (!empty($errors)) {
                $response['errors'] = $errors;
                if ($request->wantsJson()) {
                    return response()->json($response, 422);
                }
                return redirect()->route('impresoras.index')
                    ->with('error', 'Hubo errores durante la importación: ' . implode(', ', $errors));
            }

            if ($request->wantsJson()) {
                return response()->json($response);
            }

            return redirect()->route('impresoras.index')
                ->with('success', "Importación completada. {$importedCount} registros procesados correctamente.");

        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Error al procesar el archivo: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->route('impresoras.index')
                ->with('error', 'Error al procesar el archivo: ' . $e->getMessage());
        }
    }

    public function importarForm(): View
    {
        return view('impresora.importar');
    }



    public function exportarPDF()
    {
        $impresoras = Impresora::all();
        $today = Carbon::today()->format('d-m-Y');

        return Pdf::loadView('impresora.pdfAll', compact('impresoras'))
            ->setPaper('a4', 'landscape')
            ->download("impresoras_$today.pdf");
    }

}
