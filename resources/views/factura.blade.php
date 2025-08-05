<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Factura</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <h1 class="text-3xl font-bold text-center text-gray-800 mb-8">Formulario de Factura</h1>
            
            @if(isset($datos))
                <!-- Resultados del cálculo -->
                <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                    <h2 class="text-2xl font-semibold text-green-600 mb-4">Resultado del Cálculo</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <p class="text-gray-600"><strong>Cliente:</strong></p>
                            <p class="text-lg font-medium">{{ $datos['nombre_cliente'] }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600"><strong>Producto:</strong></p>
                            <p class="text-lg font-medium">{{ $datos['nombre_producto'] }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600"><strong>Cantidad:</strong></p>
                            <p class="text-lg font-medium">{{ $datos['cantidad'] }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600"><strong>Precio unitario:</strong></p>
                            <p class="text-lg font-medium">${{ number_format($datos['precio_unitario'], 2) }}</p>
                        </div>
                    </div>
                    
                    <div class="border-t pt-4">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-600">Subtotal:</span>
                            <span class="text-lg font-medium">${{ number_format($datos['subtotal'], 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-gray-600">IVA ({{ $datos['porcentaje_iva'] }}%):</span>
                            <span class="text-lg font-medium">${{ number_format($datos['iva'], 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center text-xl font-bold text-green-600 border-t pt-2">
                            <span>Total a pagar:</span>
                            <span>${{ number_format($datos['total'], 2) }}</span>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <a href="/factura" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                            Calcular Nueva Factura
                        </a>
                    </div>
                </div>
            @endif
            
            <!-- Formulario -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Ingrese los Datos</h2>
                
                @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <form method="POST" action="/factura" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label for="nombre_cliente" class="block text-sm font-medium text-gray-700 mb-2">
                            Nombre del Cliente
                        </label>
                        <input type="text" 
                               id="nombre_cliente" 
                               name="nombre_cliente" 
                               value="{{ old('nombre_cliente', isset($datos) ? $datos['nombre_cliente'] : '') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               required>
                    </div>
                    
                    <div>
                        <label for="nombre_producto" class="block text-sm font-medium text-gray-700 mb-2">
                            Nombre del Producto
                        </label>
                        <input type="text" 
                               id="nombre_producto" 
                               name="nombre_producto" 
                               value="{{ old('nombre_producto', isset($datos) ? $datos['nombre_producto'] : '') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               required>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="cantidad" class="block text-sm font-medium text-gray-700 mb-2">
                                Cantidad
                            </label>
                            <input type="number" 
                                   id="cantidad" 
                                   name="cantidad" 
                                   min="1"
                                   value="{{ old('cantidad', isset($datos) ? $datos['cantidad'] : '') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   required>
                        </div>
                        
                        <div>
                            <label for="precio_unitario" class="block text-sm font-medium text-gray-700 mb-2">
                                Precio Unitario ($)
                            </label>
                            <input type="number" 
                                   id="precio_unitario" 
                                   name="precio_unitario" 
                                   min="0" 
                                   step="0.01"
                                   value="{{ old('precio_unitario', isset($datos) ? $datos['precio_unitario'] : '') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   required>
                        </div>
                    </div>
                    
                    <div>
                        <label for="porcentaje_iva" class="block text-sm font-medium text-gray-700 mb-2">
                            Porcentaje de IVA (%) <span class="text-gray-500">(opcional, por defecto 15%)</span>
                        </label>
                        <input type="number" 
                               id="porcentaje_iva" 
                               name="porcentaje_iva" 
                               min="0" 
                               max="100" 
                               step="0.01"
                               value="{{ old('porcentaje_iva', isset($datos) ? $datos['porcentaje_iva'] : '15') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    
                    <div class="flex justify-center">
                        <button type="submit" 
                                class="bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded-lg text-lg transition duration-200">
                            Calcular Total
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html> 