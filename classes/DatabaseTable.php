<?php

class DatabaseTable
{ 
    private $pdo; // Database connection
    private $table; // Table to be queried by this instance of the class
    private $primaryKey; // The primary key identifier for specified table

    public function __construct(PDO $pdo, string $table, string $primaryKey)
    {
        $this->pdo = $pdo;
        $this->table = $table;
        $this->primaryKey = $primaryKey;
    }

    /* total: Retrieve the total number of records from a database
    $pdo: The PDO object to interact with the database
    $table: The table of which total number of records are to be selected from
    */
    public function total()
    {
        $query = $this->query($this->pdo, 'SELECT COUNT(*) FROM `'.$this->table.'`');
        $row = $query->fetch();
        return $row[0];
    }

    /* findAll: Generic method to retrieve all the records of a specified table
    $pdo: The PDO object to interact with the database
    $table: The table of which all records are to be selected from
    */
    public function findAll($pdo, $table)
    {
        $result = $this->query($pdo, 'SELECT * FROM `' . $table . '`');
        return $result->fetchAll();
    }

    /* findById: Retrieve a database record based on its identifier
    $pdo: The PDO object to interact with the database
    $table: The table for the search to be carried out on
    $primaryKey: The PK identifier for specified table.
    $value: The ID to be selected from the db
    return: none
    */
    public function findById($value)
    {
        $query = 'SELECT * FROM `' . $this->table . '` WHERE `' . $this->primaryKey .'` =  :value';

        $parameters = [
            'value' => $value
        ];

        $query = $this->query($query, $parameters);

        return $query->fetch();
    }

    /* insert: Method to insert a record into a specified table
    $pdo: The PDO object to interact with the database
    $table: The table for insert to be carried out on
    $fields: The values to be inserted into the database
    return: none
    */
    private function insert($fields)
    {
        $query = 'INSERT INTO `' . $this->table . '` (';

        // Dynamically generate fields that are being entered into the db
        // e.g. ($id, $joketext, etc.)
        foreach ($fields as $key => $value)
        {
            $query .= '`' . $key . '`,';
        }

        // Remove the trailing comma to mark the end of the 'INSERT' line
        $query = rtrim($query, ',');

        // Begin next line of SQL query (VALUES ...)
        $query .= ') VALUES (';

        // Dynamically generate placeholders for the values to be inserted
        // e.g. VALUES (:id, :joketext, etc.)
        foreach ($fields as $key => $value)
        {
            $query .= ':' . $key . ',';
        }

        // Remove the trailing comma to mark the end of the 'VALUES' line
        $query = rtrim($query, ',');

        $query .= ')';

        $fields = $this->processDates($fields);

        $this->query($query, $fields);
    }

    /* update: Method to update a record in a specified table
    $pdo: The PDO object to interact with the database
    $table: The table for update to be carried out on
    $primaryKey: The PK identifier for specified table.
    $fields: The values to be updated in the selected record
    return: none
    */
    private function update($fields)
    {
        $query = 'UPDATE `' . $this->table . '` SET ';

        /* Generate placeholders dynamically e.g: SET `id` = :id
        This can be bound in the 'query' method */
        foreach($fields as $key => $value)
        {
            $query .= '`' . $key . '` = :'.$key . ',';
        }

        // Remove the trailing comma to mark the end of the 'SET' line
        $query = rtrim($query, ',');

        /* Adding 'WHERE' clause to correctly match the primary key identifier
        to the record to be updated */
        $query .= ' WHERE `' . $this->primaryKey . '` = :primaryKey';

        // Adding the 'primaryKey' value to the array
        // 'id' is already used once, so a different key is needed for the same id value
        $fields['primaryKey'] = $fields['id'];

        // Format any dates for presentation purposes
        $fields = $this->processDates($fields);

        $this->query($query, $fields);
    }

    /* delete: Method to delete a record from a specified table
    $pdo: The PDO object to interact with the database
    $table: The table for deletion to be carried out on
    $primaryKey: The PK identifier for specified table.
    $id: The value of the identifier for the record to be deleted
    return: none
    */
    public function delete($id)
    {
        // Prepared statement parameters to bind
        $parameters = [':id' => $id];
        $this->query('DELETE FROM `' .$this->table. '` WHERE `' .$this->primaryKey. '` = :id', $parameters);
    }

    /* query: Method to run an SQL query, given a PDO object and SQL query and optionally, an array
    of parameters. 
    $pdo: The PDO object to interact with the database
    $sql: A string containing the SQL query to be executed
    $parameters[]: An array of all the parameters to be binded to the prepared SQL statement.
    // Default value for $parameters is [], for queries that have 0 parameters
    return: $query, PDOStatement upon success, false on failure
    */
    private function query($pdo, $sql, $parameters = [])
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

    /* save: Attempts to insert a record into a table, but if this record already exists,
    the update method is triggered instead. 
    $pdo: The PDO object to interact with the database
    $table: The table in the database to be queried
    $primaryKey: The primary key identifier of the specified table
    $record: The record to be inserted / updated
    return: none
    */
    public function save($record)
    {
        try
        {
            // Check that the primary key is not empty
            if ($record[$this->primaryKey] == '')
            {
                // SQL auto-increment triggered to replace an empty string
                $record[$this->primaryKey] = null;
            }

            $this->insert($record);
        }

        catch (PDOException $e)
        {
            $this->update($record);
        }
    }

    // processDates: converts any dates to Y-m-d format for presentation
    private function processDates($fields)
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
} // End of DatabaseTable class declaration