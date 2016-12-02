<?php
    include_once('db_config.php');

    session_start();

    try {
        $dbh = new PDO("mysql:host={$db_config['host']};dbname={$db_config['dbName']}", $db_config['user'], $db_config['pwd'], [PDO::ATTR_PERSISTENT => true, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"]);
    } catch (PDOExveption $e) {
        print('{"result":"Database Fatal"}');
        die();
    }

    try {
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $dbh->beginTransaction();

        $stmt = $dbh->prepare("INSERT INTO info(name, ID, class, field, grade, time) VALUES (:name, :ID, :class, :field, :grade, :time)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':ID', $ID);
        $stmt->bindParam(':class', $class);
        $stmt->bindParam(':field', $field);
        $stmt->bindParam(':grade', $grade);
        $stmt->bindParam(':time', $time);

        $name = $_POST['name'];
        $ID = $_POST['ID'];
        $class = $_POST['class'];
        $field = $_POST['field'];
        $grade = $_POST['grade'];
        $time = $_POST['time'];

        $stmt->execute();
        $dbh->commit();
        print('{"result": "Succeeded"}');
    } catch (Exception $e) {
        $dbh->rollBack();
        if($e->getCode() == 23000) {
            //Douplicate entry
            print('{"result": "Appointed"}');
        } else {
            print('{"result":"Failed"}');
        }
    }
?>