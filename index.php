<?php
include_once 'src/util/Request.php';
include_once 'src/util/Router.php';

$router = new Router(new Request);

$router->get('/', function() {
  return <<<HTML
  <h1>Hello world</h1>
HTML;
});

$router->post('/data', function($request) {
  return json_encode($request->getBody());
});
