<?php

namespace App\Http\Controllers;

use App\Models\Movimiento;
use App\Models\Producto;
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

            return back()->with('success', 'Movimiento registrado exitosamente.');
        }

        // Manejar errores de base de datos
        catch(QueryException $e){
            $errorCode = $e->errorInfo[0];
            $errorMessage = $e->errorInfo[2];
            return back()->withErrors(['database_error' => "Error Code: $errorCode, Message: $errorMessage"]);
        }
    }

    public function index(){
        $productos = Producto::all();
        return view('bodega', compact('productos'));
    }

    public function getReport(){
        $productos = Producto::all();

        $filename = "reporte_stock.txt";
        $handle = fopen($filename, 'w+');
        fputcsv($handle, ['ID', 'Nombre', 'Descripción', 'Stock']);

        foreach($productos as $producto){
            fputcsv($handle, [$producto->id, $producto->nombre, $producto->descripcion, $producto->stock]);
        }

        fclose($handle);

        return response()->download($filename)->deleteFileAfterSend(true);
    }
}
