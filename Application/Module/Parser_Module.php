<?php

class Parser_Module{

  public function __construct(){
  }

  public function validateAddNewUserParams($name,$age,$address){
    if (empty($name) || empty($age) || empty($address)) {
      return false;
    } else {
      return true;
    }
  }
}