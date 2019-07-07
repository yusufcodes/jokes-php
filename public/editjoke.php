<?php
include __DIR__.'/../includes/DatabaseConnection.php';
include __DIR__.'/../includes/DatabaseFunctions.php';

try
{
    if (isset($_POST['joketext']))
    {
        //updateJoke($pdo, $_POST['jokeid'], $_POST['joketext'], 1);

        update($pdo, 'joke', 'id', [
            'id' => $_POST['jokeid'],
            'joketext' => $_POST['joketext'],
            'authorId' => 1
        ]);

        header('location: jokes.php');
    }

    else
    {
        $joke = findById($pdo, 'joke', 'id', $_GET['id']);
        $title = 'Edit joke';
        ob_start();
        include __DIR__.'/../templates/editjoke.html.php';
        $output = ob_get_clean();
    }

}

catch (PDOException $e)
{
    $title = 'An error has occurred';

    $output = 'Database error: '.$e->getMessage().' in '.$e->getFile().':'.$e->getLine();

}

include __DIR__.'/../templates/layout.html.php';

?>