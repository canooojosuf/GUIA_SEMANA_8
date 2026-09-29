<?php

namespace App\Http\Controllers;

use App\Models\Comercio;
use Illuminate\View\View;

class ComercioController extends Controller
{
    /**
     * Semana 5 · Routing y Controladores
     * GET /comercios
     *
     * Lista todos los comercios afiliados junto con el conteo de sus
     * transacciones. withCount() evita el problema N+1: en vez de
     * disparar una consulta extra por cada comercio dentro de la vista,
     * trae el conteo ya resuelto en la consulta principal.
     */

    // EL EJERICICO EXTRA EL QUE ELEGI FUE MISON B QUE ES ORDENAR POR ACTIVIDAD QUE TENGA MAS transacciones, PARA ESO USAMOS orderByDesc('transacciones_count') Y LUEGO GET() PARA TRAER LOS DATOS
    public function index(): View
    {
        $comercios = Comercio::withCount('transacciones')
            ->orderByDesc('transacciones_count')
            ->get();

        return view('comercios.index', compact('comercios'));
    }

    /**
     * GET /comercios/{comercio}
     *
     * Route Model Binding: Laravel convierte automáticamente el
     * parámetro {comercio} de la ruta en una instancia de Comercio
     * (o lanza 404 si no existe).
     *
     * load('transacciones') trae la relación en una sola consulta
     * adicional (no una por cada transacción), evitando el N+1.
     */
    public function show(Comercio $comercio): View
    {
        $comercio->load('transacciones');

        return view('comercios.show', compact('comercio'));
    }
}
