<?php
    include_once('db_config.php');

    session_start();

    if(!isset($_SESSION['usrid'])) {
        print('{"result": "Forbidden"}');
        die();
    }

    try {
        $dbh = new PDO("mysql:host={$db_config['host']};dbname={$db_config['dbName']}", $db_config['user'], $db_config['pwd'], [PDO::ATTR_PERSISTENT => true, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"]);
    } catch (PDOExveption $e) {
        print('{"result":"Database Fatal"}');
        die();
    }

    try {
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $dbh->beginTransaction();

        $stmt = $dbh->prepare("INSERT INTO admin(usrid, userName) VALUES (:usrid, :userName)");
        $stmt->bindParam(':usrid', $usrid);
        $stmt->bindParam(':userName', $userName);

        $usrid = $_SESSION['usrid'];
        $userName = $_SESSION['name'];

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