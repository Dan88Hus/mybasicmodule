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
        return parent::install() && $this->registerHook('registerGDPRConsent') && $this->dbInstall();
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
        



}// belongs to class