<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "resumebuilder";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['delete']) && isset($_GET['table'])) {
    $id = intval($_GET['delete']);
    $table = $_GET['table'];
    $sql = "DELETE FROM $table WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Record deleted successfully'); window.location.href='admin.php';</script>";
    } else {
        echo "<script>alert('Error deleting record: {$conn->error}');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9f9f9;
            color: #000; /* Black font */
            margin: 0;
            padding: 0;
            /* Add background image to the entire body */
            background-image: url('./assets/images/background.jpg'); /* Path to your background image */
            background-size: cover; /* Cover the entire body */
            background-repeat: no-repeat; /* Do not repeat the image */
            background-position: center; /* Center the image */
            background-attachment: fixed; /* Fix the background while scrolling */
        }
        h1, h2 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            margin-bottom: 30px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f0e87f;
            color: black;
        }
        .delete-btn {
            background-color: red;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
        }
        .user-link {
            color: blue;
            cursor: pointer;
            text-decoration: underline;
        }
        .user-info-box {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            margin: 20px 0;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }
        .info-section {
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        .info-section:last-child {
            border-bottom: none;
        }
        .info-section h3 {
            color: #444;
            margin-bottom: 10px;
        }
        .info-item {
            margin: 5px 0;
        }
        .info-item strong {
            color: #666;
        }
    </style>
</head>
<body>
    <h1>Admin Panel</h1>
    
    <?php
    $tables = ['users'];
    
    foreach ($tables as $table) {
        echo "<h2>Users</h2>";
        $sql = "SELECT * FROM $table";
        $result = $conn->query($sql);
        
        if (!$result) {
            die("Query failed: " . $conn->error);
        }

        if ($result->num_rows > 0) {
            echo "<table><tr>";
            while ($field = $result->fetch_field()) {
                echo "<th>{$field->name}</th>";
            }
            echo "<th>Actions</th></tr>";
            
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                foreach ($row as $key => $value) {
                    if ($key == 'id') {
                        echo "<td><a href='?user_id={$value}' class='user-link'>{$value}</a></td>";
                    } else {
                        echo "<td>{$value}</td>";
                    }
                }
                echo "<td><a href='?delete={$row['id']}&table=$table' class='delete-btn' onclick='return confirm(\"Are you sure?\")'>Delete</a></td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No records found.";
        }
    }
    
    if (isset($_GET['user_id'])) {
        $user_id = intval($_GET['user_id']);
        echo "<div class='user-info-box'>";
        echo "<h2>User Information</h2>";
        
        // Fetch user basic info
        $sql = "SELECT * FROM users WHERE id = $user_id";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            $user = $result->fetch_assoc();
            echo "<div class='info-section'>";
            echo "<h3>Basic Info</h3>";
            foreach ($user as $key => $value) {
                echo "<div class='info-item'><strong>" . ucfirst($key) . ":</strong> $value</div>";
            }
            echo "</div>";
        }

        // Fetch user's resume
        $sql = "SELECT * FROM resumes WHERE user_id = $user_id";
        $resume_result = $conn->query($sql);
        
        if ($resume_result && $resume_result->num_rows > 0) {
            $resume = $resume_result->fetch_assoc();
            $resume_id = $resume['id'];
            
            echo "<div class='info-section'>";
            echo "<h3>Resume</h3>";
            foreach ($resume as $key => $value) {
                if ($key == 'photo_path' && !empty($value)) {
                    echo "<div class='info-item'><strong>Photo:</strong><br><img src='uploads/$value' alt='User Photo' style='max-width: 200px; height: auto;'></div>";
                } else {
                    echo "<div class='info-item'><strong>" . ucfirst($key) . ":</strong> $value</div>";
                }
            }
            echo "<div class='info-item'><a href='?delete={$resume['id']}&table=resumes' class='delete-btn' onclick='return confirm(\"Are you sure?\")'>Delete</a></div>";
            echo "</div>";

            // Fetch related tables using resume_id
            $related_tables = ['skills', 'experiences', 'educations'];
            foreach ($related_tables as $table) {
                // Assuming these tables have a resume_id column (adjust if different)
                $sql = "SELECT * FROM $table WHERE resume_id = $resume_id";
                $result = $conn->query($sql);
                
                if (!$result) {
                    // If resume_id doesn't exist, show all records or skip
                    echo "<div class='info-section'><h3>" . ucfirst($table) . "</h3><p>Error: " . $conn->error . ". Table might not be linked correctly.</p></div>";
                    continue;
                }

                if ($result->num_rows > 0) {
                    echo "<div class='info-section'>";
                    echo "<h3>" . ucfirst($table) . "</h3>";
                    while ($row = $result->fetch_assoc()) {
                        foreach ($row as $key => $value) {
                            echo "<div class='info-item'><strong>" . ucfirst($key) . ":</strong> $value</div>";
                        }
                        echo "<div class='info-item'><a href='?delete={$row['id']}&table=$table' class='delete-btn' onclick='return confirm(\"Are you sure?\")'>Delete</a></div>";
                    }
                    echo "</div>";
                } else {
                    echo "<div class='info-section'><h3>" . ucfirst($table) . "</h3><p>No records found.</p></div>";
                }
            }
        } else {
            echo "<div class='info-section'><h3>Resume</h3><p>No resume found for this user.</p></div>";
            // Show message for related tables since no resume exists
            $related_tables = ['skills', 'experiences', 'educations'];
            foreach ($related_tables as $table) {
                echo "<div class='info-section'><h3>" . ucfirst($table) . "</h3><p>No records available (no resume found).</p></div>";
            }
        }
        echo "</div>";
    }
    
    $conn->close();
    ?>
</body>
</html>