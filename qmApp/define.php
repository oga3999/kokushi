<?php
//definition of Program title  "QuestionMaker for Rigakuryouhoushi"
define("PROGRAMTITLE" , "Question Maker for Rigakuryouhoushi");

//Rigakuryouhoushi version
//1.0.0
define("VERSION" , "1.0.0");


// コピーライト：右側の””でくくってある文字を変更してください
//e.g.	 define("COPYRIGHT" , "株式会社ＡＢＣＤＥＦ");
define("COPYRIGHT" , "rigakuryouhoushi.sakura.ne.jp");


// signature of  "Powerd by"
define( 'PB' , 'Powerd by hommymoco.com');

// define exam id name which is used as POST/GET query string.
define('EID','eid');
// define category id name which is used as POST/GET query string.
define('CID','cid');
// pagination id
define('PG','qmpg');


define('DEVDIR', '' ); //本番


//プログラムにアクセスするためのドメインを除いたURL
define('PRGURL',DEVDIR.'/qmApp/'); 

//プログラム格納ディレクトリ定義
//  /home/USERDIR/www ==  $_SERVER['DOCUMENT_ROOT']
define('PRGDIR', $_SERVER['DOCUMENT_ROOT'].PRGURL); 

//生成ファイル格納ディレクトリ
define('SAVEDIR','saveData/' );
//絶対パス
define('SAVEFULLDIR',PRGDIR.SAVEDIR);



### NO END