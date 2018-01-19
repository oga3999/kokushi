//============================================
//
//		設問生成ページスクリプト
//
// index.js of Question Maker For Rigakuryouhoushi
//
// Powerd by hommymoco.com
//============================================
// TAB=2
(function(){
	
	//
	//		初期値パラメータ
	//
	var defaults = {
		'question':{
			'input[name="catID"]'						: {'val':'category1'},		// 　保存ファイル名
			'input[name="examID"]'					: {'val':1 , act:{ 'change':'isNum' }},		// 　試験ID
			'input[name="parPage"]'				: {'val':5 , act:{ 'change':'isNum' }},		// 　単位ページ中の問数
			'select[name="noBranch"]' 			: {'val':4 ,act:{ 'change':'createQwindow' }} ,				//　選択肢の数
			'input[name="pageTitle"]'	 			: {'val':'1級　試験問題' ,act:{'blur':'createQwindow'}},		// 　ページのタイトル
			'input[name="qComment"]' 			: {'val':'<p>難しいかもしれませんが頑張りましょう</p><p>難易度:<span class="qm-mark">&spades;</span></p>',act:{'blur':'createQwindow'}} ,	 //　最初の問い
			'textarea[name="questions"]' 		: {'val':'' ,act:'cbQuestions' },								//　設問
			'select[name="isRandom"]'			: {'val':1 ,act:{'change':'createQwindow'}},	//　出題方法
			'input[name="noq"]' 							: {'val':0 ,act:{'blur':'createQwindow'}} ,			//　出題数
			'input[name="hnoq"].question'	: 0  ,					//	 総出題数格納用
			'span.noq' 												: '/ 0 問中' ,	//	 総出題数
			'select[name="refreshMode"]'		: {'val':0 },

			'select[name="qOrientation"]'		: {'val':0 , 'act':{'change':'createQwindow'}},
			'select[name="tofButton"]'			: {'val':0 , 'act':{'change':'createQwindow'}},
		},
		
		// 解説
		'description':{
			'select[name="sw"].description'								: 1,
			'textarea[name="description"]'								:{'val':''} ,
		}
		,
		init : function( that , cat ){
			var o = that || this;
			for( var elm in o ){
				var dat = o[ elm ];
			
				if( elm == 'question' || elm == 'description' || elm == 'result' ) {
					arguments.callee( this[elm]  , elm );
					continue;
				}
				if( elm.indexOf('Parm') !== -1) {
					$( elm ).css( dat );
					continue;
				}
				// dose exist class name in 'elm'?
				if( ( n = elm.indexOf('.') ) !== -1 ){
					var a = elm.split('.');
					var d = v = null;
					if( a[0] == 'span' || a[0].indexOf( 'hidden' ) === 0 ){
						updateNoq(-1);
					}else{
						d = elm.split('"')[1];
						v = { 'select':'change' , 'input':'blur' }[elm.split('[')[0]];
						$( elm ).val(dat);
						if(  d == 'fontSize' || d == 'color' || d == 'backgroundColor' ){
							$( '.' + cat +'-params-' + a[1] ).css( d , dat );
						}
						$( elm ).bind( v, eval( 'createQwindow') );
					}
					continue;
				}
				// functionか？
				if( typeof( dat ) == 'function' )continue;
				// datがオブジェクトのとき、有効なvalを持っているか？
				if( typeof( dat ) == 'object' ){
					if( typeof( dat['val'] ) !== 'undefined' && typeof( dat['act'] ) !== 'undefined' ){
						if( elm == 'textarea[name="questions"]'  ){
							// 設問のときダミーを入れる
							dummyData.make( elm );
						} else {
							// その他
							$( elm ).val( dat['val']);
						}
						
						// 設定した後一度すべてのイベントを解放
						$( elm ).unbind();
						
						// bindしなおす
						if( typeof( dat['act'] ) === 'string' ) $( elm ).bind( eval( dat['act'] ));
						else for( var key in dat['act'] ){
								$( elm ).bind( key , eval( dat['act'][key] ) );
						}
						continue;
					}
				}
				$( elm ).val( typeof( dat['val'] ) !== 'undefined'  ?  dat['val']  : dat );
			}
		}
		,
		isNecessaryEnDecode : function( key ){
			return ( key == 'textarea[name="questions"]' || key ==  'textarea[name="description"]');
		}
		,
		load:function(that ){
			var d = storage.load();
			 if( !d ) return false;
			 d = d.slice( 'data={'.length , -1 ).split(',');
			
			 for( var i in d ){
				 d1 = d[i].slice(1,-1).split("':'");

				 $( d1[0] ).val( d1[1] );
				 // 特殊処理
				 if( d1[0] == 'input[name="hnoq"].question' ) updateNoq(d1[1] -1);
				 if( defaults.isNecessaryEnDecode(d1[0] )) $( d1[0] ).val( decodeURIComponent( d1[1] ) );
			 }
			return true;
		}
		,
		// 出力バッファにセットしつつエレメントを更新
		set : function( buf , that , cat  ){
			var o = that || this;
			for( var elm in o ){
				var dat = o[ elm ];
				//
				if( elm.indexOf('Parm') !== -1 || typeof( dat ) == 'function' ) continue;
				
				if( elm == 'question' || elm == 'description' || elm == 'result' ) {
					arguments.callee( buf ,this[elm]  , elm );
					continue;
				}
				// set buffer
				var v = $( elm ).val();
				if( defaults.isNecessaryEnDecode(elm) ){
					v = encodeURIComponent( v);
				} 
				else 
				if( elm.toLowerCase().indexOf( 'color' ) > -1 && typeof( v )  !== 'undefined'){
					if( ( a = v.match( /^[0-9a-fA-F]{6}$/ ) )!== null)v = '#' + a[0];
				}
				buf[ elm ] = v;
			}
		}
	};
	
	
	//============================
	// 設問数ワークメモリー
	//============================
	var iNoq = null;

	
	//============================
	// 初期化用CSSパラメータ
	//============================
	var cssPrm4init = [ 'background-color' , 'color' ,'width','font-size' ];


	//============================
	//　色や幅などの確認用ダミーデータ
	//============================
	var dummyData = {
		'question':'答えが4になる式は？<2>',
		'branches' : [
			'2+2=',
			'1x4=',
			'1+1=',
			'2x3=',
			'2+1=',
			'0-1=',
			'2-2='
		],
		make:function( elm ){
			var d = this.question + '\n';
			var e = parseInt( $('select[name="noBranch"]').val() );
			for( var i =0 ; (i < this.branches.length && i < e ); i++ ) d+= this.branches[i]+ '\n';
			$( elm ).val( d );
		}
		,
		'':''
	};


	//	出力用バッファ
	var outputBuff = {};


	//============================
	//
	//		SUB ROUTINES
	//
	//============================

	var storage = {
		clear:function(){
			localStorage.clear();
		},
		save:function(val){
			localStorage.data1=val	;
		},
		load:function(){
			return localStorage.data1;
		}
	};


	//=========================
	//	 アウトプットに書き込む
	//=========================
	var postOutPut = function( that ){
		var o = that || outputBuff ;
		var out = [];
		for( var elm in o ){
			var d= o[elm];
			out.push( '\'' + elm + '\':\'' + d +'\'' );
		}
		out = 'data={' + out.join(',') + '}';
		
		//　出力用タグにセット
		$('input[type="hidden"]#output').val( out );

		// localStorageに保存
		storage.save( out  );
	};
	
	

	//=========================
	//  入力数字チェック
	//=========================
	var isNum = function(){
		$val = $(this).val();
		if(  isNaN( $val ) )	alert('数値を入れてください');
	};

	//=========================
	//
	// 設問用見本エリア作成
	//
	//=========================
	var createQwindow = function(){
		var jqBuf = $( outputBuff );
		var qn = 1; // Question Number　見本は固定
		var noq = $('select[name="noBranch"]').val() ;
		var dat = '';

		
		//=========================
		// outputBuff にバッファー出力
		//=========================
		defaults.set( outputBuff );

	};


	//=========================
	//	設問数の設定
	//=========================
	var updateNoq = function( i ){
		var noq1 = parseInt( $('input[name="noq"]').val( ) );
		var hnoq1 = parseInt( $('input[name="hnoq"].question').val());
		
		//　出題数が数値であるかのチェック
		if( isNaN( noq1 )  ) {	alert( '出題数が数値ではありません' );return false;}
		// 　出題数が1以下のときの処理
		if( noq1 < 1 ) $('input[name="noq"]').val(1);
		
		i = parseInt( i ) + 1;
		$('span.noq').html( '/ ' + i +'問中' );
		$('input[name="hnoq"].question').val( i );
		
		//　もし全問中出題数が小さい場合は書き換えない。以外は同じにする
		if( noq1  >= hnoq1 )	$('input[name="noq"]').val(i);
		iNoq = i;
		return true;
	};



	//=========================
	//　設問数と解説数チェック
	//=========================
	var checkNumber = function( sw ,  data ){
		var err = '' ;
		var aBuf = $.trim(data).split('\n\n');
		var l = parseInt( $('select[name="noBranch"]').val() ) + 1;
		
		//入力チェック
		if( !aBuf[0] ) {
			err = ( ( sw == 'q' ) ? '設問' : '解説' ) + 'が入っていないか、不正なデータです';
		} else {
		
			// 設問ブロックの調査
			if( sw == 'q' )for( var i in aBuf ){
				// １設問単位が設問数と同じかをチェック
				var aLine = aBuf[i].split('\n');
				if( aLine.length > l ) err += ( parseInt( i ) +1 ) + '問目が多いです\n';
				if( aLine.length < l ) err += ( parseInt( i ) +1 ) + '問目が少ないです\n';
			}
			else
			// 解説ブロックの調査
			if( sw == 'd'  && aBuf.length !=  iNoq ) err +=  '解説の数が、問数とあっていません\n';
					
		}
		//	設定数のエラー
		if( err ) {
			alert( err );
			return false;
		}
		if( sw == 'q'){
			if( !updateNoq(i) ) return false;
		}
		return true;
	};
	




	//=========================
	//
	//　コールバック
	//
	//=========================
	var cbQuestions = {
		'blur': function(e){
			checkNumber( 'q',  e.target.value );
			return false;
		}
	};
	

	// 解説のコールバック
	var cbDscrpTxt = {
		'change' : function(e){
			 parseInt( e.target.value )  ? $('#description-textarea').show() : $('#description-textarea').hide()  ;
		}
	};
	

	//=========================
	//
	// 読み込み後のメインルーチン
	//
	//=========================
	var mainFx = function(){
		
		//=========================
		// 初期化
		//=========================

		$('.tb-load-item').hide();
		
		// パラメータ初期化
		defaults.init();
		defaults.load() ;

		// 設問例題を生成
		createQwindow();
		
		$('#extparam').val('');
		
		//=========================
		//
		//　　コールバック設定
		//
		//=========================
		var sizes = function(){
			return {
				'w' : ( $(window).width()  > $(document).width() ? $(window).width() : $(document).width()) + 'px' , 
				'h' : ( $(window).height()  > $(document).height() ? $(window).height() : $(document).height())+ 'px' 
			}
		};
		
		var waitScreen = function(){
			wh = sizes();
			var css = {'position':'absolute','top':'0px','left':'0px','width':wh.w,'height':wh.h,'background-color':'#222','z-index':10 ,'opacity' : 0.3 };
			$('#other-section').css(css).show(function(){$('#other-section').focus();});
			$( window ).resize(function(){
				wh = sizes();
				var css = {'width':wh.w,'height':wh.h};
				$('#other-section').css(css);
			});
		};
		
		//=========================
		// 確認ボタン押下 
		//=========================
		$('form#main-form').submit(function(){
			var err = false;

			//----------------------------
			//	 設問数と解説の数が正しいか？
			//----------------------------
			if(!( checkNumber( 'q' , $('textarea[name=questions]').val() ) 
			&&(
			   (   ( !parseInt( $('select[name="sw"]').val() ) )    ||  checkNumber( 'd' , $('textarea[name=description]').val() )  ) ) 
			)) return false;

			//=========================
			//　出力セット
			//=========================
			defaults.set( outputBuff );

			//----------------------------
			//　クッキーに保存
			//----------------------------
			postOutPut();
			
			if( err ){
				window.location.reload();
				return false;
			} 
			// ウェイト用スクリーン
			waitScreen();
			return true;
		});

		//=========================
		//　フォントサイズセレクタのイベント設定
		//=========================
		$('select[name="fontSize"]').change( createQwindow );
		
		//=========================
		// 初期化ボタン
		//=========================
		$('#init-button').click(function(){ 
			//デフォルト情報をセット
			defaults.init();
			// 設問例題を生成
			createQwindow();
			//出力用バリューを初期化
			$('#extparam').val('');
			// localStorageを初期化
			storage.clear();
			//念のためリロード
			location.reload();
		});
		
									  
		//=========================
		//　各消去ボタン設定
		//=========================
		$('.bt-clear').click(function(){
			//[name="FORMAT"]で指定した中身を空文字で埋める
			$( '*[name=' + this.id.substr( 'clear-'.length ) + ']' ).val('');
			if(this.id == 'clear-questions' ) updateNoq(-1);
		});


		//=========================
		//　ファイル出力用ページへジャンプ
		//=========================
		$('#fileout-button').click(function(){
			$('#extparam').val('fileout');
			$('form#main-form').submit();
		});
	} ;

	//=========================
	//=========================
	//
	//　　読み込み完了後処理(main)
	//
	//=========================
	//=========================
	$(document).ready( mainFx );

	// FireFox用ダミー定義
	window.onunload = function () {};
})( $ );
