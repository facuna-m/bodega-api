<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bodega Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-100 min-h-screen p-6 md:p-10 text-slate-800">
    
    <div class="max-w-5xl mx-auto bg-white p-8 rounded-xl shadow-lg border border-slate-200">
        
        <div class="border-b border-slate-200 pb-6 mb-6">
            <h1 class="text-3xl font-bold text-slate-800">📦 Control de Bodega</h1>
            <p class="text-slate-500 mt-1">Gestiona el inventario de productos en tiempo real.</p>
        </div>

        <div class="flex justify-between items-center mb-6 bg-slate-50 p-3 rounded border border-slate-200">
            <div class="text-sm text-slate-600">
                Hola, <b>{{Auth::user()->name}}</b>
            </div>
            <form method="POST" action="{{route('logout')}}">
                @csrf
                <button type="submit" class="text-sm bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-lg shadow transition transform active:scale-95">
                    Cerrar Sesión
                </button>
            </form>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm" role="alert">
                <p class="font-bold">¡Operación exitosa!</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif  

        @if($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm" role="alert">
                <p class="font-bold">Hubo un problema:</p>
                <ul class="list-disc list-inside ml-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Grid Layout -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
            
            <!-- Formulario -->
            <div class="md:col-span-6">
                <div class="bg-slate-50 p-6 rounded-lg border border-slate-200">
                    <h2 class="text-xl font-semibold mb-4 text-slate-700 flex items-center">
                        📝 Registrar Movimiento
                    </h2>
                    
                    <form action="{{ route('movimiento.guardar') }}" method="POST" class="space-y-5">
                        @csrf
                        
                        <div>
                            <label class="block mb-2 font-medium text-sm text-slate-600">Producto</label>
                            <div class="relative">
                                <select name="id_producto" class="w-full border border-gray-200 p-2.5 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition bg-white">
                                    @foreach($productos as $prod)
                                        <option value="{{ $prod->id }}">
                                            {{$prod->nombre}} (SKU: {{$prod->sku}})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block mb-2 font-medium text-sm text-slate-600">Tipo de Acción</label>
                            <div class="grid grid-cols-2 gap-4">
                                <label class="cursor-pointer">
                                    <input type="radio" name="tipo" value="Entrada" class="peer sr-only" checked>
                                    <div class="rounded-lg border border-gray-300 p-3 text-center peer-checked:border-green-500 peer-checked:bg-green-50 peer-checked:text-green-700 transition hover:bg-gray-50">
                                        📥 Entrada
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="tipo" value="Salida" class="peer sr-only">
                                    <div class="rounded-lg border border-gray-300 p-3 text-center peer-checked:border-red-500 peer-checked:bg-red-50 peer-checked:text-red-700 transition hover:bg-gray-50">
                                        📤 Salida
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div>
                            <label class="block mb-2 font-medium text-sm text-slate-600">Cantidad</label>
                            <input type="number" name="cantidad" min="1" class="w-full border border-gray-300 p-2.5 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition" placeholder="Ej: 5">
                        </div>

                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg shadow transition transform active:scale-95">
                            Guardar Movimiento
                        </button>
                    </form>
                </div>
            </div>

            <!-- Tabla de Stock -->
            <div class="md:col-span-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-slate-700">📊 Stock Actual</h2>
                    <span class="text-sm bg-blue-100 text-blue-800 py-1 px-3 rounded-full">Total Items: {{ $productos->count() }}</span>
                </div>
                
                <div class="overflow-hidden border border-slate-200 rounded-lg shadow-sm">
                    <table class="min-w-full bg-white text-sm">
                        <thead class="bg-slate-800 text-white">
                            <tr>
                                <th class="py-3 px-4 text-left font-medium uppercase tracking-wider">Producto</th>
                                <th class="py-3 px-4 text-center font-medium uppercase tracking-wider">Stock Disp.</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-300">
                            @foreach($productos as $prod)
                                <tr class="hover:bg-blue-100 transition">
                                    <td class="py-3 px-4">
                                        <div class="font-medium text-gray-900">{{ $prod->nombre }}</div>
                                        <div class="text-xs text-gray-500">SKU: {{ $prod->sku }}</div>
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        @if($prod->stock > 10)
                                            <span class="bg-green-100 text-green-800 py-1 px-3 rounded-full font-bold text-xs">
                                                {{ $prod->stock}}
                                            </span>
                                        @elseif($prod->stock > 0)
                                            <span class="bg-yellow-100 text-yellow-800 py-1 px-3 rounded-full font-bold text-xs">
                                                {{ $prod->stock}}
                                            </span>
                                        @else
                                            <span class="bg-red-100 text-red-800 py-1 px-3 rounded-full font-bold text-xs">
                                                Sin Stock
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</body>
</html>