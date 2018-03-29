<?php
require_once(dirname(__FILE__).'/view.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="qm.css" rel="stylesheet" />
<script src="jquery-1.7.1.min.js" type="text/javascript" charset="utf-8"></script>
<script src="qmView.js" type="text/javascript" charset="utf-8"></script>
<title>解答・解説生成確認用ページ</title>
</head>

<body>














<div id="qm-questions-area">

    <div id="qm-title-area">
    
        <h1 id="qm-title"><?php qmTitle(); ?></h1>
        
        <h1 id="qm-num-of-question" >
        <span class="qm-comment-title">解答解説</span>
        </h1>
    
        <div id="qm-exam-description" >
        <?php qmAbstract();  /*設問の説明文*/?>
        </div>
        
        <?php if( qmIsAnswerMode() ){ ?>
        <div id="qm-point-area">
        <h2 class="qm-verify-comment">採点結果</h2>
        <h2 class="qm-ans-point">
        <?php qmAnsPointArea( '<%NUM-ALLQUESTION%>問中<%NUM-CORRECTANS%>問正解でした。正解率は<%ANSPERCENT%>%でした。');?>
        </h2>
        </div>
        <?php } ?>
   
    </div>
    
    <ul class="qm-exam">
    <?php qmAnswer('exam.tpl' );	?>
    </ul>
    
    
    <div class="qm-pagination">
        <div class="qm-page" ><a href="index.php<?php qmRetryPrm(); ?>"><div class="qm-page-retry" >再挑戦</div></a></div>
        <div class="qm-page" ><a href="/" ><div class="qm-page-home" >TOPへ</div></a></div>
    </div>

<div class="row">
    <div class="col-12 col-md-6">
        <a href="../about/"><img style="width:100%;" src="../images/book-afi.png" alt="おすすめの本一覧"></a>
    </div>
</div>

</div>



</body>
</html>
