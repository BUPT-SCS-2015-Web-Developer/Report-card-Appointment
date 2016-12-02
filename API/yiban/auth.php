<?php
	//易班指向此地址。改地址直接登陆然后跳转到首页。
	//在首页使用js请求一个专门判断是否登陆的后台，未登陆则跳转到易班轻应用地址。


	/**
	 * 包含SDK
	 */
	require("classes/yb-globals.inc.php");
	
	//session_start();

	/**
	 * 配置文件
	 */
	include('config.php');

	session_start();
	$_SESSION['verify_request'] = $_GET['verify_request'];
    $_SESSION['yb_uid'] = $_GET['yb_uid'];
	$_REQUEST['verify_request'] = $_SESSION['verify_request'];
	$_REQUEST['yb_uid'] = $_SESSION['yb_uid'];

	/**
	 * 站内应用需要使用AppID、AppSecret和应用入口地址初始化
	 *
	 */
	$api = YBOpenApi::getInstance()->init($cfg['x']['appID'], $cfg['x']['appSecret'], $cfg['x']['callback']);
	
	if (empty($_SESSION['token']))
	{
		try
		{
			/**
			 * 调用perform()验证授权，若未授权会自动重定向到授权页面
			 * 授权成功返回的数组中包含用户基本信息及访问令牌信息
			 */
			$info = $api->getFrameUtil()->perform();
			# print_r($info);	// 可以输出info数组查看
								// 访问令牌[visit_oauth][access_token]
			$_SESSION['token']	= $info['visit_oauth']['access_token'];
			$_SESSION['usrid']	= $info['visit_user']['userid'];
			$_SESSION['name']	= $info['visit_user']['username'];

            //$user = $api->getUser();
		}
		catch (YBException $ex)
		{
			echo $ex->getMessage();
		}
	}

	header("Location:".$cfg['x']['defaultAddress']);

?>