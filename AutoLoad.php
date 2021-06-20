<?php
define ('CONTROLLERS_PATH', APP_DIR. "Controller" . DIRECTORY_SEPARATOR);
define('MODULES_PATH', APP_DIR . "Module" . DIRECTORY_SEPARATOR);
define ('MODELS_PATH', APP_DIR. "Model" . DIRECTORY_SEPARATOR);
define ('HELPERS_PATH', APP_DIR. "Helpers" . DIRECTORY_SEPARATOR);
define('CONSTANTS_PATH', APP_DIR . "Constants" . DIRECTORY_SEPARATOR);
define ('WRONG_API_HIT', "Wrong API Hit");
require_once HELPERS_PATH. 'Common.php';

class AutoLoad {
  
  public function __construct() {
    Common::loadClass(CONSTANTS_PATH);
    Common::loadClass(HELPERS_PATH);
  }

  private function wrongAPiHit() {
    echo WRONG_API_HIT;
    die();
  }
  
  public function apiHandling() {
    //check for api server
    $data = empty($_POST) ? $_GET : $_POST;
    $controllerName = empty($data['control_type']) ? "" : $data['control_type'];
    $apiRequest = empty($data['api_name']) ? "" : $data['api_name'];
    $controllerName = ucwords($controllerName)."_Controller";
    Common::loadClass(CONTROLLERS_PATH);
    if ($_SERVER['SERVER_NAME'] == Constants::MAIN_SERVER_URL && !empty($controllerName) && !empty($apiRequest) && file_exists(CONTROLLERS_PATH.$controllerName.".php") ) {
      $classobj = new $controllerName();
      if(method_exists($classobj, $apiRequest)){
        call_user_func([$classobj, $apiRequest]);
      } else {
        $this->wrongAPiHit();
      }
    } else {
      $this->wrongAPiHit();
    }
  }
}