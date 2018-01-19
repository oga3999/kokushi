<!--
--  
--  	Question Maker Template for rigakuryouhoushi
--  
--  Powerd by hommymoco.com
-->

<!-- 

	START_？.TPL 　～　END_？.TPL  で囲まれている部分がテンプレートとして表示されます。
    
    囲まれている中は通常のHTMLになります。
    また＜％％＞のタグは置換されるパラメータになりますので、変更はしないでください。
    それ以外は通常のHTMLになりますので、自由に変更いただけます。
    
-->



<!-- START_QUESTION.TPL -->
<!--  A part of a question -->
<li class="qm-exam" >
<p class="qm-question-number">設問<%QUESTONNUM%></p>
<div class="qm-question-body">
	<!-- 設問 -->
	<p class="qm-a-question"><span class="qm-q-mark">●</span><%QUESTION%></p>
    <!-- 選択肢表示フォーマット-->
    <%BRANCHLINE%>
    <p class="qm-question-branch" ><label><%BRANCH%></label></p>
    </%BRANCHLINE%>
</div>
</li>
<!-- END_QUESTION.TPL -->




<!-- START_ANSWER.TPL -->
<!--  A part of a anwer -->
<li class="qm-exam" >
<p class="qm-question-number">設問<%QUESTONNUM%></p>
<div class="qm-question-body">
	<!-- 設問 -->
	<p class="qm-a-question"><span class="qm-q-mark">●</span><%QUESTION%></p>
    <!-- 選択肢表示フォーマット-->
    <%BRANCHLINE%>
        <p class="qm-question-branch" ><span class="<%ANSCORRCLASS%>"><%ANSCORR%></span><%BRANCH%></p>
    </%BRANCHLINE%>
    
    <div class="qm-qutstion-line"></div>
    <div class="qm-qutstion-exposition">
    	<%YOURANSWERAREA%>
		<br class="qm-clear"/>

    	<hr class="qm-sep-line">
    	<div class="qm-qutstion-exposition-title">あなたの回答</div>
        <div class="qm-exposition"><%YOURANSWER%></div>
        <%/YOURANSWERAREA%>
    
    	<hr class="qm-sep-line">
    	<div class="qm-qutstion-exposition-title">解説</div>
        <div class="qm-exposition"><%EXPOSITION%></div>
    </div>
    
</div>
</li>
<!-- END_ANSWER.TPL -->



<!-- START_PAGE_PREV.TPL -->
<div class="grad01 qm-page qm-page-prev" >
<input type="submit" name="bt-submit[]" value="prev"  class="qm-bt-continue"  /><span class="qm-bt-caption" >前のページへ</span>
</div>
<!-- END_PAGE_PREV.TPL -->

<!-- START_PAGE_NEXT.TPL -->
<div class="grad01 qm-page qm-page-next" >
<input type="submit" name="bt-submit[]" value="next"  class="qm-bt-continue" /><span class="qm-bt-caption" >次のページへ</span>
</div>
<!-- END_PAGE_NEXT.TPL -->


<!-- START_PAGE_NONE.TPL -->
<div class="qm-page qm-page-none" ><a href="/" ><div class="qm-page-home" >TOPへ</div></a></div>
<!-- END_PAGE_NONE.TPL -->

<!-- START_PAGE_FINISH.TPL -->
<div class="qm-page grad01 qm-page-finish" >
<input type="submit" name="bt-submit[]" value="finish"  class="qm-bt-continue" /><span class="qm-bt-caption" >答え合わせへ</span>
</div>
<!-- END_PAGE_FINISH.TPL -->
