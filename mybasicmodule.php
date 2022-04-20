<?php
/**
 * 2007-2020 PrestaShop SA and Contributors
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 * @author    PrestaShop SA <contact@prestashop.com>
 * @copyright 2007-2020 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 * International Registered Trademark & Property of PrestaShop SA
 */

use PhpParser\Node\Expr\Cast\Bool_;
use PrestaShop\PrestaShop\Core\Module\WidgetInterface;

// checking if presto hop installed correctly
if(!defined('_PS_VERSION_')){
    exit;
}

// the main class
class MyBasicModule extends Module implements WidgetInterface{

    //constructor
    public function __construct(){
        $this->name = "mybasicmodule";
        $this->tab = "front_office_features";
        $this->version = "1.0";
        $this->author = "Huseyin Ozdogan";
        $this->need_instance = 0;
        $this->ps_versions_compliancy = [
            "min" => "1.6",
            "max" => _PS_VERSION_
        ];
        $this->bootstrap = true;

        parent::__construct();

        //$this->l() its locale translatation function call
        $this->displayName = $this->l("My very first module");
        $this->description = $this->l("this description is important for SEO ");
        $this->confirmUninstall = $this->l("Are you sure to uninstall?");


    }

    //install method, this is overriding method, the extended class has this method
    public function install()
    {
        //we can add any method on this overriding like dbInstall
        return parent::install() && $this->registerHook('registerGDPRConsent') && $this->registerHook('moduleRoutes') && $this->dbInstall() ;
    }

        //uninstall method, this is overriding method, the extended class has this method
        public function uninstall()
        {
            return parent::uninstall();
        }

        //install sql, this method is our own
        public function dbInstall(){
            //sql query that create certain table
            return true;
        }

        //our own hook 
        // public function hookdisplayFooter($params){
        //     $this->context->smarty->assign([
        //         "myparamtest" => "Huseyin Ozdogan",
        //         "idcart" => $this->context->cart->id
        //     ]); // boylelikle template e 
        //     // return "Hello world from the basic module hook";
        //     return $this->display(__FILE__, 'views/templates/hook/footeR.tpl');

        // }

        // bu hook u install methodunda da cagirabiliriz veya manuel olarak positions lardan da atama yapabiliriz
        // Design- positions- transparant module sekmesinden
        //arkasindan store webpage footer da gorunuyor
        // bu hook legacyHook oldugu icin overriding yaptik ve kendi direk sayfada footer oldugunu buldu 
        // customHook ta yapacagiz template icin 
        //custom hook icin views/templates/hook klasorleri olustur altinda .tpl dosyasi
        // return $this->display(__FILE, filePath) de yapabiliriz
        // veya $this->fetch($this->templateFile,$this->getCacheId()) de yapabiilriz

        // WidgetImplements ettigimiz icin override yapilacak methodlar var
        // public function renderWidget($hookName, array $configuration){
        //     return $this->fetch($this->templateFile, $this->getCacheId('blockassurance'));
        // }

        public function renderWidget($hookName, array $configuration){
            // link icin 
            // echo $this->context->link->getModuleLink($this->name,"test"); //burasi test controlerina yonlendiriyor 
            $this->context->smarty->assign($this->getWidgetVariables($hookName, $configuration));
            return $this->fetch('module:mybasicmodule/views/templates/hook/footeR.tpl');
        }

        public function getWidgetVariables($hookName, array $configuration){
            return [
                'myparamtest' => "from getWidgetVariables"
            ];
            // parametleri render widgeta yazmayi unutma
        }
        
        /* public function getContent(){
            $message = null;
            if(Tools::getValue("courserating")){
                Configuration::updateValue('COURSE_RATING',Tools::getValue("courserating"));
                $message = "form saved correctly";
            }
            // return "This is the configuration page";
            //suppose we have field for COURSE_RATING
            $courseRating = Configuration::get('COURSE_RATING');
            $this->context->smarty->assign([
                'courserating' => $courseRating,
                'message' => $message
            ]);
            return $this->fetch('module:mybasicmodule/views/templates/admin/configuration.tpl');

        } */
        public function getContent(){
            $message = "";
            if(Tools::isSubmit('submit'. $this->name)){ // 'submit'. $this->name = helperdeki submit_action
                $courseRating = Tools::getValue('courserating');
                if($courseRating && !empty($courseRating) && Validate::isGenericName($courseRating)){
                    Configuration::updateValue('COURSE_RATING',Tools::getValue("courserating"));
                    $message .= $this->displayConfirmation($this->trans('Form submitted successfully'));
                } else{
                    $message .= $this->displayError($this->trans('Form NOT submitted successfully'));

                }
            }

            //dispalyForm is an existing method that we will create
            return $message . $this->displayForm();
        }
        public function displayForm(){
            $defaulltLang = (int) Configuration::get('PS_LANG_DEFAULT');

            //form inputs field
            $fields[0]['form'] = [
                'legend' => [
                    'title' => $this->trans('Rating setting')
                ],
                'input' => [
                    [

                        'type' => 'text',
                        'label' => $this->l('Course rating'),
                        'name' => 'courserating', // name tpl de ki name ile ayni olmali
                        'size' => 20,
                        'required' => true
                    ]
                    ],
                    'submit' => [
                        'title' => $this->trans('Save the rating'),
                        'class' => 'btn btn-primary pull-right'
                    ]
                ];
                //instance of the Form Helper
                $helper = new HelperForm();
                $helper->module = $this;
                $helper->name_controller = $this->name;
                $helper->token = Tools::getAdminTokenLite('AdminModules');
                $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;

                //language
                $helper->default_form_language = $defaulltLang;
                $helper->allow_employee_form_lang = $defaulltLang;
                //Title and toolbar
                $helper->title = $this->displayName; // false -> remove Toolbar
                $helper->show_toolbar = true; // yes -> Toolbar is always visible on the top of the screen
                $helper->submit_action = 'submit' . $this->name;
                $helper->toolbar_btn = [
                    'save' => [
                        'desc' => $this->l('save'),
                        'href' => AdminController::$currentIndex . '&configure=' . $this->name . '&save' . $this->name .
                            '&token=' . Tools::getAdminTokenLite('AdminModules'),
                    ],
                    'back' => [ 
                        'href' => AdminController::$currentIndex . '&token=' . Tools::getAdminTokenLite('AdminModules'),
                        'desc' => $this->l('Back to list'),
                    ]
                    ];
                $helper->fields_value['courserating'] = Configuration::get('COURSE_RATING');
                    return $helper->generateForm($fields);
        }

        // save yapmiyor cunku logic yok bunun icin getContentMethodu kullanacaz if(Tools::isSubmit())
    // overriding
        public function hookModuleRoutes($params){
        return [
            'test' => [
                'controller' => 'test',
                'rule' => "fc-test",
                'keywords' => [],
                'params' => [
                   'module' => $this->name,
                    'fc' => 'module',
                    'controller' => 'test'
                ]
            ]
        ];
    }
}// belongs to class