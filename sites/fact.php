<?php
    require_once '../php/config.php';
    $pdo = new PDO($dsn, $db_user, $db_pass, $options);
    $id = $_GET['id'] ?? '';

    // Aussage
    $stmt = $pdo->query(query: "SELECT site, a.name as fact_type, f.site, f.quote_by, f.comment, f.video_timestamp_end 
                                    FROM fact f 
                                    JOIN account a ON f.account = a.id
                                    WHERE f.id='$id'");
    $fact = $stmt->fetch();
    if (!$fact || $fact['fact_type'] != "Aussage") {
        header("Location: http://1fakten.ch/eck");
        exit;
    }
    echo "Aussage: " . $fact['comment'] . "<br><br>";

    // Antwort
    $site_id = $fact['site'];
    $stmt = $pdo->query("SELECT f.comment, f.video_timestamp_end 
                      FROM fact f 
                      WHERE f.site='" . $site_id . "' AND f.video_timestamp_end <= " . ($fact['video_timestamp_end'] + 2) . " AND f.id != '$id'");
    $facts = $stmt->fetchAll();
    if (empty($facts)) {
        header("Location: http://1fakten.ch/eck");
        exit;
    }
    while (true){
        $last_fact = end($facts);
        $stmt = $pdo->query("SELECT f.comment, f.video_timestamp_end 
                        FROM fact f 
                        WHERE f.site='" . $site_id . "' AND f.video_timestamp_end > " . $last_fact['video_timestamp_end'] . " AND f.video_timestamp_end <= " . ($last_fact['video_timestamp_end'] + 1));
        $next_fact = $stmt->fetch();
        if (empty($next_fact)) {
            break;
        }
        else {
            $facts[] = $next_fact;
        }
    }
    $facts_string = "";
    foreach ($facts as $fact) {
        $facts_string .= $fact['comment'] . " ";
    }
    echo "Facts: " . $facts_string . "<br><br>";

    // Quellen
    $stmt = $pdo->query("SELECT link FROM source WHERE fact='$id'");
    $sources = $stmt->fetchAll();
    $sourcesString = "";
    if (empty($sources)) {
        $sourcesString = "Keine Quellen gefunden.";
    }
    else {
        foreach ($sources as $source) {
            $sourcesString .= "<a href='" . $source['link'] . "' target='_blank'>" . $source['link'] . "</a><br>";
        }
    }
    echo "Quellen: " . $sourcesString;
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