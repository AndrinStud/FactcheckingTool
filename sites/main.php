<?php
    require_once '../php/config.php';
    $pdo = new PDO($dsn, $db_user, $db_pass, $options);

    $stmt = $pdo->query(query: "SELECT name, shortenend_name_url FROM site");
    $sites = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faktenchecker - Startseite</title>
    <script src="https://kit.fontawesome.com/e5010892c5.js" crossorigin="anonymous"></script>
    <link rel="icon" type="image/x-icon" href="images/Faktenchecker.png">
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>
    <header>
        <img src="../images/Faktenchecker.png" alt="Logo">
        <h1>Faktenchecker</h1>
    </header>
    <hr>
    <main class="videoList">
        <h2>Geprüfte Sendungen:</h2>
        <ul>
            <?php foreach ($sites as $site): ?>
                <li>
                    <a href="http://1fakten.ch/eck-<?php echo $site['shortenend_name_url'];?>">
                        <?php echo $site['name'] ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </main>
    <footer>
        <hr>
        <div class="footerBottom">
            <a href="https://github.com/AndrinStud/FactcheckingTool" target="_blank"><i class="fa-brands fa-github"></i>Factchecker-Code</a>
        </div>
    </footer>
</body>
</html>