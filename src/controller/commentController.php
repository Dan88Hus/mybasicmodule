<?php
// symphony oldugu icin namespace e ihtiyac var, autoloader icin 
namespace Mybasicmodule\Controller;

use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends FrameworkBundleAdminController{
    public function indexAction(){
        //Action i prefix yapmak zorundayiz symphony den dolayi
        // return new Response("Hello world");
        //it uses twig as rendering template, to use twig we need to extends FrameWorkBundleAdminController
        $form = $this->createFormBuilder()->add('name',TextType::class)->getForm();
        return $this->render("@Modules/mybasicmodule/views/templates/admin/comment.html.twig",[
            'test' => 123,
            'form' => $form->createView()
        ]);
        // 2nd arguments are variable to pass twig

    }
}