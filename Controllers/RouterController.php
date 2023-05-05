<?php
namespace App\Controllers;

class RouterController extends Controller
{
    public function index()
    {
        $this->render('main/index');
    }
}