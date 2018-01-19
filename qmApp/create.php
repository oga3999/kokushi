<?php
/***

	設問ページ生成プログラム
	
	php5.2 or later version is necessary for this program.
	powerd by hommymoco.com
***/

//=================
//　定義ファイル
//=================
require_once('qm.class.php');
$qmc = new qmCreate();

$qmc->makeData();

$nextUrl = PRGURL."index.php?".EID."=" . $_POST['examID'] . "&" . CID . "=" . $_POST['catID'];

//header("Content-Type: text/html; charset=utf-8");
//print_r( $nextUrl );
//exit;

header("location: $nextUrl");
###### NO END
