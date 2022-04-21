<?php
// need to import classModel
require_once(_PS_MODULE_DIR_ . 'mybasicmodule/classes/comment.class.php');
class AdminTestController extends ModuleAdminController{
    public function __construct()
    {
        $this->table = 'testcomment';
        $this->className = 'CommentTest';
        $this->identifier = CommentTest::$definition['primary'];
        $this->bootstrap = true;
        $this->fields_list = [
            'id' => [
                'title' => 'The id',
                'align' => 'center',

            ],
        ];
        parent::__construct();
    }
        // to create render view we override
        public function renderForm(){
            $this->fields_form = [
                'legend' => [
                    'title' => 'New Comment'
                ]
                ];
                return parent::renderForm();
        }
        // overriding 
        public function renderView()
        {
            $tplFile = dirname(__FILE__) . '/../../views/templates/admin/view.tpl';
            $tpl = $this->context->smarty->createTemplate($tplFile);
            return $tpl->fetch();
            // return 'Hello';
            // views/templates/admin/view.tpl e yonlendiriyoruz
        }
}