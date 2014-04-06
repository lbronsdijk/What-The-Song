<?php

function getPDOInstance() {

    try {

        $DB_CREDENTIALS = [
            'HOST' => 'localhost',
            'NAME' => 'spotify',
            'USER' => 'root',
            'PASS' => '123456'
        ];

        $pdo = new \PDO("mysql:dbname=".$DB_CREDENTIALS['NAME'].";host=".$DB_CREDENTIALS['HOST'], $DB_CREDENTIALS['USER'], $DB_CREDENTIALS['PASS']);
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        return $pdo;

    } catch (\PDOException $e) {

        throw new \Exception("DB Connection failed: " . $e->getMessage());
    }
}

function selectQuery($query, $variables = null, $multiple = true, $class = null){

    $pdo = getPDOInstance();

    try {

        $pdo->beginTransaction();

        $statement = $pdo->prepare($query);
        $statement->execute($variables);

        $pdo->commit();

        if($class != null && class_exists($class)){

            $result = $multiple ? $statement->fetchAll(\PDO::FETCH_CLASS, $class) : $statement->fetch(\PDO::FETCH_CLASS, $class);

        } elseif($class != null && !class_exists($class)){

            throw new \Exception("Class: $class, does not exists!");

        } else {

            $result = $multiple ? $statement->fetchAll(\PDO::FETCH_OBJ) : $statement->fetch(\PDO::FETCH_OBJ);
        }

    } catch (\PDOException $e) {

        $pdo->rollBack();
        $result = "PDO query has some errors: " . $e->getMessage();
    }

    $pdo = null;

    return $result;
}

function transactionQuery($query, $variables = null){

    $pdo = getPDOInstance();

    try {

        $pdo->beginTransaction();

        $statement = $pdo->prepare($query);
        $statement->execute($variables);

        $pdo->commit();

    } catch (\PDOException $e) {
        $pdo->rollBack();
        throw new \Exception("PDO query has some errors: " . $e->getMessage());
    }

    $pdo = null;
}