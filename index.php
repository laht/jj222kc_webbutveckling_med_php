<?php

require_once("common/view/View.php");
require_once("base/controller/BaseController.php");

session_start();

$app = new \base\controller\BaseController();
$view = new \common\view\View();

$page = $app->runApp();
echo $view->assemblePage($page);

