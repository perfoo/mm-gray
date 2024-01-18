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

</head>
<body>
<main>
    <h1>Gray Market</h1>
    <div class="container">
        <?php
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

        // Fetch and display data
        $stmt = $pdo->query('SELECT * FROM submissions');
        $hasData = false;
        while ($row = $stmt->fetch()) {
            $hasData = true;
            echo "<div class='submission'>";
            echo "<img src='" . htmlspecialchars($row['photo_path']) . "' alt='Photo'>";
            echo "<p>" . htmlspecialchars($row['text1']) . "</p>";
            echo "<p>" . htmlspecialchars($row['text2']) . "</p>";
            echo "<p>" . htmlspecialchars($row['text3']) . "</p>";
            echo "</div>";
        }

        if (!$hasData) {
            echo "<p>No data available.</p>";
        }
        ?>
    </div>
    <div class="footer">
        <a href="shop-admin.php">Powered by © 2024 MM-design</a>
    </div>
    </main>
</body>
</html>