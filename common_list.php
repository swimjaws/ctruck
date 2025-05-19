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
    $where_query = " where is_common = 1 ";  // 공통 차량만 표시

    //해당 게시판 글 가져오기   
    if(!$pagenum || $pagenum < 0) $pagenum=0;
    
    if($no) $strquery .= " and carnum='$no'";
    if($name) $strquery .= " and carname like '%$name%'";
    if($carnum) $strquery .= " and carnum like '%$carnum%'";
    if($maker) $strquery .= " and maker='$maker'";
    if($gear) $strquery .= " and gear='$gear'";
    if($ston) $strquery .= " and replace(ton,'t','')>='$ston'";
    if($eton) $strquery .= " and replace(ton,'t','')<='$eton'";
    if($smade) $strquery .= " and makeyear>='$smade'";
    if($emade) $strquery .= " and makeyear<='$emade'";
    if($sprice) $strquery .= " and price>='$sprice'";
    if($eprice) $strquery .= " and price<='$eprice'";
    
    if($cartype) $strquery .= " and cartype='$cartype'";
    if($carkind) $strquery .= " and carkind='$carkind'";
    if($boxlong) $strquery .= " and boxlong='$boxlong'";
    if($ton) $strquery .= " and ton='$ton'";

    $strquery = substr($strquery,5);
    
    if(!$strquery){
        $query = "select count(*) from carinfo ".$where_query;
        $total = mysql_fetch_array($db_function->select_db($query,$dbconn));
        $total = $total["count(*)"];

        $page = 20;
        $pagesu = ceil($total/$page);
        $start = $page*$pagenum;

        $query = "select * from carinfo ".$where_query." order by issale desc, reg_date desc limit $start,$page";
        $result = $db_function->select_db($query,$dbconn);    
    }else{
        $query = "select count(*) from carinfo ".$where_query." and ".$strquery;
        $total = mysql_fetch_array($db_function->select_db($query,$dbconn));
        $total = $total["count(*)"];

        $page = 20;
        $pagesu = ceil($total/$page);
        $start = $page*$pagenum;

        $query = "select * from carinfo ".$where_query." and ".$strquery." order by issale desc, reg_date desc limit $start,$page";
        $result = $db_function->select_db($query,$dbconn);
    }
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
        frm.action = "common_list.php";
        frm.target = "_self";
        frm.submit();
}

function page(pagenum)
{
    var frm = document.frm;
        frm.pagenum.value = pagenum;
        frm.action = "common_list.php";
        frm.target = "_self";
        frm.submit();
}

function seldel()
{
    if ( ! checkedRadio($L("chk[]"), "삭제대상을")) return;
    if(confirm("선택한 목록을 삭제하시겠습니까?"))
    {
        var frm = document.frm;
            frm.action = "common_deleteall.php";
            frm.target = "iProc";
            frm.submit();
    }
}

function best()
{
    if ( ! checkedRadio($L("chk[]"), "차량을")) return;
    
        var frm = document.frm;
            frm.action = "best.php";
            frm.target = "iProc";
            frm.submit();
}

function best_cancel()
{
    if ( ! checkedRadio($L("chk[]"), "차량을")) return;
    
        var frm = document.frm;
            frm.action = "best_cancel.php";
            frm.target = "iProc";
            frm.submit();
}

function issale(idx,pagenum)
{
    if(confirm("판매완료로 바꾸시겠습니까?"))
    {
        var frm = document.frm;
            frm.idx.value = idx;
            frm.action = "common_end.php";
            frm.target = "iProc";
            frm.submit();
    }
}
    
function issale2(idx,pagenum)
{
    if(confirm("판매중으로 바꾸시겠습니까?"))
    {
        var frm = document.frm;
            frm.idx.value = idx;
            frm.action = "common_ing.php";
            frm.target = "iProc";
            frm.submit();
    }
}

function view(idx,pagenum)
{
    var frm = document.frm;
        frm.idx.value = idx;
        frm.pagenum.value = pagenum;
        frm.action = "common_view.php";
        frm.target = "_self";
        frm.submit();
}

function performance(idx)
{
    turl = "performance.php?idx=" + idx;
    openWin(turl, "idch", 520, 142,null,null,null,'yes');  
}

function performance_edit(idx)
{
    turl = "performance_edit.php?idx=" + idx;
    openWin(turl, "idch", 520, 142,null,null,null,'yes');  
}

function result_ok()
{
    location.reload();
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
                <td>HOME > 차량관리 > 공통 차량 리스트</td>
            </tr>
        </table>
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td height="45"><div class="hetxt">공통 차량 리스트</div><a href="/adm/guide/guide2.html" target="top" style="float:right"><img src="/adm/image/guibtn.png"></a></td>
            </tr>
        </table>
        <!-- 검색 -->
        <div class="reg-box">
                  <table class="cotable"  cellpadding="5" cellspacing="0">
                      <tr> 
                        <th>매물번호</th>
                        <td style="padding-left:10px;"><input type="text" name="carnum" size="10"></td>
                        <th>제조사</th>
                        <td style="padding-left:10px;">
                                <select name="maker" onchange="javascript:changecar()" style="width:120px" class="frmSelect">
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
                                <?php if(!empty($maker)) { ?>
                                <script language="JavaScript">
                                    setComboOption($("maker"), '<?=$maker?>')
                                </script>
                                <?php } ?>
                        </td>
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
                        <th>톤수선택</th>
                    <td>
                        <select name="ton" class="frmSelect">
                                <option value="">선택</option>
                                <option value="0.5">0.5</option>
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
                    </table>
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td height="50" align="center"><a href="javascript:searchlist()" class="reg-sti">검색</a></td>
                  </tr>
                </table>
        </div>
            <!-- //검색 -->
            <p style="margin-top:20px"></p>
            <!-- 리스트 -->
            <div class="reg-box">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr> 
                  <td height="40" align="right"><a href="common_regist.php"><img src="/adm/image/bt_regist.gif" width="67" height="30" border="0"></a></td>
                </tr>
            </table>
            <table class="cotable thread"  cellpadding="5" cellspacing="0">
              <colgroup>
                <col style="width:60px" />
                <col style="width:80px" />
                <col style="width:130px" />
                <col style="width:100px" />
                <col/>    
                <col style="width:120px" />
                <col style="width:110px" />
                <col style="width:120px" />
                <col style="width:100px" />
              </colgroup>
              <tr bgcolor="#dfe3e6"> 
                <th><input type="checkbox" name="chkall" onClick="javascript:setCheckAll($L('chk[]'), this.checked)"></th>
                    <th>No.</th>
                    <th>이미지</th>
                    <th>매물번호</th>
                    <th>차량정보</th>
                    <th>차량번호</th>
                    <th>판매가격</th>
                    <th>등록일</th>
                    <th>성능점검표</th>
                    <th>상태</th>
                    <th>판매유무</th>
                    <th>원래 사이트</th>
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
                <td align="center" style="border-left:1px solid #dedede;"><input type="checkbox" name="chk[]" value="<?=$rs[idx]?>"></td>
                <td height="35" align="center"><?=$listno?></td>
                <td height="116" align="center"><a href="javascript:view('<?=$rs[idx]?>','<?=$pagenum?>')"><img src="/carimg/<?=$car_img[j_file]?>?v=<?=$car_img[idx]?>" width="120" height="96"></a></td>
                <td height="35" align="center"><?=$rs[carnum]?></td>
                <td>
                    <div>
                        <h3><?=$rs[carname]?></h3>
                        <p><?=$rs[maker]?> <?=$rs[makeyear]?>년 <?=$rs[makemonth]?>월 / <?=$rs[ton]?>톤 / <?=number_format($rs[distance])?>만km</p>
                        <p><?=$rs[bigo]?></p>
                    </div>
                </td>
                <td align="center"><?=$rs[carnumber]?></td>
                <td align="center" style="font-weight:bold; color:#ff0000;">
                <? if($rs[price]==0) { ?>
                    <?=$rs[price_t]?>
                <? } else {?>
                    <?=number_format($rs[price])?> 만원
                <? } ?>
                </td>
                <td align="center"><?=$rs[reg_date]?></td>
                <td align="center">
                        <? if($rs[ispfm]=='N') { ?>
                            <a href="/adm/performance/pregist.php?idx=<?=$rs[idx]?>&carname=<?=$rs[carname]?>&carnumber=<?=$rs[carnumber]?>&pregyear=<?=$rs[makeyear]?>&pfirstyear=<?=$rs[makeyear]?>&mon=<?=$rs[makemonth]?>&pidnum=<?=$rs[pidnum]?>" class="pfmregbtn">성능표등록</a>
                        <? } else {?>
                            <a href="/adm/performance/pmodify.php?idx=<?=$rs[idx]?>" class="pfmedtbtn">성능표수정</a>
                        <? } ?>
                </td>
                <td width="100" align="center">
                    <? if($rs[best_Fl]=='Y') { ?><p style="padding-top:5px;"><img src="/adm/image/best.gif"></p><? } ?>
                </td>
                <td width="100" align="center">
                    <? if($rs[issale]=='Y') { ?><a href="javascript:issale('<?=$rs[idx]?>','<?=$pagenum?>')"><img src="/adm/image/sell_ing.gif" border="0"></a><? } else { ?><a href="javascript:issale2('<?=$rs[idx]?>','<?=$pagenum?>')"><img src="/adm/image/sell_ok.gif" border="0"></a><? } ?>
                </td>
                <td width="100" align="center">
                    <?=$rs[origin_site]?>
                </td>
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
                <div class="paging" style="margin-bottom:0;">
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
            <div class="btnlist" style="padding-bottom:100px;">
                <ul class="btn_bo_adm">
                    <li><input type="submit" name="btn_submit" value="추천등록" onclick="javascript:best()"></li>
                    <li><input type="submit" name="btn_submit" value="추천취소" onclick="javascript:best_cancel()"></li>
                    <li><input type="submit" name="btn_submit" value="선택삭제" onclick="javascript:seldel()"></li>
                </ul>
            </div>
    </div>
</div>
</form>
</body>
</html>