<?php
/********************************
*
* Question Maker PHP main Class
*
* created by Hommymoco.com
********************************/
require_once('define.php');

class QuestonMaker {
	
	private $dat;

	private $fp;
	
	protected $savedir;
	
	protected $eid ;
	protected $cid ;
	
	protected $cd ;

	//===================
	// constractor
	//===================
	protected function __construct( $eid  = null ){
		//　セッション状況
		if (!session_id()) session_start();
		if (!isset($_SESSION['safety'])){
			session_regenerate_id(true);
			$_SESSION['safety'] = true;
		}
		$_SESSION['sessionid'] = session_id();

		$this->fp = null;
		
		$this->cid  = ($this->getRequest(CID) == false ) ?$this->getSession(CID) : $_REQUEST[CID] ;
		$this->eid  = ($this->getRequest(EID) == false ) ?$this->getSession(EID) : $_REQUEST[EID] ;
		$this->savedir = SAVEFULLDIR ;

	}
	
	protected function getRequest( $key , $defaultReturnValue = false ){
		return (isset( $_REQUEST[$key]) && $_REQUEST[$key] ) ? $_REQUEST[ $key]  : $defaultReturnValue ;
	}
	protected function getSession( $key , $defaultReturnValue = false ){
		return (isset( $_SESSION[$key]) && $_SESSION[$key] ) ? $_SESSION[ $key]  :  $defaultReturnValue ;
	}

	//===================
	//  about file functions
	//===================
	protected function fo( $fname , $exr = "r" ){return $this->fp = fopen(  $fname , $exr ) ;}
	protected function fc(){ return fclose( $this->fp );  $this->fp = null ;}
	protected function fw( $str ){	return fwrite( $this->fp  , $str , strlen( $str )+1 ); }
	protected function fcsv(){	return fgetcsv( $this->fp , 0 , "\t" ,'"'); }

}


//============================
//
//  crate class
//
//============================
class qmCreate extends QuestonMaker{
	
	public function __construct(){
		// connect database
		parent::__construct() ;

	}
  
	public function makeData(){
	
		$savedir = $this->savedir;
		
		// dose exists save directory?
		if( !is_dir( $savedir ) )	mkdir( $savedir );
		// file open 
		$fn = $savedir . $_POST['catID'] . '_' . $_POST['examID']  . ".dat";
		if( ! ($this->fo( $fn ,'w' ) ) ) exit("file open ERROR [ $fn ] ");
		
		foreach( $_POST as $key => $val ){
			if( $key == 'output' ) continue;
			if (get_magic_quotes_gpc()) {
				$d = '"'.$key ."\"\t\"".  $val  . "\"\n";
			}else{
				$d = '"'.$key ."\"\t\"". addslashes( $val ) . "\"\n";
			}
			$this->fw( $d );
		}
		
		$this->fc();
	}
}


//============================
//
//  view class
//
//============================
class qmView extends QuestonMaker{

	private $sessionKey;
	
	private $tplName;
	private $tplDatas;
	
	private $dir;
	private $od;
	
	private $sequence;
	
	public $data ;
	
	// 表示するページID
	private $pid ;
	
	private $ansKey ;
	
	private $finished;
	
	private $answers;
	//---------------------------------
	//	コンストラクタ（初期化）
	//---------------------------------
	public function __construct(){
		
		parent::__construct();


		// 選択肢キー定義
		$this->ansKey = 'qbra_';
		// submit button key name 定義
		$key = 'bt-submit';
		$retbt = $this->getRequest($key);
		$retbt = $retbt ? $retbt : array( $this->getRequest('qm-hd-bt' , false)) ;
		
		// ページ処理キー定義
		$pgkey = array('next'=>1, 'prev'=>-1);


		//　解答ページであるか
		$this->finished = ( strpos( basename( $_SERVER['REQUEST_URI'] ), 'answer.php' ) === 0 ? true : false );

		//　ページオフセット取得
		$pgofs =  $retbt && isset( $pgkey[$retbt[0] ]) 	? 	 $pgkey[$retbt[0] ]	: 	0;
		//　ページ設定
		$this->pid = $this->getRequest(PG ,1) ;
		$this->pid  += $pgofs;

		//　カテゴリ情報と試験IDを保存
		$_SESSION[CID] = $this->cid;
		$_SESSION[EID] = $this->eid;

		//　設問順番をセッションから取得
		$this->sequence =  isset( $_SESSION['q_seq'] ) ? $_SESSION['q_seq'] : null;

		//　試験情報ファイルをdataに保管
		$this->getData();
		
		//　解答情報取得しセッションに入力
		$this->setAns2Ses();
		
		//　試験終了時答え合わせ
		if( $this->finished )	 $this->calcCorrect();
	}
	
	
	//---------------------------------
	//	カテゴリID取得
	//---------------------------------
	public function getCid(){
		return $this->cid;	
	}

	
	//---------------------------------
	//	試験ID取得
	//---------------------------------
	public function getEid(){
		return $this->eid;	
	}
	
	//---------------------------------
	//	試験中であるか
	//---------------------------------
	public function isWorking(){
		return ( isset( $_SESSION['work'] ) && $_SESSION['work']  == 'on'  ) ? true : false ;
	}

	//---------------------------------
	//　requiest取得
	//---------------------------------
	public function getRequest( $key  ,$defaultReturnValue = false ){
		return parent::getRequest( $key  ,$defaultReturnValue );
	}
	
	//---------------------------------
	//　sessoion取得
	//---------------------------------
	public function getSession( $key ,$defaultReturnValue = false ){
		return parent::getSession( $key  ,$defaultReturnValue);
	}


	//---------------------------------
	//　解答情報取得しセッションに入力
	//---------------------------------
	private function setAns2Ses(){
		foreach( $_REQUEST as $key => $val ){
			if( strpos( $key ,$this->ansKey ) === 0 ){
				$_SESSION[ $key ] = $val ;
			}
		}
	}

	
	//---------------------------------
	//　セッションから全解答情報を取得
	// out::array[ branch no => ans no , ... ]
	//---------------------------------
	private function getAnsFromSesAll(){
		
		$ans = array();
		foreach( $_SESSION as $key => $val ){
			if( preg_match( "/".preg_quote($this->ansKey) ."(\d+)/" , $key , $out ) ){
				$ans[ $out[1] ] = $val;
			}
		}
		return $ans ;
	}

	//---------------------------------
	//　セッションから解答情報を取得
	//---------------------------------
	private function getAnsFromSes( $qno ){
		
		foreach( $_SESSION as $key => $val ){
			if( strpos( $key ,$this->ansKey ) === 0 ){
				$a = explode( '_' , $key );
				if( $qno == $a[1] ) return $val;
			}
		}
		return false;
	}

	//---------------------------------
	//　解答セッションクリア
	//---------------------------------
	private function clearAnsInSes(){
		
		foreach( $_SESSION as $key => $val ){
			if( strpos( $key ,$this->ansKey ) === 0 || strpos( $key ,'mul_' ) === 0 ){
				$_SESSION[$key] = null;
			}
		}
	}


	private function getRepDataMulti( $start , $end , $repkey = "/s" ){
		return "/". preg_quote( $start ,"/") . "(.*)".preg_quote( $end ,"/")  .$repkey ;
	}
	
	//---------------------------------
	//	テンプレート情報初期化
	//---------------------------------
	private function initTemplatesParams( $tpl ){

		// テンプレートを取得
		$tpl = implode( '' , file( $tpl ) );
		
		foreach( array(
			'question' =>array('<!-- START_QUESTION.TPL -->','<!-- END_QUESTION.TPL -->'),
			'answer'	 =>array('<!-- START_ANSWER.TPL -->','<!-- END_ANSWER.TPL -->'),
			'pgprev'	 =>array('<!-- START_PAGE_PREV.TPL -->','<!-- END_PAGE_PREV.TPL -->'),
			'pgnext'	 =>array('<!-- START_PAGE_NEXT.TPL -->','<!-- END_PAGE_NEXT.TPL -->'),
			'pgnone'	 =>array('<!-- START_PAGE_NONE.TPL -->','<!-- END_PAGE_NONE.TPL -->'),
			'pgfinish'	 =>array('<!-- START_PAGE_FINISH.TPL -->','<!-- END_PAGE_FINISH.TPL -->'))
		 as $key => $patt ){
			 // 囲まれた中身を抽出
			preg_match( $this->getRepDataMulti( $patt[0] , $patt[1] ) , $tpl , $out );
			
			//　抽出した情報を格納
			$this->tplDatas[$key] = $out[1] ; 
		}
	}


	//---------------------------------
	//	テンプレートリプレースを取得
	//---------------------------------
	private function getTemplateReplaceData(){
		return array(
			 'question' => array('<%QUESTONNUM%>','<%QUESTION%>',array( '<%BRANCHLINE%>','</%BRANCHLINE%>') ,'<%BRANCH%>') ,
			 'answer' => array('<%QUESTONNUM%>','<%QUESTION%>',array( '<%BRANCHLINE%>','</%BRANCHLINE%>') ,'<%BRANCH%>','<%EXPOSITION%>',
			 						array('<%YOURANSWERAREA%>','<%/YOURANSWERAREA%>'),'<%YOURANSWER%>',
									'<%ANSCORRCLASS%>','<%ANSCORR%>')  ,
									
		);
	}

	//---------------------------------
	//	テンプレート情報を取得
	//---------------------------------
	private function getTemplate( $tpl , $teplateKey ='question' ){
		
		//　テンプレートリプレース情報を取得
		$replaceData = $this->getTemplateReplaceData();
		
		//　カテゴリを抽出
		$tplReps = $replaceData[ $teplateKey ];
	
		//	 テンプレート情報を取得し初期化::tplDatasに格納
		$this->initTemplatesParams( $tpl );
	
		return $tplReps;
	}


	//---------------------------------
	//	テンプレート情報を取得
	//---------------------------------
	private function getPartOfTpl( $id , $teplateKey ='question' ){
		//　テンプレートリプレース情報を取得
		$replaceData = $this->getTemplateReplaceData();
		
		$tpl = $replaceData[ $teplateKey ];

		// テンプレート変換
		if( is_array( $tpl[$id] ) ){
			//　リプレースが囲いのとき
			preg_match(
				$this->getRepDataMulti($tpl[$id] [0] ,$tpl[$id] [1] ) ,
				$this->tplDatas[$teplateKey ]  ,
				$out
			);
		}
		return trim( $out[1] ) ;
	}
	
	//---------------------------------
	//	選択肢用テンプレートハンドル
	// $tplkey = 'question' : 設問 , 'answer' : 回答解説
	//---------------------------------
	private function getBranchLine($tplkey ='question' ){
		return $this->getPartOfTpl( 2 , $tplkey );
	}

	//---------------------------------
	//	セッション破棄
	//---------------------------------
	public function sessionClear(){
		$_SESSION = array();
		if (ini_get("session.use_cookies")) {
			$params = session_get_cookie_params();
			setcookie(session_name(), '', time() - 3600,
				$params["path"], $params["domain"],
				$params["secure"], $params["httponly"]
			);
		}
		session_destroy();
	}


	//---------------------------------
	//	試験ID取得
	//---------------------------------
	public function getid(){
		return $this->eid;
	}


	//---------------------------------
	//	試験カテゴリとIDから試験情報ファイル取得
	//---------------------------------
	protected function findFileByID(){
		
		$fns = $this->savedir . "*.dat" ;

		foreach( glob( $fns )  as $fn ){
			$res = preg_match("/(.+)\_(\d+)\.dat/" ,  basename( $fn ) , $out)  ;

			if( $res ){
				if( $out[1] == $this->cid && $out[2] == $this->eid ) return $fn;
			}

		}
		return false;
	}


	//---------------------------------
	//	試験情報ファイルをdataに保管
	//---------------------------------
	private function getData(){
		//	試験カテゴリとIDから試験情報ファイル取得
		$fn = $this->findFileByID();
		
		if( !$fn )exit("試験ファイルが取得できません。");
		if( ! ( $this->fo( $fn ) ) )exit("file load error.[$fn]");
		
		// 展開しつつバッファに格納
		$this->data = array();
		while( $out = $this->fcsv( ) ){
			$this->data[ $out[0] ] = $out[1] ;
		}
		$this->fc();
		
	}
	
	
	//---------------------------------
	//	シャッフル用サブルーチン
	//---------------------------------
	private function randSub( $i , $buf ,$min,$max ){
		$n = mt_rand( $min , $max ) ;
		if( ! isset( $buf[ $n ] )){
			$buf[ $n ] = $i;
			return $buf;
		}
		for( $l = $max; $l > 0 ; $l-- ){
			if( !	isset( $buf[$l] )){
				$buf[$l] = $i;
				return $buf;
			}
		}
		return $buf;
	}
	
	
	//---------------------------------
	//	　設問の並びを生成
	//---------------------------------
	public function createSequence(  $max , $rand = 1){
		$buf = array();
		$min = 1;
		for( $i = $min ; $i <= $max ; $i++ ){
			if($rand)	$buf = $this->randSub( $i, $buf ,$min,$max );
			else			$buf[$i] = $i;
		}
		return $buf;
	}
	
	//---------------------------------
	//	　選択肢の並びを生成
	//---------------------------------
	public function makeBranch(){
		return $this->createSequence( $this->data['noBranch'] );
	}
	

	//---------------------------------
	//	設問情報をdataから取得
	//---------------------------------
	private function getQuestions(){
		return preg_split( "/\s*\n\s*\n\s*/" ,  stripslashes( $this->data['questions'] ) );
	}


	//---------------------------------
	// dataから取得した設問群を１設問に分離
	//---------------------------------
	private function devideAQuestion(){
		$buff = array();
		foreach( $this->getQuestions()  as $key => $val ){
			$buff[ $key + 1 ] = $val ;
		}
		return $buff;
	}

	
	//---------------------------------
	//　設問情報を構築
	//---------------------------------
	public function makeQuestionsMatrix(){
		$_SESSION[CID] = $this->cid;
		$_SESSION[EID] = $this->eid;

		// ファイルから設問を読み問ごとに分離
		$allQ = $this->devideAQuestion() ;
		
		// 設問の順番を生成
		$seq = $this->createSequence( $this->data['hnoq'] ,$this->data['isRandom']  ); 
		
		//	全問中N問出題時
		if( $this->data['hnoq'] != $this->data['noq'] ){
			$seq = array_slice(	$seq , 0, $this->data['noq'] ,true );
		}
		//　割り振り
		foreach( $seq  as $qid => $no ){
			$seq[ $qid ]  = $this->makeBranch();
		}
		$this->sequence = $seq ;
		// 　構築後セッションに書き込み保持
		$_SESSION['q_seq'] = $seq;
		//　試験開始フラグ
		$_SESSION['work'] = 'on' ;
		
		//　解答バッファクリア
		$this->clearAnsInSes();
		
	}
	
	//---------------------------------
	//　複数回答設問の回答数を得る(単数のときは1)
	//---------------------------------
	private function getMultiAnswer( $str ){
		
		// 文字列最後の<N>を探しだす。なければ帰す
		if( !( $res = preg_match_all( "/\<(\d+)\>/s" ,  $str , $out)  )) return array(1 , $str) ;
		
		// 抽出後、<N>を文字列から削除する
		$quote = preg_quote( $out[0][$res -1] ,"/");
		$str = preg_replace( "/".$quote."/" , '' , $str );
		
		return array( $out[1][$res -1] , $str );
	}
	
	//---------------------------------
	//　複数回答であるか：必要回答数
	//---------------------------------
	private function isMultiAnswer( $qno ){
		return $this->getSession('mul_' . $qno , 1);
	}

	
	//---------------------------------
	//　回答・解説モードか？
	//---------------------------------
	public function isAnswerMode(){
		return $this->getRequest( CID ) && $this->getRequest( EID )? false: true ;
	}
	
	
	//---------------------------------
	//
	//　設問ページを生成
	//
	//---------------------------------
	public function createExamPage( $tpl ='./exam.tpl' ){

		//　単位ページに表示する設問数 Question Par Page
		$qpp = $this->data['parPage'];
		//　ページオフセット
		$ofs = $qpp * ( $this->pid - 1 ) ;

		//	 テンプレート情報を取得
		$tplReps = $this->getTemplate( $tpl, 'question' );
		$tplQuestions = $this->getBranchLine( 'question' );

		
		//　設問データ取得
		$qdat = $this->getQuestions();

		//　複数回答用バッファ
		$nAns = array();
		
		//　ページ単位に分割
		$qParPage = array_slice( $this->sequence , $ofs , $qpp ,true);

		$pno = $ofs ;

		//　出力用バッファ初期化
		$buff  =  '';
		
		//　設問ループ
		foreach( $qParPage as $qid => $bra ){
			$pno++ ;

			//　単位設問テンプレートをワーク用にコピー
			$tplTmp = $this->tplDatas['question'];
		
			// 行を分解
			$qval =  explode("\n", trim( $qdat[ $qid -1] ));
			//  1行目は質問なので複数回答のチェックを行う
			list( $nAns[$qid]  , $strQuestion)= $this->getMultiAnswer( $qval[0]);
			//　複数回答時はセッションに記録
			if( $nAns[$qid] > 1 ) $_SESSION['mul_'.$qid] = $nAns[$qid];
			
			//　問番号リプレイス
			$quote = preg_quote( $tplReps[0],"/" );
			$tplTmp  = preg_replace( "/". $quote."/s", $pno , $tplTmp  );

			//　設問リプレイス
			$quote = preg_quote( $tplReps[1],"/" );
			$tplTmp = preg_replace( "/". $quote."/s", $strQuestion , $tplTmp);

			//　戻り時、解答していた答えを取得
			$a = $this->getAnsFromSes( $pno );
			//　戻り用、checkedバッファ初期化
			$chk = array_fill(1 , count( $bra ) ,'' );

			if( $a )	foreach( $a as $v )	$chk[ $v ]  = 'checked=checked' ;
			
			//　設問バッファ初期化
			$bufBra = '';

			//　選択肢ループ
			foreach( $bra as $bid => $tmp ){
				//　単位選択肢テンプレートをワーク用にコピー
				$tplBraTmp = $tplQuestions;

				//　単複数解答欄設定
				$tag = "<input type=\"<TYPE>\" name=\"". $this->ansKey . $pno . "[]\" value=\"" .  $tmp . "\" ". $chk[$tmp] ."/>" ;
				$strBra =  str_replace( "<TYPE>" ,   $nAns[$qid] > 1  ?  'checkbox' : 'radio'  , $tag ) . $qval[$bid] ;

				//　置換
				$bufBra  .= str_replace( $tplReps[3]  , $strBra,	$tplBraTmp );
				
			}

			//　設問単位の置換
			$bufBra = str_replace( array('\\','$'), array('\\\\' , '\$') , $bufBra ); //半角\$はエスケープしないとpreg/sでは消えてしまう
			$tplTmp = preg_replace( $this->getRepDataMulti($tplReps[2][0] ,$tplReps[2][1] ) , $bufBra , $tplTmp  );
			
			//　単位設問の終了：バッファに溜め込み終了
			$buff .= $tplTmp ;
		}
		return $buff;
	}

	//---------------------------------
	//
	//　解答ページを生成
	//
	//---------------------------------
	public function createAnswerPage($tpl ='./exam.tpl' ){

		//　解説のみか？
		$isOnlyAnsMode = $this->isAnswerMode();

		//	 テンプレート情報を取得
		$tplReps = $this->getTemplate( $tpl, 'answer' );
		$tplAnswers = $this->getBranchLine( 'answer' );
		
		//　設問データ取得
		$qdat = $this->devideAQuestion();
		
		//　ページ単位に分割せず全部
		$qParPage = $this->sequence ;

		//　解説情報を適合化
		$desc = preg_split( "/\s*\n\s*\n\s*/" ,  stripslashes( $this->data['description'] ) );
		//　改行を<BR>
		$desc = str_replace("\n","<br />",$desc);

		//　出力用バッファ初期化
		$buff = '';

		//-------------------------------
		//　設問ループ
		//-------------------------------
		$qno = 0;
		foreach( $this->sequence as $qid => $bras ){
			$qno++;
			
			//　単位設問テンプレートをワーク用にコピー
			$tplTmp = $this->tplDatas['answer'];
			//　１設問取得
			$qmes = $qdat[ $qid ];
			
			//　選択肢を分離
			$bmes = explode("\n" , $qmes );
			
			//　複数解答処理：m[0]=複数回答数、m[1]=<N>を除去した設問文
			$m = $this->getMultiAnswer($bmes[ 0 ] );
			//　問番号,設問同時リプレイス
			$tplTmp  = preg_replace( 
				array( "/". preg_quote( $tplReps[0],"/" ) ."/s", "/". preg_quote( $tplReps[1],"/" ) ."/s" ) , 
				array( $qno , $m[1] ) ,
				$tplTmp 
			);
			
			//　解答情報取得
			$ans = $this->answers[ $qno ];

			//　選択肢用バッファクリア
			$bufBra = '';
		
			//-------------------------------
			//　選択肢ループ
			//-------------------------------
			foreach( $bras as $bid => $ib ){
				//　単位選択肢テンプレートをワーク用にコピー
				$tplBraTmp = $tplAnswers;

				$strBra =  $bmes[ $bid ];
				
				$correctBranch =  '<div class="qm-question-branch-incorrect">' ;
				$correctClass = 'qm-question-incorrect';
				$correctIndc= '×';
				if( $ans['trueAns'] == $ib || ( is_array($ans['trueAns'] ) && in_array( $ib , $ans['trueAns'])  )){
					
					$correctClass = 'qm-question-correct';
					$correctIndc= '○';
					$correctBranch =  '<div class="qm-question-branch-correct">' ;
				}
				$strBra =  $correctBranch . $strBra . '</div>';
				
				//　置換
				$bufBra  .= str_replace( 
					array( $tplReps[3]  , $tplReps[7] ,$tplReps[8 ] ) ,
					array( $strBra, $correctClass , $correctIndc ),
					$tplBraTmp 
				);
			
			}
			//　設問単位の置換
			$bufBra = str_replace( array('\\','$'), array('\\\\' , '\$') , $bufBra ); //半角\$はエスケープしないとpreg/sでは消えてしまう
			$tplTmp = preg_replace( $this->getRepDataMulti($tplReps[2][0] ,$tplReps[2][1] ) , $bufBra , $tplTmp  );

			
			//-------------------------------
			//　回答部置換
			//-------------------------------
			$yourAns = '';
			if( $isOnlyAnsMode ){
				//　解説のみでなく、回答も表示

				//　回答状況インディケータ
				$indc = array('正解','不正解','未選択','多選択','少選択');
				$clsColor = array( 'qm-indc-correct','qm-indc-incorrect','qm-indc-non-chosen','qm-indc-over-choise','qm-indc-below-choise' );

				//　回答部置換テンプレート取得
				$pat = $this->getPartOfTpl( 5 , 'answer' );
				$mulVal = '';
				$ansmes = '' ;
				if( $ans['val'] ){
					foreach( $ans['val'] as $bid ){
						$bnt = array_flip( $bras );
						$ansmes  .= $bmes[ $bnt[ $bid ] ].'<br />';
					}
					//　複数回答のときのオプション表示
					$mulVal = ( count( $ans['val'] ) > 1 ) ? '<br />': '';
				}
				
				//　回答の内容をテンプレートに充てる
				$strAns = '<span class="'.$clsColor[ $ans['mesid']].'">【'. $indc[ $ans['mesid']] . '】</span>' . $mulVal;
				$ansmes = str_replace( array('\\','$'), array('\\\\' , '\$') , $ansmes ); //半角\$はエスケープしないとpreg/sでは消えてしまう
				$yourAns = str_replace( $tplReps[6] , $strAns. $ansmes , $pat );
				
			}
			$tplTmp = preg_replace( $this->getRepDataMulti($tplReps[5][0] ,$tplReps[5][1] ) , $yourAns , $tplTmp  );
			
			//-------------------------------
			//　解説部置換
			//-------------------------------
			$tplTmp = str_replace( $tplReps[4]  , $desc[ $qid -1] ,	$tplTmp );
			
			$buff .= $tplTmp ;
			
		}
		return $buff;
	}
	
	
	//---------------------------------
	// ページ処理計算
	//---------------------------------
	private function calcPagenation(){
		
		//　ワークページID取得
		$pid = $this->pid ;
		//　全数取得
		$all = $this->data['noq'] ;
		//　オフセット取得
		$qofs = $this->data['parPage']  * ($pid -1)  +1;
		// 　前ページ数を割り出す（端数切り上げ）
		$maxpage = ceil( $all /  $this->data['parPage']  );

		return array( 'all'=>$all , 'qoffset'=>$qofs ,'maxpage'=>$maxpage ,'pid'=>$pid );
		
	}


	//========================
	//　viewエイリアス用本処理
	//========================

	//---------------------------------
	//　設問数取得
	//---------------------------------
	public function getNoQ( $format ){	

		$ans = $this->calcPagenation();

		if( ( $max = $ans['qoffset'] + $this->data['parPage'] -1 ) > $ans['all'] ) $max = $ans['all'];
		
		return str_replace( array("<%START%>","<%END%>","<%ALL%>"),array( $ans['qoffset'] ,  $max ,$ans['all'] ) , $format );
	}
	
	//---------------------------------
	//　ページ処理
	//---------------------------------
	public function pagenate(){
		$ans = $this->calcPagenation();
		$buf = '';
		if( $ans['pid'] > 1 )	$buf .=  $this->tplDatas['pgprev'] ;
		else								$buf .=  $this->tplDatas['pgnone'] ;
		if( $ans['pid'] < $ans['maxpage'] )	$buf .=  $this->tplDatas['pgnext'] ;
		else																$buf .=  $this->tplDatas['pgfinish'] ;
		
		$buf .= "\t".'<input type="hidden" name="'.PG.'" value='.$ans['pid'].'>' . "\n";
		return $buf;
	}

	
	//---------------------------------
	//　ページ番号取得
	//---------------------------------
	public function getPageID(){
		return $this->pid;
	}
	
	
	//---------------------------------
	//　解答エリアか？
	//---------------------------------
	public function isAnswer(){
		return $this->finished;
	}


	
	//---------------------------------
	//
	//　解答をチェック（実際の答え合わせ）
	//
	//---------------------------------
	private function calcCorrect(){
		// -----
		//　初期化
		// -----
		$totalP = 0;
		
		//　全回答をセッションから取得
		$ans = $this->getAnsFromSesAll();
		//　出力バッファ初期化
		$buf = array();
		//　設問の並びを取得
		$seq = $this->sequence;
		//　並びの実データを抽出
		$ids  = array_keys( $this->sequence );
	
		// -----
		//　全数と照合
		// -----
		for( $qno = 1 ; $qno <= $this->data['noq'] ; $qno++ ){
			
			// 設問ごとの初期化
			$imes = 0 ;  //正解ID
			$flg = true;	//正解フラグ
			
			//　設問順列群から単位設問の順列情報を取得
			$id = array_shift( $ids );
			//　設問群から単位設問を取得
			$s = array_shift( $seq );
			//　配列の中身を反転（キーと値を反転）
			$q = array_flip( $s ) ;
			
			// 設問ごとの回答情報
			$val = isset( $ans[ $qno ] ) ? $ans[ $qno ] :false ;
			
			// 複数回答か？
			$mul = $this->isMultiAnswer( $id )  ;
			if( $mul > 1 ){

				// 正解情報取得
				$tmp = $s;
				ksort( $tmp );
				$tmp = array_chunk( $tmp , $mul ,true);
				$trueAns = $tmp[0];

				// 複数回答時、既定の数を答えているか？
				if( is_array($val) && count( $val ) == $mul ) {

					$p1 = 1;
					// 回答数が同じとき、正解を答えているか？
					foreach( $val  as $a1 ){
						//　選択した番号が複数回答数より上の場合は不正解
						if(  $q[ $a1] > $mul) {
							$flg = false;
							$imes = 1;
							$p1 = 0;
							break;
						}
					}
					$buf[$qno]=array('corr'=>$flg, 'val'=>$val , 'mesid'=>$imes, 'trueAns' => $trueAns);
					$totalP += $p1;
					continue;
				}
				
				// 複数回答時、規定回答数数未満・超過
				// 未回答・多選択・少選択
				$flg = false;
				if( !$val || !count( $val ) )			$imes = 2;	// 未回答
				else if( count( $val ) > $mul )	$imes = 3;	// 多選択
				else													$imes = 4;	// 少選択
				$buf[$qno]=array('corr'=>$flg, 'val'=>$val , 'mesid'=>$imes, 'trueAns' => $trueAns);
				continue;
			}

			// -----
			// 単数解答
			// -----
			
			// 正解情報取得
			$tmp = $s;
			ksort( $tmp );
			$trueAns = array_shift( $tmp );
				
			// 完全未選択
			if( ! isset( $ans[ $qno ] ) ){
				$buf[$qno]=array('corr'=>false, 'val'=>false , 'mesid'=>2, 'trueAns' => $trueAns);
				continue;
			}
			
			// 	正解
			if( is_array( $val ) && count( $val ) == 1 && $q[$val[0]]  == 1){
				$buf[$qno]=array('corr'=>$flg, 'val'=>$val , 'mesid'=>$imes, 'trueAns' => $trueAns);
				$totalP += 1;
				continue;
			}
			
			//　不正解
			$flg = false;
			
			if( !$val || !count( $val ) )	$imes = 2;	// 未回答
			else 											$imes = 1;	// 不正解
			$buf[$qno]=array('corr'=>$flg, 'val'=>$val , 'mesid'=>$imes, 'trueAns' => $trueAns);

		}
		
		$buf['totalpoint'] = $totalP;
		$buf['percent'] = round( $totalP * 100 / $this->data['noq'] , 1) ;
		$buf['point'] = ceil( $totalP * 100 / $this->data['noq'] )  ;
		$this->answers = $buf;
		
	}
	
	//---------------------------------
	//　正答率などを表示
	//---------------------------------
	public function ansPointArea( $format = '' ){
		$rep_key = array( "<%NUM-ALLQUESTION%>","<%NUM-CORRECTANS%>","<%ANSPERCENT%>","<%ANSPOINT%>");
		$rep_val = array( $this->data['noq'] , 	$this->answers['totalpoint'] ,$this->answers['percent'] ,$this->answers['point'] );
		return str_replace( $rep_key, $rep_val , $format);
	}
	
}

##### NO END
