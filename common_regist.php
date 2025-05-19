<?php
    // 기본 파일 포함 (데이터베이스 연결, 함수 등)
    include $_SERVER["DOCUMENT_ROOT"]."/common/db_info.php";
    include $_SERVER["DOCUMENT_ROOT"]."/common/myFunction.php";
    
    // 데이터베이스 연결 설정
    $db_function = new db_function();
    
    include $_SERVER["DOCUMENT_ROOT"]."/common/CommonLib.php";
    
    // 관리자 로그인 확인
    if(!$_SESSION['admin_id']){
        echo "<script language=javascript>
              location.href = '/adm/';
              </script>";
    }
    
    // 사이트 정보 설정
    $current_site = isset($current_site) ? $current_site : '';
    
    // 사이트 목록 정의 - API config 파일에서 가져오도록 수정 필요
    $sites = array(
    'jstruck' => 'https://xn--wl2bl5nu4g3ok.com/api/ctruck/create.php', // 주상트럭.com (https)
    'truk' => 'http://truk.co.kr/api/ctruck/create.php',                // http로 수정
    'truckpark' => 'http://truckpark.kr/api/ctruck/create.php',         // http로 수정
    'truck8949' => 'http://truck8949.kr/api/ctruck/create.php'          // http로 수정
);
    
    $dtitle = "";
    if($dflag == "direct") {
        $dtitle = "직거래 ";
    }
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
    <title><?php include $_SERVER['DOCUMENT_ROOT']."/adm/inc/admin_title.php"; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!-- 자바스크립트 및 CSS 파일 포함 -->
    <script language="javascript" src="/common/CommonLib.js"></script>
    <link href="/adm/css/common.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="/adm/dist/sidebar-menu.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script type="text/javascript" src="/common/editor/js/HuskyEZCreator.js" charset="utf-8"></script>
<script language="javascript">
    function save()
    {
        // 텍스트 에디터 업데이트
        oEditors.getById["content"].exec("UPDATE_CONTENTS_FIELD", []);
        
        var frm = document.frm;
        
        // 필수 필드 검증
        if(!frm.cartype.value){
            alert("차량용도를 선택하세요.");
            frm.cartype.focus();
            return;
        }
        if(!frm.distance.value){
            alert("주행거리를 입력하세요.");
            frm.distance.focus();
            return;
        }
        if (isNaN(frm.distance.value)) {
            alert("주행거리는 숫자만 입력하세요.");
            frm.distance.focus();
            return;
        }
        
        // 동기화할 사이트 체크 확인 - 공통 차량등록을 위한 중요 검증
        var chk = false;
        var sync_sites = document.getElementsByName('sync_sites[]');
        for (var i = 0; i < sync_sites.length; i++) {
            if (sync_sites[i].checked) {
                chk = true;
                break;
            }
        }
        
        if (!chk) {
            alert("동기화할 사이트를 하나 이상 선택하세요.");
            return;
        }
        
        // 폼 제출
        frm.action = "common_regist_ok.php";
        frm.target = "_self";
        frm.submit();
    }
</script>
<script>
function deletec_kindCategory() {
        var overMaxNum = 60;
        for (var k=0 ; k < overMaxNum ; k++) {
        document.frm.carkind.options.remove(0);
        }
    }
    
function changecar() {
    // 차량 유형에 따른 세부 분류 설정
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
        
        if(SI_VALUE[k] == "<?=$NI_b_gu?>"){
        newOpt.selected = true;
        }
        
        document.frm.carkind.options.add(newOpt);
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

/* 공통 차량 등록용 추가 스타일 */
.sync-sites {
    padding: 15px;
    border: 1px solid #ddd;
    margin-bottom: 20px;
    background-color: #f9f9f9;
}
.sync-sites h3 {
    margin-top: 0;
    padding-bottom: 10px;
    border-bottom: 1px solid #eee;
}
.sync-sites ul {
    list-style: none;
    padding: 0;
    margin: 0;
}
.sync-sites li {
    padding: 5px 0;
}
.site-label {
    display: inline-block;
    width: 150px;
    font-weight: bold;
}
</style>
</head>
<body leftmargin="0" topmargin="0" id="car">
<form name="frm" method="post">
<input type="hidden" name="direct" value="<?php echo $dflag;?>">
<input type="hidden" name="origin_site" value="<?php echo $current_site; ?>">
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
                <td>HOME > 차량관리 > 공통 차량 등록하기</td>
            </tr>
        </table>
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td height="45"><div class="hetxt">공통 차량 등록</div><a href="/adm/guide/guide1.html" target="top" style="float:right"><img src="/adm/image/guibtn.png"></a></td>
            </tr>
            <tr>
                <td height="20"></td>
            </tr>
        </table>
        
        <!-- 동기화 사이트 선택 섹션 (새로 추가) -->
<div class="sync-sites">
    <h3>차량 등록을 동기화할 사이트 선택</h3>
    <p>선택한 모든 사이트에 차량이 동일하게 등록됩니다. 최소 1개 이상 선택해야 합니다.</p>
    <ul>
        <?php 
        // 현재 사이트를 제외한 나머지 사이트 목록 표시
        foreach ($sites as $site_code => $site_name) {
            if ($site_code != $current_site) { // 현재 사이트는 제외
                echo '<li>';
                echo '<input type="checkbox" name="sync_sites[]" id="site_'.$site_code.'" value="'.$site_code.'" checked>';
                echo '<label for="site_'.$site_code.'"><span class="site-label">'.$site_name.'</span></label>';
                echo '</li>';
            }
        }
        ?>
    </ul>
</div>
        
        <!-- 등록 폼 (기존 regist.php 코드 재사용) -->
<div class="reg-box">
<table class="cotable"  cellpadding="5" cellspacing="0">
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
        </td>
    </tr>
    <tr>
        <th>매물분류</th>
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
            <select name="carkind" class="frmSelect">
                <option value="">용도선택</option>
            </select>
        </td>
    </tr>
    <tr>
        <th>매물명</th>
        <td><input type="text" name="carname" size="45"></td>
    </tr>
    <tr>
        <th>매물번호</th>
        <td><input name="carnum" type="text" id="carnum" size="30"></td>
    </tr>
    <tr>
        <th>매물가격</th>
        <td>
            <input name="price" type="text" id="price" size="10"> 만원 (숫자만입력)&nbsp;&nbsp;&nbsp;&nbsp; 또는 &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="price_t" size="10"> (단가협의 또는 전화문의는 여기에 입력)
        </td>
    </tr>
    <tr>
        <th>주행거리</th>
        <td><input name="distance" type="text" size="10"> 만km (숫자만입력)</td>
    </tr>
    <tr>
        <th>차량연식</th>
        <td>
            <select name="makeyear" class="frmSelect">
                <option value="">선택</option>
                <?php for($ii=date("Y"); $ii >= 1990; $ii--) { ?>
                <option value="<?=$ii?>">
                <?=$ii?>
                </option>
                <?php } ?>
            </select>
             년 
            <select name="makemonth" class="frmSelect">
                <option value="">선택</option>
                <?php for($ii=1; $ii <= 12; $ii++) { 
                     if($ii<10) $ii = "0".$ii;
                ?>
                <option value="<?=$ii?>">
                <?=$ii?>
                </option>
                <?php } ?>
            </select>
            월
        </td>
    </tr>
    <tr>
        <th>톤수선택</th>
        <td>
            <select name="ton" class="frmSelect">
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
        </td>
    </tr>
    <tr>
        <th>변속기</th>
        <td>
            <select name="gear" class="frmSelect">
                <option value="">선택</option>
                <option value="수동">수동</option>
                <option value="오토">오토</option>
                <option value="세미오토">세미오토</option>
            </select>
        </td>
    </tr>
    <tr>
        <th>색상</th>
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
        </td>
    </tr>
    <tr>
        <th>압류여부</th>
        <td>
            <select name="seize" class="frmSelect">
                <option value="없음">없음</option>
                <option value="압류">압류</option>
                <option value="가압류">가압류</option>
                <option value="설정">설정</option>
            </select>
        </td>
    </tr>
    <tr>
        <th>저당여부</th>
        <td>
            <select name="pledge" class="frmSelect">
                <option value="없음">없음</option>
                <option value="저당">저당</option>
            </select>
        </td>
    </tr>
    <tr>
        <th>적재함/윙길이</th>
        <td>
            <input type="radio" name="boxlong" value="" checked>&nbsp;&nbsp;
            <input type="text" name="boxlong_text" value="">&nbsp;
            <input type="radio" name="boxlong" value="단축">단축 &nbsp;&nbsp;&nbsp;&nbsp; 
            <input type="radio" name="boxlong" value="중축">중축 &nbsp;&nbsp;&nbsp;&nbsp; 
            <input type="radio" name="boxlong" value="초장축">초장축 &nbsp;&nbsp;&nbsp;&nbsp; 
            <input type="radio" name="boxlong" value="7m">7m &nbsp;&nbsp;&nbsp;&nbsp; 
            <input type="radio" name="boxlong" value="7m40">7m40 &nbsp;&nbsp;&nbsp;&nbsp;
        </td>
    </tr>
    <tr>
        <th>축</th>
        <td>
            <input type="radio" name="shaft" value="단발이" checked> 단발이 &nbsp;&nbsp;&nbsp;&nbsp; 
            <input type="radio" name="shaft" value="앞축"> 앞축 &nbsp;&nbsp;&nbsp;&nbsp; 
            <input type="radio" name="shaft" value="후축"> 후축 &nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" name="shaft" value="중축"> 중축 &nbsp;&nbsp;&nbsp;&nbsp;
            <input type="radio" name="shaft" value="2*3축"> 2*3축
        </td>
    </tr>
    <tr>
        <th>유튜브영상</th>
        <td>
            <textarea name="yurl" id="yurl" rows="3" style="width:100%; border:1px solid #a9a9a9;"></textarea>
            ※ 유튜브영상은 반드시 소스복사를 해서 등록하세요.
        </td>
    </tr>
    <tr>
        <th>매물상세정보</th>
        <td><textarea name="content" id="content" rows="25" style="width:100%"></textarea></td>
    </tr>
    <tr>
        <th>관리자메모</th>
        <td><input name="bigo" type="text" id="bigo" size="180"></td>
    </tr>
    <tr>
        <th>이미지등록</th>
        <td colspan="5" style="padding-left:10px; padding-top:15px;">
            <div id="dragandrophandler">이미지를 드래그하여 이곳에 놓으십시오<br><br><span class="exp">대표이미지는 첫번째 이미지이며, 등록순으로 이미지가 보여집니다</span><br><span class="exp">이미지는 크기는 가로1024 또는 640을 권장합니다.</span></div>
            <br>
            <div id="status1"></div>
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
                     //실제 파일명,원본파일명,파일사이즈 값을 넘기기위한 
                     this.fname = $("<div class='fname'></div>").appendTo(this.statusbar);
                     this.fname_org = $("<div class='fname_org'></div>").appendTo(this.statusbar);
                     this.fsize = $("<div class='fsize'></div>").appendTo(this.statusbar);
                     obj.after(this.statusbar);
                 
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
        <td height="50" align="center"><a href="javascript:save()" class="reg-bti">공통 차량등록</a></td>
    </tr>
</table>
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
        bUseToolbar : true,                // 툴바 사용 여부 (true:사용/ false:사용하지 않음)
        bUseVerticalResizer : true,        // 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
        bUseModeChanger : true,            // 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
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
    oEditors.getById["content"].exec("UPDATE_CONTENTS_FIELD", []);    // 에디터의 내용이 textarea에 적용됩니다.
    
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