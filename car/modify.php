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
	$query = "select * from carinfo where idx=$idx";
	$edit = mysql_fetch_array($db_function->select_db($query,$dbconn));
	
	/* $memo = stripslashes($edit[memo]);
	$memo = str_replace( "\"", "&quot;",  $memo ); */
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title><?php include $_SERVER['DOCUMENT_ROOT']."/adm/inc/admin_title.php"; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script language="javascript" src="/common/CommonLib.js"></script>
<link href="/adm/css/common.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="/adm/dist/sidebar-menu.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script type="text/javascript" src="/common/editor/js/HuskyEZCreator.js" charset="utf-8"></script>
<script language="javascript">
	function save()
	{
		oEditors.getById["content"].exec("UPDATE_CONTENTS_FIELD", []);	// 에디터의 내용이 textarea에 적용됩니다.
		
		//if(isEmpty($("subject"), "제목을")) return;
		
		var frm = document.frm;
			frm.action = "modify_ok.php";
			frm.target = "_self";
			frm.submit();
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
		document.frm.carkind.options.remove(0);
		}
	}
	
	
	
	function changecar() {
	
	
	var chooseRight = document.frm.cartype.options[document.frm.cartype.selectedIndex].value;
	
	
	//카고트럭
	S_1_TEXT = ['용도선택', '카고트럭', '샤시차량'];
	S_1_VALUE = ['', '카고트럭', '샤시차량'];

	if(chooseRight=='카고트럭') { 
		SI_TEXT = S_1_TEXT; 
		SI_VALUE = S_1_VALUE;
	}
	
	//윙바디/냉장윙/상승윙
	S_1_TEXT = ['용도선택', '윙바디','냉장윙ㆍ냉동윙바디','상승윙바디'];
	S_1_VALUE = ['', '윙바디','냉장윙ㆍ냉동윙바디','상승윙바디'];
	
	if(chooseRight=='윙바디/냉장윙/상승윙') { 
		SI_TEXT = S_1_TEXT; 
		SI_VALUE = S_1_VALUE;
	}

    //냉동탑차/익스탑차/탑차
	S_1_TEXT = ['용도선택', '냉동탑차','익스탑차','내장탑차'];
	S_1_VALUE = ['', '냉동탑차','익스탑차','내장탑차'];
	
	if(chooseRight=='냉동탑차/익스탑차/탑차') { 
		SI_TEXT = S_1_TEXT; 
		SI_VALUE = S_1_VALUE;
	}


	//추레라/트레일러
	S_1_TEXT = ['용도선택', '트렉터', '트레일러', '로우베드', 'BCT벌크', '덤프추레라', '탱크트레일러', '풀카', '평판샤시', '콘테이너샤시', '윙트레일러', '곡물트레일러', 'LPG트레일러', '삐닥이샤시'];
	S_1_VALUE = ['', '트렉터', '트레일러', '로우베드', 'BCT벌크', '덤프추레라', '탱크트레일러', '풀카', '평판샤시', '콘테이너샤시', '윙트레일러', '곡물트레일러', 'LPG트레일러', '삐닥이샤시'];
	
	if(chooseRight=='추레라/트레일러') { 
		SI_TEXT = S_1_TEXT; 
		SI_VALUE = S_1_VALUE;
	}
	
	//탱크로리/살수차/홈로리
	S_1_TEXT = ['용도선택', '탱크로리','살수차','홈로리','LPG 탱크','물차','바큠로리','유조차'];
	S_1_VALUE = ['', '탱크로리','살수차','홈로리','LPG 탱크','물차','바큠로리','유조차'];
	
	if(chooseRight=='탱크로리/살수차/홈로리') { 
		SI_TEXT = S_1_TEXT; 
		SI_VALUE = S_1_VALUE;
	}

	//덤프/중기/중장비/건설기계
	S_1_TEXT = ['용도선택', '덤프','레미콘','펌프카','지게차','굴삭기','기중기','로우더','하이랜더','불도우저','제설차','공기압축기','발전기','그레이더','항타기','크락샤','배차플랜드','스키드로더','크로라드릴','로라장비'];
	S_1_VALUE = ['', '덤프','레미콘','펌프카','지게차','굴삭기','기중기','로우더','하이랜더','불도우저','제설차','공기압축기','발전기','그레이더','항타기','크락샤','배차플랜드','스키드로더','크로라드릴','로라장비'];
	
	if(chooseRight=='덤프/중기/건설기계') { 
		SI_TEXT = S_1_TEXT; 
		SI_VALUE = S_1_VALUE;
	}

	//셀프로더/카캐리어/렉카
	S_1_TEXT = ['용도선택', '셀프로더','카캐리어','렉카','어브바카','언더리프트','크레인겸용'];
	S_1_VALUE = ['', '셀프로더','카캐리어','렉카','어브바카','언더리프트','크레인겸용'];
	
	if(chooseRight=='셀프로더/카캐리어/렉카') { 
		SI_TEXT = S_1_TEXT; 
		SI_VALUE = S_1_VALUE;
	}

	//암롤/압축/진개덤프/압착
	S_1_TEXT = ['용도선택', '암롤', '압축', '진개덤프 ', '압착'];
	S_1_VALUE = ['', '암롤', '압축', '진개덤프 ', '압착'];
	
	if(chooseRight=='암롤/압축/진개덤프/압착') { 
		SI_TEXT = S_1_TEXT; 
		SI_VALUE = S_1_VALUE;
	}
		
	//집게차/사료차/우드칩
	S_1_TEXT = ['용도선택', '집게차','사료차','우드칩','우드칩윙바디'];
	S_1_VALUE = ['', '집게차','사료차','우드칩','우드칩윙바디'];
	
	if(chooseRight=='집게차/사료차/우드칩') { 
		SI_TEXT = S_1_TEXT; 
		SI_VALUE = S_1_VALUE;
	}

	//카고크레인/사다리차/바가지차
	S_1_TEXT = ['용도선택', '카고크레인','사다리차','바가지차','고소작업차','오가크레인','수산활선차'];
	S_1_VALUE = ['', '카고크레인','사다리차','바가지차','고소작업차','오가크레인','수산활선차'];
	
	if(chooseRight=='카고크레인/사다리차/바가지차') { 
		SI_TEXT = S_1_TEXT; 
		SI_VALUE = S_1_VALUE;
	}
					
	//기타/특수차/특장차
	S_1_TEXT = ['용도선택', '워킹카','방통차','유압방통','승합/버스','고철운송차','철근운송차','활어차','구급차','곡물차','BCC벌크','소방차','소방공작차','음식물차','왕겨(톱밥)차','가축운반차','분뇨차','퇴비차','캠핑카','진공흡입차','노면청소차','이동목욕차','이동스낵카','이동광고차','이동무대차','방송중계차','농약살포차','차선도색차','특수차','희귀차량','트랜스포타','모즐','따리','기타'];
	S_1_VALUE = ['', '워킹카','방통차','유압방통','승합/버스','고철운송차','철근운송차','활어차','구급차','곡물차','BCC벌크','소방차','소방공작차','음식물차','왕겨(톱밥)차','가축운반차','분뇨차','퇴비차','캠핑카','진공흡입차','노면청소차','이동목욕차','이동스낵카','이동광고차','이동무대차','방송중계차','농약살포차','차선도색차','특수차','희귀차량','트랜스포타','모즐','따리','기타'];
	
	if(chooseRight=='기타/특수차/특장차') { 
		SI_TEXT = S_1_TEXT; 
		SI_VALUE = S_1_VALUE;
	}
	
	deletec_kindCategory();
	
	for (var k=0 ; k < SI_TEXT.length ; k++) {
		newOpt = document.createElement("OPTION");
		newOpt.text = SI_TEXT[k];
		newOpt.value = SI_VALUE[k];
		
		if(SI_VALUE[k] == "<?=$edit[carkind]?>"){
		newOpt.selected = true;
		}
		
		document.frm.carkind.options.add(newOpt);
	}
}

	
function $$(pObjName, pDoc, pMsgFlag)	{
	var tObjDoc = (pDoc==null) ? document : pDoc;
	if (pMsgFlag==null)	pMsgFlag = true;

	var tObj = tObjDoc.getElementsByName(pObjName);
	if (tObj.length==0)	{
		if (pMsgFlag) alert("[" + pObjName + "] °´Ã¼¸¦ Ã£À» ¼ö ¾ø½À´Ï´Ù.");
		return null;
	}
	else if (tObj.length>1)	{
		if (pMsgFlag) alert("[" + pObjName + "]´Â ÇÏ³ª ÀÌ»óÀÇ °´Ã¼°¡ Á¸ÀçÇÕ´Ï´Ù.");
		return null;
	}
	else	{	// Ã¹¹øÂ° °´Ã¼¸¦ ¹ÝÈ¯ÇÑ´Ù.
		return tObj[0];
	}
}

function setComboOption (pObjCombo, pValue)	{
	var tOptions = pObjCombo.options;
	var tOption = null;

	for (var tLoop=0; tLoop<tOptions.length; tLoop++)	{
		tOption = tOptions[tLoop];

		if (tOption.value == pValue)	{
			tOption.selected = true;
			break;
		}
	}
}		 
</script>
<style>
#dragandrophandler
{
border:2px dotted #0B85A1;
width:1250px;
color:#92AAB0;
text-align:center; vertical-align:middle;
padding:30px 10px 30px 10px;
margin-bottom:10px;
font-size:200%;
}
.exp {font-size:14px;}
.progressBar {
    width: 200px;
    height: 18px;
    border: 1px solid #ddd;
    border-radius: 5px; 
    overflow: hidden;
    display:inline-block;
    margin:0px 10px 5px 5px;
    vertical-align:top;
}
 
.progressBar div {
    height: 100%;
    color: #fff;
    text-align: right;
    line-height: 18px; /* same as #progressBar height if we want text middle aligned */
    width: 0;
    background-color: #0ba1b5; border-radius: 3px; 
}
.statusbar
{
    border-top:1px solid #A9CCD1;
    min-height:20px;
    width:700px;
    padding:5px 10px 0px 10px;
    vertical-align:top;
}
.statusbar:nth-child(odd){
    /* background:#EBEFF0; */
}
.filename
{
display:inline-block;
vertical-align:top;
width:250px;
}
.filesize
{
display:inline-block;
vertical-align:top;
color:#30693D;
width:100px;
margin-left:10px;
margin-right:5px;
}
.del
{
display:inline-block;
}
.abort{
    background-color:#A8352F;
    -moz-border-radius:4px;
    -webkit-border-radius:4px;
    border-radius:4px;display:inline-block;
    color:#fff;
    font-family:arial;font-size:13px;font-weight:normal;
    padding:4px 15px;
    cursor:pointer;
    vertical-align:top
    }
</style>
</head>
<body leftmargin="0" topmargin="0"  onLoad="areaload()">
<form name="frm" method="post">
<input type="hidden" name="idx" value="<?=$idx?>">
<input type="hidden" name="filename" size="200">
	<div id="navigation">
		<div class="header">
			<?php include $_SERVER['DOCUMENT_ROOT']."/adm/inc/head.php"; ?>
		</div>
	</div>
<div id="wrap">
	<div class="side-bar">
		<?php include $_SERVER['DOCUMENT_ROOT']."/adm/inc/sub-nav.php"; ?>
	</div>
	<div class="content">
		<table width="100%" height="35" border="0" cellpadding="0" cellspacing="0">
			<tr>
                <td>HOME > 차량관리 > 차량 수정하기</td>
			</tr>
		</table>
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
			    <td height="45"><div class="hetxt">차량 수정</div><a href="/adm/guide/guide1.html" target="top" style="float:right"><img src="/adm/image/guibtn.png"></a></td>
			</tr>
			<tr>
			    <td height="20"></td>
			</tr>
		</table>
		<!-- 등록-->
			<div class="reg-box">
			<table class="cotable"  cellpadding="5" cellspacing="0">
			<!--
				<tr> 
					<th>추천매물</th>
					<td><input type="checkbox" name="recomm" value="Y"> &nbsp;(체크 시 메인 추천매물에 노출)</td>
				</tr>
			-->
				<tr>
					<th>제조사</th>
					<td>
						<select name="maker" style="width:150px" class="frmSelect">
							<option value="">선택</option>
							<option value="현대">현대</option>
							<option value="대우">대우</option>
							<option value="스카니아">스카니아</option>
							<option value="만트럭">만트럭</option>
							<option value="볼보">볼보</option>
							<option value="벤츠">벤츠</option>
							<option value="이베코">이베코</option>
							<option value="이스즈">이스즈</option>
							<option value="기타">기타</option>
						</select>
						<script language="JavaScript">
							setComboOption($$("maker"), '<?=$edit[maker]?>')
						</script>
					</td>
				</tr>
				<tr>
					<th>메물분류</th>
					<td>
						<select name="cartype" id="ctype" onchange="javascript:changecar()" class="frmSelect">
							<option value="">분류선택</option>
							<option value="카고트럭">카고트럭ㆍ샤시차량</option>
								<option value="윙바디/냉장윙/상승윙">윙바디ㆍ냉장윙ㆍ상승윙</option>
								<option value="냉동탑차/익스탑차/탑차">냉동탑차ㆍ익스탑차ㆍ탑차</option>
								<option value="추레라/트레일러">추레라ㆍ트레일러</option>
								<option value="탱크로리/살수차/홈로리">탱크로리ㆍ살수차ㆍ홈로리</option>
								<option value="덤프/중기/건설기계">덤프ㆍ중기ㆍ중장비ㆍ건설기계</option>
								<option value="셀프로더/카캐리어/렉카">셀프로더ㆍ카캐리어ㆍ렉카</option>
								<option value="암롤/압축/진개덤프/압착">암롤ㆍ압축ㆍ진개덤프ㆍ압착</option>
								<option value="집게차/사료차/우드칩">집게차ㆍ사료차ㆍ우드칩</option>			
								<option value="카고크레인/사다리차/바가지차">카고크레인ㆍ사다리차ㆍ바가지차</option>
								<option value="기타/특수차/특장차">기타ㆍ특수차ㆍ특장차</option>
						</select>
						<script language="JavaScript">
								setComboOption($$("cartype"), '<?=$edit[cartype]?>')
						</script>
						<select name="carkind" class="frmSelect">
							<option value="">용도선택</option>
						</select>
					</td>
				</tr>
				<tr>
					<th>매물명</th>
					<td><input type="text" name="carname" size="45" value="<?=$edit[carname]?>"></td>
				</tr>
				<tr>
					<th>매물번호</th>
					<td><input name="carnum" type="text" id="carnum" size="30" value="<?=$edit[carnum]?>"></td>
				</tr>
				<tr>
					<th>메물가격</th>
					<td>
						<input name="price" type="text" id="price" size="10" value="<?=$edit[price]?>"> 만원 (숫자만입력)&nbsp;&nbsp;&nbsp;&nbsp; 또는 &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="price_t" size="10" value="<?=$edit[price_t]?>"> (단가협의 또는 전화문의는 여기에 입력)
					</td>
				</tr>
				<tr>
					<th>주행거리</th>
					<td><input name="distance" type="text" size="10" value="<?=$edit[distance]?>"> 만km (숫자만입력)</td>
				</tr>
				<tr>
					<th>연식</th>
					<td>
						<select name="makeyear" class="frmSelect">
							<option value="">선택</option>
						<? for($ii=date("Y"); $ii >= 1990; $ii--) { ?>
							<option value="<?=$ii?>" <? if($edit[makeyear]==$ii) echo "selected" ?>>
						<?=$ii?>
							</option>
						<? } ?>
						</select>
						  년 
						<select name="makemonth" class="frmSelect">
							<option value="">선택</option>
						<? for($ii=1; $ii <= 12; $ii++) { 
							 if($ii<10) $ii = "0".$ii;
						?>
						<option value="<?=$ii?>" <? if($edit[makemonth]==$ii) echo "selected" ?>>
						<?=$ii?>
						</option>
						<? } ?>
						</select>
						월
					</td>
				</tr>
				<tr>
					<th>톤수</th>
					<td>
						<select name="ton" style="width:100px;" class="frmSelect">
								<option value="">선택</option>
								<option value="1">1</option>
								<option value="1.2">1.2</option>
								<option value="1.3">1.3</option>
								<option value="1.4">1.4</option>
								<option value="1.5">1.5</option>
								<option value="2">2</option>
								<option value="2.5">2.5</option>
								<option value="3.5">3.5</option>
								<option value="4">4</option>
								<option value="4.5">4.5</option>
								<option value="5">5</option>
								<option value="5.5">5.5</option>
								<option value="6">6</option>
								<option value="6.5">6.5</option>
								<option value="7">7</option>
								<option value="7.5">7.5</option>
								<option value="8">8</option>
								<option value="8.5">8.5</option>
								<option value="9">9</option>
								<option value="9.5">9.5</option>
								<option value="10">10</option>
								<option value="10.5">10.5</option>
								<option value="11">11</option>
								<option value="11.5">11.5</option>
								<option value="12">12</option>
								<option value="13">13</option>
								<option value="13.7">13.7</option>
								<option value="14">14</option>
								<option value="14.5">14.5</option>
								<option value="15">15</option>
								<option value="15.5">15.5</option>
								<option value="16">16</option>
								<option value="17">17</option>
								<option value="17.5">17.5</option>
								<option value="18">18</option>
								<option value="18.5">18.5</option>
								<option value="19">19</option>
								<option value="19.5">19.5</option>
								<option value="20">20</option>
								<option value="21">21</option>
								<option value="21.5">21.5</option>
								<option value="22">22</option>
								<option value="22.5">22.5</option>
								<option value="23">23</option>
								<option value="23.5">23.5</option>
								<option value="24">24</option>
								<option value="25">25</option>
								<option value="25.5">25.5</option>
								<option value="26">26</option>
								<option value="27">27</option>
								<option value="29">29</option>
								<option value="30">30</option>
								<option value="30.5">30.5</option>
								<option value="31">31</option>
								<option value="31.5">31.5</option>
								<option value="32">32</option>
								<option value="35">35</option>
								<option value="40">40</option>
								<option value="45">45</option>
								<option value="50">50</option>
								<option value="기타">기타</option>
						</select>
							<script language="JavaScript">
								setComboOption($$("ton"), '<?=$edit[ton]?>')
							</script>
					</td>
				</tr>
				<tr>
					<th>* 변속기</th>
					<td>
						<select name="gear" class="frmSelect">
							<option value="">-선택-</option>
							<option value="수동">수동</option>
							<option value="오토">오토</option>
							<option value="세미오토">세미오토</option>
						</select>
						<script language="JavaScript">
							setComboOption($$("gear"), '<?=$edit[gear]?>')
						</script>
					</td>
				</tr>
				<tr>
					<th>* 색상</th>
					<td>
							<select name="color" class="frmSelect">
								<option value="흰색">흰색</option>
								<option value="검정">검정</option>
								<option value="은색">은색</option>
								<option value="청색">청색</option>
								<option value="자주">자주</option>
								<option value="녹색">녹색</option>
								<option value="은회색">은회색</option>
								<option value="빨강">빨강</option>
								<option value="갈색">갈색</option>
								<option value="쥐색">쥐색</option>
								<option value="노랑">노랑</option>
								<option value="주황색">주황색</option>
								<option value="금색">금색</option>
								<option value="은하색">은하색</option>
								<option value="진주색">진주색</option>
								<option value="담녹색">담녹색</option>
								<option value="갈대색">갈대색</option>
								<option value="연금색">연금색</option>
								<option value="흰색투톤">흰색투톤</option>
								<option value="은색투톤">은색투톤</option>
								<option value="청색투톤">청색투톤</option>
								<option value="기타투톤">기타투톤</option>
								<option value="노랑투톤">노랑투톤</option>
								<option value="기타">기타</option>
							</select>
							<script language="JavaScript">
								setComboOption($$("color"), '<?=$edit[color]?>')
							</script>
					</td>
				</tr>
				<tr>
					<th>압류</th>
					<td>
						<select name="seize" class="frmSelect">
							<option value="없음">없음</option>
							<option value="있음">있음</option>
						</select>
						<script language="JavaScript">
							setComboOption($$("seize"), '<?=$edit[seize]?>')
						</script>
					</td>
				</tr>
				<tr>
					<th>저당</th>
					<td>
						<select name="pledge" class="frmSelect">
							<option value="없음">없음</option>
							<option value="있음">있음</option>
						</select>
						<script language="JavaScript">
							setComboOption($$("pledge"), '<?=$edit[pledge]?>')
						</script>
					</td>
				</tr>
				<!--
				<tr>
					<th>* 세금미납</th>
					<td>
						<select name="tax" class="frmSelect">
							<option value="없음">없음</option>
							<option value="있음">있음</option>
						</select>
						<script language="JavaScript">
							setComboOption($$("tax"), '<?=$edit[tax]?>')
						</script>
					</td>
				</tr>
				-->
				<tr>
					<th>적재함/윙길이</th>
					<td><input type="radio" name="boxlong" value=""<? if($edit[boxlong]=="&nbsp;&nbsp;") { ?>checked<? } ?>>&nbsp;&nbsp;<input type="text" name="boxlong_text" value="<?=$edit[boxlong_text]?>">&nbsp;<input type="radio" name="boxlong" value="단축" <? if($edit[boxlong]=="단축") { ?>checked<? } ?>>단축 &nbsp;&nbsp;&nbsp;&nbsp; <input type="radio" name="boxlong" value="중축" <? if($edit[boxlong]=="중축") { ?>checked<? } ?>>중축 &nbsp;&nbsp;&nbsp;&nbsp; <input type="radio" name="boxlong" value="초장축" <? if($edit[boxlong]=="초장축") { ?>checked<? } ?>>초장축 &nbsp;&nbsp;&nbsp;&nbsp; <input type="radio" name="boxlong" value="7m" <? if($edit[boxlong]=="7m") { ?>checked<? } ?>>7m &nbsp;&nbsp;&nbsp;&nbsp; <input type="radio" name="boxlong" value="7m40" <? if($edit[boxlong]=="7m40") { ?>checked<? } ?>>7m40 &nbsp;&nbsp;&nbsp;&nbsp; </td>
				</tr>
				<tr>
					<th>축</th>
					<td><input type="radio" name="shaft" value="단발이" <? if($edit[shaft]=="단발이") { ?>checked<? } ?>>단발이 &nbsp;&nbsp;&nbsp;&nbsp; <input type="radio" name="shaft" value="앞축" <? if($edit[shaft]=="앞축") { ?>checked<? } ?>>앞축 &nbsp;&nbsp;&nbsp;&nbsp; <input type="radio" name="shaft" value="후축" <? if($edit[shaft]=="후축") { ?>checked<? } ?>>후축 &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="shaft" value="중축" <? if($edit[shaft]=="중축") { ?>checked<? } ?>>중축 &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="shaft" value="2*3축" <? if($edit[shaft]=="2*3축") { ?>checked<? } ?>>2*3축</td>
				</tr>
				<tr>
					<th>유튜브영상</th>
					<td>
						<textarea name="yurl" id="yurl" rows="3" style="width:100%; border:1px solid #a9a9a9;"><?=$edit[url]?></textarea>
						※ 유튜브영상은 반드시 소스복사를 해서 등록하세요.
					</td>
				</tr>
				<tr>
					<th>매물상세정보</th>
					<td><textarea name="content" id="content" rows="25" style="width:100%"><?=$edit[content]?></textarea></td>
				</tr>
				<tr>
					<th>관리자메모</th>
					<td><input name="bigo" type="text" id="bigo" size="180" value="<?=$edit[bigo]?>"></td>
				</tr>
				<tr>
					<th>이미지등록</th>
					<td>
						<div id="dragandrophandler">이미지를 드래그하여 이곳에 놓으십시오<br><br><span class="exp">대표이미지는 첫번째 이미지이며, 등록순으로 이미지가 보여집니다</span></div>
						<?
							$query = "select * from carinfo_img where j_idx=$idx and j_file<>'' order by j_no desc";
							$result = $db_function->select_db($query,$dbconn);	
					
							while($rs=mysql_fetch_array($result))
							{
						?>
						<div id="d<?=$rs[idx]?>" class="statusbar" style="background:#efefef;">
							<div class='filename'><?=$rs[j_file_org]?></div>
							<div class="filesize"><?=$rs[j_filesize]?></div>
							<div class='progressBar'><div style="width:100%;"></div></div>
							<div class="del"><a href="javascript:del_div2('d<?=$rs[idx]?>')">del</a></div>
							<input type="hidden" name="attachfile[]" value="<?=$rs[j_file]?>">
							<input type="hidden" name="fname[]" value="<?=$rs[j_file_org]?>">
							<input type="hidden" name="fsize[]" value="<?=$rs[j_filesize]?>">
						</div>
						<? } ?>
						<div id="editdata"></div>
						<script>
							function sendFileToServer(formData,status)
							{
								var uploadURL ="upload.php"; //Upload URL
								var extraData ={}; //Extra Data.
								var jqXHR=$.ajax({
										xhr: function() {
										var xhrobj = $.ajaxSettings.xhr();
										if (xhrobj.upload) {
												xhrobj.upload.addEventListener('progress', function(event) {
													var percent = 0;
													var position = event.loaded || event.position;
													var total = event.total;
													if (event.lengthComputable) {
														percent = Math.ceil(position / total * 100);
													}
													//Set progress
													status.setProgress(percent);
												}, false);
											}
										return xhrobj;
									},
								url: uploadURL,
								type: "POST",
								contentType:false,
								processData: false,
									cache: false,
									data: formData,
									success: function(data){
										status.setProgress(100);
							 
										//$("#status1").append(data);   
										//document.frm.filename.value += data+"||";
										status.setFname(data);
									}
								}); 
							 
								status.setAbort(jqXHR);
							}

							function del_div2(rowcount)
							{
								var deleteURL ="delfile_list.php"; //Delete URL
								
								$.ajax({
								  method: "POST",
								  url: deleteURL,
								  data: { fid:rowcount }								  
								}).done(function( rcode ) {
									if(rcode == "200") {
										rowid = document.getElementById(rowcount);
										$(rowid).remove();
										//alert( "File Deleted " );
									} else {
										alert( "Error " );
									}
								});								
								//alert(rowcount);
								//rowid = document.getElementById(rowcount);
								//$(rowid).remove();
							}

							function del_div(rowcount)
							{
								var deleteURL ="delfile_list.php"; //Delete URL
								var filenm = $("#"+rowcount+" .fname input").val();
								//alert(filenm);
								$.ajax({
								  method: "POST",
								  url: deleteURL,
								  data: { fnm:filenm }								  
								}).done(function( rcode ) {
									if(rcode == "200") {
										rowid = document.getElementById(rowcount);
										$(rowid).remove();
										//alert( "File Deleted " );
									} else {
										alert( "Error " );
									}
								});								
								//alert(rowcount);
								//rowid = document.getElementById(rowcount);
								//$(rowid).remove();
							}
							 
							var rowCount=0;
							function createStatusbar(obj)
							{
								 rowCount++;
								 var row="odd";
								 if(rowCount %2 ==0) row ="even";
								 this.statusbar = $("<div id="+rowCount+" class='statusbar "+row+"'></div>");
								 this.filename = $("<div class='filename'></div>").appendTo(this.statusbar);
								 this.size = $("<div class='filesize'></div>").appendTo(this.statusbar);
								 this.progressBar = $("<div class='progressBar'><div></div></div>").appendTo(this.statusbar);
								 this.abort = $("<div class='abort'>Abort</div>").appendTo(this.statusbar);
								 $("<div class='del'><a href='javascript:del_div("+rowCount+")'>del</a></div>").appendTo(this.statusbar);
								 this.fname = $("<div class='fname'></div>").appendTo(this.statusbar);
								 this.fname_org = $("<div class='fname_org'></div>").appendTo(this.statusbar);
								 this.fsize = $("<div class='fsize'></div>").appendTo(this.statusbar);
								 obj.after(this.statusbar);
								 //$("#editdata").after(this.statusbar);
							 
								this.setFileNameSize = function(name,size)
								{
									var sizeStr="";
									var sizeKB = size/1024;
									if(parseInt(sizeKB) > 1024)
									{
										var sizeMB = sizeKB/1024;
										sizeStr = sizeMB.toFixed(2)+"MB";
									}
									else
									{
										sizeStr = sizeKB.toFixed(2)+"KB";
									}
							 
									this.filename.html(name);
									//원본파일이름
									fo = "<input type='hidden' name='fname[]' value="+name+">";
									this.fname_org.html(fo);
								
									this.size.html(sizeStr);
									//파일사이즈
									fs = "<input type='hidden' name='fsize[]' value="+sizeStr+">";
									this.fsize.html(fs);
								}
								this.setFname = function(fm)
								{
									//alert(fm);
									ip = "<input type='hidden' name='attachfile[]' value="+fm+">";
									this.fname.html(ip);
								}
								this.setProgress = function(progress)
								{       
									var progressBarWidth =progress*this.progressBar.width()/ 100;  
									this.progressBar.find('div').animate({ width: progressBarWidth }, 10).html(progress + "% ");
									if(parseInt(progress) >= 100)
									{
										this.abort.hide();
									}
								}
								this.setAbort = function(jqxhr)
								{
									var sb = this.statusbar;
									this.abort.click(function()
									{
										jqxhr.abort();
										sb.hide();
									});
								}
							}
							function handleFileUpload(files,obj)
							{
							   for (var i = 0; i < files.length; i++) 
							   {
									var fd = new FormData();
									fd.append('file', files[i]);
							 
									var status = new createStatusbar(obj); //Using this we can set progress.
									status.setFileNameSize(files[i].name,files[i].size);
									sendFileToServer(fd,status);
							 
							   }
							}

							$(document).ready(function()
							{
							var obj = $("#dragandrophandler");
							obj.on('dragenter', function (e) 
							{
								e.stopPropagation();
								e.preventDefault();
								$(this).css('border', '2px solid #0B85A1');
							});
							obj.on('dragover', function (e) 
							{
								 e.stopPropagation();
								 e.preventDefault();
							});
							obj.on('drop', function (e) 
							{
							 
								 $(this).css('border', '2px dotted #0B85A1');
								 e.preventDefault();
								 var files = e.originalEvent.dataTransfer.files;
							 
								 //We need to send dropped files to Server
								 handleFileUpload(files,obj);
							});
							$(document).on('dragenter', function (e) 
							{
								e.stopPropagation();
								e.preventDefault();
							});
							$(document).on('dragover', function (e) 
							{
							  e.stopPropagation();
							  e.preventDefault();
							  obj.css('border', '2px dotted #0B85A1');
							});
							$(document).on('drop', function (e) 
							{
								e.stopPropagation();
								e.preventDefault();
							});
							 
							});
						</script>
					</td>
			  </tr>
			</table>
			</div>
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
			  <tr>
			    <td height="50" align="center"><a href="javascript:save()" class="reg-bti">차량수정</a></td>
			  </tr>
			</table>
			<!-- //등록-->
	</div>
</div>
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