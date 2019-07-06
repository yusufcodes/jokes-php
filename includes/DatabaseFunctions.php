<?php
function totalJokes($pdo)
{
    $query = query($pdo, 'SELECT COUNT(*) FROM `joke`');
    $row = $query->fetch();
    return $row[0];
}

function getJoke($pdo, $id)
{
    // Array, $parameters, to be used in the query function
    $parameters = [':id' => $id];
    $query = query($pdo, 'SELECT * FROM `joke` WHERE `id` = :id', $parameters);
    return $query->fetch();
}

/* ** insertJokes **
// Purpose:
Allows for a joke to be added to the database
// Parameters:
$pdo: PDO object to interact with the database
$joketext: The joke to be added to the database
$authorId: The ID of the author who wrote the joke
*/
function insertJoke($pdo, $joketext, $authorId)
{
    $query = 'INSERT INTO `joke` VALUES (:joketext, CURDATE(), :authorId)';
    $parameters = [
    ':joketext' => $joketext,
    ':authorId' => $authorId];
    query($pdo, $query, $parameters);
}

// Method to run an SQL query, given a PDO object and SQL query

// Default value for $parameters is [], for queries that have 0 parameters
// If the function is passed in $pdo and $sql, $parameters will default to an empty array
function query($pdo, $sql, $parameters = [])
{
    $query = $pdo->prepare($sql);

    /* Before: */
    /* Uses the $name and $value pair, to pass into the bindValue function,
    where $name is the parameter to be filled, and $value is the actual value 
    to be assigned in the prepared statement. */
    /*
    foreach ($parameters as $name => $value)
    {
        $query->bindValue($name, $value);
    }
    $query->execute();
    */

    /* After: */
    /* Execute method can accept an array of parameters to be executed, so
    no need to manually do this (as done in the 'Before' code) */
    $query->execute($parameters);

    return $query;
}
?>