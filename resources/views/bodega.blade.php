<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bodega Manager</title>
</head>
<body class = "bg-gray-100 p-10">
    <div class = "max-w-3xl mx-auto bg-white p-6 rounded shadow">
        <h1 class = "text-2xl font-bold mb-6">Control de Bodega</h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-4 mb-6 rounded">
                <strong>Éxito:</strong> {{ session('success') }}
            </div>
        @endif  

        @if($errors->any())
            <div class="bg-red-100 text-red-800 p-4 mb-6 rounded">
                <strong>Error:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <h2 class="text-xl font-semibold mb-4">Registrar Movimiento</h2>
                <form action="{{ route('movimiento.guardar') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block mb-1 font-medium">Producto:</label>
                        <select name="id_producto" class="w-full border border-gray-300 p-2 rounded">
                            @foreach($productos as $prod)
                                <option value="{{ $prod->id }}">
                                    {{$prod->nombre}} (SKU: {{$prod->sku}})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">Tipo de Movimiento:</label>
                        <select name="tipo" class="w-full border border-gray-300 p-2 rounded">
                            <option value="Entrada">Entrada</option>
                            <option value="Salida">Salida</option>   
                        </select>                     
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">Cantidad:</label>
                        <input type="number" name="cantidad" min="1" class="w-full border border-gray-300 p-2 rounded" placeholder="Ej:5">
                    </div>

                    <div>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                            Registrar Movimiento
                        </button>
                    </div>
            </div>
        </div>

        <div>
            <h2 class="text-xl font-semibold mb-4">Stock Actual</h2>
            <div class="overflow-hidden border rounded-lg">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="py-2 px-4 text-left">Producto</th>
                            <th class="py-2 px-4 text-center">Stock</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @foreach($productos as $prod)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-2 px-4">{{ $prod->nombre }} <span class="text-xs text-gray-500">({{ $prod->sku }})</span></td>
                                <td class="py-2 px-4 text-center font-bold">{{ $prod->stock}}</td>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>