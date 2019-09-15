<?php

use app\core\Controller;
use app\core\QueryBuilder;
Router::get('/', function () {
//    $ct = new Controller();
//    $ct->render('index', ['age' => 21, 'name' => havt]);
    $builder = QueryBuilder::table('abc')
        ->select('col1', 'col2')
        ->orderBy('col1', 'ASC')
        ->orderBy('col2', 'DESC')
        ->limit(10)
        ->offset(5)
        ->get();
    echo $builder;
});
Router::get('/home', 'HomeController@index');
Router::get('/news', function () {
    echo 'News';
});
Router::any('*', function () {
    echo '404 Not found';
});