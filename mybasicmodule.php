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

// checking if presto hop installed correctly
if(!defined('_PS_VERSION_')){
    exit;
}

// the main class
class MyBasicModule extends Module{

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
    
}