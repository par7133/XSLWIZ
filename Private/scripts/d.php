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
 * download.php
 * 
 * Xslwiz download page.
 *
 * @author Daniele Bonini <my25mb@aol.com>
 * @copyrights (c) 2016, 2024 5 Mode
 */

$ID = filter_input(INPUT_GET, "ID")??"";
$ID = strip_tags($ID);

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
  <script src="/js/common.js" type="text/javascript"></script>  
  <script src="/js/htmlencode.js" type="text/javascript"></script>  
  <script src="/js/index.js?r=<?PHP echo(time());?>" type="text/javascript"></script>  
    
  <link href="/css/bootstrap.min.css" type="text/css" rel="stylesheet">
  <link href="/css/style.css?r=<?PHP echo(time());?>" type="text/css" rel="stylesheet">

    
<script>    

   function setFooterPos() {
     if (document.getElementById("footerCont")) {
       tollerance = 16;
       $("#footerCont").css("top", parseInt( window.innerHeight - $("#footerCont").height() - tollerance ) + "px");
       $("#footer").css("top", parseInt( window.innerHeight - $("#footer").height() - tollerance ) + "px");
     }
   }

   window.addEventListener("load", function() {
 
     setTimeout("setFooterPos()", 1000);

   });

   window.addEventListener("resize", function() {

     setTimeout("setFooterPos()", 1000);

   });    
   
</script>
   
   
</head>
<body>

 <div class="header" style="margin-top:18px;margin-bottom:18px;">
      <a href="http://xslwiz.5mode-foss.eu" target="_self" style="color:#000000; text-decoration: none;">&nbsp;&nbsp;&nbsp;<b>XSLWIZ<b></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="https://github.com/par7133/XSLWIZ" style="color:#000000;"><span style="color:#119fe2">on</span> github</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="mailto:posta@elettronica.lol" style="color:#000000;"><span style="color:#119fe2">for</span> feedback</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="tel:+39-331-4029415" style="font-size:13px;background-color:#15c60b;border:2px solid #15c60b;color:#000000;height:27px;text-decoration:none;">&nbsp;&nbsp;get support&nbsp;&nbsp;</a>
 </div>  
  
<form name="frmXslwiz" action="/" method="POST" target="_self" enctype="multipart/form-data">
  
    <div id="content" style="text-align:center">
 
      <br><br>
      
      <img src="/res/logo.png" style="width:450px;"><br>
          
      <br><br><br>

       <span style="font-size:24px;">Your ID is <i><b><?PHP echo($ID);?></b></i></span><br><br>
            
        <a href="/xsl-repo/<?PHP echo($ID);?>/index.xml"><?PHP echo($ID);?>/index.xml</a><br><br>
            
        <a href="/xsl-repo/<?PHP echo($ID);?>/index.xsl"><?PHP echo($ID);?>/index.xsl</a>    
            
        <br><br><br><br><br>
           
        <div id="navbar" style="width:550px;clear:both;margin:auto;white-space:no-wrap;text-align:center">
             <button id="butStartOver" onclick="window.open('/','_self')" style="font-size:24px">Start Over</button>&nbsp;&nbsp;&nbsp;
        </div>  
        
        <br><br><br><br>    
            
     </div>                  

  </form>

 <div id="footerCont">&nbsp;</div>
  <div id="footer">
 <span style="background:#FFFFFF; opacity:0.7;">&nbsp;&nbsp; <a href="dd.html" class="aaa">Disclaimers</a>. A <a href="http://5mode.com" class="aaa">5 Mode</a> project and <a href="http://demo.5mode.com" class="aaa">WYSIWYG</a> system. Some rights reserved.</span>
  </div>
 
</body>
</html>
