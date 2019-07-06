<?php 
if (isset($_POST['joketext']))
{
    try
    {
        // Connect to the database and perform an INSERT operation
        include __DIR__.'/../includes/DatabaseConnection.php';

        // SQL Query with placeholders - Prepared Statement
        // Use prepare method on SQL query
        // :joketext = placeholder, refer to this in the bindValue method after prepare method
        // CURDATE(): Built in SQL method to get the current date
        $sql = 
        'INSERT INTO `joke`
        SET `joketext` = :joketext,
        `jokedate` = CURDATE()';

        $stmt = $pdo->prepare($sql); // RETURN: PDOStatement object
        $stmt->bindValue(':joketext', $_POST['joketext']);
        $stmt->execute();

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