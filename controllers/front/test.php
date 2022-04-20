<?php
// <ModuleName><FileName><ModuleFrontController>
class MyBasicModuleTestModuleFrontController extends ModuleFrontController{
    // GET, POST request can handle
    // overriding from extended parent
    public function initContent()
    {
        parent::initContent();
        $this->context->smarty->assign([
            "data" => "HELLO mr PRESTASHOP"
        ]);
        $this->setTemplate("module:mybasicmodule/views/templates/front/test.tpl");
    }
    // its overriding method
    public function postProcess()
    {
        if(Tools::isSubmit("form")){
            return Tools::redirect("URL");
        }
    }
}// belongs to class