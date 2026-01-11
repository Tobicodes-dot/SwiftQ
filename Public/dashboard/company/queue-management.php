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
    <title><?php echo htmlspecialchars($company_name); ?> - Queue Management</title>
    <link rel="stylesheet" href="../../assets/style/output.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">
    <div class="flex">
        <!-- Sidebar -->
        <div class="hidden lg:w-64 lg:flex lg:flex-col lg:bg-[#0A1A3A] lg:text-white lg:shadow-lg sticky top-0 h-screen">
            <div class="p-6 border-b border-white/10">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-stream text-lg"></i>
                    </div>
                    <span class="text-2xl font-bold">SwiftQ</span>
                </div>
            </div>

            <div class="flex-1 flex flex-col pt-5 pb-4 overflow-y-auto">
                <nav class="flex-1 px-2 space-y-1">
                    <a href="./company_dashboard.php" class="text-gray-300 hover:bg-[#1a2d54] group flex items-center px-2 py-2 text-sm font-medium rounded-md">
                        <i class="fas fa-chart-line mr-3"></i>
                        Dashboard
                    </a>
                    <a href="./queue-management.php" class="bg-blue-600 text-white group flex items-center px-2 py-2 text-sm font-medium rounded-md">
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

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar with Title and Actions -->
            <div class="bg-white border-b border-gray-200 px-8 py-4 flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Queue Management</h1>
                    <p class="text-sm text-gray-600 mt-1">Create, manage, and monitor your service queues</p>
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
                <!-- Action Buttons -->
                <div class="flex gap-4 mb-8">
                    <button class="px-6 py-2 bg-[#0A1A3A] text-white rounded-lg font-medium hover:bg-opacity-90 transition flex items-center space-x-2" onclick="openCreateQueueModal()">
                        <i class="fas fa-plus"></i>
                        <span>Create Queue</span>
                    </button>
                    <button class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition flex items-center space-x-2">
                        <i class="fas fa-download"></i>
                        <span>Export Data</span>
                    </button>
                </div>

                <!-- Queues Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    <!-- Queue Card 1 -->
                    <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow border-t-4 border-[#0A1A3A]">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">General Service</h3>
                                <p class="text-sm text-gray-600">Counter 1</p>
                            </div>
                            <div class="flex space-x-2">
                                <button class="p-2 rounded-lg hover:bg-gray-100 text-gray-600" onclick="editQueue(1)">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="p-2 rounded-lg hover:bg-gray-100 text-red-600" onclick="deleteQueue(1)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Customers Waiting</span>
                                <span class="text-2xl font-bold text-[#0A1A3A]">45</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Avg Wait Time</span>
                                <span class="text-lg font-semibold text-yellow-600">8 min</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Status</span>
                                <span class="px-3 py-1 rounded-full bg-green-100 text-green-800 text-xs font-semibold">Active</span>
                            </div>
                        </div>

                        <button class="w-full mt-4 px-4 py-2 border border-[#0A1A3A] text-[#0A1A3A] rounded-lg font-medium hover:bg-[#0A1A3A] hover:text-white transition">
                            View Details
                        </button>
                    </div>

                    <!-- Queue Card 2 -->
                    <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow border-t-4 border-blue-500">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Premium Service</h3>
                                <p class="text-sm text-gray-600">Counter 2</p>
                            </div>
                            <div class="flex space-x-2">
                                <button class="p-2 rounded-lg hover:bg-gray-100 text-gray-600" onclick="editQueue(2)">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="p-2 rounded-lg hover:bg-gray-100 text-red-600" onclick="deleteQueue(2)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Customers Waiting</span>
                                <span class="text-2xl font-bold text-blue-500">12</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Avg Wait Time</span>
                                <span class="text-lg font-semibold text-green-600">4 min</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Status</span>
                                <span class="px-3 py-1 rounded-full bg-green-100 text-green-800 text-xs font-semibold">Active</span>
                            </div>
                        </div>

                        <button class="w-full mt-4 px-4 py-2 border border-blue-500 text-blue-500 rounded-lg font-medium hover:bg-blue-500 hover:text-white transition">
                            View Details
                        </button>
                    </div>

                    <!-- Queue Card 3 -->
                    <div class="bg-white rounded-lg shadow p-6 hover:shadow-lg transition-shadow border-t-4 border-yellow-500">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Express Service</h3>
                                <p class="text-sm text-gray-600">Counter 3</p>
                            </div>
                            <div class="flex space-x-2">
                                <button class="p-2 rounded-lg hover:bg-gray-100 text-gray-600" onclick="editQueue(3)">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="p-2 rounded-lg hover:bg-gray-100 text-red-600" onclick="deleteQueue(3)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Customers Waiting</span>
                                <span class="text-2xl font-bold text-yellow-600">28</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Avg Wait Time</span>
                                <span class="text-lg font-semibold text-green-600">3 min</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Status</span>
                                <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-800 text-xs font-semibold">Busy</span>
                            </div>
                        </div>

                        <button class="w-full mt-4 px-4 py-2 border border-yellow-500 text-yellow-600 rounded-lg font-medium hover:bg-yellow-500 hover:text-white transition">
                            View Details
                        </button>
                    </div>
                </div>

                <!-- Queue Analytics Table -->
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-lg font-bold text-gray-900">Queue Analytics</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Queue Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Counter</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Waiting</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Avg Wait</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Today Served</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">General Service</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">Counter 1</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-[#0A1A3A]">45</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-yellow-600">8 min</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">287</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Active
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <button class="text-blue-600 hover:text-blue-900 font-medium">View</button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Premium Service</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">Counter 2</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-blue-600">12</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600">4 min</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">156</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Active
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <button class="text-blue-600 hover:text-blue-900 font-medium">View</button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Express Service</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">Counter 3</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-yellow-600">28</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600">3 min</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">423</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Busy
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <button class="text-blue-600 hover:text-blue-900 font-medium">View</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Queue Modal -->
    <div id="createQueueModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl p-8 w-full max-w-md">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Create New Queue</h2>
            
            <form onsubmit="submitQueue(event)">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Queue Name</label>
                        <input type="text" placeholder="e.g., General Service" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0A1A3A]" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Counter Number</label>
                        <input type="text" placeholder="e.g., Counter 1" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0A1A3A]" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea placeholder="Queue description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0A1A3A]"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Priority Level</label>
                        <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#0A1A3A]">
                            <option>Standard</option>
                            <option>Premium</option>
                            <option>Express</option>
                        </select>
                    </div>
                </div>

                <div class="flex gap-4 mt-6">
                    <button type="button" onclick="closeCreateQueueModal()" class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-[#0A1A3A] text-white rounded-lg font-medium hover:bg-opacity-90">
                        Create Queue
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openCreateQueueModal() {
            document.getElementById('createQueueModal').classList.remove('hidden');
        }

        function closeCreateQueueModal() {
            document.getElementById('createQueueModal').classList.add('hidden');
        }

        function submitQueue(event) {
            event.preventDefault();
            alert('Queue created successfully!');
            closeCreateQueueModal();
        }

        function editQueue(queueId) {
            alert('Edit queue ' + queueId);
        }

        function deleteQueue(queueId) {
            if (confirm('Are you sure you want to delete this queue?')) {
                alert('Queue deleted successfully!');
            }
        }

        // Logout functionality
        document.addEventListener('click', function(e) {
            if (e.target.closest('[href="#logout"]')) {
                if (confirm('Are you sure you want to logout?')) {
                    window.location.href = '/SwiftQ/Public/loader.html?to=/SwiftQ/index.html';
                }
            }
        });

        // Close modal when clicking outside
        document.getElementById('createQueueModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeCreateQueueModal();
            }
        });
    </script>
</body>
</html>
