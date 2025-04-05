<div class="sidebar w-64 text-white bg-gray-800">
    <div class="p-4">
        <h1 class="text-xl font-bold">Admin Portal</h1>
        <p class="text-sm text-gray-300"><?php echo htmlspecialchars($_SESSION['business_name']); ?></p>
    </div>
    <nav class="mt-6">
        <a href="upload_excel.php" class="block py-2 px-4 hover:bg-gray-700 <?php echo basename($_SERVER['PHP_SELF']) === 'upload_excel.php' ? 'bg-gray-700' : ''; ?>">
            <i class="fas fa-file-upload mr-2"></i> Upload Excel
        </a>
        <a href="preview_data.php" class="block py-2 px-4 hover:bg-gray-700 <?php echo basename($_SERVER['PHP_SELF']) === 'preview_data.php' ? 'bg-gray-700' : ''; ?>">
            <i class="fas fa-table mr-2"></i> Preview Data
        </a>
        <a href="../logout.php" class="block py-2 px-4 hover:bg-gray-700 mt-4">
            <i class="fas fa-sign-out-alt mr-2"></i> Logout
        </a>
    </nav>
</div>