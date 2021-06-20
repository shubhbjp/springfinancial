<?php
class Game_Controller extends Controller{
  
  private $parserModule;  
  public function __construct() {
    parent::__construct();
    $this->parserModule = new Parser_Module();
  }
  
  public function addNewUser() {
    try {
      $name = empty($_POST['name']) ? "" : trim($_POST['name']);
      $age = empty($_POST['age']) ? 0 : (int)$_POST['age'];
      $address = empty($_POST['address']) ? "" : trim($_POST['address']);
      if ($this->parserModule->validateAddNewUserParams($name,$age,$address)){
        session_start();
        $data = isset($_SESSION['players']) ? json_decode($_SESSION['players']) : [];
        if(count($data) >= 10) {
          Common::sendResponse(Constants::API_ERROR, Messages::ADD_NEW_USER_MAX_PLAYER);
        }
        if(in_array($name, array_column($data, 'name'))) {
          Common::sendResponse(Constants::API_ERROR, Messages::ADD_NEW_USER_NAME_EXISTS);
        }
        $currentObj = ["name"=>$name, "age"=>$age, "address"=>$address,"points"=>0];
        $data[] = $currentObj;
        $_SESSION['players'] = json_encode($data, true);
        Common::sendResponse(Constants::API_SUCCESS, Messages::ADD_NEW_USER_SUCCESS, $data);
      } else {
        Common::sendResponse(Constants::API_ERROR, Messages::ADD_NEW_USER_VALIDATION_FAILED);
      }

    } catch(\Exception $e) {
      Common::sendResponse(Constants::API_ERROR, Messages::EXCEPTION_OCCURED);
    }
  }

  public function getUser() {
    try {
      session_start();
      $data = isset($_SESSION['players']) ? json_decode($_SESSION['players']) : [];
      Common::sendResponse(Constants::API_SUCCESS, Messages::GET_USER_SUCCESS, $data);
    } catch(\Exception $e) {
      Common::sendResponse(Constants::API_ERROR, Messages::EXCEPTION_OCCURED);
    }
  }

  public function plusUserPoint(){
    try {
      session_start();
      $key = (int) $_POST['id'];
      $data = isset($_SESSION['players']) ? json_decode($_SESSION['players']) : [];
      if(isset($data[$key]) && $data[$key]->points<=1000) {
        $data[$key]->points +=1;
        usort($data, [$this, "sort_points"]);
        $_SESSION['players'] = json_encode($data, true);
      }
      Common::sendResponse(Constants::API_SUCCESS, Messages::PLS_USER_SUCCESS, $data);
    } catch(\Exception $e) {
      Common::sendResponse(Constants::API_ERROR, Messages::EXCEPTION_OCCURED);
    }
  }

  public function minUserPoint(){
    try {
      session_start();
      $key = (int) $_POST['id'];
      $data = isset($_SESSION['players']) ? json_decode($_SESSION['players']) : [];
      if(isset($data[$key]) && $data[$key]->points > 0) {
        $data[$key]->points -=1;
        usort($data, [$this, "sort_points"]);
        $_SESSION['players'] = json_encode($data, true);
      }
      Common::sendResponse(Constants::API_SUCCESS, Messages::MIN_USER_SUCCESS, $data);
    } catch(\Exception $e) {
      Common::sendResponse(Constants::API_ERROR, Messages::EXCEPTION_OCCURED);
    }
  }

  public function delUserPoint(){
    try {
      session_start();
      $key = (int) $_POST['id'];
      $data = isset($_SESSION['players']) ? json_decode($_SESSION['players']) : [];
      if(isset($data[$key])) {
        unset($data[$key]);
        $data = array_values($data);
        usort($data, [$this, "sort_points"]);
        $_SESSION['players'] = json_encode($data, true);
      }
      Common::sendResponse(Constants::API_SUCCESS, Messages::DEL_USER_SUCCESS, $data);
    } catch(\Exception $e) {
      Common::sendResponse(Constants::API_ERROR, Messages::EXCEPTION_OCCURED);
    }
  }

  private function sort_points($a, $b){
    return $a->points < $b->points;
  }
}