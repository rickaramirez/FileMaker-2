<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ronny
 * Date: 05.02.13
 * Time: 16:00
 * To change this template use File | Settings | File Templates.
 */
require_once('FileMaker.php');

$fm = new FileMaker('FMServer_Sample', 'http://localhost');
$fm = new FileMaker('FMServer_Sample');

$fm->setDatabaseLayout('Projects');
$fm->setCommand("findall");
$fm->doQuery();

if ($fm->getErrorNumber() !=0 ) {

    echo "EN:Test english / DE: folgender Fehler: ";
    echo $fm->getErrorDescription();
    die();

}

while ($fm->getNextRecord() ) {
    echo $fm->getField("Content");
    echo "<hr>";



}

?>