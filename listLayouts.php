<html>
<head>
<!-- declare charset as UTF-8 -->
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
</head>
<body>
<?php
/**
 * listLayouts.php
 * 
 * Copyright © 2005-2006, FileMaker, Inc. All rights reserved.
 * NOTE: Use of this source code is subject to the terms of the FileMaker
 * Software License which accompanies the code. Your use of this source code
 * signifies your agreement to such license terms and conditions. Except as
 * expressly granted in the Software License, no other copyright, patent, or
 * other intellectual property license or right is granted, either expressly or
 * by implication, by FileMaker.
 * 
 * Example PHP script to illustrate how to list layouts in a database.
 * 
 * Requirements:
 *   1. Working FileMaker Server installation
 *   2. 'FMPHP_Sample' database hosted in FileMaker Server
 *
 */
 
// Include FileMaker API
require_once ('FileMaker.php');

// Create a new connection to FMPHP_Sample database.
// Location of FileMaker Server is assumed to be on the same machine,
//  thus we assume hostspec is api default of 'http://localhost' as specified
//  in filemaker-api.php.
// If FMSA web server is on another machine, specify 'hostspec' as follows:
$fm = new FileMaker('semicon2013', 'http://localhost');
$fm = new FileMaker('semicon2013');

// Call listLayouts() to get array of layout names.
$layouts = $fm->listLayouts();

// If an error is found, return a message and exit.
if (FileMaker::isError($layouts)) {
    printf("Error %s: %s\n", $layouts->getCode());
    "<br>";
    printf($layouts->getMessage());
    exit;
}

// Print out layout names
foreach ($layouts as $layout) {
    echo $layout . "<br>";
}

?>
</body>
</html>
