<?php
require_once("common/view/View.php");
require_once("base/controller/BaseController.php");

session_start();

//start the application and assemble html to present
try {
	$app = new \base\controller\BaseController();
	$view = new \common\view\View();

	$page = $app->runApp();
	echo $view->assemblePage($page);
} catch (\Exception $e) {
	//incase something unexpected happened
	header("Location: http://www.laht.eu5.org");
}
