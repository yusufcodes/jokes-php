<?php
try
{
    include_once __DIR__.'/../includes/DatabaseConnection.php';
    include_once __DIR__.'/../includes/DatabaseFunctions.php';

    // Retrieving all records from the 'joke' table
    $result = findAll($pdo, 'joke');

    $jokes = [];

    foreach($result as $joke)
    {
        // Retrieving author details for each joke
        $author = findById($pdo, 'author', 'id', $joke['authorid']);

        // Creating a record of Joke ID, Joke Text, Joke Date, Author Name and Email
        $jokes[] = [
            'id' => $joke['id'],
            'joketext' => $joke['joketext'],
            'jokedate' => $joke['jokedate'],
            'name' => $author['name'],
            'email' => $author['email']
        ];
    }

    // Dynamically setting the title of the jokes page
    $title = 'Joke list';

    // Retrieving the total number of jokes submitted
    $totalJokes = total($pdo, 'joke');

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
?>