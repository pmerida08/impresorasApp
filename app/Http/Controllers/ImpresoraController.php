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
}
