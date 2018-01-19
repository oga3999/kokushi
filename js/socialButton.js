jQuery(function(){

//ツイートボタンを設置
$(".sb-tweet").append('<a href="https://twitter.com/share" class="twitter-share-button" data-lang="ja">ツイート</a>');
!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];
if(!d.getElementById(id)){
js=d.createElement(s);
js.id=id;js.src="//platform.twitter.com/widgets.js";
fjs.parentNode.insertBefore(js,fjs);}}
(document,"script","twitter-wjs");

//はてなボタンを設置
$(".sb-hatebu").append('<a href="http://b.hatena.ne.jp/entry/" class="hatena-bookmark-button" data-hatena-bookmark-layout="standard" title="このエントリーをはてなブックマークに追加"><img src="http://b.st-hatena.com/images/entry-button/button-only.gif" alt="このエントリーをはてなブックマークに追加" width="20" height="20" style="border: none;" /></a><script type="text/javascript" src="http://b.st-hatena.com/js/bookmark_button.js" charset="utf-8" async="async"></script>');

//プラス1ボタンを設置
$(".sb-gplus").append('<div class="g-plusone" data-size="medium"></div>');
window.___gcfg = {lang: 'ja'};
(function() {
var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
po.src = 'https://apis.google.com/js/plusone.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
})();

//いいねボタンを設置
(function(d, s, id) {
var js, fjs = d.getElementsByTagName(s)[0];
if (d.getElementById(id)) return;
js = d.createElement(s); js.id = id;
js.async = true;
js.src = "//connect.facebook.net/ja_JP/all.js#xfbml=1&appId="; //appIdを追加
fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

$(".sb-fb-like").append('<div class="fb-like" data-send="false" data-layout="button_count" data-width="110" data-show-faces="false" data-colorscheme="light" data-action="like"></div>');
});
