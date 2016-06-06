<?php
namespace BaseTheme\Controllers;

use BaseTheme\Core\Blade\Controller;

class TestController extends Controller
{

    protected $views = [
        'index'
    ];

    public function process()
    {
        return ['home' => 'that', 'page' => 'this'];
    }

}
