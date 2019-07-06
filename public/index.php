<?php
// Setting the title of the homepage 
$title = 'Internet Joke Database';

// Starting the buffer
ob_start();
// Storing the contents of the 'home' template into the $output variable, which is accessed
// in the 'layout' template

include __DIR__.'/../templates/home.html.php';

// Dumping the buffer contents into $output
$output = ob_get_clean();

include __DIR__.'/../templates/layout.html.php';
?>