<?php

include '../../../Backend/config.php';
session_start();

// Check if company is logged in
if (!isset($_SESSION['company_id'])) {
    header('Location: /SwiftQ/Public/loader.html?to=/SwiftQ/Public/auth/company-login.html');
    exit();
}

$company_id = $_SESSION['company_id'];
$company_name = $_SESSION['company_name'] ?? 'Company';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($company_name); ?> - Dashboard</title>
    <link rel="stylesheet" href="../../assets/style/output.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">

    <div class="flex">
        <!-- Sidebar -->
        <div class="hidden lg:w-64 lg:flex lg:flex-col lg:bg-[#0A1A3A] lg:text-white lg:shadow-lg sticky top-0 h-screen">
            <div class="p-6 border-b border-white/10">
                <div class="flex items-center space-x-3">
                    <div class="logo-container"></div>
                    <span class="text-2xl font-bold">SwiftQ</span>
                </div>
            </div>

            <div class="flex-1 flex flex-col pt-5 pb-4 overflow-y-auto">
                <nav class="flex-1 px-2 space-y-1">
                    <a href="./company_dashboard.php" class="bg-blue-600 text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                        <i class="fas fa-chart-line mr-3"></i>
                        Dashboard
                    </a>
                    <a href="./queue-management.php" class="text-gray-300 hover:bg-[#1a2d54] group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                        <i class="fas fa-list mr-3"></i>
                        Queue Management
                    </a>
                    <a href="./customers.php" class="text-gray-300 hover:bg-[#1a2d54] group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                        <i class="fas fa-users mr-3"></i>
                        Customers
                    </a>
                    <a href="./wait-times.php" class="text-gray-300 hover:bg-[#1a2d54] group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                        <i class="fas fa-clock mr-3"></i>
                        Wait Times
                    </a>
                    <a href="./notifications.php" class="text-gray-300 hover:bg-[#1a2d54] group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                        <i class="fas fa-bell mr-3"></i>
                        Notifications
                    </a>
                    <a href="./analytics.php" class="text-gray-300 hover:bg-[#1a2d54] group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                        <i class="fas fa-chart-bar mr-3"></i>
                        Analytics
                    </a>
                    <a href="./settings.php" class="text-gray-300 hover:bg-[#1a2d54] group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                        <i class="fas fa-cog mr-3"></i>
                        Settings
                    </a>
                </nav>
            </div>

            <!-- User Profile Section -->
            <div class="p-4 border-t border-white/10">
                <div class="flex items-center space-x-3 px-4 py-3 rounded-lg hover:bg-white/10 transition cursor-pointer group relative">
                    <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center font-bold text-sm">
                        <?php echo strtoupper(substr($company_name, 0, 1)); ?>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium"><?php echo htmlspecialchars($company_name); ?></p>
                        <p class="text-xs text-gray-400">Admin</p>
                    </div>
                    <i class="fas fa-chevron-down text-xs text-gray-400 group-hover:text-white"></i>
                    
                    <!-- Dropdown Menu -->
                    <div class="absolute bottom-full left-0 right-0 mb-2 bg-white text-gray-900 rounded-lg shadow-xl hidden group-hover:block w-full">
                        <a href="#" class="block px-4 py-2 text-sm hover:bg-gray-100">Profile</a>
                        <a href="#" class="block px-4 py-2 text-sm hover:bg-gray-100">Settings</a>
                        <hr class="my-1">
                        <a href="#logout" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-50">Logout</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar with Title and Actions -->
            <div class="bg-white border-b border-gray-200 px-8 py-4 flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
                    <p class="text-sm text-gray-600 mt-1">Manage your queues efficiently and optimize customer flow</p>
                </div>
                <div class="flex items-center space-x-4">
                    <button class="relative p-2 text-gray-600 hover:text-gray-900">
                        <i class="fas fa-bell text-xl"></i>
                        <span class="absolute top-0 right-2 w-3 h-3 bg-red-500 rounded-full"></span>
                    </button>
                </div>
            </div>

            <!-- Scrollable Content -->
            <div class="flex-1 overflow-auto p-8">
                <!-- Stats Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Active Queues -->
                    <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow border-l-4 border-[#0A1A3A]">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm font-medium">Active Queues</p>
                                <p class="text-3xl font-bold text-gray-900 mt-2">12</p>
                                <p class="text-green-600 text-sm mt-2"><i class="fas fa-arrow-up"></i> 3 active now</p>
                            </div>
                            <div class="w-12 h-12 bg-[#0A1A3A]/10 rounded-lg flex items-center justify-center">
                                <i class="fas fa-list text-[#0A1A3A] text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Total Customers in Queue -->
                    <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow border-l-4 border-blue-500">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm font-medium">Customers in Queue</p>
                                <p class="text-3xl font-bold text-gray-900 mt-2">347</p>
                                <p class="text-blue-600 text-sm mt-2"><i class="fas fa-users"></i> Peak hours</p>
                            </div>
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-users text-blue-600 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Average Wait Time -->
                    <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow border-l-4 border-yellow-500">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm font-medium">Avg Wait Time</p>
                                <p class="text-3xl font-bold text-gray-900 mt-2">8 min</p>
                                <p class="text-yellow-600 text-sm mt-2"><i class="fas fa-clock"></i> Down 15%</p>
                            </div>
                            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-hourglass-end text-yellow-600 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Customers Served -->
                    <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow border-l-4 border-green-500">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm font-medium">Served Today</p>
                                <p class="text-3xl font-bold text-gray-900 mt-2">1,245</p>
                                <p class="text-green-600 text-sm mt-2"><i class="fas fa-check"></i> 98% on-time</p>
                            </div>
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-check-circle text-green-600 text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Queue Status Overview -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                    <!-- Queue Status Cards -->
                    <div class="lg:col-span-2 bg-white rounded-lg shadow">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-bold text-gray-900">Queue Status</h2>
                        </div>
                        <div class="p-6 space-y-4">
                            <!-- Queue 1 -->
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-[#0A1A3A]/10 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-door-open text-[#0A1A3A] text-lg"></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">Counter 1 - General Service</p>
                                        <p class="text-xs text-gray-600">45 customers waiting</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-2xl font-bold text-[#0A1A3A]">45</p>
                                    <span class="inline-block px-2 py-1 text-xs font-semibold text-white bg-green-500 rounded">Running</span>
                                </div>
                            </div>

                            <!-- Queue 2 -->
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-door-open text-blue-600 text-lg"></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">Counter 2 - Premium</p>
                                        <p class="text-xs text-gray-600">12 customers waiting</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-2xl font-bold text-blue-600">12</p>
                                    <span class="inline-block px-2 py-1 text-xs font-semibold text-white bg-green-500 rounded">Running</span>
                                </div>
                            </div>

                            <!-- Queue 3 -->
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-door-open text-yellow-600 text-lg"></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">Counter 3 - Express</p>
                                        <p class="text-xs text-gray-600">28 customers waiting</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-2xl font-bold text-yellow-600">28</p>
                                    <span class="inline-block px-2 py-1 text-xs font-semibold text-white bg-yellow-500 rounded">Busy</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Quick Actions</h3>
                        <div class="space-y-3">
                            <button class="w-full px-4 py-3 bg-[#0A1A3A] text-white rounded-lg font-medium hover:bg-opacity-90 transition flex items-center justify-center space-x-2">
                                <i class="fas fa-plus"></i>
                                <span>Create New Queue</span>
                            </button>
                            <button class="w-full px-4 py-3 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition flex items-center justify-center space-x-2">
                                <i class="fas fa-bell"></i>
                                <span>Send Notification</span>
                            </button>
                            <button class="w-full px-4 py-3 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition flex items-center justify-center space-x-2">
                                <i class="fas fa-download"></i>
                                <span>Export Report</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-bold text-gray-900">Recent Activity</h2>
                    </div>
                    <div class="divide-y divide-gray-200">
                        <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50">
                            <div class="flex items-center space-x-4">
                                <div class="w-10 h-10 bg-[#0A1A3A]/10 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user-check text-[#0A1A3A] text-lg"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Customer ID: C12345 served</p>
                                    <p class="text-xs text-gray-600">Counter 1 - Just now</p>
                                </div>
                            </div>
                            <span class="text-sm text-gray-500">2 sec ago</span>
                        </div>
                        <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50">
                            <div class="flex items-center space-x-4">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-plus text-blue-600 text-lg"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">New customer joined Queue</p>
                                    <p class="text-xs text-gray-600">Counter 3 - General Service</p>
                                </div>
                            </div>
                            <span class="text-sm text-gray-500">45 sec ago</span>
                        </div>
                        <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50">
                            <div class="flex items-center space-x-4">
                                <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-exclamation text-yellow-600 text-lg"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">High wait time alert</p>
                                    <p class="text-xs text-gray-600">Counter 2 - Wait time exceeds 15 min</p>
                                </div>
                            </div>
                            <span class="text-sm text-gray-500">3 min ago</span>
                        </div>
                        <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50">
                            <div class="flex items-center space-x-4">
                                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-bell text-green-600 text-lg"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Notification sent to 45 customers</p>
                                    <p class="text-xs text-gray-600">Queue updates sent successfully</p>
                                </div>
                            </div>
                            <span class="text-sm text-gray-500">12 min ago</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Mobile menu toggle (if needed)
        document.addEventListener('DOMContentLoaded', function() {
            // Add any interactive functionality here
        });

        // Logout functionality
        document.addEventListener('click', function(e) {
            if (e.target.closest('[href="#logout"]')) {
                if (confirm('Are you sure you want to logout?')) {
                    // Add logout logic here
                    window.location.href = '/SwiftQ/Public/loader.html?to=/SwiftQ/index.html';
                }
            }
        });
    </script>
</body>
</html>