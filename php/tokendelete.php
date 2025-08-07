<?php
// Destroy all tokens
if (isset($_GET['destroy_tokens'])) {
    unset($_SESSION['access_tokens']);
    echo '<p>Alle Tokens wurden zerstört.</p>';
    echo '<script>window.location.href = window.location.pathname;</script>'; // Full page reload without GET parameters
}

if (!isset($_GET['code'])) {
    echo '<p><a href="?destroy_tokens=1">Destroy All Tokens</a></p>';
}
?>