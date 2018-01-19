jQuery(function(){

//マウスオーバー（ファイルの末尾に「_off」「_on」で切り替え）
$("img.over,input.over")
.each( function(){
	$("<img>,<input>").attr("src",$(this).attr("src").replace(/^(.+)_off(\.[a-z]+)$/, "$1_on$2"));
})
.mouseover( function(){
	$(this).attr("src",$(this).attr("src").replace(/^(.+)_off(\.[a-z]+)$/, "$1_on$2"));
})
.mouseout( function(){
	$(this).attr("src",$(this).attr("src").replace(/^(.+)_on(\.[a-z]+)$/, "$1_off$2"));
});

//検索ボックス内のテキスト
$(".search").val("検索ワードを入力");
$(".search").focus( function(){
	var searchWord=$(this);
		if(searchWord.val()=='検索ワードを入力'){
		$(this).val(""),
		$(this).addClass("onfocus");
	};
});
$(".search").blur( function(){
	var searchWord=$(this);
		if(searchWord.val()==''){
		$(this).val("検索ワードを入力"),
		$(this).removeClass("onfocus");
	};
});

//テーブルのセルとリストに偶数・奇数を付与
$("li:odd,tr:odd").addClass("odd"),
$("li:even,tr:even").addClass("even");

//スムーズスクロール
$("a[href^=#]").click(function(){
	var Hash = $(this.hash);
	var HashOffset = $(Hash).offset().top;
	$("html,body").animate({
		scrollTop: $($(this).attr("href")).offset().top }, 'slow','swing');
	return false;
});

//グローバルメニューのプルダウン設定
$("#menu li").hover(function() {
	$("> ul:not(:animated)", this).fadeIn("normal");
}, function() {
	$("> ul", this).fadeOut("normal");
});


//グローバルメニュー用のIE「z-index」バグ対策
var zNum = 1000;
$('#global-nav li').each(function() {
	$(this).css('zIndex', zNum);
	zNum = zNum-10;
});

//モバイル用のグローバルメニュー設定
$(".btn-gnav").click(function(){
	$(".menu-wrap").toggleClass("showMenu");
});

//モバイル用のサイドバーとサブコンテンツの設定
$(".sub-contents-btn").click(function(){
	$(".sub-column #sub-contents-in").toggleClass("showSubConts");
});

$(".sidebar-btn").click(function(){
	$(".sub-column #sidebar-in").toggleClass("showSidebar");
});

//クリックでテキストを選択
$(".text-field")
	.focus(function(){
		$(this).select();
	})
	.click(function(){
		$(this).select();
		return false;
});


});


