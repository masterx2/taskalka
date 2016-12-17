<?php
/**
 * Created by PhpStorm.
 * User: masterx2
 * Date: 16.12.16
 * Time: 2:02
 */

define('ROOT', __DIR__.'/..');
require ROOT.'/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Taskalka\Core;

$app = new Core();
$app->dispatch(Request::createFromGlobals());