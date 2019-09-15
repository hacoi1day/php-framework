<?php

namespace app\controllers;

use app\core\Controller;
/**
 * Class HomeController
 * @package app\controllers
 */
class HomeController extends Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->render('index', [
            'ten' => 'havt',
            'tuoi' => 21,
        ]);
    }
}