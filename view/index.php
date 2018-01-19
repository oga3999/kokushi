<?php
require_once(dirname(__FILE__).'/../qmApp/view.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" xml:lang="ja" lang="ja" xmlns:og="http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml" itemscope="itemscope" itemtype="http://schema.org/">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>過去問題 | 理学療法士国家試験・作業療法士　国家試験対策 WEBで合格！</title>

        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="keywords" content="理学療法士,国家試験,作業療法士,過去問題,国試" />
        <meta name="description" content="理学療法士（PT）・作業療法士（OT）の国家試験過去問を無料公開中。WEBで演習問題を解き、国試合格を勝ち取ろう！" />
        <meta http-equiv="Content-Style-Type" content="text/css" />
        <meta http-equiv="Content-Script-Type" content="text/javascript" />
        <meta name="GENERATOR" content="JustSystems Homepage Builder Version 16.0.10.0 for Windows" />
        <!--[if IE]><meta http-equiv="imagetoolbar" content="no" /><![endif]-->

        <link rel="stylesheet" href="../../css/common.css" type="text/css" media="all" />
        <link rel="stylesheet" href="../../css/layout.css" type="text/css" media="all" />
        <link rel="stylesheet" href="../../css/design.css" type="text/css" media="all" />
        <link rel="stylesheet" href="../../css/mobile.css" type="text/css" media="all" />
        <link rel="stylesheet" href="../../css/advanced.css" type="text/css" media="all" />
        <link rel="stylesheet" href="../../css/print.css" type="text/css" media="print" />

        <link rel="contents" href="../../sitemap/" title="サイトマップ" />
        <link rel="shortcut icon"  type="image/x-icon" href="../../favicon.ico" />
        <link rel="apple-touch-icon" href="../../images/home-icon.png" />

        <script type="text/javascript" src="../../js/jquery.js" charset="utf-8"></script>
        <script type="text/javascript" src="../../js/utility.js" charset="utf-8"></script>

        <link href="qm.css" rel="stylesheet" />
        <script src="jquery-1.7.1.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="qmView.js" type="text/javascript" charset="utf-8"></script>
    </head>
    <body id="page" class="col2r">
        <div id="fb-root"></div>
        <div id="container">


            <!--▼ヘッダー-->
            <div id="header">
                <div id="header-in">

                    <div id="header-title">
                        <p class="header-logo"><a href="../../">理学療法士国家試験・作業療法士国家試験対策 WEBで合格！</a></p>
                        <h1>理学療法士・作業療法士 国家試験問題</h1>
                    </div>


                </div>
            </div>
            <!--▲ヘッダー-->



            <!--▼グローバルナビ-->
            <div id="global-nav">
                <dl id="global-nav-in">
                    <dt class="btn-gnav">メニュー</dt>
                    <dd class="menu-wrap">

                        <ul id="menu">
                            <li class="first"><a href="../../">ホーム</a></li>
                            <li><a href="../">PT/OT共通問題</a></li>
                            <li><a href="../../customer/">PT専門問題</a></li>
                            <li><a href="../../about/">おすすめ参考書</a></li>
                            <li><a href="../../news/">メルマガ登録</a></li>
                            <li><a href="../../link/">リンク集</a></li>
                        </ul>

                    </dd>
                </dl>
            </div>
            <!--▲グローバルナビ-->


            <!--main-->
            <div id="main">
                <!--main-in-->
                <div id="main-in">


                    <!--▼パン屑ナビ-->
                    <div id="breadcrumbs">
                        <ol>
                            <li class="first" itemscope="itemscope" itemtype="http://data-vocabulary.org/Breadcrumb">
                                <a href="../../" itemprop="url"><span itemprop="title">理学療法士・作業療法士 国家試験対策 WEBで合格！</span> TOP</a>

                            </li>
                        </ol>
                    </div>
                    <!--▲パン屑ナビ-->


                    <!--▽メイン＆サブ-->
                    <div id="main-and-sub">

                        <!--▽メインコンテンツ-->
                        <div id="main-contents">

                            <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                            <!-- 国試サイト728×90 -->
                            <ins class="adsbygoogle"
                                 style="display:inline-block;width:728px;height:90px"
                                 data-ad-client="ca-pub-9635019046613020"
                                 data-ad-slot="4342145796"></ins>
                            <script>
                                (adsbygoogle = window.adsbygoogle || []).push({});
                            </script>

                            <?php
                            require_once(dirname(__FILE__).'/../qmApp/view.php');
                            ?>







                            <!--  ここから必要です-->
                            <form id="qm-section" method="post" action="index.php" >
                                <div id="qm-questions-area">

                                    <div id="qm-title-area">

                                        <h1 id="qm-title"><?php qmTitle(); ?></h1>

                                        <h1 id="qm-num-of-question" >
                                            <?php // qmNoQ("<%START%>～<%END%>/<%ALL%>問");   ?>
                                            <?php  qmNoQ("全<%ALL%>問中<%START%>問～<%END%>問");  ?>
                                        </h1>

                                        <div id="qm-exam-description" >
                                            <?php qmAbstract();  /*設問の説明文*/?>
                                        </div>

                                    </div>

                                    <ul class="qm-exam">
                                        <?php  qmExam( 'exam.tpl' );?>
                                    </ul>


                                    <div class="qm-pagination">
                                        <?php qmPagenation() ?>
                                    </div>

                                </div>
                            </form>

                            <div class="ninja_onebutton">
                                <script type="text/javascript">
                                    //<![CDATA[
                                    (function(d){
                                        if(typeof(window.NINJA_CO_JP_ONETAG_BUTTON_6ebdb9066b3f6145232e00242376e7d9)=='undefined'){
                                            document.write("<sc"+"ript type='text\/javascript' src='http:\/\/omt.shinobi.jp\/b\/6ebdb9066b3f6145232e00242376e7d9'><\/sc"+"ript>");
                                        }else{
                                            window.NINJA_CO_JP_ONETAG_BUTTON_6ebdb9066b3f6145232e00242376e7d9.ONETAGButton_Load();}
                                    })(document);
                                    //]]>
                                </script><span class="ninja_onebutton_hidden" style="display:none;"></span><span style="display:none;" class="ninja_onebutton_hidden"></span>
                            </div>


                            <br />
                            <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                            <!-- 国試サイトリンクユニット -->
                            <ins class="adsbygoogle"
                                 style="display:inline-block;width:468px;height:15px;margin:0 0 1em 0;"
                                 data-ad-client="ca-pub-9635019046613020"
                                 data-ad-slot="7435212992"></ins>
                            <script>
                                (adsbygoogle = window.adsbygoogle || []).push({});
                            </script>


                            <!--  ここまで-->

                            <br />
                            <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                            <!-- 国試サイト336 -->
                            <ins class="adsbygoogle"
                                 style="display:inline-block;width:336px;height:280px"
                                 data-ad-client="ca-pub-9635019046613020"
                                 data-ad-slot="8911946195"></ins>
                            <script>
                                (adsbygoogle = window.adsbygoogle || []).push({});
                            </script>
                            <br />
                            <!--ランキング-->
                            <div class="contents">

                                <!--conts-->
                                <h2>音声で学ぶシリーズ</h2>
                                <a href="https://www.dlmarket.jp/products/detail/476576" target="_blank"><img src="../../images/onsei.png" alt="onsei" width="503" height="208" /></a><br />
                                <p class="study-series">音声で学ぶシリーズ</p>
                                <ul class="onsei_serise">
                                    <li><a href="https://www.dlmarket.jp/products/detail/475371" target="_blank">音声で学ぶ国家試験　解剖学</a></li>
                                    <li><a href="https://www.dlmarket.jp/products/detail/475370" target="_blank">音声で学ぶ国家試験　生理学</a></li>
                                    <li><a href="https://www.dlmarket.jp/products/detail/475369" target="_blank">音声で学ぶ国家試験　運動学</a></li>
                                    <li><a href="https://www.dlmarket.jp/products/detail/476576" target="_blank">音声で学ぶ国家試験シリーズパック</a></li>
                                    <li>国家試験を耳で聞いて学ぶ！</li>
                                </ul> <!--/conts-->


                                <!--conts-->
                                <h2><a name="facebook" id="facebook">Facebookで国試好評配信中！</a></h2>
                                <a href="https://www.facebook.com/ptotkokushi" target="_blank"><img src="../../images/fb.png" alt="facebook" width="503" height="208" /></a><br />
                                <a class="study_facebook" href="https://www.facebook.com/ptotkokushi" target="_blank">理学療法士・作業療法士国家試験対策 WEBで合格！Facebook</a>
                                <ul>
                                    <li>Facebookのタイムラインに共通問題の中からランダムで一問、国試過去問を配信。翌日に解答も配信しています。LINEアプリをインストールしていればリンク先をワンクリックでOK!<br />
                                    </li>
                                </ul> <!--/conts-->
                                <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                                <!-- 国試サイト336×280 -->
                                <ins class="adsbygoogle"
                                     style="display:inline-block;width:336px;height:280px"
                                     data-ad-client="ca-pub-9635019046613020"
                                     data-ad-slot="8911946195"></ins>
                                <script>
                                    (adsbygoogle = window.adsbygoogle || []).push({});
                                </script>
                            </div>

                            <!--/ランキング-->






                        </div>
                        <!--△メインコンテンツ-->





                    </div>
                    <!--△メイン＆サブ-->


                    <!--▼サイドバー-->
                    <dl id="sidebar" class="sub-column">
                        <dt class="sidebar-btn">サイドバー</dt>
                        <dd id="sidebar-in">
                            <div class="contents">
                                <h3>オリジナル教材</h3>
                                <p class="profile-img"><a href="https://www.dlmarket.jp/products/detail/475376" target="_blank"><img src="../../images/kanban10.jpg" width="162" height="162" alt="プロフィール画像" /></a></p>
                                <div class="profile-txt">
                                    <p>筋肉の起始停止だけでなく主な作用や支配神経も含みます。</p>
                                </div>
                            </div>
                            <!--メニュー-->

                            <div class="contents">
                                <h3>連携サイト｢POST｣</h3>
                                <p class="profile-img"><a href="http://1post.jp/" target="_blank"><img src="../../images/post.jpg" alt="post" /></a>
                                </p>
                                <div class="profile-txt">
                                    <p><br />
                                        PT/OT/STとして働く若手療法士や、これから療法士を目指す大学生、専門学生、高校生のためウェブサイトです。当サイトと公式に連携させて頂いており、皆様の支援をしております。参考になる事が多数ありますので是非、ご活用ください！</p><a href="http://1post.jp/">PT・OT・STの働き方・学び方発見サイト</a>

                                    <a href="http://1post.jp/">「POST」</a>
                                </div>
                            </div>

                            <div class="contents">
                                <h3>問題一覧</h3>
                                <ul class="side-menu">

                                    <li><a href="/item/item01/">解剖学</a></li>
                                    <li><a href="/item/item02/">生理学</a></li>
                                    <li><a href="/item/item03/">運動学</a></li>
                                    <li><a href="/item/item04/">病理学</a></li>
                                    <li><a href="/item/item05/">内科学</a></li>
                                    <li><a href="/item/item06/">神経内科学</a></li>
                                    <li><a href="/item/item07/">整形外科学</a></li>
                                    <li><a href="/item/item08/">人間発達学</a></li>
                                    <li><a href="/item/item09/">リハ概論・リハ医学</a></li>
                                    <li><a href="/item/item10/">精神医学</a></li>
                                    <li><a href="/item/item11/">心理学</a></li>
                                    <li><a href="/item/item12/">理学療法評価学</a></li>
                                    <li><a href="/item/item13/">臨床運動学</a></li>
                                    <li><a href="/item/item14/">ADL</a></li>
                                    <li><a href="/item/item15/">義肢装具学</a></li>
                                    <li><a href="/item/item16/">物理療法学</a></li>
                                    <li><a href="/item/item17/">法律・その他</a></li>
                                    <li><a href="/item/item18/">整形外科疾患</a></li>
                                    <li><a href="/item/item19/">脊髄損傷</a></li>
                                    <li><a href="/item/item20/">脳血管障害</a></li>
                                    <li><a href="/item/item21/">神経筋疾患</a></li>
                                    <li><a href="/item/item22/">内科系疾患</a></li>
                                    <li><a href="/item/item23/">小児疾患</a></li>
                                    <li><a href="/item/item24/">運動療法総論</a></li>
                                    <li><a href="/item/item25/">第48回国試</a></li>
                                    <li><a href="/item/item26/">第49回国試</a></li>
                                    <li><a href="/item/item27/">第50回国試</a></li>
                                    <li><a href="../about/">おすすめ参考書</a></li>
                                    <li><a href="../news/">メルマガ登録</a></li>
                                    <li class="end"><a href="../link/">リンク集</a></li>
                                </ul>
                            </div>
                            <!--/メニュー-->



                            <!--conts-->
                            <div class="contents">
                                <h3>twitter</h3>
                                <!-- start TweetsWind code -->
                                <iframe     scrolling="no" frameborder="0" id="twitterWindIframe"     style="width:234px;height:480px; border:none;"     src="http://www.tweetswind.com/show?option=%7B%22isOnlyMe%22%3A%20%22true%22%2C%20%22twitterwind_frame_width%22%3A%20%22234%22%2C%20%22twitterwind_frame_height%22%3A%20%22480%22%2C%20%22twitterwind_frame_border%22%3A%20%22none%22%2C%20%22twitterwind_frame_border_color%22%3A%20%22C0DEED%22%2C%20%22twitterwind_base_font_size%22%3A%20%2212%22%2C%20%22twitterwind_logoimage%22%3A%20%22blueonwhite%22%2C%20%22twitterwind_username%22%3A%20%22on%22%2C%20%22twitterwind_username_bgcolor%22%3A%20%22FFFFFF%22%2C%20%22twitterwind_username_color%22%3A%20%22333333%22%2C%20%22twitterwind_username_follow%22%3A%20%22on%22%2C%20%22twitterwind_max_length%22%3A%20%2239%22%2C%20%22twitterwind_logo_bgcolor%22%3A%20%22FFFFFF%22%2C%20%22twitterwind_twit%22%3A%20%22on%22%2C%20%22twitterwind_twit_scroll_color%22%3A%20%22C0DEED%22%2C%20%22twitterwind_twit_scroll_bg_color%22%3A%20%22FFFFFF%22%2C%20%22twitterwind_twit_bgcolor%22%3A%20%22FFFFFF%22%2C%20%22twitterwind_twit_color%22%3A%20%22333333%22%2C%20%22twitterwind_twit_link_color%22%3A%20%220084B4%22%2C%20%22twitterwind_opacity%22%3A%20%22off%22%2C%20%22twitterwind_follower%22%3A%20%22none%22%2C%20%22twitterwind_follower_bgcolor%22%3A%20%22FFFFFF%22%2C%20%22usn%22%3A%20%22102674%22%7D"     > </iframe>
                                <!--利用規約に従ってページ内に必ずリンクを表示してください-->
                                <div style="font-size:12px; text-align:right; width:234px"><a target="_blank" href="http://www.tweetswind.com">TweetsWind</a></div> 
                                <!-- end TweetsWind code -->

                            </div>
                            <!--/conts--><!--▲サイドバー--></dd>
                    </dl>
                </div>
                <!--/main-in-->

            </div>
            <!--/main-->


            <!--▼フッター-->

            <div id="footer">
                <div id="footer-in">


                    <!--アドレスエリア-->
                    <div class="area01">
                        <h3>facebookでも問題配信中</h3>
                        <div class="access">
                            <iframe src="http://www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fptotkokushi&amp;width=350&amp;height=427&amp;colorscheme=dark&amp;show_faces=false&amp;header=true&amp;stream=true&amp;show_border=true" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:350px; height:427px;" allowtransparency="true"></iframe>
                        </div>
                    </div>
                    <!--/アドレスエリア-->


                    <!--フッターメニュー-->
                    <div class="area02">
                        <h3>メニュー</h3>
                        <div class="footer-menu">

                            <ul>
                                <li><a href="../../">ホーム</a></li>

                                <li><a href="/item/item01/">解剖学</a></li>
                                <li><a href="/item/item02/">生理学</a></li>
                                <li><a href="/item/item03/">運動学</a></li>
                                <li><a href="/item/item04/">病理学</a></li>
                                <li><a href="/item/item05/">内科学</a></li>
                                <li><a href="/item/item06/">神経内科学</a></li>
                                <li><a href="/item/item07/">整形外科学</a></li>
                                <li><a href="/item/item08/">人間発達学</a></li>
                                <li><a href="/item/item09/">リハ概論・リハ医学</a></li>
                                <li><a href="/item/item10/">精神医学</a></li>
                                <li><a href="/item/item11/">心理学</a></li>
                            </ul>
                            <ul>
                                <li><a href="/item/item12/">理学療法評価学</a></li>
                                <li><a href="/item/item13/">臨床運動学</a></li>
                                <li><a href="/item/item14/">ADL</a></li>
                                <li><a href="/item/item15/">義肢装具学</a></li>
                                <li><a href="/item/item16/">物理療法学</a></li>
                                <li><a href="/item/item17/">法律・その他</a></li>
                                <li><a href="/item/item18/">整形外科疾患</a></li>
                                <li><a href="/item/item19/">脊髄損傷</a></li>
                                <li><a href="/item/item20/">脳血管障害</a></li>
                                <li><a href="/item/item21/">神経筋疾患</a></li>
                                <li><a href="/item/item22/">内科系疾患</a></li>
                                <li class="end"><a href="/item/item23/">小児疾患</a></li>
                            </ul>
                            <ul>
                                <li><a href="../about/">おすすめ参考書</a></li>
                                <li><a href="../news/">メルマガ登録</a></li>
                                <li><a href="../link/">リンク集</a></li>
                            </ul>
                        </div>
                    </div>
                    <!--/フッターメニュー-->


                </div>



            </div>
            <!--▲フッター-->

            <!--▼トップメニュー-->
            <div id="top">
                <div id="top-in">

                    <ul id="top-menu">
                        <li><a href="../../sitemap/">サイトマップ</a></li>
                        <li><a href="../../privacy-policy/">個人情報保護方針</a></li>
                    </ul>

                </div>
            </div>
            <!--▲トップメニュー-->


            <!--コピーライト-->
            <div class="copyright">
                <p><small>Copyright (C) 2014 あなたのお名前 <span>All Rights Reserved.</span></small></p>
            </div>
            <!--/コピーライト--><!--▼ページの先頭へ戻る-->
            <p class="page-top"><a href="#container">このページの先頭へ</a></p>
            <!--▲ページの先頭へ戻る-->
        </div>
        <script type="text/javascript">

            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-12581090-6']);
            _gaq.push(['_trackPageview']);

            (function() {
                var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();

        </script>
        <!-- NINJA ANALYZE -->
        <script type="text/javascript">
            //<![CDATA[
            (function(d) {
                var sc=d.createElement("script"),
                    ins=d.getElementsByTagName("script")[0];
                sc.type="text/javascript";
                sc.src=("https:"==d.location.protocol?"https://":"http://") + "code.analysis.shinobi.jp" + "/ninja_ar/NewScript?id=00182826&hash=c51fb49c&zone=36";
                sc.async=true;
                ins.parentNode.insertBefore(sc, ins);
            })(document);
            //]]>
        </script>
        <!-- /NINJA ANALYZE -->
    </body>
</html>