/********************************
*
* Question Maker View javascript
*
* created by Hommymoco.com
********************************/
$(function(){
	//
	var clicked = null;
	
	var fncBt = function(){
		clicked = this;
		if( this.children[0].tagName.toLowerCase() == 'a' ){
			window.location = this.children[0].href;
		}
		return $('form#qm-section').submit();
	};
	
	//
	$('form#qm-section').submit( function(){
		obj		=  ( clicked ) ?  $( clicked ).find('input[type=submit]') :$( this ).find('input[type=submit]');
		hdn = $('<input type="hidden" name="qm-hd-bt" />');
		if( obj.val() == 'next' || obj.val() == 'prev' ){
			// js用ボタン情報生成
			hdn.val(obj.val());
			$(clicked).append( hdn );
			return true;
		}
		
		if( obj.val() == 'finish' ){
			hdn.val(obj.val());
			this.action = 'answer.php';
			return true;
		}
		return false;
	});
	// set button event
	$('div.qm-page').css({'cursor':'pointer'}).bind( 'click', fncBt );
	//
	$('.qm-bt-continue').css({	'visibility':'hidden'});
	
});