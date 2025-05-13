<?php

namespace App\Http\Controllers;

use App\Models\Impresora;
use App\Models\ImpresoraHistorico;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ImpresoraRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Mail\LowTonerAlert;
use PHPMailer\PHPMailer\PHPMailer;
use App\Services\TonerLevelService;

class ImpresoraController extends Controller
{
    protected $tonerLevelService;

    public function __construct(TonerLevelService $tonerLevelService)
    {
        $this->middleware('auth');
        $this->tonerLevelService = $tonerLevelService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Impresora $impresora): View
    {
        $impresoras = $impresora->paginate(15);

        return view('impresora.index', [
            'impresoras' => $impresoras,
            'i' => ($request->input('page', 1) - 1) * $impresoras->perPage(),
        ])->with('pagination', 'pagination::bootstrap-5');
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

        // Filtros permitidos
        $allowedFilters = [
            'tipo',
            'ubicacion',
            'ip',
            'usuario',
            'sede_rcja',
            'organismo',
            'contrato',
            'color',
            'activo',
            'num_serie'
        ];

        if (!in_array($filter, $allowedFilters)) {
            return response()->json([], 400);
        }

        $impresoras = Impresora::with('datosSnmp');

        switch ($filter) {
            case 'color':
                $impresoras->where('color', 1);
                break;
            case 'bw':
                $impresoras->where('color', 0);
                break;
            case 'activo':
                $impresoras->where('activo', 1);
                break;
            case 'inactivo':
                $impresoras->where('activo', 0);
                break;
            case 'num_serie':
                $impresoras->whereHas('datosSnmp', function ($queryBuilder) use ($sanitizedQuery) {
                    $queryBuilder->where('num_serie', 'LIKE', '%' . $sanitizedQuery . '%');
                });
                break;
            default:
                $impresoras->where($filter, 'LIKE', '%' . $sanitizedQuery . '%');
                break;
        }

        $result = $impresoras->get([
            'id',
            'tipo',
            'ubicacion',
            'ip',
            'usuario',
            'sede_rcja',
            'organismo',
            'contrato',
            'color',
            'activo'
        ]);

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
                            'contrato' => $data['contrato'],
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

    /**
     * Show the PDF filter form.
     */
    public function showFilterForm(): View
    {
        return view('impresora.filterPdf');
    }

    /**
     * Generate filtered PDF based on request parameters.
     */
    public function generateFilteredPDF(Request $request)
    {
        // Build the base query
        $query = Impresora::query();

        // Validate dates if provided and set up date filtering
        $start_date = null;
        $end_date = null;
        $range_paginas = null;

        if ($request->filled(['start_date', 'end_date', 'range_paginas'])) {
            $validated = $request->validate([
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'range_paginas' => 'required|integer|min:0|max:1000000',
            ]);

            $start_date = Carbon::parse($validated['start_date'])->startOfDay();
            $end_date = Carbon::parse($validated['end_date'])->endOfDay();
            $range_paginas = $validated['range_paginas'];
        }

        // Apply filters if they exist
        $filterFields = [
            'tipo',
            'ubicacion',
            'ip',
            'usuario',
            'sede_rcja',
            'organismo',
            'contrato',
            'num_serie'
        ];

        foreach ($filterFields as $field) {
            if ($request->filled($field)) {
                $query->where($field, 'LIKE', '%' . $request->input($field) . '%');
            }
        }

        // Handle boolean filter
        if ($request->has('color')) {
            $query->where('color', true);
        }

        // Handle range filter
        if ($range_paginas && $start_date && $end_date) {
            $query->whereExists(function ($subquery) use ($start_date, $end_date, $range_paginas) {
                $subquery->selectRaw('1')
                    ->from('impresora_historicos')
                    ->whereColumn('impresoras.id', '=', 'impresora_historicos.impresora_id')
                    ->whereBetween('fecha', [$start_date, $end_date])
                    ->havingRaw('MAX(paginas) - MIN(paginas) >= ?', [$range_paginas])
                    ->groupBy('impresora_id');
            });
        }

        // Get the filtered results
        $impresoras = $query->get();

        // Calculate pages for each printer if dates are provided
        if ($start_date && $end_date) {
            foreach ($impresoras as $impresora) {
                $historico = ImpresoraHistorico::where('impresora_id', $impresora->id)
                    ->whereBetween('fecha', [$start_date, $end_date])
                    ->selectRaw('
                        MIN(paginas) as min_paginas, 
                        MAX(paginas) as max_paginas,
                        MIN(paginas_bw) as min_paginas_bw, 
                        MAX(paginas_bw) as max_paginas_bw,
                        MIN(paginas_color) as min_paginas_color, 
                        MAX(paginas_color) as max_paginas_color
                    ')
                    ->first();

                $impresora->total_paginas = 0;
                $impresora->total_paginas_bw = 0;
                $impresora->total_paginas_color = 0;

                if ($historico) {
                    if (!is_null($historico->min_paginas) && !is_null($historico->max_paginas)) {
                        $impresora->total_paginas = $historico->max_paginas - $historico->min_paginas;
                    }
                    if (!is_null($historico->min_paginas_bw) && !is_null($historico->max_paginas_bw)) {
                        $impresora->total_paginas_bw = $historico->max_paginas_bw - $historico->min_paginas_bw;
                    }
                    if (!is_null($historico->min_paginas_color) && !is_null($historico->max_paginas_color)) {
                        $impresora->total_paginas_color = $historico->max_paginas_color - $historico->min_paginas_color;
                    }
                }
            }
        }

        // Format dates for display
        $display_start_date = $start_date ? $start_date->format('d/m/Y') : null;
        $display_end_date = $end_date ? $end_date->format('d/m/Y') : null;

        // Get filter parameters for the view
        $filters = $request->only($filterFields + ['color']);

        // Generate filename with date
        $filename = 'impresoras_filtradas_' . Carbon::now()->format('d-m-Y') . '.pdf';

        // Load view and generate PDF
        return Pdf::loadView('impresora.pdfAllFiltered', [
            'impresoras' => $impresoras,
            'start_date' => $display_start_date,
            'end_date' => $display_end_date,
            'filters' => $filters,
            'range_paginas' => $range_paginas,
        ])
            ->setPaper('a4', 'landscape')
            ->download($filename);
    }

    public function checkTonerLevels()
    {
        $impresoras = Impresora::all();
        $alertEmail = env('MAIL_DESTINO');
        $results = [];

        foreach ($impresoras as $impresora) {
            $lowTonerLevels = $this->tonerLevelService->checkTonerLevels($impresora);

            if (!empty($lowTonerLevels)) {
                $mailResult = $this->tonerLevelService->sendLowTonerAlert($impresora, $lowTonerLevels, $alertEmail);
                $results[] = [
                    'impresora' => $impresora->ip,
                    'lowTonerLevels' => $lowTonerLevels,
                    'mailSent' => $mailResult
                ];
            }
        }

        return response()->json($results);
    }

    private function sendLowTonerAlert($impresora, $lowTonerLevels, $alertEmail)
    {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host = 'mail.juntadeandalucia.es';
            $mail->Port = 25;
            $mail->SMTPAuth = false;
            $mail->SMTPSecure = false;
            $mail->SMTPAutoTLS = false;
            $mail->CharSet = 'UTF-8';


            //Recipients
            $mail->setFrom('ceis.dpco.chap@juntadeandalucia.es', 'Junta de Andalucía');
            $mail->addAddress($alertEmail);

            //Content
            $mail->isHTML(true);
            $mail->Subject = 'Alerta de nivel bajo de tóner';

            $body = "La impresora {$impresora->tipo} (IP: {$impresora->ip}) tiene niveles bajos de tóner:<br><br>";
            foreach ($lowTonerLevels as $color => $level) {
                $body .= ucfirst($color) . ": " . $level . "%<br>";
            }

            $mail->Body = $body;

            $mail->send();
            $this->info("Correo enviado correctamente para impresora: {$impresora->ip}");
            return true;
        } catch (Exception $e) {
            $this->error("Error al enviar correo para impresora {$impresora->ip}: {$mail->ErrorInfo}");
            return false;
        }
    }
}
