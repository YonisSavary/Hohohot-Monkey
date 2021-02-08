<?php 

namespace Controllers;

use Monkey\Web\Renderer;

class IndexController 
{
    public function index()
    {
        return Renderer::render("index");
    }
    
    public function home()
    {
        return Renderer::render("home");
    }

}