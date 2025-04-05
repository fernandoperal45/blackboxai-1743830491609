<?php
session_start();
require_once '../config.php';

// Redirect to login if not authenticated or not admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin'])) {
    header('Location: ../index.php');
    exit;
}

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['excel_file'])) {
    try {
        // Check for upload errors
        if ($_FILES['excel_file']['error'] !== UPLOAD_ERR_OK) {
            throw new Exception('File upload error: ' . $_FILES['excel_file']['error']);
        }

        // Validate file type
        $file_type = $_FILES['excel_file']['type'];
        $allowed_types = [
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ];
        
        if (!in_array($file_type, $allowed_types)) {
            throw new Exception('Only Excel files are allowed (XLS or XLSX)');
        }

        // Move uploaded file
        $upload_dir = '../uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $file_path = $upload_dir . basename($_FILES['excel_file']['name']);
        if (!move_uploaded_file($_FILES['excel_file']['tmp_name'], $file_path)) {
            throw new Exception('Failed to move uploaded file');
        }

        // Process Excel file (placeholder - actual parsing would require PHPExcel/PhpSpreadsheet)
        // In a real implementation, you would:
        // 1. Parse the Excel file
        // 2. Validate data
        // 3. Insert into database
        $message = 'File uploaded successfully. Data processing would happen here.';

    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Excel - Admin</title>
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
                    <h2 class="text-2xl font-bold text-gray-800">Upload Excel Data</h2>
                    <a href="preview_data.php" class="text-blue-600 hover:text-blue-800">
                        <i class="fas fa-table mr-1"></i> View All Data
                    </a>
                </div>

                <?php if (!empty($message)): ?>
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($error)): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" enctype="multipart/form-data" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Excel File</label>
                        <div class="mt-1 flex items-center">
                            <label for="excel_file" class="cursor-pointer">
                                <span class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                    <i class="fas fa-upload mr-2"></i> Choose File
                                </span>
                                <input id="excel_file" name="excel_file" type="file" class="hidden" accept=".xls,.xlsx">
                            </label>
                            <span id="file-name" class="ml-2 text-sm text-gray-500">No file chosen</span>
                        </div>
                    </div>

                    <div>
                        <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <i class="fas fa-cloud-upload-alt mr-2"></i> Upload & Process
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('excel_file').addEventListener('change', function(e) {
            const fileName = e.target.files[0] ? e.target.files[0].name : 'No file chosen';
            document.getElementById('file-name').textContent = fileName;
        });
    </script>
</body>
</html>