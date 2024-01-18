<?php
session_start();

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

// Database credentials
$host = '89.116.147.1'; // Your actual host
$db   = 'u720534510_shop'; // Your actual database name
$user = 'u720534510_admin'; // Your actual username
$pass = 'gs500eMM'; // Your actual password
$charset = 'utf8mb4';

// Set up DSN (Data Source Name)
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// Authentication logic
$authPassword = 'SurveillanceRoom';
if (isset($_POST['password']) && $_POST['password'] === $authPassword) {
    $_SESSION['authenticated'] = true;
}

if (!isset($_SESSION['authenticated'])) {
    echo '<form style="margin: 20px auto; padding: 16px;" action="" method="post">
            <input type="password" name="password" />
            <input type="submit" value="Login" />
          </form>';
    exit;
}

// Form handling logic
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['photo'])) {
    $photo = $_FILES['photo'];
    $text1 = $_POST['text1'];
    $text2 = $_POST['text2'];
    $text3 = $_POST['text3'];

    // Define the directory to save the photo
    $uploadDir = 'uploads/';
    $uploadFile = $uploadDir . basename($photo['name']);

    // Move the photo to the directory
    if (move_uploaded_file($photo['tmp_name'], $uploadFile)) {
        // Prepare SQL query
        $stmt = $pdo->prepare('INSERT INTO submissions (photo_path, text1, text2, text3) VALUES (?, ?, ?, ?)');
        $stmt->execute([$uploadFile, $text1, $text2, $text3]);

        echo 'File and texts submitted successfully.';
    } else {
        echo 'File upload failed.';
    }
}

// Display and deletion logic
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare('DELETE FROM submissions WHERE id = ?');
    $stmt->execute([$id]);
}
?>


<!DOCTYPE html>
<html lang="hr-HR" xml:lang="hr-HR">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Gray Market - Techno Shop">
    <meta name="keywords"
        content="tehnicka roba, mobiteli, laptopi, TV uređaji, PlayStation, dronovi, alati">
    <link rel="shortcut icon" href="./icon/favicon.ico" type="image/x-icon" />
    <link rel="apple-touch-icon" href="./icon/apple-touch-icon.png" />
    <link rel="apple-touch-icon" sizes="57x57" href="./icon/apple-touch-icon-57x57.png" />
    <link rel="apple-touch-icon" sizes="72x72" href="./icon/apple-touch-icon-72x72.png" />
    <link rel="apple-touch-icon" sizes="76x76" href="./icon/apple-touch-icon-76x76.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="./icon/apple-touch-icon-114x114.png" />
    <link rel="apple-touch-icon" sizes="120x120" href="./icon/apple-touch-icon-120x120.png" />
    <link rel="apple-touch-icon" sizes="144x144" href="./icon/apple-touch-icon-144x144.png" />
    <link rel="apple-touch-icon" sizes="152x152" href="./icon/apple-touch-icon-152x152.png" />
    <link rel="apple-touch-icon" sizes="180x180" href="./icon/apple-touch-icon-180x180.png" />
    <link rel="stylesheet" href="style.css">
    
    <title>Gray Market</title>

<body>
    <main>
    <div class="container">
        <?php if (isset($_SESSION['authenticated'])): ?>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="photo">Photo:</label>
                    <input type="file" name="photo" accept="image/*" required>
                </div>
                <div class="form-group">
                    <label for="text1">Text 1:</label>
                    <input type="text" name="text1" maxlength="150" required>
                </div>
                <div class="form-group">
                    <label for="text2">Text 2:</label>
                    <input type="text" name="text2" maxlength="150" required>
                </div>
                <div class="form-group">
                    <label for="text3">Text 3:</label>
                    <input type="text" name="text3" maxlength="150" required>
                </div>
                <div class="form-group">
                    <input type="submit" value="Submit">
                </div>
            </form>
        <?php endif; ?>  
    </div>
    <?php
            $stmt = $pdo->query('SELECT * FROM submissions');
            while ($row = $stmt->fetch()) {
                echo "<div class='container'>";
                echo "<div class='submission'>";
                echo "<img src='" . htmlspecialchars($row['photo_path']) . "' alt='Photo'>";
                echo "<h4>" . htmlspecialchars($row['text1']) . "</h4>";
                echo "<p class='black'>" . htmlspecialchars($row['text2']) . "</p>";
                echo "<p>" . htmlspecialchars($row['text3']) . "</p>";
                echo "<a href='?action=delete&id=" . $row['id'] . "'>Delete</a>";
                echo "</div>";
                echo "</div>";
            }

        ?>
    <div class="footer">
        <a href="index.php">Powered by © 2024 MM-design</a>
    </div>
    </main>
</body>
</html>
