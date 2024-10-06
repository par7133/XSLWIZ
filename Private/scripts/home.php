<?php

/**
 * Copyright 2021, 2024 5 Mode
 *
 * This file is part of Xslwiz.
 *
 * Xslwiz is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Xslwiz is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.  
 * 
 * You should have received a copy of the GNU General Public License
 * along with Xslwiz. If not, see <https://www.gnu.org/licenses/>.
 *
 * fileName.php
 * 
 * xslwiz description of the file.
 *
 * @author Daniele Bonini <my25mb@aol.com>
 * @copyrights (c) 2016, 2024 5 Mode
 */

/*
 *  PARAMETERS
 */
$page = filter_input(INPUT_POST, "OP_PAGE")??"";
$page = strip_tags($page);

switch ($page) {
  case "":
  case "1":
    $iPage = 1;
    $iPrevPage = 1;
    $iNextPage = 2;
    break;
  case "2":
    $iPage = 2;
    $iPrevPage = 1;
    $iNextPage = 3;
    break;
  case "3":
    $iPage = 3;
    $iPrevPage = 2;
    $iNextPage = 4;
    break;
  case "4":
    $iPage = 4;
    $iPrevPage = 3;
    $iNextPage = 5;
    break;
  case "5":
    $iPage = 5;
    $iPrevPage = 4;
    $iNextPage = 6;
    break;
  default:
    $iPage = 1;
    $iPrevPage = 1;
    $iNextPage = 2;
    break;
}

$id_prefix = ['A','B','C','D','E'];
$ID = filter_input(INPUT_POST, "ID")??"";
$ID = strip_tags($ID);

$OP = filter_input(INPUT_POST, "OP_MSG")??"";
$OP = strip_tags($OP);

$logoCode = filter_input(INPUT_POST, "LOGO_CODE")??"";
$logoCode = strip_tags($logoCode);
if ($logoCode===PHP_STR) {
  $logoCode = "logo-default";
}

//$logoPath = "/res/pxl.gif";
$logoPath = "/res/$logoCode.png";

if ($iPage === 4) {
  
  if ($ID==="" && false===true) {
    $ID = $id_prefix[mt_rand(0,4)] . mt_rand(99999, mt_getrandmax());
    if (!is_readable(APP_DATA_PATH . DIRECTORY_SEPARATOR . $ID)) {
      mkdir(APP_DATA_PATH . DIRECTORY_SEPARATOR . $ID);
    }
  }

  if ($OP === "del_logo") {
    delLogo();
  }

  if ($OP !== "del_logo") {
    upload();
  }  

  //logo
  if (is_readable(APP_DATA_PATH . DIRECTORY_SEPARATOR . $ID)) {

    $pattern = APP_DATA_PATH . DIRECTORY_SEPARATOR . $ID . DIRECTORY_SEPARATOR . "logo.*";
    $aFiles = glob($pattern);
    if (!empty($aFiles)) {
      //$logoPath = "/img?av=".$ID."&pic=".basename($aFiles[0]);
      $logoPath = APP_HOST.DIRECTORY_SEPARATOR."xsl-repo".DIRECTORY_SEPARATOR.$ID.DIRECTORY_SEPARATOR.basename($aFiles[0]);
    }
  } 
}

$title = filter_input(INPUT_POST, "TITLE")??"";
$title = strip_tags($title);

$desc = filter_input(INPUT_POST, "DESC")??"";
$desc = strip_tags($desc);

$keywords = filter_input(INPUT_POST, "KEYWORDS")??"";
$keywords = strip_tags($keywords);
//echo("keywords=$keywords<br>");

$footer = filter_input(INPUT_POST, "FOOTER")??"";
$footer = HTMLencode2($footer);
if (mb_strpos($footer,"<")===false) { 
} else {  
  $footer = HTMLencode2($footer);
}


// DEFINITION

// Displayed record
$defRecNum = filter_input(INPUT_POST, "DEF_REC_NUM")??"";
$defRecNum = strip_tags($defRecNum);
$defRecNum = (int)$defRecNum;
if ($defRecNum===0) {
  $defRecNum = 1;
}

// CREATED RECORDS
$defRecTot = filter_input(INPUT_POST, "DEF_REC_TOT")??"";
$defRecTot = strip_tags($defRecTot);
$defRecTot = (int)$defRecTot;
if ($defRecTot===0) {
  $defRecTot = 1;
}

$defField = filter_input(INPUT_POST, "DEF_FIELD")??"";
$defField = strip_tags($defField);
if ($defField === PHP_STR) {
  $defField = $defField . "ID&";
  $defField = $defField . "NAME&";
  $defField = $defField . "BUSINESS&";
  $defField = $defField . "URL&";
  for ($z=4; $z<(APP_MAX_TOT_FIELDS-1);$z++) {
    $defField = $defField . "Field$z&";
  }  
  $defField = left($defField,strlen($defField)-1);
}


$defFieldType = filter_input(INPUT_POST, "DEF_FIELD_TYPE")??"";
$defFieldType = strip_tags($defFieldType);
if ($defFieldType === PHP_STR) {
  $defFieldType = $defFieldType . "text&";
  $defFieldType = $defFieldType . "text&";
  $defFieldType = $defFieldType . "text&";
  $defFieldType = $defFieldType . "text&";
  for ($z=4; $z<(APP_MAX_TOT_FIELDS-1);$z++) {
    $defFieldType = $defFieldType . "&";
  }  
  $defFieldType = left($defFieldType,strlen($defFieldType)-1);
}

$adefFieldVal = [];
for ($i=0; $i<$defRecTot; $i++) {
  $adefFieldVal[$i] = filter_input(INPUT_POST, "DEF_FIELD_VAL".$i)??"";
  $adefFieldVal[$i] = strip_tags($adefFieldVal[$i]);
  if ($adefFieldVal[$i] === PHP_STR) {
    $sID = "".$defRecNum;
    if (strlen($sID)<=1) {
      $sID = "0".$defRecNum;      
    }
    $adefFieldVal[$i] = $adefFieldVal[$i] . "$sID&";
    $adefFieldVal[$i] = $adefFieldVal[$i] . "Daniele Bonini&";
    $adefFieldVal[$i] = $adefFieldVal[$i] . "5 Mode&";
    $adefFieldVal[$i] = $adefFieldVal[$i] . "http://5mode&";
    for ($z=4; $z<(APP_MAX_TOT_FIELDS-1);$z++) {
      $adefFieldVal[$i] = $adefFieldVal[$i] . "&";
    }  
    $adefFieldVal[$i] = $adefFieldVal[$i] . "$defRecNum&";
    $adefFieldVal[$i] = left($adefFieldVal[$i],strlen($adefFieldVal[$i])-1);
  }
}

$defFieldTot = filter_input(INPUT_POST, "DEF_FIELD_TOT")??"";
$defFieldTot = strip_tags($defFieldTot);
$defFieldTot = (int)$defFieldTot;
if ($defFieldTot===0) {
  $defFieldTot = 4;
}


// PRESENTATION

$preSelField = filter_input(INPUT_POST, "PRE_SEL_FIELD")??"";
$preSelField = strip_tags($preSelField);
if ($preSelField===PHP_STR) {
  $preSelField = "ID";
}

$preSelMethod = filter_input(INPUT_POST, "PRE_SEL_METHOD")??"";
$preSelMethod = strip_tags($preSelMethod);
if ($preSelMethod===PHP_STR) {
  $preSelMethod = "bigger";
}

$preSelVal = filter_input(INPUT_POST, "PRE_SEL_VAL")??"";
$preSelVal = strip_tags($preSelVal);
if ($preSelVal===PHP_STR) {
  $preSelVal = "00";
}


$preTopHtml = filter_input(INPUT_POST, "PRE_TOP_HTML")??"";
$preTopHtml = HTMLencode2($preTopHtml);


// PRESENTATION FIELDS TOT
$preFieldTot = filter_input(INPUT_POST, "PRE_FIELD_TOT")??"";
$preFieldTot = strip_tags($preFieldTot);
$preFieldTot = (int)$preFieldTot;
if ($preFieldTot===0) {
  $preFieldTot = $defFieldTot;
}

$apreHtmlPrefix = [];
for ($i=0; $i<((APP_MAX_TOT_FIELDS+10)-1); $i++) {
  $apreHtmlPrefix[$i] = filter_input(INPUT_POST, "PRE_HTML_PREFIX".$i)??"";
  if (mb_strpos($apreHtmlPrefix[$i],"<")===false) { 
  } else {  
    $apreHtmlPrefix[$i] = HTMLencode2($apreHtmlPrefix[$i]);
  }
  if ($apreHtmlPrefix[$i] === PHP_STR) {
    $apreHtmlPrefix[$i] = "&lt;div style='float:left'&gt;";
  }
}

$adefField = explode("&", $defField); 
$apreField = [];
for ($i=0; $i<((APP_MAX_TOT_FIELDS+10)-1); $i++) {
  $apreField[$i] = filter_input(INPUT_POST, "PRE_FIELD".$i)??"";
  $apreField[$i] = strip_tags($apreField[$i]);
  if ($apreField[$i] === PHP_STR && isset($adefField[$i+1])) {
    $apreField[$i] = $adefField[$i+1];
  }
}

$apreHtmlSuffix = [];
for ($i=0; $i<((APP_MAX_TOT_FIELDS+10)-1); $i++) {
  $apreHtmlSuffix[$i] = filter_input(INPUT_POST, "PRE_HTML_SUFFIX".$i)??"";
  if (mb_strpos($apreHtmlSuffix[$i],"<")===false) {  
  } else {    
    $apreHtmlSuffix[$i] = HTMLencode2($apreHtmlSuffix[$i]);
  }  
  if ($apreHtmlSuffix[$i] === PHP_STR) {
    $apreHtmlSuffix[$i] = "&lt;/div&gt;";
  }
}


$preBottomHtml = filter_input(INPUT_POST, "PRE_BOTTOM_HTML")??"";
$preBottomHtml = HTMLencode2($preBottomHtml);

$preOrdField = filter_input(INPUT_POST, "PRE_ORD_FIELD")??"";
$preOrdField = strip_tags($preOrdField);
if ($preOrdField===PHP_STR) {
  $preOrdField = "INDEX";
}

$preOrdFieldType = filter_input(INPUT_POST, "PRE_ORD_FIELDTYPE")??"";
$preOrdFieldType = strip_tags($preOrdFieldType);
if ($preOrdFieldType===PHP_STR) {
  $preOrdFieldType = "number";
}

$preOrdDir = filter_input(INPUT_POST, "PRE_ORD_DIR")??"";
$preOrdDir = strip_tags($preOrdDir);
if ($preOrdDir===PHP_STR) {
  $preOrdDir = "asc";
}


$dataIndex = $defRecNum-1;

$aData = [];

$adefField = [];
$adefFieldType = [];
//$adefFieldVal = [];
if ($defField!==PHP_STR) {
  $adefField = explode("~", $defField);  
  $adefFieldType = explode("~", $defFieldType);  
  //$adefFieldVal = explode("~", $defFieldVal);  
} else {
  $adefField = [];
  $adefFieldType = [];
  //$adefFieldVal = [];
}

for($irec=0;$irec<$defRecTot;$irec++) {

  if (!isset($adefFieldVal[$irec])) {
    
    $aItem = [];
    $sItemId = "".($irec+1);
    if (strlen($sItemId) === 1) {
      $sItemId = "0".$sItemId;
    }   
    $aItem[0] = ['ID', "text", $sItemId];
    $aItem[1] = ['NAME', "text", "Daniele Bonini"];
    $aItem[2] = ['BUSINESS', "text", "5 Mode"];
    $aItem[3] = ['URL', "text", "http://5mode.com"];
    for($z=4;$z<(APP_MAX_TOT_FIELDS-1);$z++) {
      $aField = ["Field".$z, "text", PHP_STR];
      $aItem[$z] = $aField; 
    }
    $aItem[APP_MAX_TOT_FIELDS-1] = ['INDEX', "number", ($irec+1)];

    $aData[$irec] = $aItem;
    
  } else {
    
    //echo("irec=".$irec."<br>");
    
    $s = $adefField[0];
    $mydefField = explode("&", $s);
    $s = $adefFieldType[0];
    $mydefFieldType = explode("&", $s);
    $s = $adefFieldVal[$irec];
    $mydefFieldVal = explode("&", $s);

    $aItem = [];
    $sItemId = "".($irec+1);
    if (strlen($sItemId) === 1) {
      $sItemId = "0".$sItemId;
    }   
    $aItem[0] = ["ID", "text", $sItemId];
    for($z=1;$z<(APP_MAX_TOT_FIELDS-1);$z++) {
      $aField = [$mydefField[$z], $mydefFieldType[$z], $mydefFieldVal[$z]];
      $aItem[$z] = $aField; 
    }
    $aItem[APP_MAX_TOT_FIELDS-1] = ['INDEX', "number", ($irec+1)];

    $aData[$irec] = $aItem;
    
  } 
  
}

//var_dump($aData);
//exit(1);

/*
 * VARIABLES AND FUNCTIONS
 */

function delLogo() {

   global $ID;
  
   $pattern = APP_DATA_PATH . DIRECTORY_SEPARATOR . $ID . DIRECTORY_SEPARATOR . "logo.*";
   $aFiles = glob($pattern);
   if (!empty($aFiles)) {
     $destFileName = basename($aFiles[0]);
     $destFullPath = APP_DATA_PATH . DIRECTORY_SEPARATOR . $ID . DIRECTORY_SEPARATOR . $destFileName;
     unlink($destFullPath); 
   }
}


function upload() {

   global $ID;
   global $msgSign;

   //if (!empty($_FILES['files'])) {
   if (!empty($_FILES['files']['tmp_name'][0])) {
	   
     $uploads = (array)fixMultipleFileUpload($_FILES['files']);
     
     //no file uploaded
     if ($uploads[0]['error'] === PHP_UPLOAD_ERR_NO_FILE) {
       echo("WARNING: No file uploaded.");
       return;
     } 

     $google = "abcdefghijklmnopqrstuvwxyz";
     if (count($uploads)>strlen($google)) {
       echo("WARNING: Too many uploaded files."); 
       return;
     }

     // Checking for repeated upload cause ie. caching prb..
     //$duplicateLogos = glob(APP_DATA_PATH . DIRECTORY_SEPARATOR . $ID . DIRECTORY_SEPARATOR . "logo.*");
     //if (!empty($duplicateLogos)) {
     //  echo("WARNING: destination already exists");
     //  return;
     //}	   

     $i=1;
     foreach($uploads as &$upload) {
		
       switch ($upload['error']) {
       case PHP_UPLOAD_ERR_OK:
         break;
       case PHP_UPLOAD_ERR_NO_FILE:
         echo("WARNING: One or more uploaded files are missing.");
         return;
       case PHP_UPLOAD_ERR_INI_SIZE:
         echo("WARNING: File exceeded INI size limit.");
         return;
       case PHP_UPLOAD_ERR_FORM_SIZE:
         echo("WARNING: File exceeded form size limit.");
         return;
       case PHP_UPLOAD_ERR_PARTIAL:
         echo("WARNING: File only partially uploaded.");
         return;
       case PHP_UPLOAD_ERR_NO_TMP_DIR:
         echo("WARNING: TMP dir doesn't exist.");
         return;
       case PHP_UPLOAD_ERR_CANT_WRITE:
         echo("WARNING: Failed to write to the disk.");
         return;
       case PHP_UPLOAD_ERR_EXTENSION:
         echo("WARNING: A PHP extension stopped the file upload.");
         return;
       default:
         echo("WARNING: Unexpected error happened.");
         return;
       }
      
       if (!is_uploaded_file($upload['tmp_name'])) {
         echo("WARNING: One or more file have not been uploaded.");
         return;
       }
      
       // name	 
       $name = (string)substr((string)filter_var($upload['name']), 0, 255);
       if ($name == PHP_STR) {
         echo("WARNING: Invalid file name: " . $name);
         return;
       } 
       $upload['name'] = $name;
       
       // fileType
       $fileType = substr((string)filter_var($upload['type']), 0, 30);
       $upload['type'] = $fileType;	 
       
       // tmp_name
       $tmp_name = substr((string)filter_var($upload['tmp_name']), 0, 300);
       if ($tmp_name == PHP_STR || !file_exists($tmp_name)) {
         echo("WARNING: Invalid file temp path: " . $tmp_name);
         return;
       } 
       $upload['tmp_name'] = $tmp_name;
       
       //size
       $size = substr((string)filter_var($upload['size'], FILTER_SANITIZE_NUMBER_INT), 0, 12);
       if ($size == "") {
         echo("WARNING: Invalid file size.");
         return;
       } 
       $upload["size"] = $size;

       $tmpFullPath = $upload["tmp_name"];
       
       $originalFilename = pathinfo($name, PATHINFO_FILENAME);
       $originalFileExt = pathinfo($name, PATHINFO_EXTENSION);
       $fileExt = strtolower(pathinfo($name, PATHINFO_EXTENSION));

       $date = date("Ymd-His");
       $rnd = $msgSign;    
       
       if ($originalFileExt!==PHP_STR) {
         $destFileName = "logo.$fileExt";
       } else {
         return; 
       }	   
       $destFullPath = APP_DATA_PATH . DIRECTORY_SEPARATOR . $ID . DIRECTORY_SEPARATOR . $destFileName;

       //if (file_exists($destFullPath)) {
         //echo("WARNING: destination already exists");
         //return;
       //}	   

       copy($tmpFullPath, $destFullPath);

       // Cleaning up..
      
       // Delete the tmp file..
       unlink($tmpFullPath); 
       
       $i++;
        
     }	 
   }
 }

 
/*
 *  XSL FILES CREATION
 */
if ($iPage === 5) {

  if ($ID==="") {
    $ID = $id_prefix[mt_rand(0,4)] . mt_rand(99999, mt_getrandmax());
    if (!is_readable(APP_DATA_PATH . DIRECTORY_SEPARATOR . $ID)) {
      mkdir(APP_DATA_PATH . DIRECTORY_SEPARATOR . $ID);
    }
  }
  
  $xml = PHP_STR;
  $xml = $xml . "<?xml version=\"1.0\"?>\n\n";
  $xml = $xml . " <?xml-stylesheet type=\"text/xsl\" href=\"index.xsl\"?>\n\n";
  $xml = $xml . "<CONTENT>\n";
  for($irec=0;$irec<$defRecTot;$irec++) {
    $xml = $xml . "<ITEM>\n";
    for($z=0;$z<($defFieldTot);$z++) {
      $xml = $xml . "<".$aData[$irec][$z][0].">".$aData[$irec][$z][2]."</".$aData[$irec][$z][0].">\n";
    }  
    $xml = $xml . "<".$aData[$irec][APP_MAX_TOT_FIELDS-1][0].">".$aData[$irec][APP_MAX_TOT_FIELDS-1][2]."</".$aData[$irec][APP_MAX_TOT_FIELDS-1][0].">\n";
    $xml = $xml . "</ITEM>\n";
  }  
  $xml = $xml . "</CONTENT>\n";
  
  $destFilePath = APP_DATA_PATH . DIRECTORY_SEPARATOR . $ID . DIRECTORY_SEPARATOR . "index.xml"; 
  
  if (is_readable($destFilePath)) {
    unlink($destFilePath);
  }  
  file_put_contents(APP_DATA_PATH . DIRECTORY_SEPARATOR . $ID . DIRECTORY_SEPARATOR . "index.xml", $xml);


  $xsl = PHP_STR;
  $xsl = $xsl . "<xsl:stylesheet xmlns:xsl=\"http://www.w3.org/1999/XSL/Transform\"  xmlns:xlink=\"http://www.w3.org/1999/xlink\"  version=\"1.0\">\n\n"; 
  $xsl = $xsl . "<xsl:output method=\"html\"/>\n\n";
  $xsl = $xsl . "<xsl:template match=\"CONTENT\">\n\n";
	$xsl = $xsl . "<HTML>\n";
	$xsl = $xsl . "<HEAD>\n";
  $xsl = $xsl . "<TITLE>".$title."</TITLE>\n";
	$xsl = $xsl . "<meta name=\"description\" content=\"".$desc."\"/>\n";
  $xsl = $xsl . "<meta name=\"keywords\" content=\"".$keywords."\"/>\n";
	$xsl = $xsl . "<link rel=\"shortcut icon\" href=\"favicon.ico\"/>\n";
	$xsl = $xsl . "<link href=\"style.css\" type=\"text/css\" rel=\"stylesheet\"></link>\n";
 	$xsl = $xsl . "</HEAD>\n";  
  $xsl = $xsl . "<BODY>\n";
  $xsl = $xsl . "<div class=\"header\">";
  $xsl = $xsl . "<img src=\"http://".APP_HOST.DIRECTORY_SEPARATOR."res".DIRECTORY_SEPARATOR.$logoCode.".png\"/>\n";
  $xsl = $xsl . "<H1>".$title."</H1>\n";
  $xsl = $xsl . "</div>";
  $xsl = $xsl . "<div class=\"content\">";
  $xsl = $xsl . "<div class=\"top-html\" style=\"clear:both;\"><H2>". html_entity_decode($preTopHtml, ENT_QUOTES | ENT_IGNORE | ENT_HTML5)."</H2></div>\n";
  $xsl = $xsl . "<div class=\"items\">";
  if ($preSelField===PHP_STR) {
    $xsl = $xsl . "<xsl:for-each select=\"ITEM\">\n";
  } else {  
    
    $s = $adefField[0];
    $mydefField = explode("&", $s);
    $s = $adefFieldType[0];
    $mydefFieldType = explode("&", $s);

    $preSelFieldType = "";
    for($i=0;$i<(APP_MAX_TOT_FIELDS-1);$i++) {
      if ($mydefField[$i] === $preSelField) {
        $preSelFieldType = $mydefFieldType[$i];
        break;
      }
    }
    
    switch ($preSelMethod) {
      case "equal":
        $preSelMethodOp = "=";
        break;
      case "bigger":
        $preSelMethodOp = ">";
        break;
      case "smaller":
        $preSelMethodOp = "<";
        break;
    }
    
    if ($preSelFieldType==="text") {
      $xsl = $xsl . "<xsl:for-each select=\"ITEM[".$preSelField.$preSelMethodOp."'$preSelVal']\">\n";
    } else {
      $xsl = $xsl . "<xsl:for-each select=\"ITEM[".$preSelField.$preSelMethodOp."$preSelVal]\">\n";
    }
  }  
  
  switch ($preOrdDir) {
    case "asc":
      $preOrdDirOp = "ascending";
      break;
    case "desc":
      $preOrdDirOp = "descending";
      break;
  }

  
  $xsl = $xsl . "<xsl:sort select=\"".$preOrdField."\" data-type=\"".$preOrdFieldType."\" order=\"".$preOrdDirOp."\"/>\n";
  
  for($i=0;$i<$preFieldTot-1;$i++) {
    $xsl = $xsl . html_entity_decode($apreHtmlPrefix[$i], ENT_QUOTES | ENT_IGNORE | ENT_HTML5)."<xsl:value-of select=\"".$apreField[$i]."\"/>".html_entity_decode($apreHtmlSuffix[$i], ENT_QUOTES | ENT_IGNORE | ENT_HTML5)."\n";
  }
  
  $xsl = $xsl . "</xsl:for-each>";
  
  $xsl = $xsl . "</div>";
  $xsl = $xsl . "<div style=\"clear:both; margin:auto\"><br/><br/></div>\n";
  $xsl = $xsl . "<div class=\"bottom-html\" style=\"clear:both;\">".html_entity_decode($preBottomHtml, ENT_QUOTES | ENT_IGNORE | ENT_HTML5)."</div>\n";
  $xsl = $xsl . "<div style=\"clear:both; margin:auto\"><br/><br/></div>\n";
  $xsl = $xsl . "<div class=\"footer\" style=\"clear:both; margin:auto\">".html_entity_decode($footer, ENT_QUOTES | ENT_IGNORE | ENT_HTML5)."</div>\n";
  $xsl = $xsl . "</div>";
  $xsl = $xsl . "</BODY>\n";
  $xsl = $xsl . "</HTML>\n";
 
  $xsl = $xsl . "</xsl:template>";
  $xsl = $xsl . "</xsl:stylesheet>";
    
  $destFilePath = APP_DATA_PATH . DIRECTORY_SEPARATOR . $ID . DIRECTORY_SEPARATOR . "index.xsl"; 
  
  if (is_readable($destFilePath)) {
    unlink($destFilePath);
  }  
  file_put_contents(APP_DATA_PATH . DIRECTORY_SEPARATOR . $ID . DIRECTORY_SEPARATOR . "index.xsl", $xsl);
  
  //echo $xsl;
  //exit(1);
  
} 

?>

<!DOCTYPE html>
<html lang="en-US" xmlns="http://www.w3.org/1999/xhtml">
<head>

  <meta name="viewport" content="width=device-width, initial-scale=1"/>
   
<!--<?PHP echo(APP_LICENSE);?>-->  
  
  <title><?PHP echo(APP_TITLE);?></title>

  <link rel="shortcut icon" href="/favicon.ico" />

  <meta name="description" content="Welcome to Xslwiz!"/>
  <meta name="keywords" content="xlswiz,xsl,generator,on,premise,solution"/>
  <meta name="robots" content="index,follow"/>
  <meta name="author" content="5 Mode"/>
  
  <script src="/js/jquery-3.6.0.min.js" type="text/javascript"></script>
  <script src="/js/bootstrap.min.js" type="text/javascript"></script> 
  <script src="/js/htmlencode.js" type="text/javascript"></script>  
    
  <link href="/css/bootstrap.min.css" type="text/css" rel="stylesheet">
  <link href="/css/style.css?r=<?PHP echo(time());?>" type="text/css" rel="stylesheet">
  
  <script>
   var defFieldTot = <?PHP echo($defFieldTot);?>; 
   var preFieldTot = <?PHP echo($preFieldTot);?>;
   
   function addRecord() {
<?PHP  if ($defRecTot < APP_MAX_TOT_REC): ?>
    
     s = serializeField();
     if (s!=="") {
       $("#DEF_FIELD").val(s);
     }  
     s = serializeFieldType();
     if (s!=="") {
       $("#DEF_FIELD_TYPE").val(s);
     }
     s = serializeFieldVal();
     if (s!=="") {
       $("#DEF_FIELD_VAL"+<?PHP echo($defRecNum-1);?>).val(s);
     }    
    
     $("#DEF_REC_TOT").val(<?PHP echo($defRecTot);?>+1);
     $("#DEF_REC_NUM").val(<?PHP echo($defRecNum);?>+1);
     frmXslwiz.submit();
<?PHP  Endif; ?>     
   } 

   function clearUpload() {
     //$("#upload-cont").html("<input id='files' name='files[]' type='file' accept='.png,.jpg,.jpeg' style='visibility: hidden;' multiple>"); 
     //$("#del-attach").css("display", "none");
     $("#OP_MSG").val("del_logo");
     frmXslwiz.submit();
   }  
   
   function changePage(page) {
 
    if (!(parseInt(page)>=1 && parseInt(page)<=5)) {
      alert("Page doesn't exist: "+page);
      return;
    }
 
    $("#ID").val('<?PHP echo($ID);?>');
    //$("#TITLE").val('<?PHP echo($title);?>');
    //$("#DESC").val('<?PHP echo($desc);?>');
    //$("#KEYWORDS").val('<?PHP echo($keywords);?>');
    //$("#FOOTER").val('<?PHP echo($footer);?>');
    $("#OP_PAGE").val(page);

    s = serializeField();
    if (s!=="") {
      $("#DEF_FIELD").val(s);
    }  
    s = serializeFieldType();
    if (s!=="") {
      $("#DEF_FIELD_TYPE").val(s);
    }
    s = serializeFieldVal();
    if (s!=="") {
      $("#DEF_FIELD_VAL"+<?PHP echo($defRecNum-1);?>).val(s);
    }

    $("#DEF_FIELD_TOT").val(defFieldTot);


    $("#PRE_FIELD_TOT").val(preFieldTot);


    frmXslwiz.submit();
   }  

   function delRecord() {
<?PHP  if ($defRecNum === $defRecTot): ?>
     $("#DEF_REC_TOT").val(<?PHP echo($defRecTot);?>-1);
     $("#DEF_REC_NUM").val(<?PHP echo($defRecNum);?>-1);
     frmXslwiz.submit();
<?PHP  Endif; ?>     
   } 

   function deserializeField(s) {
     //alert(s);
     aFields = s.split("&");
     for (i=0; i<<?PHP echo(APP_MAX_TOT_FIELDS);?>;i++) {
        if (aFields[i]) {
          $("#txtDefField"+i).val(aFields[i]);
        //} else {
        //  if (i===0) {
        //    $("#txtDefField"+i).val("ID");
        //  } else if (i===1) {
        //    $("#txtDefField"+i).val("NAME");
        //  } else if (i===2) {
        //    $("#txtDefField"+i).val("BUSINESS");
        //  } else if (i===3) {
        //    $("#txtDefField"+i).val("URL");
        //  } else {
        //    $("#txtDefField"+i).val("Field"+i);
        //  }
        }  
      }
   }  

   function deserializeFieldType(s) {
     //alert(s);
     aFields = s.split("&");
     for (i=0; i<<?PHP echo(APP_MAX_TOT_FIELDS);?>;i++) {
         if (aFields[i] && (aFields[i]==="text" || aFields[i]==="number")) {
           $("#cbDefField"+i+"Type").val(aFields[i]);
        // } else {
        //   $("#cbDefField"+i+"Type").val("text");
         }  
     }
   }  

   function deserializeFieldVal(s) {
     //alert(s);
     aVals = s.split("&");
     for (i=0; i<<?PHP echo(APP_MAX_TOT_FIELDS);?>;i++) {
         if (aVals[i]) {
           $("#txtDefField"+i+"Val").val(aVals[i]);
         } else {
           $("#txtDefField"+i+"Val").val("");
         }  
      }  
   }  

   function deserializePreHtmlPrefix(s) {
     //alert(s);
     aVals = s.split("%");
     for (i=0; i<<?PHP echo(APP_MAX_TOT_FIELDS+10);?>;i++) {
         if (aVals[i]) {
           $("#txtPreHtmlPrefix"+i).val(aVals[i]);
         } else {
           $("#txtPreHtmlPrefix"+i).val("");
         }  
      }  
   }  

   function deserializePreHtmlSuffix(s) {
     //alert(s);
     aVals = s.split("%");
     for (i=0; i<<?PHP echo(APP_MAX_TOT_FIELDS+10);?>;i++) {
         if (aVals[i]) {
           $("#txtPreHtmlSuffix"+i).val(aVals[i]);
         } else {
           $("#txtPreHtmlSuffix"+i).val("");
         }  
      }  
   }  

   function deserializePreField(s) {
     //alert(s);
     aVals = s.split("%");
     for (i=0; i<<?PHP echo(APP_MAX_TOT_FIELDS+10);?>;i++) {
         if (aVals[i]) {
           $("#cbPreField"+i).val(aVals[i]);
         } else {
           $("#cbPreField"+i).val("");
         }  
      }  
   }  

   function displayDelUpload() {
     $("#del-attach").show();
   } 

   function hideDefField(iField) {
     if (iField>0) {
       $("#ctrlDefMinus"+(iField-1)).show();
       $("#ctrlDefPlus"+(iField-1)).show();
     }
     $("#deffieldrow"+iField).hide();
     defFieldTot--;
     $("#DEF_FIELD_TOT").val(defFieldTot);
   }  

   function hidePreField(iField) {
     if (iField>0) {
       $("#ctrlPreMinus"+(iField-1)).show();
       $("#ctrlPrePlus"+(iField-1)).show();
     }
     $("#prefieldrow"+iField).hide();
     preFieldTot--;
     $("#PRE_FIELD_TOT").val(preFieldTot);
   }  

   function showDefField(iField) {
     if (iField>0) {
       $("#ctrlDefMinus"+(iField-1)).hide();
       $("#ctrlDefPlus"+(iField-1)).hide();
     }
     $("#deffieldrow"+iField).show();
     defFieldTot++;
     $("#DEF_FIELD_TOT").val(defFieldTot);
   }  

   function showPreField(iField) {
     if (iField>0) {
       $("#ctrlPreMinus"+(iField-1)).hide();
       $("#ctrlPrePlus"+(iField-1)).hide();
     }
     $("#prefieldrow"+iField).show();
     //if ((iField+1)>=(<?PHP echo(APP_MAX_TOT_FIELDS+10)?>-1)) {
     //  $("#ctrlPrePlus"+iField).hide();
     //}
     preFieldTot++;
     $("#PRE_FIELD_TOT").val(preFieldTot);
   }  

   function serializeField() {
     ret = "";
     if ($("#txtDefField0").get(0)) {
       for (i=0; i<<?PHP echo(APP_MAX_TOT_FIELDS);?>;i++) {
         ret = ret + $("#txtDefField"+i).val();
         if (i<<?PHP echo(APP_MAX_TOT_FIELDS-1);?>) {
           ret = ret + "&";
         }  
       }  
     } else {
       ret = ""; 
     }
     return ret;
   }  

   function serializeFieldType() {
     ret = "";
     if ($("#cbDefField0Type").get(0)) {
        for (i=0; i<<?PHP echo(APP_MAX_TOT_FIELDS);?>;i++) {
          ret = ret + $("#cbDefField"+i+"Type").val();
          if (i<<?PHP echo(APP_MAX_TOT_FIELDS-1);?>) {
            ret = ret + "&";
          }  
        }
     } else {
       ret = ""; 
     }
     return ret;
   }  

   function serializeFieldVal() {
     ret = "";
     if ($("#txtDefField0Val").get(0)) {
        for (i=0; i<<?PHP echo(APP_MAX_TOT_FIELDS);?>;i++) {
          ret = ret + $("#txtDefField"+i+"Val").val();
          if (i<<?PHP echo(APP_MAX_TOT_FIELDS-1);?>) {
            ret = ret + "&";
          }  
        }
     } else {
       ret = ""; 
     }
     return ret;
   }  

   function serializePreHtmlPrefix() {
     ret = "";
     if ($("#txtPreHtmlPrefix0").get(0)) {
        for (i=0; i<<?PHP echo(APP_MAX_TOT_FIELDS+10);?>;i++) {
          ret = ret + $("#txtPreHtmlPrefix"+i).val();
          if (i<<?PHP echo((APP_MAX_TOT_FIELDS+10)-1);?>) {
            ret = ret + "#";
          }  
        }
     } else {
       ret = ""; 
     }
     return ret;
   }  

   function serializeHtmlSuffix() {
     ret = "";
     if ($("#txtPreHtmlSuffix0").get(0)) {
        for (i=0; i<<?PHP echo(APP_MAX_TOT_FIELDS+10);?>;i++) {
          ret = ret + $("#txtPreHtmlSuffix"+i).val();
          if (i<<?PHP echo((APP_MAX_TOT_FIELDS+10)-1);?>) {
            ret = ret + "#";
          }  
        }
     } else {
       ret = ""; 
     }
     return ret;
   }  

   function serializePreField() {
     ret = "";
     if ($("#cbPreField0").get(0)) {
        for (i=0; i<<?PHP echo(APP_MAX_TOT_FIELDS+10);?>;i++) {
          ret = ret + $("#cbPreField"+i).val();
          if (i<<?PHP echo((APP_MAX_TOT_FIELDS+10)-1);?>) {
            ret = ret + "#";
          }  
        }
     } else {
       ret = ""; 
     }
     return ret;
   }  

   function showDefFieldSAFE(iField) {
     if (iField>0 && iField!==<?PHP echo(APP_MAX_TOT_FIELDS-1);?>) {
       $("#ctrlDefMinus"+(iField-1)).hide();
       $("#ctrlDefPlus"+(iField-1)).hide();
     }
     $("#deffieldrow"+iField).show();
   }  

   function showPreFieldSAFE(iField) {
     if (iField>0) {
       $("#ctrlPreMinus"+(iField-1)).hide();
       $("#ctrlPrePlus"+(iField-1)).hide();
     }
     $("#prefieldrow"+iField).show();
   }  

   function showNextRec() {
<?PHP  if ($defRecNum < $defRecTot): ?>
    
       s = serializeField();
       if (s!=="") {
         $("#DEF_FIELD").val(s);
       }  
       s = serializeFieldType();
       if (s!=="") {
         $("#DEF_FIELD_TYPE").val(s);
       }
       s = serializeFieldVal();
       if (s!=="") {
         $("#DEF_FIELD_VAL"+<?PHP echo($defRecNum-1);?>).val(s);
       }
    
       $("#DEF_REC_NUM").val(<?PHP echo($defRecNum);?>+1);
       frmXslwiz.submit();
<?PHP  Endif; ?>
   }  

   function showPrevRec() {
<?PHP  if ($defRecNum > 1): ?>     
    
     s = serializeField();
     if (s!=="") {
       $("#DEF_FIELD").val(s);
     }  
     s = serializeFieldType();
     if (s!=="") {
       $("#DEF_FIELD_TYPE").val(s);
     }
     s = serializeFieldVal();
     if (s!=="") {
       $("#DEF_FIELD_VAL"+<?PHP echo($defRecNum-1);?>).val(s);
     }    
    
     $("#DEF_REC_NUM").val(<?PHP echo($defRecNum);?>-1);
     frmXslwiz.submit();
<?PHP  Endif; ?>     
   }  

   function stripKeys1(tthis, e) {
     //key = e.which;
     //alert(key);
     filterKeysField(tthis);
   }  

   function stripKeys2(tthis, e) {
     //key = e.which;
     //alert(key);
     filterKeysFieldVal(tthis);
   }  

   function filterKeysField(this1) {
     var value = $(this1).val();
     //$(this1).val(value.replace(/[^A-Za-z0-9-_]/, ""));
     var re = new RegExp(/[^\w\d]/, "gi");
     if (re.test(value)) {
       $(this1).val(value.replace(re, ""));
     }  
   }

   function filterKeysFieldVal(this1) {
     var value = $(this1).val();
     //$(this1).val(value.replace(/[^A-Za-z0-9-_]/, ""));
     var re = new RegExp(/[^\w\-\,\.\s]/, "gi");
     if (re.test(value)) {
       $(this1).val(value.replace(re, ""));
     }  
   }

   function upload() {
     $("input#files").click();
   } 
   
   function upload_event() {
      alert("hello!");
      //if (!document.getElementById("files").files) {
      //  $("#del-attach").css("display", "none");
      //} else {  
      //  $("#del-attach").css("display", "inline");
      //}  
      frmXslwiz.submit();
   } 

   $("#txtDesc").on("change", function() {
     $("#DESC").val($("#txtDesc").val());
   });
   $("#txtKeywords").on("change", function() {
     $("#KEYWORDS").val($("#txtKeywords").val());
   });
   $("#txtFooter").on("change", function() {
     $("#FOOTER").val($("#txtFooter").val());
   });

   function setFooterPos() {
     if (document.getElementById("footerCont")) {
       tollerance = 16;
       $("#footerCont").css("top", parseInt( window.innerHeight - $("#footerCont").height() - tollerance ) + "px");
       $("#footer").css("top", parseInt( window.innerHeight - $("#footer").height() - tollerance ) + "px");
     }
   }

   window.addEventListener("load", function() {
     <?PHP if ($logoPath !== "/res/pxl.gif"): ?>
       setTimeout("displayDelUpload()","1000");
     <?PHP endif; ?>    
     
     deserializeField('<?PHP echo($defField);?>');
     deserializeFieldType('<?PHP echo($defFieldType);?>');
     deserializeFieldVal('<?PHP echo($adefFieldVal[$defRecNum-1]);?>');

     deserializePreHtmlPrefix("<?PHP echo(implode("%",$apreHtmlPrefix));?>");
     deserializePreField("<?PHP echo(implode("%",$apreField));?>");
     deserializePreHtmlSuffix("<?PHP echo(implode("%",$apreHtmlSuffix));?>");
     
     //alert(defFieldTot);
     for (i=2; i<=(defFieldTot); i++) {
       showDefFieldSAFE(i-1);
     }  
     showDefFieldSAFE(<?PHP echo(APP_MAX_TOT_FIELDS-1);?>);

     for (i=1; i<(preFieldTot); i++) {
       showPreFieldSAFE(i-1);
     }  
     showPreFieldSAFE(<?PHP echo((APP_MAX_TOT_FIELDS+10)-1);?>);

     setTimeout("setFooterPos()", 1000);

   });

   window.addEventListener("resize", function() {

     setTimeout("setFooterPos()", 1000);

   });

 </script>     
    
</head>
  
<body>

 <div class="header" style="margin-top:18px;margin-bottom:18px;">
      <a href="http://xslwiz.5mode-lab.com" target="_self" style="color:#000000; text-decoration: none;">&nbsp;&nbsp;&nbsp;<b>XSLWIZ<b></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="https://github.com/par7133/XSLWIZ" style="color:#000000;"><span style="color:#119fe2">on</span> github</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="mailto:posta@elettronica.lol" style="color:#000000;"><span style="color:#119fe2">for</span> feedback</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="tel:+39-378-0812391" style="font-size:13px;background-color:#15c60b;border:2px solid #15c60b;color:#000000;height:27px;text-decoration:none;">&nbsp;&nbsp;get support&nbsp;&nbsp;</a>
 </div>  
  
<form name="frmXslwiz" action="/" method="POST" target="_self" enctype="multipart/form-data">
  
    <div id="content" style="text-align:center">
 
      <br><br>
      
      <img src="/res/logo.png" style="width:450px;"><br>
          
      <br><br><br>
     
<?PHP

  switch($iPage) {
            
    case 1: ?>
    
              <table style="width:600px;margin:auto;font-size:24px;">
                 <tr>
                   <td align="right" style="width:150px;height:60px;"> 
               Title:&nbsp;<br>
                   </td> 
                   <td align="left">
                     <input id="txtTitle" name="txtTitle" type="text" placeholder="text" onkeyup="$('#TITLE').val($(this).val());" maxlength="250" value="<?PHP echo($title);?>" style="width:370px;font-size:24px; border: 3px solid dodgerblue; border-radius: 5px;"><br>
                    </td> 
                 </tr> 
                <!--
                 <tr>
                   <td align="right" style="width:150px;height:60px;"> 
               Logo:&nbsp;<br><br><br><br><br>
                   </td> 
                   <td align="left">

                     <img src="<?PHP echo($logoPath);?>" style="float:left; min-width:100px; max-width:350px; min-height:250px; border: 1px dashed #000000; border-radius: 5px; vertical-align:bottom;">

                     <div onclick="upload();" style="float:left;position:relative;top:+1px;left:5px;cursor:pointer;border:3px solid dodgerblue; border-radius: 5px;"><img src="/res/upload2.png" style="width:36px;"></div><div id="del-attach" onclick="clearUpload()" style="position:relative;top:+10px;left:10px;display:none;cursor:pointer;"><img src="/res/del-attach.png" style="width:36px;"></div></div>

                      <div id="upload-cont"><input id="files" name="files[]" type="file" accept=".png,.jpg,.jpeg" onchange="upload_event();" style="visibility: hidden;" multiple></div>

                    </td> 
                 </tr> -->
                </table> 

                <br>   

               <div style="width:542px;clear:both;margin:auto;">
               <div class="input-group-btn btn-white dropdown" style="width: 540px; border-top-left-radius: 4px; border-bottom-left-radius: 4px;">   
               <button id="butAdvancedOptions" class="btn dropdown-toggle btn-blue" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Advanced options"><span id="lblOptionMenu" class="dropdown-menu-caption">Advanced</span>&nbsp;<span id="mycarret" class="glyphicon glyphicon-triangle-bottom" style="position: relative; top: +3px;"></span></button>
               <table class="dropdown-menu search-options-table" style="position:relative; width: 540px; background-color: #FFFFFF; border: 1px solid black; padding:20px;font-size:24px;">   
                 <tr>
                     <td colspan="2">
                        <br>
                     </td>
                 </tr>
                 <tr>
                     <td align="right">
                         Description:&nbsp;<br>
                     </td>
                     <td align="left">
                       <input id="txtDesc" name="txtDesc" type="text" placeholder="text" onkeyup="$('#DESC').val($(this).val());" maxlength="250" value="<?PHP echo($desc);?>" style="font-size:24px; border: 3px solid dodgerblue; border-radius: 5px;"><br>
                      </td> 
                 </tr>
                 <tr>
                     <td align="right">
                         Keywords:&nbsp;<br>
                     </td>
                     <td align="left">
                        <br>
                         <textarea id="txtKeywords" name="txtKeywords" placeholder="comma separeted text" onkeyup="$('#KEYWORDS').val($(this).val());" maxlength="250" style="width:340px; height:96px; font-size:18px; border: 3px solid dodgerblue; border-radius: 5px;"><?PHP echo($keywords);?></textarea><br>
                      </td> 
                 </tr>
                 <tr>
                     <td align="right">
                         Footer:&nbsp;<br><br>
                     </td>
                     <td align="left">
                        <br>
                         <textarea id="txtFooter" name="txtFooter" placeholder="html text"  onkeyup="$('#FOOTER').val($(this).val());" maxlength="250" style="width:340px; height:96px; font-size:18px; border: 3px solid dodgerblue; border-radius: 5px;"><?PHP echo($footer);?></textarea><br>
                         <br>  
                      </td> 
                 </tr>
               </table>  
               </div>      
               </div> 

<?PHP 
      break;
    
    case 2: ?>
                        
                 <h2>DATA SPEC ( XML FILE )</h2> 
                 
                 <br><br><br>
      
                 <table style="width:720px;margin:auto;font-size:24px;border:0px solid black;">
                 <tr>
                   <td align="left" style="width:102px; border:0px solid black;padding-top:4px;">
                      <div id="ctrlPrevious" style="float:right; position:relative; top:-6px; height:38px; font-size:24px; font-weight:900; padding-right:10px; cursor:pointer;" onclick="showPrevRec();">&lt;&lt;</div><br>
                    </td> 
                   <td align="left" style="width:152px; border:0px solid black;padding-top:4px;">
                     <input id="txtDefField0" name="txtDefField0" type="text" placeholder="ID" onkeyup="" maxlength="250" value="<?PHP echo($aData[$dataIndex][0][0]);?>" style="width:150px;background-color:lightgray; font-size:24px; border: 3px solid dodgerblue; border-radius: 5px;" readonly><br>
                    </td> 
                   <td align="left" style="width:162px; border:0px solid black;padding-top:4px;">
                     <!--<input id="txtDefField0Type" name="txtDefField0Type" type="text" placeholder="text" maxlength="50" value="text" style="width:200px;background-color:lightgray; font-size:24px; border: 3px solid dodgerblue; border-radius: 5px;" readonly><br>-->
                     <select id="cbDefField0Type" name="cbDefField0Type" style="width:160px;background-color: #c0c0c0; font-size:24px; border: 3px solid dodgerblue; border-radius: 5px;" disabled>    
                         <option value="text" <?PHP echo(($aData[$dataIndex][0][1]==="text")?"selected":"");?>>text</option>
                         <option value="number" <?PHP echo(($aData[$dataIndex][0][1]==="number")?"selected":"");?>>number</option>
                     </select> <br> 
                   </td> 
                  <td align="left" style="width:202px; border:0px solid black;padding-top:4px;">
                    <input id="txtDefField0Val" name="txtDefField0Val" type="text" placeholder="text" onkeyup="" maxlength="250" value="<?PHP echo($aData[$dataIndex][0][2]);?>" style="width:200px;background-color:lightgray; font-size:24px; border: 3px solid dodgerblue; border-radius: 5px;" readonly><br>
                   </td> 
                   <td align="left" style="width:102px; border:0px solid black;padding-top:4px;">
                     <div id="ctrlDefNext" style="float:left; position:relative; top:-6px; height:38px; font-size:24px; font-weight:900; padding-left:10px; cursor:pointer;" onclick="showNextRec();">&gt;&gt;</div><br>
                    </td> 
                 </tr>   

                 <tr>
                   <td align="left" style="width:102px; border:0px solid black;padding-top:4px;">
                      &nbsp;
                    </td> 
                   <td align="left" style="width:152px; border:0px solid black;padding-top:4px;">
                     <input id="txtDefField1" name="txtDefField1" type="text" placeholder="Field1" onkeyup="stripKeys1(this, event);$('#DEF_FIELD1').val($(this).val());" maxlength="250" value="<?PHP echo($aData[$dataIndex][1][0]);?>" style="width:150px;background-color:#ffffff; font-size:24px; border: 3px solid dodgerblue; border-radius: 5px;"><br>
                    </td> 
                   <td align="left" style="width:162px; border:0px solid black;padding-top:4px;">
                     <!--<input id="txtDefField1Type" name="txtDefField1Type" type="text" placeholder="text" maxlength="50" value="" style="width:200px;background-color:#ffffff; font-size:24px; border: 3px solid dodgerblue; border-radius: 5px;"><br>-->
                     <select id="cbDefField1Type" name="cbDefField1Type" style="width:160px;background-color:<?PHP echo(($aData[$dataIndex][APP_MAX_TOT_FIELDS-1][2]!=1)?"#c0c0c0":"#ffffff");?>; font-size:24px; border: 3px solid dodgerblue; border-radius: 5px;" <?PHP echo(($aData[$dataIndex][APP_MAX_TOT_FIELDS-1][2]!=1)?"disabled":"");?> <?PHP echo($aData[$dataIndex][0][2]);?> <?PHP echo($aData[$dataIndex][APP_MAX_TOT_FIELDS-1][2]);?>>    
                         <option value="text" <?PHP echo(($aData[$dataIndex][1][1]==="text")?"selected":"");?>>text</option>
                         <option value="number" <?PHP echo(($aData[$dataIndex][1][1]==="number")?"selected":"");?>>number</option>
                     </select> <br> 
                    </td> 
                  <td align="left" style="width:202px; border:0px solid black;padding-top:4px;">
                    <input id="txtDefField1Val" name="txtDefField1Val" type="text" placeholder="text" onkeyup="stripKeys2(this, event);$('#DEF_FIELD1_VAL').val($(this).val());" maxlength="250" value="<?PHP echo($aData[$dataIndex][1][2]);?>" style="width:200px;background-color:#ffffff; font-size:24px; border: 3px solid dodgerblue; border-radius: 5px;"><br>
                   </td> 
                   <td align="left" style="width:102px; border:0px solid black;padding-top:4px;">
                     <div id="ctrlDefMinus" style="float:left; position:relative; top:-6px; height:38px; margin-left:7px; cursor:pointer; display:none;"><img src="/res/minus.png" style="width:36px;border: 3px dashed dodgerblue;"></div>&nbsp;&nbsp;
                     <div id="ctrlDefPlus1" style="float:left; position:relative; top:-6px; height:38px; cursor:pointer;" onclick="showDefField(2);"><img src="/res/plus.png" style="width:36px;border: 3px dashed dodgerblue;"></div><br>
                    </td> 
                 </tr>   
                   
 <?PHP for($iField=2; $iField<(APP_MAX_TOT_FIELDS-1); $iField++): ?>  
                   
                 <tr id="deffieldrow<?PHP echo($iField);?>" style="display:none;">
                   <td align="left" style="width:102px; border:0px solid black;padding-top:4px;">
                      &nbsp;
                    </td> 
                   <td align="left" style="width:152px; border:0px solid black;padding-top:4px;">
                     <input id="txtDefField<?PHP echo($iField);?>" name="txtDefField<?PHP echo($iField);?>" type="text" placeholder="Field<?PHP echo($iField);?>" onkeyup="$('#DEF_FIELD<?PHP echo($iField);?>').val($(this).val());" maxlength="250" value="<?PHP echo($aData[$dataIndex][$iField][0]);?>" style="width:150px;background-color:#fffffff; font-size:24px; border: 3px solid dodgerblue; border-radius: 5px;"><br>
                    </td> 
                   <td align="left" style="width:162px; border:0px solid black;padding-top:4px;">
                     <!--<input id="txtDefField<?PHP echo($iField);?>Type" name="txtDefField<?PHP echo($iField);?>Type" type="text" placeholder="text" maxlength="50" value="" style="width:200px;background-color:#ffffff; font-size:24px; border: 3px solid dodgerblue; border-radius: 5px;"><br>-->
                     <select id="cbDefField<?PHP echo($iField);?>Type" name="cbDefField1Type" style="width:160px;background-color:<?PHP echo(($aData[$dataIndex][APP_MAX_TOT_FIELDS-1][2]!=1)?"#c0c0c0":"#ffffff");?>;<?PHP echo($aData[$dataIndex][0][2]);?>; font-size:24px; border: 3px solid dodgerblue; border-radius: 5px;" <?PHP echo(($aData[$dataIndex][APP_MAX_TOT_FIELDS-1][2]!=1)?"disabled":"");?>>    
                         <option value="text" <?PHP echo(($aData[$dataIndex][$iField][1]==="text")?"selected":"");?>>text</option>
                         <option value="number" <?PHP echo(($aData[$dataIndex][$iField][1]==="number")?"selected":"");?>>number</option>
                     </select> <br> 
                    </td> 
                   <td align="left" style="width:202px; border:0px solid black;padding-top:4px;">
                     <input id="txtDefField<?PHP echo($iField);?>Val" name="txtDefField<?PHP echo($iField);?>Val" type="text" placeholder="text" onkeyup="$('#DEF_FIELD<?PHP echo($iField);?>_VAL').val($(this).val());" maxlength="250" value="<?PHP echo($aData[$dataIndex][$iField][2]);?>" style="width:200px;background-color:#ffffff; font-size:24px; border: 3px solid dodgerblue; border-radius: 5px;"><br>
                    </td> 
                   <td align="left" style="width:162px; border:0px solid black;padding-top:4px;">
                     <?PHP if ($iField>0): ?>
                     <div id="ctrlDefMinus<?PHP echo($iField);?>" style="float:left; position:relative; top:-6px; height:38px; margin-left:7px; cursor:pointer;display:<?PHP echo(($iField===0)?"none":"inline");?>;" " onclick="hideDefField(<?PHP echo($iField);?>);"><img src="/res/minus.png" style="width:36px;border: 3px dashed dodgerblue;"></div>&nbsp;&nbsp;
                      <?PHP Endif; ?>
                    <?PHP if (($iField+1)<(APP_MAX_TOT_FIELDS-1)):?> 
                     <div id="ctrlDefPlus<?PHP echo($iField);?>" style="float:left;  position:relative; top:-6px; height:38px; cursor:pointer; margin-left:10px;" onclick="showDefField(<?PHP echo($iField+1);?>);"><img src="/res/plus.png" style="width:36px;border: 3px dashed dodgerblue;"></div><br>
                    <?PHP Endif;?>   
                    </td> 
                 </tr>   
                                 
 <?PHP EndFor; ?>

                 <tr id="deffieldrow<?PHP echo(APP_MAX_TOT_FIELDS-1);?>" style="display:none;">
                   <td align="left" style="width:102px; border:0px solid black;padding-top:4px;">
                      &nbsp;
                    </td> 
                   <td align="left" style="width:152px; border:0px solid black;padding-top:4px;">
                     <input id="txtDefField<?PHP echo(APP_MAX_TOT_FIELDS-1);?>" name="txtDefField<?PHP echo(APP_MAX_TOT_FIELDS-1);?>" type="text" placeholder="Field<?PHP echo(APP_MAX_TOT_FIELDS-1);?>" onkeyup="$('#DEF_FIELD<?PHP echo(APP_MAX_TOT_FIELDS-1);?>').val($(this).val());" maxlength="250" value="<?PHP echo($aData[$dataIndex][APP_MAX_TOT_FIELDS-1][0]);?>" style="width:150px;background-color:lightgray; font-size:24px; border: 3px solid dodgerblue; border-radius: 5px;" readonly><br>
                    </td> 
                   <td align="left" style="width:162px; border:0px solid black;padding-top:4px;">
                     <!--<input id="txtDefField<?PHP echo(APP_MAX_TOT_FIELDS-1);?>Type" name="txtDefField<?PHP echo(APP_MAX_TOT_FIELDS-1);?>Type" type="text" placeholder="text" maxlength="50" value="" style="width:200px;background-color:#ffffff; font-size:24px; border: 3px solid dodgerblue; border-radius: 5px;"><br>-->
                     <select id="cbDefField<?PHP echo(APP_MAX_TOT_FIELDS-1);?>Type" name="cbDefField1Type" style="width:160px;background-color:#c0c0c0; font-size:24px; border: 3px solid dodgerblue; border-radius: 5px;" disabled>    
                         <option value="text" <?PHP echo(($aData[$dataIndex][APP_MAX_TOT_FIELDS-1][1]==="text")?"selected":"");?>>text</option>
                         <option value="number" <?PHP echo(($aData[$dataIndex][APP_MAX_TOT_FIELDS-1][1]==="number")?"selected":"");?>>number</option>
                     </select> <br>
                   </td> 
                   <td align="left" style="width:202px; border:0px solid black;padding-top:4px;">
                     <input id="txtDefField<?PHP echo(APP_MAX_TOT_FIELDS-1);?>Val" name="txtDefField<?PHP echo(APP_MAX_TOT_FIELDS-1);?>Val" type="text" placeholder="text" onkeyup="$('#DEF_FIELD<?PHP echo(APP_MAX_TOT_FIELDS-1);?>_VAL').val($(this).val());" maxlength="250" value="<?PHP echo($aData[$dataIndex][APP_MAX_TOT_FIELDS-1][2]);?>" style="width:200px;background-color:lightgray; font-size:24px; border: 3px solid dodgerblue; border-radius: 5px;" readonly><br>
                    </td> 
                   <td align="left" style="width:102px; border:0px solid black;padding-top:4px;">
                     <!--
        <div id="ctrlDefMinus<?PHP echo(APP_MAX_TOT_FIELDS-1);?>" style="float:left; position:relative; top:-6px; height:38px; margin-left:7px; cursor:pointer;" onclick="hideDefField(<?PHP echo(APP_MAX_TOT_FIELDS-1);?>)"><img src="/res/minus.png" style="width:36px;border: 3px dashed dodgerblue;"></div>&nbsp;&nbsp;
        <div id="ctrlDefPlus<?PHP echo(APP_MAX_TOT_FIELDS-1);?>" style="float:left; position:relative; top:-6px; height:38px; cursor:pointer; margin-left:10px; display:none;"><img src="/res/plus.png" style="width:36px;border: 3px dashed dodgerblue;"></div><br>
        -->             
                    </td> 
                 </tr>   
                   
                  <tr> 
                    <td align="left" style="width:152px; border:0px solid black;padding-top:4px;">&nbsp;</td>
                    <td colspan="3" align="left" style="width:466px; border:0px solid black;padding-top:4px;font-size:24px;text-align:left;vertical-align:middle;">
                      <br>
                      <div style="float:left;width:243px;cursor:pointer" onclick="delRecord();"><img src="/res/minus.png" align="middle" style="position:relative;top:-7px;width:36px;border: 3px dashed dodgerblue;vertical-align:middle;">&nbsp;Delete Item&nbsp;&nbsp;&nbsp;</div>
                      <div style="float:left;width:173px;cursor:pointer" onclick="addRecord();"><img src="/res/plus.png" align="middle" style="position:relative;top:-7px;width:36px;border: 3px dashed dodgerblue;vertical-align:middle;">&nbsp;Add Item</div>
                    </td>
                 </tr>   
                   
             </table>       
                   
<?PHP 
      break;
    
    case 3: ?>
                       
                 <h2>PRESENTATION ( XSL FILE )</h2> 
                 
                 <br><br><br>
      
                 <table style="width:720px;margin:auto;font-size:24px;border:0px solid black;">
                 <tr>
                   <td align="left" style="width:102px;padding-top:4px;border:0px solid black;">
                      <div style="float:right; position:relative; top:-0px; height:38px; font-size:24px; font-weight:900; padding-right:10px;">SELECT&nbsp;&nbsp;&nbsp;</div><br>
                    </td> 
                   <td align="left" style="width:152px;padding-top:4px;border:0px solid black;">
                     <select id="cbPreSelField" name="cbPreSelField" onchange="$('#PRE_SEL_FIELD').val($(this).val());" style="width:150px;background-color: #FFFFFF; font-size:24px; border: 3px solid dodgerblue; border-radius: 5px;">    
                       <?PHP 
          $s = $defField;
          $adefField = explode("&", $s);             
          ?>
                       <?PHP for($i=0;$i<$defFieldTot;$i++): ?>
                         <option value="<?PHP echo($adefField[$i]);?>" <?PHP echo(($adefField[$i]===$preSelField)?"selected":"");?>><?PHP echo($adefField[$i]);?></option>
                        <?PHP EndFor; ?>
                     </select> <br> 
                    </td> 
                   <td align="left" style="width:162px;padding-top:4px;border:0px solid black;">
                     <select id="cbPreSelMethod" name="cbPreSelMethod" onchange="$('#PRE_SEL_METHOD').val($(this).val());" style="width:150px;background-color: #FFFFFF; margin-left:6px; font-size:24px; border: 3px solid dodgerblue; border-radius: 5px;">    
                        <option value="equal" <?PHP echo(($preSelMethod === "equal")?"selected":"");?>>=&nbsp;equal</option>
                        <option value="bigger" <?PHP echo(($preSelMethod === "bigger")?"selected":"");?>>&gt;&nbsp;bigger</option>
                        <option value="smaller" <?PHP echo(($preSelMethod === "smaller")?"selected":"");?>>&lt;&nbsp;smaller</option>
                      </select> <br> 
                   </td> 
                  <td align="left" style="width:162px;padding-top:4px;border:0px solid black;">
                    <input id="txtPreSelVal" name="txtPreSelVal" type="text" placeholder="text" maxlength="250" onkeyup="$('#PRE_SEL_VAL').val($(this).val());" value="<?PHP echo($preSelVal);?>" style="width:147px;background-color:#FFFFFF; font-size:24px; border: 3px solid dodgerblue; border-radius: 5px;"><br>
                   </td> 
                   <td align="left" style="width:102px; border:0px solid black;padding-top:4px;">
                     &nbsp;
                    </td> 
                 </tr>   
                   
                   
                 <tr>
                   <td align="left" style="width:102px;padding-top:4px;padding-top:15px;border:0px solid black;">
                      &nbsp;
                    </td> 
                   <td colspan="3" align="left" style="width:466px; border:0px solid black;padding-top:15px;">
                     <textarea id="txtPreTopHtml" name="txtPreTopHtml" placeholder="top html" maxlength="550" onkeyup="$('#PRE_TOP_HTML').val($(this).val());" style="width:463px;height:72px;background-color:#FFFFFF; font-size:24px; border: 3px solid dodgerblue; border-radius: 5px;"><?PHP echo($preTopHtml);?></textarea><br>
                   </td> 
                   <td align="left" style="width:102px; border:0px solid black;padding-top:15px;">
                     &nbsp;
                    </td> 
                 </tr>   

                   
 <?PHP for($iField=0; $iField<((APP_MAX_TOT_FIELDS+10)-1); $iField++): ?>                     
                   
                 <tr id="prefieldrow<?PHP echo($iField);?>" style="display:none;">
                   <td align="left" style="width:102px;padding-top:8px;border:0px solid black;">
                      &nbsp;
                    </td> 
                   <td colspan="3" align="left" style="width:444px;padding-top:8px;border:0px solid black;">
                     <input id="txtPreHtmlPrefix<?PHP echo($iField);?>" name="txtPreHtmlPrefix<?PHP echo($iField);?>" type="text" placeholder="prefix" onkeyup="$('#PRE_HTML_PREFIX<?PHP echo($iField);?>').val($(this).val());" maxlength="550" value=" <?PHP echo($apreHtmlPrefix[$iField]);?>" style="float:left;width:147px;background-color:#FFFFFF;font-size:24px;border:3px solid dodgerblue;border-radius:5px;margin-right:6px;">
                     <select id="cbPreField<?PHP echo($iField);?>" name="cbPreField<?PHP echo($iField);?>" onchange="$('#PRE_FIELD<?PHP echo($iField);?>').val($(this).val());" style="float:left;width:150px;height:42px;background-color:#ffffff;margin-left:6px;font-size:24px; border:3px solid dodgerblue; border-radius: 5px;margin-right:6px;">    
                       <?PHP 
          $s = $defField;
          $adefField = explode("&", $s);             
          ?>
                       <?PHP for($i=1;$i<$defFieldTot;$i++): ?>
                         <option value="<?PHP echo($adefField[$i]);?>" <?PHP echo(($apreField[$iField] === $adefField[$i])?"selected":"");?>>&nbsp;<?PHP echo($adefField[$i]);?></option>
                        <?PHP EndFor; ?>
                      </select>
                     <input id="txtPreHtmlSuffix<?PHP echo($iField);?>" name="txtPreHtmlSuffix<?PHP echo($iField);?>" type="text" placeholder="suffix" onkeyup="$('#PRE_HTML_SUFFIX<?PHP echo($iField);?>').val($(this).val());" maxlength="550" value="<?PHP echo($apreHtmlSuffix[$iField]);?>" style="float:left;width:147px;background-color:#FFFFFF;font-size:24px;border:3px solid dodgerblue;border-radius:5px;margin-right:6px;">
                   </td> 
                   <td align="left" style="width:105px;padding-top:8px;border:0px solid black;">
                     <?PHP if ($iField>0): ?>
                     <div id="ctrlPreMinus<?PHP echo($iField);?>" style="float:left; position:relative; top:-6px; height:38px; margin-left:7px; cursor:pointer;display:<?PHP echo(($iField===0)?"none":"inline");?>;" onclick="hidePreField(<?PHP echo($iField);?>);"><img src="/res/minus.png" style="width:36px;border: 3px dashed dodgerblue;"></div>
                     <?PHP Endif; ?>
                     <?PHP if (($iField+1)<((APP_MAX_TOT_FIELDS+9)-1)):?>
                     <div id="ctrlPrePlus<?PHP echo($iField);?>" style="float:left; position:relative; top:-6px; height:38px; margin-left:10px; cursor:pointer;display:inline;" onclick="showPreField(<?PHP echo($iField+1);?>);"><img src="/res/plus.png" style="width:36px;border: 3px dashed dodgerblue;"></div>
                     <?PHP Endif; ?>
                    </td> 
                 </tr>   
   
  <?PHP Endfor; ?>
                   
                   
                <tr>
                   <td align="left" style="width:102px; border:0px solid black;padding-top:15px;">
                      &nbsp;
                    </td> 
                   <td colspan="3" align="left" style="width:466px; border:0px solid black;padding-top:15px;">
                     <textarea id="txtPreBottomHtml" name="txtPreBottomHtml" placeholder="bottom html" maxlength="550" onkeyup="$('#PRE_BOTTOM_HTML').val($(this).val());" style="width:463px;height:72px;background-color:#FFFFFF; font-size:24px; border: 3px solid dodgerblue; border-radius: 5px;"><?PHP echo($preBottomHtml);?></textarea><br>
                   </td> 
                   <td align="left" style="width:102px; border:0px solid black;padding-top:15px;">
                     &nbsp;
                    </td> 
                 </tr>                    

                   
                 <tr>
                   <td align="left" style="width:102px;padding-top:15px;border:0px solid black;">
                      <div style="float:right; position:relative; top:-0px; height:38px; font-size:24px; font-weight:900; padding-right:10px;">ORDER&nbsp;&nbsp;&nbsp;</div><br>
                    </td> 
                   <td align="left" style="width:152px;padding-top:15px;border:0px solid black;">
                     <select id="cbPreOrdField" name="cbPreOrdField" style="width:150px;background-color: #FFFFFF; font-size:24px; border: 3px solid dodgerblue; border-radius: 5px;">    
                       <?PHP 
          $s = $defField;
          $adefField = explode("&", $s);             
          ?>
                       <?PHP for($i=0;$i<$defFieldTot;$i++): ?>
                         <option value="<?PHP echo($adefField[$i]);?>">&nbsp;<?PHP echo($adefField[$i]);?></option>
                        <?PHP EndFor; ?>
                         <option value="INDEX" selected>&nbsp;INDEX</option>
                     </select> <br> 
                    </td> 
                   <td align="left" style="width:162px;padding-top:15px;border:0px solid black;">
                     <select id="cbPreOrdFieldType" name="cbPreOrdFieldType" style="width:150px;background-color: #FFFFFF; margin-left:6px; font-size:24px; border: 3px solid dodgerblue; border-radius: 5px;" onchange="$('#PRE_ORD_FIELDTYPE').val($(this).val());">    
                        <option value="text" <?PHP echo(($preOrdFieldType === "text")?"selected":"");?>>&nbsp;text</option>
                        <option value="number" <?PHP echo(($preOrdFieldType === "number")?"selected":"");?>>&nbsp;number</option>
                      </select> <br> 
                   </td> 
                  <td align="left" style="width:162px;padding-top:15px;border:0px solid black;">
                     <select id="cbPreOrdDir" name="cbPreOrdDir" style="width:148px;background-color: #FFFFFF; margin-left:0px; font-size:24px; border: 3px solid dodgerblue; border-radius: 5px;" onchange="$('#PRE_ORD_DIR').val($(this).val());">    
                        <option value="asc" <?PHP echo(($preOrdDir === "asc")?"selected":"");?>>&nbsp;asc</option>
                        <option value="desc" <?PHP echo(($preOrdDir === "desc")?"selected":"");?>>&nbsp;desc</option>
                      </select> <br> 
                   </td> 
                   <td align="left" style="width:102px; border:0px solid black;padding-top:4px;">
                     &nbsp;
                    </td> 
                 </tr>   
                 </table>

                       
<?PHP 
      break;

    case 4: ?>
      
              <table style="width:600px;margin:auto;font-size:24px;">
                 <tr>
                   <td align="right" style="width:150px;height:60px;"> 
               Code:&nbsp;
                   </td> 
                   <td align="left" style="width:150px;height:60px;"> 
                     <input id="txtLogoCode" name="txtLogoCode" type="text" placeholder="text" onkeyup="$('#LOGO_CODE').val($(this).val());" maxlength="250" value="<?PHP echo($logoCode);?>" style="width:370px;font-size:24px; border: 3px solid dodgerblue; border-radius: 5px;"><br> 
                    </td> 
                 </tr>  
                 <tr>
                   <td colspan="2" style="height:60px;"> 
               &nbsp;
                   </td> 
                 </tr>  
                 <tr>
                   <td align="right" style="width:150px;height:60px;"> 
               Logo:&nbsp;<br><br><br><br><br>
                   </td> 
                   <td align="left" title="Pay 5$ to have your logo code. Contact us at info@5mode.com ">

                     <img src="<?PHP echo($logoPath);?>" style="float:left; min-width:100px; max-width:360px; min-height:250px; border: 1px dashed #000000; border-radius: 5px; vertical-align:bottom;">

                     <div onclick="disupload();" style="float:left;position:relative;top:+1px;left:5px;cursor:pointer;border:3px solid darkgray; border-radius: 5px;"><img src="/res/upload2-dis.png" style="width:36px;"></div><div id="del-attach" onclick="disclearUpload()" style="position:relative;top:+5px;left:10px;display:none;cursor:normal;padding:3px;"><img src="/res/del-attach2-dis.png" style="width:34px;"></div></div>

                      <div id="upload-cont"><input id="files" name="files[]" type="file" accept=".png,.jpg,.jpeg" onchange="upload_event();" style="visibility: hidden;" multiple></div>

                    </td> 
                 </tr> 
                </table> 
      

<?PHP 
      break;

    case 5: ?>
                
                       <input id="ID" name="ID" type="hidden" value="<?PHP echo($ID);?>">
                       
                       <script>
           function openDownload() {
             frmXslwiz.action = "/download";
             frmXslwiz.method = "GET";
             frmXslwiz.submit();              
           }              
           openDownload();
         </script>
                       
                       <?PHP exit(1);?>
                                                
<?PHP      
      break;
      
  } ?>
                  
        <br><br><br>
           
        <div id="navbar" style="width:550px;clear:both;margin:auto;white-space:no-wrap;">
             <button id="butCencel" style="font-size:24px" onclick="frmXslwiz.reset();">Cancel</button>&nbsp;&nbsp;&nbsp;
             <?PHP if ($iPage>1): ?>
             <button id="butPrev" style="font-size:24px" onclick="changePage(<?PHP echo($iPrevPage)?>);">&lt;&lt; Prev</button>
             <?PHP endif; ?>
             <button id="butNext" style="font-size:24px" onclick="changePage(<?PHP echo($iNextPage)?>);">Next &gt;&gt;</button>
        </div>  
        
        <br><br><br><br>    
            
     </div>      
  
     <input id="ID" name="ID" type="hidden" value="<?PHP echo($ID);?>">
     <input id="TITLE" name="TITLE" type="hidden" value="<?PHP echo($title);?>">
     <input id="DESC" name="DESC" type="hidden" value="<?PHP echo($desc);?>">
     <input id="KEYWORDS" name="KEYWORDS" type="hidden" value="<?PHP echo($keywords);?>">
     <input id="FOOTER" name="FOOTER" type="hidden" value="<?PHP echo($footer);?>">

     <!-- DEFINITION -->  
       
     <input id="DEF_FIELD" name="DEF_FIELD" type="hidden" value="<?PHP echo($defField);?>">
     <input id="DEF_FIELD_TYPE" name="DEF_FIELD_TYPE" type="hidden" value="<?PHP echo($defFieldType);?>">
     <?PHP for ($i=0; $i<$defRecTot; $i++): ?>   
       <input id="DEF_FIELD_VAL<?PHP echo($i);?>" name="DEF_FIELD_VAL<?PHP echo($i);?>" type="hidden" style="width:500px;" value="<?PHP echo($adefFieldVal[$i]);?>"><br>
     <?PHP Endfor; ?>
         
     <input id="DEF_FIELD_TOT" name="DEF_FIELD_TOT" type="hidden" value="<?PHP echo($defFieldTot);?>">
     <input id="DEF_REC_NUM" name="DEF_REC_NUM" type="hidden" value="<?PHP echo($defRecNum);?>">
     <input id="DEF_REC_TOT" name="DEF_REC_TOT" type="hidden" value="<?PHP echo($defRecTot);?>">
     
     <!-- PRESENTATION --> 
     <input id="PRE_SEL_FIELD" name="PRE_SEL_FIELD" type="hidden" value="<?PHP echo($preSelField);?>">
     <input id="PRE_SEL_METHOD" name="PRE_SEL_METHOD" type="hidden" value="<?PHP echo($preSelMethod);?>">
     <input id="PRE_SEL_VAL" name="PRE_SEL_VAL" type="hidden" value="<?PHP echo($preSelVal);?>">
       
     <input id="PRE_TOP_HTML" name="PRE_TOP_HTML" type="hidden" value="<?PHP echo($preTopHtml);?>">
       
     <?PHP for ($i=0; $i<((APP_MAX_TOT_FIELDS+10)-1); $i++): ?>   
       <input id="PRE_HTML_PREFIX<?PHP echo($i);?>" name="PRE_HTML_PREFIX<?PHP echo($i);?>" type="hidden" value="<?PHP echo($apreHtmlPrefix[$i]);?>">
       <input id="PRE_FIELD<?PHP echo($i);?>" name="PRE_FIELD<?PHP echo($i);?>" type="hidden" value="<?PHP echo($apreField[$i]);?>"> <br>
       <input id="PRE_HTML_SUFFIX<?PHP echo($i);?>" name="PRE_HTML_SUFFIX<?PHP echo($i);?>" type="hidden" value="<?PHP echo($apreHtmlSuffix[$i]);?>">
     <?PHP Endfor; ?>
       
     <input id="PRE_BOTTOM_HTML" name="PRE_BOTTOM_HTML" type="hidden" value="<?PHP echo($preBottomHtml);?>"><br>    

     <input id="PRE_ORD_FIELD" name="PRE_ORD_FIELD" type="hidden" value="<?PHP echo($preOrdField);?>">
     <input id="PRE_ORD_FIELDTYPE" name="PRE_ORD_FIELDTYPE" type="hidden" value="<?PHP echo($preOrdFieldType);?>">
     <input id="PRE_ORD_DIR" name="PRE_ORD_DIR" type="hidden" value="<?PHP echo($preOrdDir);?>">
     
     <input id="PRE_FIELD_TOT" name="PRE_FIELD_TOT" type="hidden" value="<?PHP echo($preFieldTot);?>">  
     
     <!-- OP -->  
     
     <input id="LOGO_CODE" name="LOGO_CODE" type="hidden" value="<?PHP echo($logoCode);?>">
     
     <input id="OP_PAGE" name="OP_PAGE" type="hidden" value="<?PHP echo($page);?>">  
     <input id="OP_MSG" name="OP_MSG" type="hidden" value="">
       
 </form>

 <div id="footerCont">&nbsp;</div>
  <div id="footer">
 <span style="background:#FFFFFF; opacity:0.7;">&nbsp;&nbsp; <a href="https://5mode.com/dd.html" class="aaa">Disclaimers</a>. A <a href="http://5mode.com" class="aaa">5 Mode</a> project and <a href="http://demo.5mode.com" class="aaa">WYSIWYG</a> system. CC&nbsp;&nbsp;</span>
  </div>  

<!-- METRICS CODE -->
<?php if (file_exists(APP_PATH . DIRECTORY_SEPARATOR . "metrics.html")): ?>
<?php include(APP_PATH . DIRECTORY_SEPARATOR . "metrics.html"); ?> 
<?php endif; ?>
	      
</body>
</html>
