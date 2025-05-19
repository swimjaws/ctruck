<?
	include $_SERVER["DOCUMENT_ROOT"]."/common/db_info.php";
	include $_SERVER["DOCUMENT_ROOT"]."/common/myFunction.php";
	
	#######################################
	# DBConnection u
	$db_function = new db_function();
	#######################################
	
	include $_SERVER["DOCUMENT_ROOT"]."/common/CommonLib.php";
	
	if(!$_SESSION[admin_id]){
	echo "<script language=javascript>
		  location.href = '/adm/';
		  </script>";
	}
?>
<?
	//해당 게시판 글 가져오기	
	if(!$pagenum || $pagenum < 0) $pagenum=0;

		$query = "select count(*) from carinfo where best_Fl='Y' ";
		$total = mysql_fetch_array($db_function->select_db($query,$dbconn));
		$total = $total["count(*)"];

		$page = 50;
		$pagesu = ceil($total/$page);
		
		$start = $page*$pagenum;

		$query = "select * from carinfo where best_Fl='Y' order by issale desc, idx desc limit $start,$page";
		$result = $db_function->select_db($query,$dbconn);	
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title><?php include $_SERVER['DOCUMENT_ROOT']."/adm/inc/admin_title.php"; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="/adm/css/common.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="/adm/dist/sidebar-menu.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
<script language="javascript" src="/common/CommonLib.js"></script>
<script>
function searchlist()
{
	var frm = document.frm;
		frm.action = "list.php";
		frm.target = "_self";
		frm.submit();
}

function page(pagenum)
{
	var frm = document.frm;
		frm.pagenum.value = pagenum;
		frm.action = "list.php";
		frm.target = "_self";
		frm.submit();
}

function seldel()
{
	if ( ! checkedRadio($L("chk[]"), "삭제대상을")) return;
	if(confirm("선택한 목록을 삭제하시겠습니까?"))
	{
		var frm = document.frm;
			frm.action = "deleteall.php";
			frm.target = "iProc";
			frm.submit();
	}
}

function best_cancel()
{
	if ( ! checkedRadio($L("chk[]"), "차량을")) return;
	
		var frm = document.frm;
			frm.action = "best_cancel.php";
			frm.target = "iProc";
			frm.submit();
}

function reup()
{
	if ( ! checkedRadio($L("chk[]"), "차량을")) return;
	
		var frm = document.frm;
			frm.action = "reup.php";
			frm.target = "iProc";
			frm.submit();
}

function issale(idx,pagenum)
	{
		if(confirm("판매완료로 바꾸시겠습니까?"))
		{
			//location.href = "end.php?idx="+idx+"&pagenum="+pagenum;
			//var frm = document.frm;
				//frm.action = "end.php?idx="+idx+"&homemade="+homemade;
				//frm.target = "_self"
				//frm.submit();
			var frm = document.frm;
				frm.idx.value = idx;
				frm.action = "end.php";
				frm.target = "iProc";
				frm.submit();
		}
	}
	
	function issale2(idx,pagenum)
	{
		if(confirm("판매중으로 바꾸시겠습니까?"))
		{
			//location.href = "ing.php?idx="+idx+"&pagenum="+pagenum;
			//var frm = document.frm;
				//frm.action = "ing.php?idx="+idx+"&homemade="+homemade;
				//frm.target = "_self"
				//frm.submit();
			var frm = document.frm;
				frm.idx.value = idx;
				frm.action = "ing.php";
				frm.target = "iProc";
				frm.submit();
		}
	}

function view(idx,pagenum)
{
	var frm = document.frm;
		frm.idx.value = idx;
		frm.pagenum.value = pagenum;
		frm.action = "view.php";
		frm.target = "_self";
		frm.submit();
}

function result_ok()
{
	location.reload();
}
</script>
</head>
<body leftmargin="0" topmargin="0" onLoad="" id="car">
<iframe name="iProc" id="iProc" height="0" frameborder="0" marginheight="0" marginwidth="0"></iframe>
<form name="frm">
<input type="hidden" name="idx">
<input type="hidden" name="pagenum">
<div class="header">
	<?php include $_SERVER['DOCUMENT_ROOT']."/adm/inc/head.php"; ?>
</div>
<div id="wrap">
	<div class="side-bar">
		<?php include $_SERVER['DOCUMENT_ROOT']."/adm/inc/sub-nav.php"; ?>
	</div>
	<div class="content">
		<table width="100%" height="35" border="0" cellpadding="0" cellspacing="0">
			<tr>
                <td>HOME > 차량관리 > 직거래차량 리스트</td>
			</tr>
		</table>
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
			    <td height="45"><h4><img src="/adm/image/icon04.gif" width="18" height="18" hspace="8" align="absmiddle" style="padding-right:10px"><strong>직거래차량 리스트 </strong></h4></td>
			</tr>
		</table>
			<!-- 리스트 -->
		<div class="reg-box">
			<div id="header-wrap" style="font-size:16px; font-weight:bold; padding-bottom:10px;">직거래 차량수 : <? echo $total ?></div>
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
			  <tr bgcolor="#dfe3e6"> 
			    <td width="50" align="center"><input type="checkbox" name="chkall" onClick="javascript:setCheckAll($L('chk[]'), this.checked)"></td>
                <td width="70" height="30" align="center"><font color="#000"><strong>번호</strong></font></td>
                <td width="200" align="center"><font color="#000"><strong>이미지</strong></font></td>
				<td width="100" align="center"><font color="#000"><strong>차량번호</strong></font></td>
                <td align="center"><font color="#000"><strong>차량정보</strong></font></td>
				<td width="120" align="center"><font color="#000"><strong>판매가격</strong></font></td>
                <td width="140" align="center"><font color="#000"><strong>등록일</strong></font></td>
				
              </tr>
			  <tr bgcolor="dddddd">
			    <td colspan="8" height="1"></td>
			  </tr>
			  <?
	 			 $top_article = $pagenum * $page;
	 			 $listno = $total-$top_article;
				
  				 while($rs=mysql_fetch_array($result))
  				 {
					if($rs[ton]=="120"){
						$rs[ton]="1.2";
					} 
					if($rs[ton]=="140"){
						$rs[ton]="1.4";
					} 
					
			  		$sql = "select * from carinfo_img where j_idx=$rs[idx] and j_no=0";
					$car_img = mysql_fetch_array(mysql_query($sql,$dbconn));
  		  	   ?>
			   <tr> 
			    <td align="center"><input type="checkbox" name="chk[]" value="<?=$rs[idx]?>"></td>
                <td height="35" align="center"><?=$listno?></td>
                <td height="140" align="center"><div class="cimg-wrap"><p class="reico"><? if ($rs[recomm]=='Y') { ?> <img src="/adm/image/recomm_ing.gif" border="0"> <? } ?></p><a href="javascript:view('<?=$rs[idx]?>','<?=$pagenum?>')"><img src="/carimg/<?=$car_img[j_file]?>" width="150" height="120"></a></div></td>
                <td height="35" align="center"><?=$rs[carnumber]?></td>
				<td>
					<table border="0" cellpadding="0" cellspacing="0">
					  <tr>
					    <td height="30"><strong> <font size="3">
                          <?=$rs[carname]?>
                          </font> </strong></td>
					  </tr>
					  <tr>
					    <td height="30"><?=$rs[maker]?> <?=$rs[makeyear2]?>년<?=$rs[makemonth2]?>월 / <?=$rs[ton]?>톤 / <?=number_format($rs[distance])?>km</td>
					  </tr>
					  <tr>
					    <td><?=$rs[memo]?></td>
					  </tr>
					</table>
				</td>
				<td align="center">
				<? if($rs[iscounsel]=='Y'){ ?>
					가격상담
				<? } else {?>
					<?=number_format($rs[price])?>만원
				<? } ?>
				</td>
                <td align="center"><?=$rs[reg_date]?></td>
                
              </tr>
              <tr> 
                <td height="1" colspan="9" bgcolor="dddddd"></td>
              </tr>
			  <?
			     $listno = $listno-1;   	
			     }
  		  	  ?>
			</table>
		</div>
			
			<!-- //리스트 -->
			<!-- 페이징 -->
            <div id="pagination">
				<div class="paging">
					<?
						$pageviewsu = 5; //한페이지에 보여줄 목록수
						$pagegroup = ceil(($pagenum+1)/$pageviewsu); //페이지 그룹결정
						$pagestart = ($pageviewsu*($pagegroup-1))+1; //시작페이지 결정
						$pageend = $pagestart+$pageviewsu-1; //종료페이지 결정

						//이전페이지 구하는 부분
						if($pagegroup > 1){
							$prev = $pagestart-$pageviewsu-1;
							echo "<a href=javascript:page('$prev')><span><img src=/adm/image/pg_start.gif></span></a>";
						}else{
							echo "<span><img src=/adm/image/pg_start.gif></span>";
						}
		   
						//바로이전페이지 구하기
						if($pagenum){
							$prevpage = $pagenum-1;
							echo "<a href=javascript:page('$prevpage')><span><img src=/adm/image/pg_prev.gif></span></a>";
						}else{
							echo "<span><img src=/adm/image/pg_prev.gif></span>";
						}

						//페이지 번호 찍기
						for($i=$pagestart;$i<=$pageend;$i++)
						{
							if($pagesu < $i){break;}
							$j = $i-1;
							if($pagenum == $j){echo "<span class='nlk'>$i</span>";}
							else{
								echo "<a href=javascript:page('$j') class='pg'><span>$i</span></a>";
							}
						}

						//바로다음페이지 구하기
						if(($pagenum+1) != $pagesu){
							$nextpage = $pagenum+1;
							echo "<a href=javascript:page('$nextpage')><span><img src=/adm/image/pg_next.gif></span></a>";
						}else{
							echo "<span><img src=/adm/image/pg_next.gif></span>";
						}

						//다음페이지 구하는 부분
						if($pageend < $pagesu){
							echo "<a href=javascript:page('$pageend')><span><img src=/adm/image/pg_end.gif></span></a>";
						}else{
							echo "<span><img src=/adm/image/pg_end.gif></span>";
						}
					?>
				</div>
			</div>
			<!-- //페이징 -->
			<div class="btnlist">
				<ul class="btn_bo_adm">
				<li><input type="submit" name="btn_submit" value="직거래차량취소" onclick="javascript:best_cancel()"></li>
				<li><input type="submit" name="btn_submit" value="전체차량보기" onclick="javascript:page()"></li>
				</ul>
			</div>
	</div>
</div>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><?php include $_SERVER['DOCUMENT_ROOT']."/adm/inc/footer.php"; ?></td>
  </tr>
</table>
</form>
</body>
</html>