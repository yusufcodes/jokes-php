<?php
include_once __DIR__.'/../includes/DatabaseConnection.php';

include_once __DIR__.'/../includes/DatabaseFunctions.php';

echo totalJokes($pdo);
?>