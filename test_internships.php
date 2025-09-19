<?php
// Test file for internships API
require_once 'config/database.php';

echo "<h1>Test Internships API</h1>";

try {
    $conn = getConnection();
    echo "<p style='color: green;'>✓ Database connection successful</p>";
    
    // Test table exists
    $stmt = $conn->query("SHOW TABLES LIKE 'internships'");
    if ($stmt->rowCount() > 0) {
        echo "<p style='color: green;'>✓ Table 'internships' exists</p>";
        
        // Test table structure
        $stmt = $conn->query("DESCRIBE internships");
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "<h3>Table Structure:</h3>";
        echo "<table border='1' style='border-collapse: collapse;'>";
        echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>";
        foreach ($columns as $column) {
            echo "<tr>";
            echo "<td>" . $column['Field'] . "</td>";
            echo "<td>" . $column['Type'] . "</td>";
            echo "<td>" . $column['Null'] . "</td>";
            echo "<td>" . $column['Key'] . "</td>";
            echo "<td>" . $column['Default'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        // Test data count
        $stmt = $conn->query("SELECT COUNT(*) as count FROM internships");
        $count = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "<p>Total records: " . $count['count'] . "</p>";
        
        // Test upload directories
        echo "<h3>Upload Directories:</h3>";
        $uploadPaths = [
            'Temp Directory' => sys_get_temp_dir() . '/uploads/',
            'Public Uploads' => __DIR__ . '/public/uploads/',
            'Root Uploads' => __DIR__ . '/uploads/',
            'Current Directory' => __DIR__ . '/'
        ];
        
        foreach ($uploadPaths as $name => $path) {
            if (is_dir($path)) {
                echo "<p style='color: green;'>✓ $name: $path (exists)</p>";
                $files = scandir($path);
                $imageFiles = array_filter($files, function($file) {
                    return $file != '.' && $file != '..' && (strpos($file, 'internship_') === 0 || strpos($file, 'dress_') === 0);
                });
                echo "<p>Image files: " . count($imageFiles) . "</p>";
            } else {
                echo "<p style='color: orange;'>⚠ $name: $path (does not exist)</p>";
            }
        }
        
    } else {
        echo "<p style='color: red;'>✗ Table 'internships' does not exist</p>";
        echo "<p>Please create the table with the following SQL:</p>";
        echo "<pre>";
        echo "CREATE TABLE internships (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_name VARCHAR(255) NOT NULL,
    image_url VARCHAR(500),
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);";
        echo "</pre>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Error: " . $e->getMessage() . "</p>";
}

echo "<h3>Test API Endpoints:</h3>";
echo "<p><a href='api/internships.php' target='_blank'>GET /api/internships.php</a></p>";
echo "<p><a href='internships.html' target='_blank'>Management Page</a></p>";
echo "<p><a href='internship.html' target='_blank'>Public Page</a></p>";
?>
