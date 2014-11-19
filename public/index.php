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

$app->get('/', function() {
	echo "Lovely cat website";
});

$app->get('/new/:url', function($url) {
	$cat = new \Cat();
	$cat->url = $url;
	$cat->save();
	echo $cat->toJson();
});

$app->run();
?>
