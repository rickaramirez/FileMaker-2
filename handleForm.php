<html>
<head>
<title>Add/Edit Record</title>
</head>
<?php
/**
 * handleForm.php
 * 
 * Copyright © 2005-2006, FileMaker, Inc. All rights reserved.
 * NOTE: Use of this source code is subject to the terms of the FileMaker
 * Software License which accompanies the code. Your use of this source code
 * signifies your agreement to such license terms and conditions. Except as
 * expressly granted in the Software License, no other copyright, patent, or
 * other intellectual property license or right is granted, either expressly or
 * by implication, by FileMaker.
 *
 * This is a script to handle the form submit for a new record or editing a record.
 */

// Turn on output buffering so that we can set Location: HTTP Header later on
ob_start();

require_once("FileMaker.php");

// Create FileMaker object
// Location of FileMaker Server is assumed to be on the same machine,
//  thus we assume hostspec is api default of 'http://localhost' as specified
//  in filemaker-api.php.
// If FMSA web server is on another machine, specify 'hostspec' as follows:
$fm = new FileMaker('semicon2013', 'http://localhost');
$fm = new FileMaker('semicon2013');

//$fm->setProperty('username', 'admin');
//$fm->setProperty('password', 'colnago12');

// Field names we expect as keys in $_POST[]
$keys = array(
		'KONTAKT.T_Anrede',
		'KONTAKT.T_Member',
		'KONTAKT.T_Promocode',
		'KONTAKT.T_EMail',
		'KONTAKT.T_First_Name',
		'KONTAKT.T_Last_Name',
		'KONTAKT.T_Company_1',
		'KONTAKT.T_Company_2'
		);

// utility function to set field values from posted data
function setFieldData($record)
{
	// declare $keys as a global variable
	global $keys;
	// loop over each field value and append to array
	$result = array();
	foreach ($keys as $fieldname) {
		$value = null;
		// workaround PHP's insistence that spaces in
		// form variables be replaced by "_"
		if (!strpos($fieldname, " ")) {
			$value = $_POST[$fieldname];
		} else {
			$value = $_POST[str_replace(" ", "_", $fieldname)];
		}
		if (strlen($value) > 0) {
			$record->setField($fieldname, $value);
		} elseif (strlen($record->getField($fieldname)) > 0) {
			$record->setField($fieldname, null);
		}
	}
	return $result;
}
// declare $rec
$rec = null;

// check to see that user didn't hit 'cancel' button
if (!array_key_exists('cancel', $_POST)) {
	// Check for recid parameter which determines if this is a create new or edit
	if (array_key_exists('recid', $_POST)) {
		$rec = $fm->getRecordById('LKontakte', $_POST['recid']);
	} else {
		$rec =& $fm->createRecord('LKontakte', $values);
	}
	if (FileMaker::isError($result)) {
	    echo 'Record addition failed: (' . $result->getCode() . ') ' . $result->getMessage() . "\n";
	    exit;
	}
	// set field data from form data
	setFieldData($rec);
	// commit record to database
	$result = $rec->commit();
	
	if (FileMaker::isError($result)) {
	    echo 'Record addition failed: (' . $result->getCode() . ') ' . $result->getMessage() . "\n";
	    exit;
	}
}

// set Location: HTTP header to force redirect
header("Location: displayRecords.php");

// End output buffering and flush output
ob_end_flush();
?>