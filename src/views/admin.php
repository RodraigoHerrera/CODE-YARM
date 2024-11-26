<?php include '../../templates/sidebar.html' ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexaVerse Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

        <!-- Main Content -->
        <div class="flex-1 p-6 ml-64">
            <!-- Dashboard Header -->
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-2xl font-bold">Dashboard</h1>
                <input type="text" placeholder="Search transactions, customers, subscriptions" class="border border-gray-300 rounded-lg px-4 py-2 w-1/3">
                <button class="ml-4 bg-gray-200 rounded-full p-3 focus:outline-none">
                    <span class="material-icons">person</span>
                </button>
            </div>

            <!-- Dashboard Cards -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-lg font-semibold">Current MRR</h2>
                    <p class="text-2xl font-bold">$12.4k</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-lg font-semibold">Current Customers</h2>
                    <p class="text-2xl font-bold">16,601</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-lg font-semibold">Active Customers</h2>
                    <p class="text-2xl font-bold">33%</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-lg font-semibold">Churn Rate</h2>
                    <p class="text-2xl font-bold">2%</p>
                </div>
            </div>

            <!-- Trend and Sales -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-lg font-semibold">Trend</h2>
                    <div class="h-48 bg-gray-200 mt-4"></div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-lg font-semibold">Sales</h2>
                    <div class="h-48 bg-gray-200 mt-4"></div>
                </div>
            </div>

            <!-- Transactions and Support Tickets -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-lg font-semibold">Transactions</h2>
                    <div class="h-48 bg-gray-200 mt-4"></div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h2 class="text-lg font-semibold">Support Tickets</h2>
                    <div class="h-48 bg-gray-200 mt-4"></div>
                </div>
            </div>

            <!-- Customer Demographic -->
            <div class="bg-white p-6 rounded-lg shadow-md mt-6">
                <h2 class="text-lg font-semibold">Customer Demographic</h2>
                <div class="h-48 bg-gray-200 mt-4"></div>
            </div>
        </div>
    </div>
</body>
</html>
