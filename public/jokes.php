<?php
try
{
    // Including the file allowing for the establishment of the database to occur
    include_once __DIR__.'/../includes/DatabaseConnection.php';

    // Including the files allowing for functions querying the database to be accessed 
    include_once __DIR__.'/../includes/DatabaseFunctions.php';

    $jokes = allJokes($pdo);

    // Dynamically setting the title of the jokes page
    $title = 'Joke list';

    $totalJokes = totalJokes($pdo);

    // Output buffer: save contents into a buffer, doesn't get displayed in the browser straight away
    ob_start();
    include __DIR__.'/../templates/jokes.html.php';
    $output = ob_get_clean();
}

catch (PDOException $e)
{
    $output = 'Database error: '.$e->getMessage().' in '.$e->getFile().':'.$e->getLine();
}

include __DIR__.'/../templates/layout.html.php';

// Querying the select statement to retrieve all jokes
    // $sql = 'SELECT `id`, `joketext` FROM `joke`';

    // Adding each joke to an array
    
    // while ($row = $result->fetch())
    // {
        // OLD: $jokes[] = $row['joketext'];

        /* OLD OLD: Each element is now an associative array with two values,
        id and joketext */
        /*
        $jokes[] = [
            'id' => $row['id'],
            'joketext' => $row['joketext']
        ];
        */
    // }

    /* *** UPDATE ***
    $sql = 'UPDATE joke SET jokedate="2012-04-01" WHERE joketext LIKE "%programmer%"';

    $affectedRows = $pdo->exec($sql);

    $output = 'Updated '.$affectedRows. ' rows. ';
    */