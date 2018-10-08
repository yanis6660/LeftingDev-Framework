<?php

// By Yanis6660

class LeftingDev{

  private $dir;
  private $dirTheme;
  private $PageIndex;

  public function start($dir, $dirTheme, $PageIndex){

    $this->dir = glob($dir . '*');
    $this->dirTheme = $dirTheme;
    $this->PageIndex = $PageIndex;

    $GLOBALS['dirTheme'] = $dirTheme;

  }

  // Emulate Page

  public function EmulatePage(){

    //AutoLoad
    require '../libs/LeftingDev/AutoLoad.php';
    
    //Variable
    $found = false;

    foreach($this->dir as $filename){
      $getFile = pathinfo($filename);
      if (strpos($_SERVER['REQUEST_URI'], "/" . $getFile['filename']) !== false){
        if ($getFile['extension'] == "php"){

          //echo $getFile['filename'], '<br />';
          //echo $_SERVER['REQUEST_URI'];

          include $getFile['dirname'] . '/' . $getFile['basename'];

          $found = true;
        }
      }
    }

    if($_SERVER['REQUEST_URI'] == "/"){
      $found = true;
      header('Location: '.$this->PageIndex);
      die();
    }

    if ($found == false){
      $file = $this->dirTheme."/www".$_SERVER['REQUEST_URI'];
      if ((file_exists($file) && !is_dir($file))){
        header('content-type: '.$this->MimeContent($file));
        readfile($file);
        exit(); 
      }else{
        $this->Error(404);
      }
    }

  }

  private function Error($code){
    if ($code == 404) {
      header("HTTP/1.0 404 Not Found");
    }
  }

  //MimeContent return content type.
  public function MimeContent($filename){

    $mime_types = array(
      'txt' => 'text/plain',
      'htm' => 'text/html',
      'html' => 'text/html',
      'php' => 'text/html',
      'css' => 'text/css',
      'js' => 'application/javascript',
      'json' => 'application/json',
      'xml' => 'application/xml',
      'swf' => 'application/x-shockwave-flash',
      'flv' => 'video/x-flv',

      // images

      'png' => 'image/png',
      'jpe' => 'image/jpeg',
      'jpeg' => 'image/jpeg',
      'jpg' => 'image/jpeg',
      'gif' => 'image/gif',
      'bmp' => 'image/bmp',
      'ico' => 'image/vnd.microsoft.icon',
      'tiff' => 'image/tiff',
      'tif' => 'image/tiff',
      'svg' => 'image/svg+xml',
      'svgz' => 'image/svg+xml',

      // archives

      'zip' => 'application/zip',
      'rar' => 'application/x-rar-compressed',
      'exe' => 'application/x-msdownload',
      'msi' => 'application/x-msdownload',
      'cab' => 'application/vnd.ms-cab-compressed',

      // audio/video

      'mp3' => 'audio/mpeg',
      'qt' => 'video/quicktime',
      'mov' => 'video/quicktime',

      // adobe

      'pdf' => 'application/pdf',
      'psd' => 'image/vnd.adobe.photoshop',
      'ai' => 'application/postscript',
      'eps' => 'application/postscript',
      'ps' => 'application/postscript',

      // ms office

      'doc' => 'application/msword',
      'rtf' => 'application/rtf',
      'xls' => 'application/vnd.ms-excel',
      'ppt' => 'application/vnd.ms-powerpoint',

      // open office

      'odt' => 'application/vnd.oasis.opendocument.text',
      'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
    );

    $explode = explode('.', $filename);

    if(is_array($explode)) {
      $ext = array_pop($explode);
    }else{
      $ext = null;
    }
    
    if (array_key_exists($ext, $mime_types)){
      return $mime_types[$ext];
    }elseif (function_exists('finfo_open')){
      $finfo = finfo_open(FILEINFO_MIME);
      $mimetype = finfo_file($finfo, $filename);
      finfo_close($finfo);
      return $mimetype;
    }else{
      return 'application/octet-stream';
    } 
  }
}

?>