<?php
require_once 'config.php';

// Check if already installed
if (file_exists('installed.lock')) {
    die('<h2>Installation already completed!</h2><p>Database has already been installed. Delete "installed.lock" file to reinstall.</p>');
}

try {
    // Create database if it doesn't exist
    $pdo = new PDO("mysql:host=" . DB_HOST, DB_USERNAME, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $pdo->exec("CREATE DATABASE IF NOT EXISTS " . DB_NAME);
    $pdo->exec("USE " . DB_NAME);
    
    // Create tables
    $tables = [
        // Users table (for patients and admin)
        "CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            first_name VARCHAR(50) NOT NULL,
            last_name VARCHAR(50) NOT NULL,
            email VARCHAR(100) UNIQUE NOT NULL,
            password VARCHAR(255) NOT NULL,
            phone VARCHAR(20),
            address TEXT,
            date_of_birth DATE,
            gender ENUM('Male', 'Female', 'Other'),
            user_type ENUM('patient', 'admin') DEFAULT 'patient',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )",
        
        // Departments table
        "CREATE TABLE IF NOT EXISTS departments (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            description TEXT,
            head_doctor VARCHAR(100),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )",
        
        // Doctors table
        "CREATE TABLE IF NOT EXISTS doctors (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            specialization VARCHAR(100) NOT NULL,
            qualification VARCHAR(200),
            department_id INT,
            phone VARCHAR(20),
            email VARCHAR(100),
            schedule TEXT,
            image VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE SET NULL
        )",
        
        // Appointments table
        "CREATE TABLE IF NOT EXISTS appointments (
            id INT AUTO_INCREMENT PRIMARY KEY,
            patient_id INT NOT NULL,
            doctor_id INT NOT NULL,
            appointment_date DATE NOT NULL,
            appointment_time TIME NOT NULL,
            symptoms TEXT,
            status ENUM('pending', 'confirmed', 'cancelled', 'completed') DEFAULT 'pending',
            notes TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (patient_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (doctor_id) REFERENCES doctors(id) ON DELETE CASCADE
        )",
        
        // Payments table
        "CREATE TABLE IF NOT EXISTS payments (
            id INT AUTO_INCREMENT PRIMARY KEY,
            patient_id INT NOT NULL,
            patient_name VARCHAR(100) NOT NULL,
            amount DECIMAL(10,2) NOT NULL,
            payment_method ENUM('credit_card', 'debit_card', 'cash', 'insurance') NOT NULL,
            card_number VARCHAR(20),
            transaction_id VARCHAR(100),
            status ENUM('pending', 'completed', 'failed') DEFAULT 'pending',
            payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (patient_id) REFERENCES users(id) ON DELETE CASCADE
        )",
        
        // Contact messages table
        "CREATE TABLE IF NOT EXISTS contact_messages (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL,
            subject VARCHAR(200),
            message TEXT NOT NULL,
            status ENUM('unread', 'read', 'replied') DEFAULT 'unread',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )",
        
        // Blog posts table
        "CREATE TABLE IF NOT EXISTS blog_posts (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(200) NOT NULL,
            content TEXT NOT NULL,
            author VARCHAR(100) NOT NULL,
            image VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )",
        
        // Gallery images table
        "CREATE TABLE IF NOT EXISTS gallery_images (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(100) NOT NULL,
            description TEXT,
            image_path VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )"
    ];
    
    // Execute table creation
    foreach ($tables as $table) {
        $pdo->exec($table);
    }
    
    // Insert sample data
    
    // Insert admin user
    $adminPassword = password_hash(ADMIN_PASSWORD, PASSWORD_DEFAULT);
    $pdo->exec("INSERT IGNORE INTO users (first_name, last_name, email, password, user_type) 
                VALUES ('Admin', 'User', '" . ADMIN_EMAIL . "', '$adminPassword', 'admin')");
    
    // Insert departments
    $departments = [
        ['Cardiology', 'Heart and cardiovascular diseases treatment', 'Dr. Smith Johnson'],
        ['Neurology', 'Brain and nervous system disorders', 'Dr. Emily Brown'],
        ['Pediatrics', 'Child healthcare and treatment', 'Dr. Michael Davis'],
        ['Orthopedics', 'Bone and joint related treatments', 'Dr. Sarah Wilson'],
        ['Dermatology', 'Skin and hair related treatments', 'Dr. Jessica Alam'],
        ['Ophthalmology', 'Eye care and vision treatment', 'Dr. Prime Biswajit'],
        ['General Surgery', 'Surgical procedures and operations', 'Dr. Prity Ahosan'],
        ['Emergency Medicine', 'Emergency and critical care', 'Dr. Nabinur Islam']
    ];
    
    $stmt = $pdo->prepare("INSERT IGNORE INTO departments (name, description, head_doctor) VALUES (?, ?, ?)");
    foreach ($departments as $dept) {
        $stmt->execute($dept);
    }
    
    // Insert doctors
    $doctors = [
        ['Dr. Md. Abu Zisan Provat', 'Child care', 'Consultant', 1, '+8801765489641', 'provat@unity.com'],
        ['Dr. Zehad Hasan', 'Neurology', 'MBBS', 2, '+8801765489642', 'zehad@unity.com'],
        ['Dr. Prity Ahosan', 'General Surgery', 'MBBS, MS, DNB', 7, '+8801765489643', 'prity@unity.com'],
        ['Dr. Nabinur Islam Rony', 'Health Checkup', 'MBBS', 8, '+8801765489644', 'rony@unity.com'],
        ['Dr. Jessica Alam Jui', 'Dermatology', 'MD', 5, '+8801765489645', 'jessica@unity.com'],
        ['Dr. Prime Biswajit Barua', 'Eye Specialist', 'MBBS, MS, MD', 6, '+8801765489646', 'prime@unity.com'],
        ['Dr. Samsun Nahar Borsha', 'CCU & ICU', 'MBBS', 8, '+8801765489647', 'borsha@unity.com'],
        ['Dr. Ashraful Islam Ropin', 'Health Checkup', 'MBBS', 8, '+8801765489648', 'ropin@unity.com']
    ];
    
    $stmt = $pdo->prepare("INSERT IGNORE INTO doctors (name, specialization, qualification, department_id, phone, email) VALUES (?, ?, ?, ?, ?, ?)");
    foreach ($doctors as $doctor) {
        $stmt->execute($doctor);
    }
    
    // Insert sample blog posts
    $blogs = [
        [
            'Top 10 Health Tips for Better Living',
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
            'Dr. Admin'
        ],
        [
            'Importance of Regular Health Checkups',
            'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'Dr. Smith'
        ],
        [
            'Mental Health Awareness in Modern Times',
            'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt.',
            'Dr. Emily'
        ],
        [
            'Nutrition and Healthy Lifestyle',
            'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident.',
            'Dr. Michael'
        ]
    ];
    
    $stmt = $pdo->prepare("INSERT IGNORE INTO blog_posts (title, content, author) VALUES (?, ?, ?)");
    foreach ($blogs as $blog) {
        $stmt->execute($blog);
    }
    
    // Insert gallery images
    $gallery = [
        ['Hospital Building', 'Main hospital building exterior view', 'assets/img/gallery/hospital.jpg'],
        ['OPD Area', 'Outpatient department waiting area', 'assets/img/gallery/opd.jpg'],
        ['Patient Rooms', 'Comfortable patient accommodation', 'assets/img/gallery/room1.jpg'],
        ['Reception Area', 'Hospital main reception desk', 'assets/img/gallery/reception.jpg'],
        ['Parking Facility', 'Hospital parking area', 'assets/img/gallery/parking.jpg'],
        ['Platinum Wing', 'Premium healthcare facilities', 'assets/img/gallery/platinum_wing.jpg'],
        ['Catheterization Lab', 'Advanced cardiac procedures lab', 'assets/img/gallery/cath_lab.jpg'],
        ['OPD Area 2', 'Additional outpatient facilities', 'assets/img/gallery/opd2.jpg']
    ];
    
    $stmt = $pdo->prepare("INSERT IGNORE INTO gallery_images (title, description, image_path) VALUES (?, ?, ?)");
    foreach ($gallery as $image) {
        $stmt->execute($image);
    }
    
    // Create installation lock file
    file_put_contents('installed.lock', date('Y-m-d H:i:s'));
    
    echo "<h2>Installation Successful!</h2>";
    echo "<p>Database and tables have been created successfully.</p>";
    echo "<h3>Default Admin Credentials:</h3>";
    echo "<p><strong>Email:</strong> " . ADMIN_EMAIL . "</p>";
    echo "<p><strong>Password:</strong> " . ADMIN_PASSWORD . "</p>";
    echo "<p><a href='index.php'>Go to Homepage</a> | <a href='login.php'>Admin Login</a></p>";
    
} catch(PDOException $e) {
    echo "<h2>Installation Failed!</h2>";
    echo "<p>Error: " . $e->getMessage() . "</p>";
}
?>
