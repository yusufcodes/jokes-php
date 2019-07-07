<?php 
if (isset($_POST['joketext']))
{
    try
    {
        include __DIR__.'/../includes/DatabaseConnection.php';
        include __DIR__.'/../includes/DatabaseFunctions.php';

        //insertJoke($pdo, $_POST['joketext'], 1);

        insertJoke($pdo, ['authorId' => 1,
        'joketext' => $_POST['joketext'],
        'jokedate' => new DateTime()
        ]);

        header('location: jokes.php');
    }

    catch (PDOException $e)
    {
        $title = 'An error has occurred';
        $output = 'Database error: '.$e->getMessage().' in '.$e->getFile().':'.$e->getLine();
    }
} // End of if (isset) ...

else
{
    // Prompt the user to enter a new joke
    $title = 'Add a new joke';

    ob_start();

    include __DIR__.'/../templates/addjoke.html.php';

    $output = ob_get_clean();
}

include __DIR__.'/../templates/layout.html.php';

?>