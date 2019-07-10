<?php
include __DIR__.'/../includes/DatabaseConnection.php';
include __DIR__.'/../classes/DatabaseTable.php';

try
{
    $jokesTable = new DatabaseTable($pdo, 'joke', 'id');

    // Query the database as joke has been edited by user
    if (isset($_POST['joketext']))
    {
        $joke = $_POST; // Extracting the ID (id) and Text (joketext) of the joke
        $joke['authorid'] = 1;
        $joke['jokedate'] = new DateTime();

        $jokeTable->save($joke);

        header('location: jokes.php');
    }

    // Load page to allow for a joke to be edited
    else
    {
        if (isset($_GET['id']))
        {
            $joke = $jokesTable->findById($_GET['id']);
        }

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