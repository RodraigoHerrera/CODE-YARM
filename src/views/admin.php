<?php include '../../templates/sidebar.html' ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

        <!-- Main Content -->
        <div class="flex-1 p-6 ml-64">
            <!-- Dashboard Header -->
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold">Panel</h1>
            </div>

            <!-- Dashboard Cards -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-lg font-semibold">Ventas</h2>
                    <p class="text-2xl font-bold">Bs.- 0</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-lg font-semibold">Pedidos</h2>
                    <p class="text-2xl font-bold">0</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-lg font-semibold">Clientes</h2>
                    <p class="text-2xl font-bold">0</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-lg font-semibold">Gastos</h2>
                    <p class="text-2xl font-bold">Bs.- 0</p>
                </div>
            </div>

            <!-- Trend and Sales -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-lg font-semibold">Tendencia</h2>
                    <div class="h-48 bg-gray-200 mt-4"></div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-lg font-semibold">Ventas</h2>
                    <div class="h-48 bg-gray-200 mt-4"></div>
                </div>
            </div>

            
        </div>
    </div>
</body>
</html>
