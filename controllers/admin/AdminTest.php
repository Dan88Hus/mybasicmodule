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
            //fetch data from db
            $sql = new DbQuery();
            $sql->select('*')->from($this->table)->where('id', Tools::getValue('id'));
            // echo diyerek ekrana yazdiriyor
            $data = Db::getInstance()->executeS($sql);
            // print_r($data); ekrana yazdiriyor echo gibi
            $tpl->assign([
                'data' => $data[0]
            ]);
            return $tpl->fetch();
            // return 'Hello';
            // views/templates/admin/view.tpl e yonlendiriyoruz
        }
}