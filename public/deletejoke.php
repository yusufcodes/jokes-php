<?php
try {
    include __DIR__.'/../includes/DatabaseConnection.php';

    $sql = 'DELETE FROM `joke` WHERE `id` = :id';
    //prepare
    $stmt = $pdo->prepare($sql);

    // bindValue
    $stmt->bindValue(':id', $_POST['id']);
    $stmt->execute();

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