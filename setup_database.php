<?php
require_once 'config.php';

try {
    // Create users table
    $conn->exec("DROP TABLE IF EXISTS users");
    $create_users = "CREATE TABLE users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        business_name VARCHAR(255) NOT NULL,
        first_name VARCHAR(100) NOT NULL,
        last_name VARCHAR(100) NOT NULL,
        address TEXT NOT NULL,
        email VARCHAR(255) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        is_admin BOOLEAN DEFAULT FALSE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    $conn->exec($create_users);
    echo "Users table created successfully.<br>";
    
    // Create admin user
    $hashed_password = password_hash('admin123', PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (business_name, first_name, last_name, address, email, password, is_admin) 
                               VALUES (?, ?, ?, ?, ?, ?, TRUE)");
        $stmt->bind_param("ssssss", 
            "Admin Business", 
            "Admin", 
            "User", 
            "123 Admin Street", 
            "admin@example.com", 
            $hashed_password
        );
        $stmt->execute();
        echo "Admin user created.<br>";
    } else {
        throw new Exception("Error creating users table: " . $conn->error);
    }

    // Create shipping_data table
    $conn->query("DROP TABLE IF EXISTS shipping_data");
    $create_shipping = "CREATE TABLE shipping_data (
        id INT AUTO_INCREMENT PRIMARY KEY,
        invoice_number VARCHAR(255) NOT NULL,
        invoice_date DATE NOT NULL,
        trans_date DATE NOT NULL,
        cust_po VARCHAR(255) NOT NULL,
        ship_via VARCHAR(100),
        comment TEXT,
        ship_to_name VARCHAR(255),
        item_code VARCHAR(100),
        description TEXT,
        qty_ordered INT DEFAULT 0,
        qty_shipped INT DEFAULT 0,
        qty_backorder INT DEFAULT 0,
        pro_number VARCHAR(100),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX (cust_po),
        INDEX (comment(255))
    )";
    
    if ($conn->query($create_shipping)) {
        echo "Shipping_data table created successfully.<br>";
        
        // Insert sample data
        $sample_data = [
            ['INV-1001', '2023-01-15', '2023-01-10', 'PO-001', 'FedEx', 'Urgent delivery', 'Acme Corp', 'ITEM-001', 'Widget A', 100, 100, 0, 'PRO1001'],
            ['INV-1002', '2023-01-20', '2023-01-18', 'PO-002', 'UPS', 'Standard delivery', 'Globex Inc', 'ITEM-002', 'Gadget B', 50, 30, 20, 'PRO1002'],
            ['INV-1003', '2023-02-05', '2023-02-01', 'PO-003', 'DHL', 'International', 'Contoso Ltd', 'ITEM-003', 'Thing C', 200, 200, 0, 'PRO1003']
        ];
        
        $stmt = $conn->prepare("INSERT INTO shipping_data 
            (invoice_number, invoice_date, trans_date, cust_po, ship_via, comment, ship_to_name, item_code, description, qty_ordered, qty_shipped, qty_backorder, pro_number) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        foreach ($sample_data as $data) {
            $stmt->bind_param("sssssssssiiis", ...$data);
            $stmt->execute();
        }
        echo "Sample shipping data inserted.<br>";
    } else {
        throw new Exception("Error creating shipping_data table: " . $conn->error);
    }

    // Create uploads directory
    if (!is_dir('uploads')) {
        mkdir('uploads', 0755, true);
        echo "Uploads directory created.<br>";
    }

    echo "<h2>Database setup completed successfully!</h2>";
    echo "<p>You can now <a href='index.php'>login</a> using:</p>";
    echo "<p>Email: admin@example.com<br>Password: admin123</p>";
    echo "<p><strong>Important:</strong> Delete this file after setup for security reasons.</p>";

} catch (Exception $e) {
    echo "<div style='color:red;'><strong>Error:</strong> " . $e->getMessage() . "</div>";
}
?>