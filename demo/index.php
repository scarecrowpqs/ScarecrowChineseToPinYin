<?php
namespace ScarecrowChineseToPY;
include '../src/ScarecrowChineseToPingYin.php';
include '../src/ScarecrowGetData.php';
$a = new ScarecrowChineseToPingYin();
var_dump($a->getPingYin('阿N123你'));