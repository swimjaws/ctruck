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
	
	if($maker) $strquery .= " and maker='$maker'";
	if($model) $strquery .= " and model='$model'";
	if($position) $strquery .= " and position='$position'";
	if($position_detail) $strquery .= " and position_detail='$position_detail'";
	if($longth) $strquery .= " and longth='$longth'";
	
	if($ton){
		if($ton=="6"){
	 		$strquery .= " and ton>5";
		} else {
			$strquery .= " and ton='$ton'";
		}
	}
	
	$strquery = substr($strquery,5);
	
	if(!$strquery){
		$query = "select count(*) from carinfo ";
		$total = mysql_fetch_array($db_function->select_db($query,$dbconn));
		$total = $total["count(*)"];

		$page = 20;
		$pagesu = ceil($total/$page);
		$start = $page*$pagenum;

		$query = "select * from carinfo order by idx desc limit $start,$page";
		$result = $db_function->select_db($query,$dbconn);	
	}else{
		$query = "select count(*) from carinfo where ".$strquery;
		$total = mysql_fetch_array($db_function->select_db($query,$dbconn));
		$total = $total["count(*)"];

		$page = 20;
		$pagesu = ceil($total/$page);
		$start = $page*$pagenum;

		$query = "select * from carinfo where ".$strquery." order by idx desc limit $start,$page";
		$result = $db_function->select_db($query,$dbconn);
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title><?php include $_SERVER['DOCUMENT_ROOT']."/adm/inc/admin_title.php"; ?></title>
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
<script language="javascript">
	function areaload()
	{
		changecar()
		
	}
	
	function deletec_kindCategory() {
		var overMaxNum = 60;
		for (var k=0 ; k < overMaxNum ; k++) {
		document.frm.model.options.remove(0);
		}
	}
	
	
	
	function changecar() {
	
	
	var chooseRight = document.frm.maker.options[document.frm.maker.selectedIndex].value;
	
	
	//현대
	S_1_TEXT = ['------ 차 종 ------', '포터', '뉴포터', '포터2', '마이티', '마이티2', 'e마이티', '현대트럭', '리베로', '메가트럭', '파워텍', '뉴파워텍', '트라고', '엑시먼트'];
	S_1_VALUE = ['', '포터', '뉴포터', '포터2', '마이티', '마이티2', 'e마이티', '현대트럭', '리베로', '메가트럭', '파워텍', '뉴파워텍', '트라고', '엑시먼트'];

	if(chooseRight=='현대') { 
		SI_TEXT = S_1_TEXT; 
		SI_VALUE = S_1_VALUE;
		
	}


	//기아
	S_1_TEXT = ['------ 차 종 ------', '세레스', '타우너트럭', '타이탄', '트레이드', '파맥스', '라이노', '복사', '프런티어', '봉고프런티어', '와이드봉고', '봉고3'];
	S_1_VALUE = ['', '세레스', '타우너트럭', '타이탄', '트레이드', '파맥스', '라이노', '복사', '프런티어', '봉고프런티어', '와이드봉고', '봉고3'];
	
	if(chooseRight=='기아') { 
		SI_TEXT = S_1_TEXT; 
		SI_VALUE = S_1_VALUE;
		
	}
	
	
	//대우
	S_1_TEXT = ['------ 차 종 ------', '라보', '대우트럭', '노부스', '프리마'];
	S_1_VALUE = ['', '라보', '대우트럭', '노부스', '프리마'];
	
	if(chooseRight=='대우') { 
		SI_TEXT = S_1_TEXT; 
		SI_VALUE = S_1_VALUE;
		
	}
	
	
	//기타
	S_1_TEXT = ['------ 차 종 ------'];
	S_1_VALUE = [''];
	
	if(chooseRight=='기타') { 
		SI_TEXT = S_1_TEXT; 
		SI_VALUE = S_1_VALUE;
		
	}
	
	deletec_kindCategory();
	
	for (var k=0 ; k < SI_TEXT.length ; k++) {
		newOpt = document.createElement("OPTION");
		newOpt.text = SI_TEXT[k];
		newOpt.value = SI_VALUE[k];
		
		if(SI_VALUE[k] == "<?=$model?>"){
		newOpt.selected = true;
		}
		
		document.frm.model.options.add(newOpt);
	}
}
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="/adm/css/style.css" rel="stylesheet" type="text/css">

</head>

<body leftmargin="0" topmargin="0" onLoad="areaload()">
<iframe name="iProc" id="iProc" height="0" frameborder="0" marginheight="0" marginwidth="0"></iframe>
<form name="frm">
<input type="hidden" name="idx">
<input type="hidden" name="pagenum">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><?php include $_SERVER['DOCUMENT_ROOT']."/adm/inc/top.php"; ?></td>
  </tr>
</table>
<table class="wraptable">
  <tr>
    <td width="188" height="600" align="center" valign="top" bgcolor="#FFFFFF"><?php include $_SERVER['DOCUMENT_ROOT']."/adm/inc/menu01_leftmenu.php"; ?></td>
	<td valign="top" bgcolor="#FFFFFF" style="padding-left:10px">
	  <table width="100%" border="0" cellpadding="0" cellspacing="0">
	    <tr>
		  <td width="6">&nbsp;</td>
		  <td height="50" style="padding-top:9px">
		    <table width="1039" height="35" border="0" cellpadding="0" cellspacing="0" background="/adm/image/titlemap_bg.gif">
			  <tr>
			      
                  <td style="padding-left:20px">HOME > 트럭관리</td>
			  </tr>
			</table>
			<br>
            <table width="1039" border="0" cellpadding="0" cellspacing="0">
			  <tr>
			    <td height="30"><h4><img src="/adm/image/icon04.gif" width="18" height="18" hspace="8" align="absmiddle"><strong>트럭 
                      리스트 </strong></h4></td>
			  </tr>
			  
			  <tr bgcolor="#CCCCCC">
			    <td height="1"></td>
			  </tr>
			  <tr>
			    <td height="20"></td>
			  </tr>
			</table>
			<table width="1039" border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" style="border-collapse:collapse">
			  <tr>
			    <td>
				  <table width="100%" border="0" cellpadding="5" cellspacing="0">
                      <tr> 
                        <td width="80" height="35" bgcolor="#F2F2F2"><strong>제조사</strong></td>
                        <td width="200"><select name="maker" onchange="javascript:changecar()" style="width:120px">
                            <option value="">-- 선택 --</option>
                            <option value="현대">현대</option>
                            <option value="기아">기아</option>
                            <option value="대우">대우</option>
                            <option value="기타">기타</option>
                          </select> <script language="JavaScript">
			  		  setComboOption($("maker"), '<?=$maker?>')
				    </script></td>
                        <td width="80" bgcolor="#F2F2F2"><strong>차종</strong></td>
                        <td width="200"><select name="model" style="width:150px">
                             <option value="">-- 선택 --</option>
                          </select></td>
                        <td width="80" bgcolor="#F2F2F2"><strong>분류</strong></td>
                        <td><select name="position" style="width:120px">
                             <option value="">-- 선택 --</option>
                            <option value="카고트럭">카고트럭</option>
                            <option value="윙바디">윙바디</option>
                            <option value="냉동탑">냉동탑</option>
                            <option value="내장탑">내장탑</option>
                            <option value="익스탑">익스탑</option>
                            <option value="집게차">집게차</option>
                            <option value="바가지">바가지</option>
                            <option value="크레인">크레인</option>
                            <option value="암롤">암롤</option>
                            <option value="덤프">덤프</option>
                            <option value="홈로리">홈로리</option>
                            <option value="탱크로리">탱크로리</option>
                            <option value="살수차">살수차</option>
                            <option value="셀프로더">셀프로더</option>
                            <option value="활어차">활어차</option>
                            <option value="버큠로리">버큠로리</option>
                            <option value="음식물처리차">음식물처리차</option>
                            <option value="진개차">진개차</option>
                            <option value="압축">압축</option>
                            <option value="압착">압착</option>
                          </select> <script language="JavaScript">
			  		  setComboOption($("position"), '<?=$position?>')
				    </script></td>
                      </tr>
                      <tr> 
                        <td height="35" bgcolor="#F2F2F2"><strong>세부분류</strong></td>
                        <td><select name="position_detail">
                             <option value="">-- 선택 --</option>
                            <option value="슈퍼캡" >슈퍼캡</option>
                            <option value="일반캡" >일반캡</option>
                            <option value="더블캡" >더블캡</option>
                            <option value="4륜" >4륜</option>
                          </select> <script language="JavaScript">
			  		  setComboOption($("position_detail"), '<?=$position_detail?>')
				    </script></td>
                        <td bgcolor="#F2F2F2"><strong>길이</strong></td>
                        <td><select name="longth">
							 <option value="">-- 선택 --</option>
                            <option value="단축">단축</option>
                            <option value="장축">장축</option>
                            <option value="초장축">초장축</option>
                            <option value="극초장축">극초장축</option>
                            <option value="극극초장축">극극초장축</option>
                          </select> <script language="JavaScript">
			  		  setComboOption($("longth"), '<?=$longth?>')
				    </script></td>
                        <td bgcolor="#F2F2F2"><strong>톤수</strong></td>
                        <td><select name="ton">
                             <option value="">-- 선택 --</option>
							<option value="1">1t</option>
                            <option value="1.2">1.2t</option>
                            <option value="2">2t</option>
                            <option value="2.4">2.4t</option>
                            <option value="2.5">2.5t</option>
                            <option value="3">3t</option>
                            <option value="3.5">3.5t</option>
                            <option value="4.5">4.5t</option>
                            <option value="5">5t</option>
                            <option value="6">5t이상</option>
                            
                          </select> <script language="JavaScript">
			  		  setComboOption($("ton"), '<?=$ton?>')
				    </script></td>
                      </tr>
                    </table>
				</td>
			  </tr>
			  <tr>
				<td height="60" align="center"><a href="javascript:searchlist()"><img src="/adm/image/bt_search.gif" border="0"></a></td>
			  </tr>
			</table>
			<br>
			<table width="1039" border="0" cellpadding="0" cellspacing="0">
			  <tr bgcolor="#86979F"> 
			    <td width="50" align="center"><input type="checkbox" name="chkall" onClick="javascript:setCheckAll($L('chk[]'), this.checked)"></td>
                <td width="70" height="30" align="center"><font color="#FFFFFF"><strong>번호</strong></font></td>
                  <td width="200" align="center"><font color="#FFFFFF"><strong>이미지</strong></font></td>
                <td align="center"><font color="#FFFFFF"><strong>차량정보</strong></font></td>
                <td width="120" align="center"><font color="#FFFFFF"><strong>판매가격</strong></font></td>
                <td width="140" align="center"><font color="#FFFFFF"><strong>등록일</strong></font></td>
              </tr>
			  <tr bgcolor="dddddd">
			    <td colspan="6" height="1"></td>
			  </tr>
			  <?
	 			 $top_article = $pagenum * $page;
	 			 $listno = $total-$top_article;
	 
  				 while($rs=mysql_fetch_array($result))
  				 {
			  		$sql = "select * from carinfo_img where j_idx=$rs[idx] and j_no=0";
					$car_img = mysql_fetch_array(mysql_query($sql,$dbconn));
  		  	   ?>
			   <tr> 
			    <td align="center"><input type="checkbox" name="chk[]" value="<?=$rs[idx]?>"></td>
                <td height="35" align="center"><?=$listno?></td>
                <td height="140" align="center"><a href="javascript:view('<?=$rs[idx]?>','<?=$pagenum?>')"><img src="/carimg/<?=$car_img[j_file]?>" width="150" height="120"></a></td>
                <td>
					<table border="0" cellpadding="0" cellspacing="0">
					  <tr>
					    <td height="30"><strong> <font size="3">
                          <?=$rs[model]?>
                          <?=$rs[position_detail]?>
                          <?=$rs[position]?>
                          </font> </strong></td>
					  </tr>
					  <tr>
					    <td height="30"><?=$rs[maker]?> <?=$rs[makeyear]?>년<?=$rs[makemonth]?>월 / <?=$rs[ton]?>톤 / <?=number_format($rs[distance])?>km</td>
					  </tr>
					  <tr>
					    <td><?=$rs[memo]?></td>
					  </tr>
					</table>
				</td>
				<td align="center"><?=number_format($rs[price])?>만원</td>
                <td align="center"><?=$rs[reg_date]?></td>
                
              </tr>
              <tr> 
                <td height="1" colspan="6" bgcolor="dddddd"></td>
              </tr>
			  <?
			     $listno = $listno-1;   	
			     }
  		  	  ?>
			</table>
			
			  <table width="1039" border="0" cellpadding="0" cellspacing="0">
                <tr> 
                  <td height="40"><img src="/adm/image/btn_select_delete.gif" width="65" height="23" style="cursor:hand" onClick="javascript:seldel()"></td>
                </tr>
              </table>
              <table width="1039" border="0" cellpadding="0" cellspacing="0">
                <tr> 
                  <td height="40" align="right"><a href="regist.php"><img src="/adm/image/bt_regist.gif" width="67" height="30" border="0"></a></td>
                </tr>
              </table>
              <table width="1039" border="0" cellpadding="0" cellspacing="0">
                <tr> 
                  <td height="50" align="center"> 
                    <?
								$pageviewsu = 10; //한페이지에 보여줄 목록수
   								$pagegroup = ceil(($pagenum+1)/$pageviewsu); //페이지 그룹결정
   								$pagestart = ($pageviewsu*($pagegroup-1))+1; //시작페이지 결정
   								$pageend = $pagestart+$pageviewsu-1; //종료페이지 결정

								//이전페이지 구하는 부분
								if($pagegroup > 1){
								$prev = $pagestart-$pageviewsu-1;
								echo "<a href=list.php?pagenum=$prev&mem_type=$mem_type&name=$name&id=$id&hp=$hp&area=$area&startdate=$startdate><img src=/adm/image/prebt_01.gif width=12 height=15 border=0 align=absmiddle></a>&nbsp;";
    							}
   
    							//바로이전페이지 구하기
								//if($pagenum){
								//$prevpage = $pagenum-1;
								//echo "<a href=list.php?pagenum=$prevpage><img src=/main_img/button_03.gif border=0 align=absmiddle></a>";
    							//}

								//페이지 번호 찍기
							    for($i=$pagestart;$i<=$pageend;$i++)
								{
									if($pagesu < $i){break;}
									$j = $i-1;
		  							if($pagenum == $j){echo "&nbsp;<font color='999999'>$i</font>&nbsp;";}
          							else{
			  							echo "&nbsp;<a href=javascript:page('$j')>$i</a>&nbsp;";
		  							}
								}

								//바로다음페이지 구하기
								//if(($pagenum+1) != $pagesu){
								//$nextpage = $pagenum+1;
								//echo "<a href=list.php?pagenum=$nextpage><img src=/main_img/button_04.gif border=0 align=absmiddle></a>";
    							//}

								//다음페이지 구하는 부분
								if($pageend < $pagesu){echo "&nbsp;<a href=list.php?pagenum=$pageend&mem_type=$mem_type&name=$name&id=$id&hp=$hp&area=$area&startdate=$startdate><img src=/adm/image/nextbt_01.gif width=12 height=15 border=0 align=absmiddle></a>";}
							?>
                  </td>
                </tr>
              </table></td>
		</tr>
	  </table>
    </td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><?php include $_SERVER['DOCUMENT_ROOT']."/adm/inc/footer.php"; ?></td>
  </tr>
</table>
</form>
</body>
</html>
<script type="text/javascript">
var oEditors = [];
nhn.husky.EZCreator.createInIFrame({
	oAppRef: oEditors,
	elPlaceHolder: "content",
	sSkinURI: "/common/editor/SmartEditor2Skin.html",	
	htParams : {
		bUseToolbar : true,				// 툴바 사용 여부 (true:사용/ false:사용하지 않음)
		bUseVerticalResizer : true,		// 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
		bUseModeChanger : true,			// 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
		fOnBeforeUnload : function(){
			//alert("아싸!");	
		}
	}, //boolean
	fOnAppLoad : function(){
		//예제 코드
		//oEditors.getById["ir1"].exec("PASTE_HTML", ["로딩이 완료된 후에 본문에 삽입되는 text입니다."]);
	},
	fCreator: "createSEditor2"
});

function pasteHTML() {
	var sHTML = "<span style='color:#FF0000;'>이미지도 같은 방식으로 삽입합니다.<\/span>";
	oEditors.getById["ir1"].exec("PASTE_HTML", [sHTML]);
}

function showHTML() {
	var sHTML = oEditors.getById["ir1"].getIR();
	alert(sHTML);
}
	
function submitContents(elClickedObj) {
	oEditors.getById["content"].exec("UPDATE_CONTENTS_FIELD", []);	// 에디터의 내용이 textarea에 적용됩니다.
	
	// 에디터의 내용에 대한 값 검증은 이곳에서 document.getElementById("ir1").value를 이용해서 처리하면 됩니다.
	
	try {
		elClickedObj.form.submit();
	} catch(e) {}
}

function setDefaultFont() {
	var sDefaultFont = '궁서';
	var nFontSize = 24;
	oEditors.getById["ir1"].setDefaultFont(sDefaultFont, nFontSize);
}
</script>