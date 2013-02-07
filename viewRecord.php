<html>
<?php
/**
 * viewRecord.php
 * 
 * Copyright © 2005-2006, FileMaker, Inc. All rights reserved.
 * NOTE: Use of this source code is subject to the terms of the FileMaker
 * Software License which accompanies the code. Your use of this source code
 * signifies your agreement to such license terms and conditions. Except as
 * expressly granted in the Software License, no other copyright, patent, or
 * other intellectual property license or right is granted, either expressly or
 * by implication, by FileMaker.
 * 
 * Example PHP script to illustrate how to view a particular record in a database using PHP API.
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
//   $fm = new FileMaker('FMPHP_Sample', 'http://10.0.0.1');
//$fm = new FileMaker('semicon2013');

$fm = new FileMaker('semicon2013', 'http://localhost');
$fm = new FileMaker('semicon2013');

// Since we're passed in recid via param (i.e. viewRecord.php?recid=n), use
// FileMaker::getRecordById() to directly get record object with recid accessed
// via $_GET[] array
$record = $fm->getRecordById('LKontakte', $_GET['recid']);

if (FileMaker::isError($record)) {
    echo "<body>Error: " . $record->getMessage(). "</body>";
    exit;
}
?>
<head>
<title><?php echo $record->getField('KONTAKT.T_Anrede'); ?></title>
<!-- declare charset as UTF-8 -->
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="style.css">
</head>
<body>
<table>
<tr><th id="table-title" colspan="3">Kontakt Semicon 2013</th></tr>
<tr><th>Anrede</th><td><?php echo $record->getField('KONTAKT.T_Anrede'); ?></td></tr>
<tr><th>Member</th><td><?php echo $record->getField('KONTAKT.T_Member'); ?></td></tr>
<tr><th>Promocode</th><td><?php echo $record->getField('KONTAKT.T_Promocode'); ?></td></tr>
<tr><th>E Mail</th><td><?php echo $record->getField('KONTAKT.T_EMail'); ?></td></tr>
<tr><th>Vor</th><td><?php echo $record->getField('KONTAKT.T_First_Name'); ?></td></tr>
<tr><th>Nachname</th><td><?php echo $record->getField('KONTAKT.T_Last_Name'); ?></td></tr>
<tr><th>Firma 1</th><td><?php echo $record->getField('KONTAKT.T_Company_1'); ?></td></tr>
<tr><th>Firma 2</th><td><?php echo $record->getField('KONTAKT.T_Company_2'); ?></td></tr>
<tr><th>Cover Image</th><td><?php if ($record->getField('Cover Image')) {?> <IMG src="containerBridge.php?path=<?php echo urlencode($record->getField('Cover Image')); ?>"> <?php } ?></td></tr>
<tr><td colspan="2" style="text-align: center"><a href="editRecord.php?recid=<?php echo $record->getRecordId(); ?>">Bearbeiten</a></td></tr>
<tr><td colspan="2" style="text-align: center"><a href="deleteRecord.php?recid=<?php echo $record->getRecordId(); ?>">Löschen.. falls schon geht</a></td></tr>
<tr><td colspan="2" style="text-align: center"><a href="displayRecords.php">Zurück zur Kontakt-Liste</a></td></tr>
</table>
</body>
</html>
