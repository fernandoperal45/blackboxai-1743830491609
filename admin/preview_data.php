<?php
session_start();
require_once '../config.php';

// Redirect to login if not authenticated or not admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin'])) {
    header('Location: ../index.php');
    exit;
}

// Get all shipping data
$query = "SELECT * FROM shipping_data ORDER BY trans_date DESC";
$result = $conn->query($query);
$shipping_data = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview Data - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="flex">
        <!-- Sidebar -->
        <?php include '../includes/admin_sidebar.php'; ?>

        <!-- Main Content -->
        <div class="flex-1 p-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">All Shipping Data</h2>
                    <div>
                        <a href="upload_excel.php" class="text-blue-600 hover:text-blue-800 mr-4">
                            <i class="fas fa-file-upload mr-1"></i> Upload New Data
                        </a>
                        <a href="#" class="text-blue-600 hover:text-blue-800" onclick="exportToCSV()">
                            <i class="fas fa-file-export mr-1"></i> Export to CSV
                        </a>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Invoice #</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Invoice Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cust. PO #</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ship To</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Items</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($shipping_data as $row): ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($row['invoice_number']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($row['invoice_date']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($row['cust_po']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($row['ship_to_name']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php echo htmlspecialchars($row['qty_ordered']); ?> ordered
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            <?php echo $row['qty_backorder'] > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800'; ?>">
                                            <?php echo $row['qty_backorder'] > 0 ? 'Partial' : 'Complete'; ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <a href="#" class="text-blue-600 hover:text-blue-900 mr-3" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="#" class="text-red-600 hover:text-red-900" title="Delete" onclick="return confirmDelete(<?php echo $row['id']; ?>)">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function exportToCSV() {
            // In a real implementation, this would generate and download a CSV file
            alert('CSV export functionality would be implemented here');
        }

        function confirmDelete(id) {
            if (confirm('Are you sure you want to delete this record?')) {
                // In a real implementation, this would make an AJAX call to delete the record
                alert('Record deletion would be implemented here for ID: ' + id);
                return true;
            }
            return false;
        }
    </script>
</body>
</html>