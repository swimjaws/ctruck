<?
    include $_SERVER["DOCUMENT_ROOT"]."/common/db_info.php";
    include $_SERVER["DOCUMENT_ROOT"]."/common/myFunction.php";
    
    #######################################
    # DBConnection u
    $db_function = new db_function();
    #######################################
    
    include $_SERVER["DOCUMENT_ROOT"]."/common/CommonLib.php";
    
    // 한글 인코딩 문제 해결을 위한 설정
    header("Content-Type: text/html; charset=utf-8");
    mysql_query("SET NAMES 'utf8'");
    mysql_query("SET CHARACTER SET utf8");
    mysql_query("SET SESSION collation_connection = 'utf8_general_ci'");
    
    if(!$_SESSION['admin_id']){
    echo "<script language=javascript>
          location.href = '/adm/';
          </script>";
    }
?>
<?
    $query = "select * from carinfo where idx=$idx";
    $view = mysql_fetch_array($db_function->select_db($query,$dbconn));
    
    $idx = $view['idx'];
    $positions= $view['position'];
    $model = $view['model'];
    
    if($view['ton']=="120"){
        $view['ton']="1.2";
    } 
    if($view['ton']=="140"){
        $view['ton']="1.4";
    } 
    
    $tons = $view['ton'];
    $price = $view['price'];
    
    $memo = stripslashes($view['memo']);
    $content = stripslashes($view['content']);
    
    // 공통 차량 정보 가져오기
    $is_common = $view['is_common'];
    $common_id = $view['common_id'];
    $origin_site = $view['origin_site'];
    
    // 원본 사이트 이름 표시용 변환
    $site_names = array(
        'jstruck' => '주상트럭.com',
        'truk' => 'truk.co.kr',
        'truckpark' => 'truckpark.kr',
        'truck8949' => 'truck8949.kr'
    );
    
    $origin_site_name = isset($site_names[$origin_site]) ? $site_names[$origin_site] : $origin_site;
    
    // API 동기화 상태 확인 (실제 구현 시 필요한 로직)
    // 예시: 각 사이트별 동기화 상태를 배열로 저장
    $sync_status = array(
        'jstruck' => true,
        'truk' => true,
        'truckpark' => true,
        'truck8949' => true
    );
    
    $uri = $position;
    $uri = $positions." - ".$model." - ".$tons."톤 - ".$price."만원";
    $uri = urldecode($uri);
    $sql_vu = " insert g4_visit_uri ( vu_ip, vu_date, vu_uri, vu_idx ) values ( '$_SERVER[REMOTE_ADDR]', '$g4[time_ymd]', '$uri', '$idx' ) ";
    $db_function->insert_db($sql_vu,$dbconn);
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
<style>
.sync-status {
    margin-top: 15px;
    border: 1px solid #ddd;
    padding: 15px;
    background-color: #f9f9f9;
}
.sync-status h3 {
    margin-top: 0;
    margin-bottom: 10px;
    font-size: 16px;
    font-weight: bold;
}
.sync-status ul {
    list-style: none;
    padding: 0;
    margin: 0;
}
.sync-status ul li {
    padding: 5px 0;
    border-bottom: 1px dotted #eee;
}
.sync-status .site {
    display: inline-block;
    width: 150px;
}
.sync-status .status {
    display: inline-block;
    width: 80px;
    text-align: center;
}
.sync-status .status.success {
    color: #28a745;
    font-weight: bold;
}
.sync-status .status.fail {
    color: #dc3545;
    font-weight: bold;
}
.origin-site {
    background-color: #fffde7;
    padding: 5px 10px;
    border-radius: 3px;
    font-weight: bold;
    display: inline-block;
    margin-left: 10px;
}
</style>
<script>
function changeImg(name)
{
    if (document.images){
        document.images.imgzone.src=name
    }
}

function list()
{
    var frm = document.frm;
        frm.action = "common_list.php";
        frm.target = "_self";
        frm.submit();
}

function modify()
{
    var frm = document.frm;
        frm.action = "common_modify.php"
        frm.submit();
}
    
function del()
{
    if(confirm("삭제하시겠습니까? 공통 차량을 삭제하면 동기화된 모든 사이트에서 삭제됩니다.")){
        var frm = document.frm;
            frm.action = "common_delete.php";
            frm.target = "iProc";
            frm.submit();
    }
}

function sync_all()
{
    if(confirm("모든 사이트에 동기화를 재시도하시겠습니까?")){
        var frm = document.frm;
            frm.action = "common_sync.php";
            frm.target = "iProc";
            frm.submit();
    }
}

function performanceview(idx)
{
    turl = "/adm/performance/pview.php?idx=" + idx;
    openWin(turl, "idch", 840, 900,null,null,null,'yes');  
}

function dealer()
{
    turl = "/adm/dealer/dealer.php";
    openWin(turl, "idch", 420, 580,null,null,null,'no');  
}

function open_cate()
{
    document.getElementById('cate-nwrap').style.display = "block";
}

function close_cate()
{
    document.getElementById('cate-nwrap').style.display = "none";
}
</script>
</head>
<body leftmargin="0" topmargin="0" onLoad="" id="car">
<form name="frm">
<input type="hidden" name="idx" value="<?=$idx?>">
<input type="hidden" name="pagenum" value="<?=$pagenum?>">
<input type="hidden" name="carnum" value="<?=$carnum?>">
<input type="hidden" name="maker" value="<?=$maker?>">
<input type="hidden" name="cartype" value="<?=$cartype?>">
<input type="hidden" name="ton" value="<?=$ton?>">
<input type="hidden" name="common_id" value="<?=$common_id?>">
<input type="hidden" name="origin_site" value="<?=$origin_site?>">
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
                <td>HOME > 공통 차량 관리 > 공통 차량 상세정보</td>
            </tr>
        </table>
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td height="45"><h4><div class="hetxt">공통 차량 상세정보 <span class="origin-site">등록 사이트: <?=$origin_site_name?></span></div></h4></td>
            </tr>
        </table>
        
        <!-- 동기화 상태 정보 -->
        <div class="sync-status">
            <h3>사이트 동기화 상태</h3>
            <ul>
                <?php
                foreach($sync_status as $site => $status) {
                    if($site != $origin_site) { // 원본 사이트는 제외
                        $status_text = $status ? '<span class="status success">성공</span>' : '<span class="status fail">실패</span>';
                        $site_name = $site_names[$site] ? $site_names[$site] : $site;
                        echo '<li><span class="site">'.$site_name.'</span>'.$status_text.'</li>';
                    }
                }
                ?>
            </ul>
            <div style="margin-top: 10px;">
                <a href="javascript:sync_all()" class="cregbtn">동기화 재시도</a>
            </div>
        </div>
        
        <!-- 상세정보 -->
        <div class="reg-box">
            <div class="viewarea">
                <div class="viewimg">
                    <?
                        $sql = "select * from carinfo_img where j_idx=$idx and j_no=0";
                        $car_img = mysql_fetch_array(mysql_query($sql,$dbconn));
                    ?>
                    <div class="vimg-wrap">
                        <div class="bimg"><div class="carnum">번호 : <?=$view['carnum']?></div><img src="/carimg/<?=$car_img['j_file']?>?v=<?=$car_img['idx']?>" name="imgzone" width="636"></div>
                        <div class="sumnail">
                            <ul>
                            <?
                                $query = "select * from carinfo_img where j_idx=$idx order by j_no asc";
                                $result = $db_function->select_db($query,$dbconn);  
                            ?>
                                <?
                                    while($rs=mysql_fetch_array($result))
                                    {
                                ?>
                                <li><img src="/carimg/<?=$rs['j_file']?>" width="106" height="82" style="cursor:pointer" onMouseover="changeImg('/carimg/<?=$rs['j_file']?>?v=<?=$rs['idx']?>')"></li>
                                <?  } ?>
                            </ul>
                        </div>
                        <div style="clear:both;"><a href="./img_order.php?idx=<?php echo $idx;?>" class="cregbtn">사진순서 변경하기</a></div>
                    </div>
                    <!-- 정보 -->
                    <div class="vinfo-wrap">
                        <p class="vname"> <?=$view['carname']?></p>
                        <? if($view['price']==0) { ?>
                            <p class="vprice"><?=$view['price_t']?></p>
                        <? } else { ?> 
                            <p class="vprice"><?=number_format($view['price'])?>만원</p>
                        <? } ?>
                        <div class="line"></div>
                        <div class="title">차량정보</div>
                        <div class="info">
                            <table>
                                <tr>
                                    <td class="t0">제조사</td>
                                    <td class="t3"><?=$view['maker']?></td>
                                    <td class="t0">차종</td>
                                    <td class="t3"><?=$view['cartype']?></td>
                                </tr>
                                <tr>
                                    <td class="t0">용도</td>
                                    <td class="t3"><?=$view['carkind']?></td>
                                    <td class="t0">톤수</td>
                                    <td class="t3"><?=$view['ton']?>톤</td>
                                </tr>
                                <tr>
                                    <td class="t0">연식</td>
                                    <td class="t1"><? if(!$view['makeyear']) { ?>-<? } else { ?><?=$view['makeyear']?>년 <?=$view['makemonth']?>월<? } ?></td>
                                    
                                </tr>
                                <tr>
                                    <td class="t0">변속기</td>
                                    <td class="t3"><?=$view['gear']?></td>
                                    <td class="t0">주행거리</td>
                                    <td class="t3"><?=number_format($view['distance'])?>만km</td>
                                </tr>
                                
                                <tr>
                                    <td class="t0">적재함길이</td>
                                    <td class="t3"><?=$view['boxlong']?> <?=$view['boxlong_text']?></td>
                                    <td class="t0">축</td>
                                    <td class="t3"><?=$view['shaft']?></td>
                                </tr>
                                <tr>
                                    <td class="t0">압류/저당</td>
                                    <td class="t3"><?=$view['seize']?>/<?=$view['pledge']?></td>
                                    
                                </tr>
                            </table>
                        </div>
                        <div class="line"></div>
                        <div class="title">관리자메모</div>
                        <div class="spc"><?=$view['bigo']?></div>
                        <div class="line"></div>
                        <div class="title">판매자정보</div>
                        <?
                        $query = "select * from dealer";
                        $view2 = mysql_fetch_array($db_function->select_db($query,$dbconn));
                        ?>
                        <!-- dealer -->
                        <div class="dealer">
                            <table class="view-info">
                                <tr>
                                    <td rowspan="4" class="t1" style="text-align:center; padding:0;"><img src="/uploadfiles/<?=$view2['listimg']?>" border="0" width="98" height="112"></td>
                                    <td class="t0">성명</td>
                                    <td class="t3"><?=$view2['name']?></td>
                                    <td class="t0">연락처</td>
                                    <td class="t3"><?=$view2['hp']?></td>
                                </tr>
                                <tr>
                                    <td class="t0">거래지역</td>
                                    <td colspan="3" class="t4"><?=$view2['addr']?></td>
                                </tr>
                                <tr>
                            
                            </table>
                        </div>
                        <!-- //dealer -->
                    </div>
                    <!-- //정보 -->
                    <div class="wb"></div>
                    <div class="opt_tit">차량옵션정보</div>
                        <table class="view-tbl2">
                            <tr>
                                <td width="120" class="c1">상세설명</td>
                                <td style="padding:20px 10px;"><?=$content?></td>
                            </tr>
                        </table>
                    <? if(!$view['url']) { ?>
                        &nbsp;
                    <? } else { ?>
                        <div class="opt_tit">차량영상</div>
                        <div class="mv-wrap">
                            <?=$view['url']?>
                        </div>
                    <? } ?>
                </div>
            </div>  
        </div>
    <!-- //상세정보 -->
        <table width="1500" border="0" cellpadding="0" cellspacing="0">
            <tr> 
                <td height="60" align="center">
                    <a href="javascript:list()" class="cregbtn">목록보기</a> <a href="javascript:modify()" class="cregbtn">수정하기</a> <a href="javascript:del()" class="cregbtn">삭제하기</a></td>
            </tr>
        </table>
    </div>
</div>
</form>
<iframe name="iProc" width="0" height="0" frameborder="0" scrolling="no"></iframe>
</body>
</html>