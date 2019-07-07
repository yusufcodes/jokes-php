<?php
// DatabaseFunctions.php: Functions created to query the ijdb database

function processDates($fields)
{
    foreach ($fields as $key => $value)
    {
        if ($value instanceof DateTime)
        {
            $fields[$key] = $value->format('Y-m-d');
        }
    }

    return $fields;
}

/* **totalJokes**
// Purpose:
Allows for the number of jokes stored in the database to be retrieved
// Parameters:
$pdo: PDO object to interact with the database
*/
function totalJokes($pdo)
{
    $query = query($pdo, 'SELECT COUNT(*) FROM `joke`');
    $row = $query->fetch();
    return $row[0];
}

/* **getJoke**
// Purpose:
Allows for a specific joke to be selected from the database based on ID
// Parameters:
$pdo: PDO object to interact with the database
$id: ID of the joke to be retrieved from the database
*/
function getJoke($pdo, $id)
{
    // Array, $parameters, to be used in the query function
    $parameters = [':id' => $id];
    $query = query($pdo, 'SELECT * FROM `joke` WHERE `id` = :id', $parameters);
    return $query->fetch();
}

/* ** insertJoke **
// Purpose:
Allows for a joke to be added to the database
// Parameters:
$pdo: PDO object to interact with the database
$joketext: The joke to be added to the database
$authorId: The ID of the author who wrote the joke
*/
/*
function insertJoke($pdo, $joketext, $authorId)
{
    $query = 'INSERT INTO `joke` VALUES (:joketext, CURDATE(), :authorId)';
    $parameters = [
    ':joketext' => $joketext,
    ':authorId' => $authorId];
    query($pdo, $query, $parameters);
}*/

function insertJoke($pdo, $fields)
{
    $query = 'INSERT INTO `joke` (';

    foreach ($fields as $key => $value)
    {
        $query .= '`' . $key . '`,';
    }

    $query = rtrim($query, ',');

    $query .= ') VALUES (';

    foreach ($fields as $key => $value)
    {
        $query .= ':' . $key . ',';
    }

    $query = rtrim($query, ',');

    $query .= ')';

    $fields = processDates($fields);

    query($pdo, $query, $fields);
}
/* ** updateJoke **
// Purpose:
Allows for an existing joke to be updated
// Parameters:
$pdo: PDO object to interact with the database
$jokeId: The ID of the joke to be edited
$joketext: The new joke text to be added
$authorId: The new joke author id to be added
*/
/*
function updateJoke($pdo, $jokeId, $joketext, $authorId)
{
    $parameters = [
        ':joketext' => $joketext,
        ':authorId' => $authorId,
        ':id' => $jokeId];
    
    query($pdo, 'UPDATE `joke` SET `authorId` = :authorId, `joketext` = :joketext WHERE `id` = :id', $parameters);
}
*/

/*
$pdo: PDO object to interact with the database
$fields: An array containing the fields that will be updated
*/
function updateJoke($pdo, $fields)
{
    $query = 'UPDATE `joke` SET ';

    foreach($fields as $key => $value)
    {
        $query .= '`' . $key . '` = :'.$key . ',';
    }

    $query = rtrim($query, ',');

    $query .= ' WHERE `id` = :primaryKey';

    $fields['primaryKey'] = $fields['id'];

    $fields = processDates($fields);

    query($pdo, $query, $fields);
}

/* **deleteJoke**
// Purpose:
Allows for a joke from the database to be deleted based on its ID
// Parameters:
$pdo: PDO object to interact with the database
$id: ID of the joke to be deleted
*/
function deleteJoke($pdo, $id)
{
    $parameters = [':id' => $id];
    query($pdo, 'DELETE FROM `joke` WHERE `id` = :id', $parameters);
}

/* **allJokes**
// Purpose:
Allows for all of the jokes in the database to be retrieved
// Parameters:
$pdo: PDO object to interact with the database
*/
function allJokes($pdo)
{
    $jokes = query($pdo, 'SELECT `joke`.`id`, `joketext`, `name`, `email`
    FROM `joke` INNER JOIN `author`
    ON `authorid` = `author`.`id`');

    return $jokes->fetchAll();
}
/* **query**
// Purpose:
Method to run an SQL query, given a PDO object and SQL query and optionally, an array
of parameters. 
// Parameters:
$pdo: PDO object to interact with the database
$sql: A string containing the SQL query to be executed
$parameters[]: An array of all the parameters to be binded to the prepared SQL statement.
// Default value for $parameters is [], for queries that have 0 parameters
// If the function is passed in $pdo and $sql, $parameters will default to an empty array
*/
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