<?php
// symphony oldugu icin namespace e ihtiyac var, autoloader icin 
namespace Mybasicmodule\Controller;

use Symfony\Component\HttpFoundation\Response;

class CommentController {
    public function indexAction(){
        //Action i prefix yapmak zorundayiz symphony den dolayi
        return new Response("Hello world");
    }
}