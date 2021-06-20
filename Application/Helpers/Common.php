<?php

class Common {
  
  public static function loadClass($directoryPath = '') {
    if (empty($directoryPath)) {
      return;
    } else {
      $files = scandir($directoryPath);
      foreach ($files as $file) {
        $filePath = $directoryPath . $file;
        $ext = pathinfo($file, PATHINFO_EXTENSION);
        if ((strtolower($ext) == 'php') && file_exists($filePath)) {
          require_once $filePath;
        }
      }
    }
  }
  
  public static function sendResponse($status, $msg="API_SUCCESS", $data = []) {
    echo json_encode(['status' => $status, 'data' => $data, 'message' => $msg]);
    die();
  }
  
}