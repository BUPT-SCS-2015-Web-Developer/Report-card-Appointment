<?php
    include_once('db_config.php');

    session_start();
    $_SESSION['admin'] = 0;

    try {
        $dbh = new PDO("mysql:host={$db_config['host']};dbname={$db_config['dbName']}", $db_config['user'], $db_config['pwd'], [PDO::ATTR_PERSISTENT => true, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"]);
    } catch (PDOExveption $e) {
        print('{"result":"Database Fatal"}');
        die();
    }

    try {
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $dbh->beginTransaction();

        $stmt = $dbh->prepare("SELECT ID FROM admin WHERE ID = :ID AND password = :pwd ");
        $stmt->bindParam(':ID', $ID);
        $stmt->bindParam(':pwd', $pwd);

        $ID = $_POST['ID'];
        $pwd = $_POST['pwd'];

        $stmt->execute();
        $dbh->commit();

        if ($row = $stmt->fetch(PDO::FETCH_NAMED)) {
            $_SESSION['admin'] = 1;
            print('{"result": "Succeeded"}');
        } else {
            print('{"result":"Failed"}');
        }
    } catch (Exception $e) {
        $dbh->rollBack();
        print('{"result":"Failed"}');
    }
?>