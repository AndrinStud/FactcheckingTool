<?php
require_once '../php/config.php';
$pdo = new PDO($dsn, $db_user, $db_pass, $options);

$id = $_GET['id'] ?? '';
$stmt = $pdo->query("SELECT id, name, description, video_id FROM site WHERE shortenend_name_url='$id'");
$site = $stmt->fetch();
if (!$site) {
    header("Location: http://1fakten.ch/eck");
    exit;
}
$site_id = $site['id'];

$stmt = $pdo->query("SELECT a.name, f.comment, f.video_timestamp_end 
                      FROM fact f 
                      JOIN account a ON f.account = a.id 
                      WHERE f.site='" . $site_id . "'");
$facts = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faktenchecker - <?php echo $site['name']; ?></title>
    <script src="https://kit.fontawesome.com/e5010892c5.js" crossorigin="anonymous"></script>
    <link rel="icon" type="image/x-icon" href="images/Faktenchecker.png">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/article.css">
</head>
<body>
    <header>
        <a href="http://1fakten.ch/eck"><img src="../images/Faktenchecker.png" alt="Logo"></a>
        <h1>Faktenchecker</h1>
    </header>
    <hr>
    <main>
        <section class="titleAndLead">
            <h2><?php echo $site['name']; ?></h2>
            <p><?php echo $site['description']; ?></p>
        </section>
        <section class="playerAndFactcheck">
            <aside id="player"></aside>
            <article id="factcheck">
                <div id="checkArea"></div>
            </article>
        </section>
    </main>
    <footer>
        <hr>
        <div class="footerBottom">
            <a href="https://github.com/AndrinStud/FactcheckingTool" target="_blank"><i class="fa-brands fa-github"></i>Factchecker-Code</a>
        </div>
    </footer>
    <script type="module">
        import { Factchecker } from "../js/Factchecker.js";
        let facts = <?php echo json_encode($facts); ?>;
        new Factchecker("<?php echo $site['video_id']; ?>", facts);
    </script>
</body>
</html>