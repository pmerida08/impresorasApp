<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Impresora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImportadorImpresorasController extends Controller
{
    public function importar(Request $request)
    {
        // Validate file presence and extension
        $request->validate([
            'file' => 'required|file|mimes:csv,txt',
        ]);

        try {
            // Start transaction
            DB::beginTransaction();

            $file = $request->file('file');
            $csvData = array_map('str_getcsv', file($file->getRealPath()));
            
            // Remove headers
            $headers = array_shift($csvData);
            
            // Expected headers
            $expectedHeaders = ['ip', 'sede_rcja', 'tipo', 'organismo', 'num_serie', 'descripcion', 'contrato'];
            
            // Validate headers
            if ($headers !== $expectedHeaders) {
                return response()->json([
                    'error' => 'CSV headers do not match expected format',
                    'expected' => $expectedHeaders,
                    'received' => $headers
                ], 422);
            }

            $imported = 0;
            $errors = [];

            foreach ($csvData as $index => $row) {
                // Validate row data
                if (count($row) !== count($expectedHeaders)) {
                    $errors[] = "Row " . ($index + 1) . ": Invalid number of columns";
                    continue;
                }

                // Create associative array
                $data = array_combine($headers, $row);

                // Validate IP format
                if (!filter_var($data['ip'], FILTER_VALIDATE_IP)) {
                    $errors[] = "Row " . ($index + 1) . ": Invalid IP format";
                    continue;
                }

                try {
                    // Create or update impresora
                    Impresora::updateOrCreate(
                        ['ip' => $data['ip']], // Unique identifier
                        [
                            'sede' => $data['sede_rcja'],
                            'tipo' => $data['tipo'],
                            'num_serie' => $data['num_serie'],
                            'num_contrato' => $data['contrato'],
                            'observaciones' => $data['descripcion'] . 
                                ($data['organismo'] ? " (Organismo: " . $data['organismo'] . ")" : ""),
                        ]
                    );
                    $imported++;
                } catch (\Exception $e) {
                    $errors[] = "Row " . ($index + 1) . ": " . $e->getMessage();
                }
            }

            if (empty($errors)) {
                DB::commit();
                return response()->json([
                    'message' => 'Import completed successfully',
                    'records_imported' => $imported
                ]);
            } else {
                DB::rollBack();
                return response()->json([
                    'error' => 'Import failed',
                    'details' => $errors
                ], 422);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Import failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
