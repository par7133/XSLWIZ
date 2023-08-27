<?php

/**
 * Copyright (c) 2016, 2024, 5 Mode
 * 
 * This file is part of Puzzleu.
 * 
 * Puzzleu is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * Puzzleu is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.  
 * 
 * You should have received a copy of the GNU General Public License
 * along with Puzzleu. If not, see <https://www.gnu.org/licenses/>.
 *
 * index.php
 * 
 * Puzzleu index file.
 *
 * @author Daniele Bonini <my25mb@aol.com>
 * @copyrights (c) 2016, 2024, 5 Mode     
 */

require "../Private/core/init.inc";


// FUNCTION AND VARIABLE DECLARATIONS
$scriptPath = APP_SCRIPT_PATH;

// PARAMETERS VALIDATION

$url = filter_input(INPUT_GET, "url")??"";
$url = strip_tags($url);
$url = strtolower(trim(substr($url, 0, 300), "/"));

switch ($url) {
  case "action":
    $scriptPath = APP_AJAX_PATH;
    define("SCRIPT_NAME", "action");
    define("SCRIPT_FILENAME", "action.php");     
    break;
  case "download":
  
    define("SCRIPT_NAME", "download");
    define("SCRIPT_FILENAME", "download.php");   
    
    break;  

  case "d":
  
    define("SCRIPT_NAME", "d");
    define("SCRIPT_FILENAME", "d.php");   
    
    break;  
  
  case "":
  case "home":
  
    define("SCRIPT_NAME", "home");
    define("SCRIPT_FILENAME", "home.php");   
    
    break;  

  case "img":
    $ID = filter_input(INPUT_GET, "av")??"";

    $JOB_PATH = APP_DATA_PATH . DIRECTORY_SEPARATOR . $ID;
    $GALLERY_PATH = $JOB_PATH . DIRECTORY_SEPARATOR . "gallery";     

    $pic = filter_input(INPUT_GET, "pic")??"";
       
    $originalFilename = pathinfo($pic, PATHINFO_FILENAME);
    $originalFileExt = pathinfo($pic, PATHINFO_EXTENSION);
    $fileExt = strtolower(pathinfo($pic, PATHINFO_EXTENSION));
    
    if (left($pic,4) === "logo") {
      $picPath = APP_DATA_PATH . DIRECTORY_SEPARATOR . $ID . DIRECTORY_SEPARATOR . $pic;
    } else {
      $picPath = $GALLERY_PATH . DIRECTORY_SEPARATOR . $pic;
    }  
       
    if (filesize($picPath) <= APP_FILE_MAX_SIZE) { 
      if ($fileExt = "jpg") {
        header("Content-Type: image/jpeg");
      } else {
        header("Content-Type: image/" . $fileExt);
      }  
      echo(file_get_contents($picPath));
      exit(0);
    } else {
      die("picture size over app limits.");
    }  
    
    break;
  
  default:
    
    $scriptPath = APP_ERROR_PATH;
    define("SCRIPT_NAME", "err-404");
    define("SCRIPT_FILENAME", "err-404.php");   

    define("AVATAR_NAME", $url);

    break;
}

if (SCRIPT_NAME==="err-404") {
  header("HTTP/1.1 404 Not Found");
}  

require $scriptPath . "/" . SCRIPT_FILENAME;
