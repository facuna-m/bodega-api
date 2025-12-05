<?php

namespace App\Http\Controllers;

use App\Models\Movimiento;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class MovimientoController extends Controller
{
    public function store(Request $request)
    {
        // Validar los datos de entrada para crear un movimiento
        $request -> validate([
            'tipo' => 'required|string|in:Entrada,Salida',
            'cantidad' => 'required|integer|min:1',
            'id_producto' => 'required|exists:producto,id',
        ]);

        // Crear un nuevo movimiento
        try{
            $movimiento = new Movimiento();
            $movimiento->tipo = $request->tipo;
            $movimiento->cantidad = $request->cantidad;
            $movimiento->id_producto = $request->id_producto;
            $movimiento->save();

            return response()->json(['message' => 'Movimiento creado exitosamente', 'movimiento' => $movimiento], 201);
        }

        // Manejar errores de base de datos
        catch(QueryException $e){
            $errorCode = $e->errorInfo[0];
            $errorMessage = $e->errorInfo[2];
            return response()->json(['error' => 'Error de base de datos', 'detalle' => $errorMessage], 400);
        }
    }
}
