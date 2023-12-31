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

<html>
<head>
  <meta http-equiv="refresh" content="3;url=http://<?php echo $_SERVER['HTTP_HOST'];?>/d?ID=<?PHP echo($ID);?>">  
</head> 
</html>  