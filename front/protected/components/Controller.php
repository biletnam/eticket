<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController {

    public function init() {
        
    }

    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout = '//layouts/main';

    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();

    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();

    public function CheckPermission() {
        $controller = $this->controllerID();
        $method = $this->methodID();
        HelperGlobal::AccessControl($controller, $method);
    }

    public function controllerID() {
        return Yii::app()->getController()->getId();
    }

    public function methodID() {
        return Yii::app()->getController()->getAction()->getId();
    }

    public function load_404() {
        $this->renderFile(Yii::app()->basePath . "/views/layouts/404.php");
        die;
    }
    
    public function load_401(){
        $this->renderFile(Yii::app()->basePath . "/views/layouts/401.php");
        die;
    }

}