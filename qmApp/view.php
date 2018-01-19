<?php
/********************************
*
* 表示プログラム
*
* created by Hommymoco.com
********************************/
require_once(dirname(__FILE__).'/qm.class.php');
header("Content-Type: text/html; charset=utf-8");

$qmv = new qmView();

if( ! $qmv->isWorking() ||  $qmv->getRequest(EID) && $qmv->getRequest(CID) ){
	
	// 初ページのみシャッフルする
	$qmv->makeQuestionsMatrix();
}
//$qmv->createTag();


//　タイトル表示用
function qmTitle(){
	global $qmv;
	echo $qmv->data['pageTitle'];
}

//　設問数表示用
function qmNoQ($format = '<start>～<end>/<all>問'){
	global $qmv;
	echo $qmv->getNoQ( $format );
}

//　設問の説明文表示用
function qmAbstract(){
	global $qmv;
	echo stripslashes( $qmv->data['qComment'] );
}
 
 
//　試験本表示用
function qmExam( $tpl = './exam.tpl'){
	global $qmv;
	echo $qmv->createExamPage( $tpl );
}

//　試験本表示用
function qmAnswer( $tpl = './exam.tpl'){
	global $qmv;
	echo $qmv->createAnswerPage( $tpl );
}

//　ページ処理表示用
function qmPagenation(){ 
	global $qmv;
	echo  $qmv->pagenate( ) ;
}

//　正答値などのエリア表示
function qmAnsPointArea($format=''){
	global $qmv;
	echo  $qmv->ansPointArea( $format ) ;
}

//　結果エリアか？
function qmIsAnswer(){
	global $qmv;
	return $qmv->isAnswer( ) ;
}

//　答え合わせモードか？
function qmIsAnswerMode(){
	global $qmv;
	return $qmv->isAnswerMode( ) ;
}

//　リトライ用パラメータセット
function qmRetryPrm(){
	global $qmv;
	echo '?' . CID . '=' . $qmv->getCid() . '&' .EID . '=' . $qmv->getEid();
}

##### NO END
