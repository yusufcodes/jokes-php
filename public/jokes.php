<?php
try
{
    include_once __DIR__.'/../includes/DatabaseConnection.php';
    include_once __DIR__.'/../includes/DatabaseFunctions.php';

    $result = findAll($pdo, 'joke');

    $jokes = [];

    foreach($result as $joke)
    {
        $author = findById($pdo, 'author', 'id', $joke['authorid']);

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
?>