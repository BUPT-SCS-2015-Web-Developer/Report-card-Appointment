<?php
    include_once('db_config.php');

    session_start();

    if($_SESSION['admin'] == 0) {
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

        $today = $dbh->query("SELECT * FROM info WHERE DateDiff(`time`,NOW())=0 ORDER BY `time`");
        $future = $dbh->query("SELECT * FROM info WHERE DateDiff(`time`,NOW())>0 ORDER BY `time`");
        $history = $dbh->query("SELECT * FROM info WHERE DateDiff(`time`,NOW())<0 ORDER BY `time` DESC");

        $dbh->commit();

        $todayData = $today->fetchALL(PDO::FETCH_ASSOC);
        $todayTotal = count($todayData);
        $futureData = $future->fetchALL(PDO::FETCH_ASSOC);
        $futureTotal = count($futureData);
        $historyData = $history->fetchALL(PDO::FETCH_ASSOC);
        $historyTotal = count($historyData);

        $result = array();
        $result['result'] = 'Succeeded';
        $result['todayTotal'] = $todayTotal;
        $result['todayData'] = $todayData;
        $result['futureTotal'] = $futureTotal;
        $result['futureData'] = $futureData;
        $result['historyTotal'] = $historyTotal;
        $result['historyData'] = $historyData;
        print_r(json_encode($result));
    } catch (Exception $e) {
        $dbh->rollBack();
        print('{"result":"Failed"}');
        print($e->getMessage());
    }
?>