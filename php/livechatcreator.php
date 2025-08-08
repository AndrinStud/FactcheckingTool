<?php
    require_once 'config.php';
    $pdo = new PDO($dsn, $db_user, $db_pass, $options);
    session_start();
    $firstEmpty = true;
    $sites;
    
    function showTokenIfExists($index) {
        global $firstEmpty;
        if (isset($_SESSION['access_tokens'][$index])) {
            echo $_SESSION['access_tokens'][$index];
            if ($index == 4) {
                loadSitesSelect();
            }
        }
        else if ($firstEmpty) {
            require_once('tokencreate.php');
            $firstEmpty = false;
        }
    }

    function loadSitesSelect() {
        global $sites;
        global $pdo;
        $stmt = $pdo->query("SELECT id, name FROM site");
        $sites = $stmt->fetchAll();
    }
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faktenchecker - Live Chat Creator</title>
    <script src="https://kit.fontawesome.com/e5010892c5.js" crossorigin="anonymous"></script>
    <link rel="icon" type="image/x-icon" href="../images/Faktenchecker.png">
    <link rel="stylesheet" href="../css/main.css">
    <link rel="stylesheet" href="../css/livechatcreator.css">
</head>
<body>
    <header>
        <a href="http://1fakten.ch/eck"><img src="../images/Faktenchecker.png" alt="Logo"></a>
        <h1>Faktenchecker</h1>
    </header>
    <hr>
    <main>
    <h2>Livechat Comment posten</h2>
    <table>
    <tr>
        <th>Account</th>
        <th>Access Token</th>
    </tr>
    <tr>
        <td>Faktenchecker</td>
        <td class="tokenBearer">
            <?php
                showTokenIfExists(0);
            ?>
        </td>
    </tr>
    <tr>
        <td>Korrekt</td>
        <td class="tokenBearer">
            <?php
                showTokenIfExists(1);
            ?>
        </td>
    </tr>
    <tr>
        <td>Falsch</td>
        <td class="tokenBearer">
            <?php
                showTokenIfExists(2);
            ?>
        </td>
    </tr>
    <tr>
        <td>Aussage</td>
        <td class="tokenBearer">
            <?php
                showTokenIfExists(3);
            ?>
        </td>
    </tr>
    <tr>
        <td>Information</td>
        <td class="tokenBearer">
            <?php
                showTokenIfExists(4);
            ?>
        </td>
    </tr>
    <tr>
        <td><?php require_once('tokendelete.php') ?></td>
        <td>
            <form action="livechatcreator.php" method="post" id="activateLivestreamBots">
                <select id="siteSelect" name="site">
                    <option id="tokenWarning">Fülle zuerst alle Tokens aus!</option>
                </select>
            </form>
        </td>
    </tr>
</table>
<?php
if (isset($_POST['site'])) {
        require_once('livechat_botactivation.php');
    }
?>
    </main>
    <footer>
        <hr>
        <div class="footerBottom">
            <a href="https://github.com/AndrinStud/FactcheckingTool" target="_blank"><i class="fa-brands fa-github"></i>Factchecker-Code</a>
        </div>
    </footer>
    <script>
    // Markiere gefüllte Tokens und bestimme Add Token Position
    let tokenBearers = document.getElementsByClassName('tokenBearer');
    let firstEmptyBearer;
    Array.from(tokenBearers).forEach(bearer => {
        if (bearer.innerText != '' && bearer.innerText != 'Add Token') {
            bearer.style.backgroundColor = 'lightgreen';
        } else if (firstEmptyBearer == undefined) {
            firstEmptyBearer = bearer;
        }
    });

    if (firstEmptyBearer == undefined) {
        // Select richtig anzeigen
        let siteSelect = document.getElementById('siteSelect');
        siteSelect.removeChild(document.getElementById('tokenWarning'));
        let siteSelectOptions = <?php echo json_encode($sites); ?>;
        siteSelectOptions.forEach(siteSelectOption => {
            let option = document.createElement('option');
            option.value = siteSelectOption.id;
            option.innerText = siteSelectOption.name;
            siteSelect.appendChild(option);
        });

        // Zeige Livechat Bots aktivieren Link an
        let liveChatBotsStartCell = document.getElementById('activateLivestreamBots');
        let activateLivechatBots = document.createElement('input');
        activateLivechatBots.type = 'submit';
        activateLivechatBots.value = 'START LIVECHAT BOTS (Nach Knopfdruck 30s um Stream einzustellen)';
        liveChatBotsStartCell.appendChild(activateLivechatBots);
    }
</script>
</body>
</html>