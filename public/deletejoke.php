<?php
try {
    include __DIR__.'/../includes/DatabaseConnection.php';
    include __DIR__.'/../includes/DatabaseFunctions.php';

    // Execute the delete method with the ID retrieved from the form submitted
    delete($pdo, 'joke', 'id', $_POST['id']);

    // redirect
    header('location: jokes.php');
}

catch (PDOException $e)
{
    $title = 'An error has occurred';
    $output = 'Database error: '.$e->getMessage().' in '.$e->getFile().':'.$e->getLine();
}

include __DIR__.'/../templates/layout.html.php';
?>