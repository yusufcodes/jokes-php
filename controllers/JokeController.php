<?php
class JokeController 
{
    private $jokesTable;
    private $authorsTable;
    
    public function __construct(DatabaseTable $jokesTable, DatabaseTable $authorsTable)
    {
        $this->jokesTable = $jokesTable;
        $this->authorsTable = $authorsTable;
    }

    public function list()
    {
        // Retrieving all the jokes to display
        $result = $this->jokesTable->findAll();

        // Array to store all the joke information
        $jokes = [];

        foreach($result as $joke)
        {
            // Get individual author record for the current joke
            $author = $this->authorsTable->findById($joke['authorid']);

            $jokes[] = [
                'id' => $joke['id'],
                'joketext' => $joke['joketext'],
                'jokedate' => $joke['jokedate'],
                'name' => $author['name'],
                'email' => $author['email']
            ];
        }

        $title = 'Joke list';

        $totalJokes = $this->jokesTable->total();

        ob_start();
        include __DIR__.'/../templates/jokes.html.php';
        $output = ob_get_clean();

        return ['output' => $output, 'title' => $title];
    }

    public function home()
    {

        // Setting the title of the homepage 
        $title = 'Internet Joke Database';

        // Starting the buffer
        ob_start();
        // Storing the contents of the 'home' template into the $output variable, which is accessed
        // in the 'layout' template

        include __DIR__.'/../templates/home.html.php';

        // Dumping the buffer contents into $output
        $output = ob_get_clean();

        return ['output' => $output, 'title' => $title];
    }

    public function delete()
    {
        // Execute the delete method with the ID retrieved from the form submitted
        $this->jokesTable->delete($_POST['id']);

        // redirect
        header('location: index.php?action=list');
    }

    public function edit()
    {
        // Query the database as joke has been edited by user
        if (isset($_POST['joketext']))
        {
            $joke = $_POST; // Extracting the ID (id) and Text (joketext) of the joke
            $joke['authorid'] = 1;
            $joke['jokedate'] = new DateTime();

            $this->jokesTable->save($joke);

            header('location: index.php?action=list');
        }

        // Load page to allow for a joke to be edited
        else
        {
            if (isset($_GET['id']))
            {
                $joke = $this->jokesTable->findById($_GET['id']);
            }

            $title = 'Edit joke';
            ob_start();
            include __DIR__.'/../templates/editjoke.html.php';
            $output = ob_get_clean();

            return ['output' => $output, 'title' => $title];
        }
    }
}