<?php
function totalJokes($pdo)
{
    $query = query($pdo, 'SELECT COUNT(*) FROM `joke`');
    $row = $query->fetch();
    return $row[0];
}

/*
function getJoke($pdo, $id)
{
    $query = $pdo->prepare('SELECT FROM `joke` WHERE `id` = :id');
    $query->bindValue(':id', $id);
    $query->execute();
    return $query->fetch();
}

function getJokeNew($pdo, $id)
{
    $sql = 'SELECT FROM `joke` WHERE `id` = '.$id;
    $query = query($pdo, $sql);
    return $query->fetch();
}
*/

function getJoke($pdo, $id)
{
    // Array, $parameters, to be used in the query function
    $parameters = [':id' => $id];
    $query = query($pdo, 'SELECT * FROM `joke` WHERE `id` = :id', $parameters);
    return $query->fetch();

}

// Method to run an SQL query, given a PDO object and SQL query

// Default value for $parameters is []
function query($pdo, $sql, $parameters = [])
{
    $query = $pdo->prepare($sql);

    foreach ($parameters as $name => $value)
    {
        $query->bindValue($name, $value);
    }

    $query->execute();
    return $query;
}

/*
function totalJokes($pdo)
{
    $query = $pdo->prepare('SELECT COUNT(*) FROM `joke`');
    $query->execute();
    $row = $query->fetch();
    return $row[0];
}
*/

?>