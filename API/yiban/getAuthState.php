<?php
	require("classes/yb-globals.inc.php");
	include('config.php');

	session_start();

	$api = YBOpenApi::getInstance()->init($cfg['x']['appID'], $cfg['x']['appSecret'], $cfg['x']['callback']);
	
	if (empty($_SESSION['token']))
	{
		print('{"result": -1}');//-1 for not authencated
	} else {
        print('{"result": 0, "userID": '.$_SESSION['usrid'].', "userName": "'.$_SESSION['name'].'"}');
    }

?>