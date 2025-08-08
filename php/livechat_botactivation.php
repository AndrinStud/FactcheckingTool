<?php
    // Hilfsfunktion: Führt eine HTTP-POST-Anfrage aus
    function http_post($url, $headers, $body)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response);
    }

    // Hilfsfunktion: Führt eine HTTP-GET-Anfrage aus
    function http_get($url, $headers)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response);
    }

    // Hilfsfunktion: Gibt die aktuelle Zeit zurück
    function getCurrentTime() {
        return date('Y-m-d H:i:s');
    }

    function postYtLivechatComment($livechatId, $comment, $accessToken) {
        $url = 'https://youtube.googleapis.com/youtube/v3/liveChat/messages?part=snippet';
        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $accessToken
        ];
        $body = json_encode([
            'snippet' => [
                'type' => 'textMessageEvent',
                'liveChatId' => $livechatId,
                'textMessageDetails' => [
                    'messageText' => $comment
                ]
            ]
        ]);
        return http_post($url, $headers, $body);
    }

    $faktencheckToken = $_SESSION['access_tokens'][0];
    $korrektToken = $_SESSION['access_tokens'][1];
    $falschToken = $_SESSION['access_tokens'][2];
    $aussageToken = $_SESSION['access_tokens'][3];
    $informationToken = $_SESSION['access_tokens'][4];

    echo "Fakten werden aus DB geladen...<br>";

    $site_id = $_POST['site'];
    $stmt = $pdo->query("SELECT a.name, f.comment, f.video_timestamp_end 
                        FROM fact f 
                        JOIN account a ON f.account = a.id 
                        WHERE f.site='" . $site_id . "'");
    $facts = $stmt->fetchAll();

    if ($facts == null) {
        echo 'Keine Fakten gefunden';
    }
    else {
        echo 'Fakten erfolgreich aus DB geladen<br>';
        echo "Livestream wird gesucht...<br>";

        // Livestream finden
        $livechatId = require_once('catchlivestream.php');
        if ($livechatId == null) {
            echo 'Kein Livestream gefunden';
        }
        else {
            echo 'Livestream erfolgreich gefunden: ' . $livechatId . '<br>';
            echo 'Kommentare werden gepostet...<br>';

            // Kommentare posten
            $factCount = count($facts);
            for ($i = 0; $i < $factCount; $i++) {
                $fact = $facts[$i];
                $comment = $fact['comment'];
                $accessToken = null;
                if ($fact['name'] == 'Korrekt') {
                    $accessToken = $korrektToken;
                }
                else if ($fact['name'] == 'Falsch') {
                    $accessToken = $falschToken;
                }
                else if ($fact['name'] == 'Aussage') {
                    $accessToken = $aussageToken;
                }
                else if ($fact['name'] == 'Information') {
                    $accessToken = $informationToken;
                }
                if ($accessToken != null) {
                    $response = postYtLivechatComment($livechatId, $comment, $accessToken);
                    if ($response != null) {
                        echo 'Kommentar gepostet: ' . $comment . '<br>';
                    }
                    else {
                        echo 'Fehler beim Posten des Kommentars: ' . $comment . '<br>';
                    }
                }
                else {
                    echo 'Kein Access Token gefunden für: ' . $fact['name'] . '<br>';
                }

                // Wartezeit bis zum nächsten Kommentar
                if ($i < $factCount - 1) {
                    $timeToSleep = $facts[$i + 1]['video_timestamp_end'] - $fact['video_timestamp_end'];
                    usleep($timeToSleep * 1000);
                }
            }
        }
    }
?>