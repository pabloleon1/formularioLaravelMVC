<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FacturaController extends Controller
{
    public function index()
    {
        return view('factura');
    }

    public function calcular(Request $request)
    {
        $request->validate([
            'nombre_cliente' => 'required|string|max:255',
            'nombre_producto' => 'required|string|max:255',
            'cantidad' => 'required|numeric|min:1',
            'precio_unitario' => 'required|numeric|min:0',
            'porcentaje_iva' => 'nullable|numeric|min:0|max:100',
        ]);

        $nombreCliente = $request->input('nombre_cliente');
        $nombreProducto = $request->input('nombre_producto');
        $cantidad = $request->input('cantidad');
        $precioUnitario = $request->input('precio_unitario');
        $porcentajeIva = $request->input('porcentaje_iva', 15); 

        // Calcular subtotal
        $subtotal = $cantidad * $precioUnitario;

        // Calcular IVA
        $iva = $subtotal * ($porcentajeIva / 100);

        // Calcular total
        $total = $subtotal + $iva;

        $datos = [
            'nombre_cliente' => $nombreCliente,
            'nombre_producto' => $nombreProducto,
            'cantidad' => $cantidad,
            'precio_unitario' => $precioUnitario,
            'porcentaje_iva' => $porcentajeIva,
            'subtotal' => $subtotal,
            'iva' => $iva,
            'total' => $total,
        ];

        return view('factura', compact('datos'));
    }
} 