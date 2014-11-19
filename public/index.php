<?php
require '../vendor/autoload.php';
use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;
$capsule->addConnection(array(
	'driver' => 'pgsql',
	'host' => 'localhost',
	'database' => 'cats_test',
	'charset' => 'utf8',
	'collation' => 'utf8_general_ci',
	'prefix' => ''
));
$capsule->setAsGlobal();
$capsule->bootEloquent();
date_default_timezone_set('UTC');
require '../models/cat.php';

$app = new \Slim\Slim();
$view = $app->view();
$view->setTemplatesDirectory('../views');

$app->get('/', function() use($app) {
	$cats = new \Cat();
	$app->render('index.php', array("cats" => $cats->all() ));
});

$app->get('/new/:url', function($url) {
	$cat = new \Cat();
	$cat->url = $url;
	$cat->save();
});

$app->run();
?>
