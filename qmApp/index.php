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
<title>設問生成確認用ページ</title>
</head>

<body>
<!--

	設問生成確認用ページ

-->





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
<!--  ここまで-->


</body>
</html>
