<?php

namespace App\Http\Controllers;

use App\Models\Impresora;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ImpresoraRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

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

        return Redirect::route('impresoras.index')
            ->with('success', 'Impresora actualizada correctamente.');
    }

    public function buscar(Request $request)
    {
        $query = $request->input('q');
        $sanitizedQuery = str_replace('%', '', $query);

        $impresoras = Impresora::where('tipo', 'LIKE', '%' . $sanitizedQuery . '%')
            ->orWhere('ubicacion', 'LIKE', '%' . $sanitizedQuery . '%')
            ->orWhere('usuario', 'LIKE', '%' . $sanitizedQuery . '%')
            ->select('id', 'tipo', 'ubicacion', 'usuario')
            ->get();

        return response()->json($impresoras);
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
            'csv_file' => 'required|file|mimes:csv,txt'
        ]);

        try {
            $file = $request->file('csv_file');
            $csvData = array_map('str_getcsv', file($file->getRealPath()));

            // Remove headers
            $headers = array_shift($csvData);
            $headerCount = count($headers);

            foreach ($csvData as $index => $row) {
                // Skip rows that don't match header count
                if (count($row) !== $headerCount) {
                    \Log::warning("Row {$index} has incorrect number of columns. Expected: {$headerCount}, Got: " . count($row));
                    continue;
                }

                $data = array_combine($headers, $row);

                Impresora::create([
                    'ip' => $data['ip'] ?? null,
                    'sede_rcja' => $data['sede_rcja'] ?? null,
                    'tipo' => $data['tipo'] ?? null,
                    'num_contrato' => $data['num_contrato'] ?? null,
                    'organismo' => $data['organismo'] ?? null,
                    'descripcion' => $data['descripcion'] ?? null,
                ]);

                
            }

            return Redirect::route('impresoras.index')
            ->with('success', 'Impresoras añadidas  correctamente.');

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al importar el archivo CSV: ' . $e->getMessage()
            ], 500);
        }
    }

    public function importarForm(): View
    {
        return view('impresora.importar');
    }
}
