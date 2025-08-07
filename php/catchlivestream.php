<?php
    $dateTimeNow =  new DateTime('now', new DateTimeZone('UTC'));
    $dateTimeNow->format('Y-m-d H:i:s');
    $headersLmlb = [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $heimatstadtToken
    ];
    for ($i = 0; $i < 120; $i++) {
        $listMyLiveBroadcasts = http_get("https://www.googleapis.com/youtube/v3/liveBroadcasts?part=snippet&broadcastType=all&mine=true", $headersLmlb);
        if($listMyLiveBroadcasts->items != null) {
            foreach ($listMyLiveBroadcasts->items as $item) {
                if (($item->snippet->actualStartTime == null) || ($item->snippet->liveChatId == null)) {
                    continue;
                }
                $streamStartTime = new DateTime($item->snippet->actualStartTime, new DateTimeZone('UTC'));
                $streamStartTime->format('Y-m-d H:i:s');
                if ($streamStartTime > $dateTimeNow) {
                    return $item->snippet->liveChatId;
                }
            }
        }
        usleep(250000);
    }
    return null;
?>