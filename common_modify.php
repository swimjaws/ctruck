<?php
    include $_SERVER["DOCUMENT_ROOT"]."/common/db_info.php";
    include $_SERVER["DOCUMENT_ROOT"]."/common/myFunction.php";
    
    #######################################
    # DBConnection u
    $db_function = new db_function();
    #######################################
    
    include $_SERVER["DOCUMENT_ROOT"]."/common/CommonLib.php";
    
    if(!$_SESSION['admin_id']){
        echo "<script language=javascript>
              location.href = '/adm/';
              </script>";
    }
?>
<?php
    $query = "select * from carinfo where idx=$idx";
    $edit = mysql_fetch_array($db_function->select_db($query, $dbconn));
    
    // 공통 차량 정보 확인
    $is_common = $edit['is_common'] == 1;
    $common_id = $edit['common_id'];
    $origin_site = $edit['origin_site'];
    
    // 동기화 대상 사이트 목록 (API config에서 가져오도록 수정 필요)
    $sites = array(
        'jstruck' => '주상트럭.com',
        'truk' => 'truk.co.kr',
        'truckpark' => 'truckpark.kr',
        'truck8949' => 'truck8949.kr'
    );
    
    // 현재 사이트 정보
    $current_site = isset($current_site) ? $current_site : '';
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
        oEditors.getById["content"].exec("UPDATE_CONTENTS_FIELD", []);    // 에디터의 내용이 textarea에 적용됩니다.
        
        //if(isEmpty($("subject"), "제목을")) return;
        
        var frm = document.frm;
        
        // 동기화할 사이트 체크 확인
        var chk = false;
        var sync_sites = document.getElementsByName('sync_sites[]');
        for (var i = 0; i < sync_sites.length; i++) {
            if (sync_sites[i].checked) {
                chk = true;
                break;
            }
        }
        
        if (!chk) {
            alert("동기화할 사이트를 하나 이상 선택해야 합니다.");
            return;
        }
        
        frm.action = "common_modify_ok.php";
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
        // 기존 changecar 함수 내용 (modify.php에서 복사)
        var chooseRight = document.frm.cartype.options[document.frm.cartype.selectedIndex].value;
        
        //카고트럭
        S_1_TEXT = ['용도선택', '카고트럭', '샤시차량'];
        S_1_VALUE = ['', '카고트럭', '샤시차량'];
    
        if(chooseRight=='카고트럭') { 
            SI_TEXT = S_1_TEXT; 
            SI_VALUE = S_1_VALUE;
        }
        
        // 나머지 차종 옵션 설정... (기존 코드 사용)
        
        deletec_kindCategory();
        
        for (var k=0 ; k < SI_TEXT.length ; k++) {
            newOpt = document.createElement("OPTION");
            newOpt.text = SI_TEXT[k];
            newOpt.value = SI_VALUE[k];
            
            if(SI_VALUE[k] == "<?=$edit['carkind']?>"){
            newOpt.selected = true;
            }
            
            document.frm.carkind.options.add(newOpt);
        }
    }
    
    function $$(pObjName, pDoc, pMsgFlag)    {
        // 기존 함수 내용 유지
        var tObjDoc = (pDoc==null) ? document : pDoc;
        if (pMsgFlag==null)    pMsgFlag = true;
    
        var tObj = tObjDoc.getElementsByName(pObjName);
        if (tObj.length==0)    {
            if (pMsgFlag) alert("[" + pObjName + "] 객체를 찾을 수 없습니다.");
            return null;
        }
        else if (tObj.length>1)    {
            if (pMsgFlag) alert("[" + pObjName + "]는 하나 이상의 객체가 존재합니다.");
            return null;
        }
        else    {    // 첫번째 객체를 반환한다.
            return tObj[0];
        }
    }
    
    function setComboOption (pObjCombo, pValue)    {
        // 기존 함수 내용 유지
        var tOptions = pObjCombo.options;
        var tOption = null;
    
        for (var tLoop=0; tLoop<tOptions.length; tLoop++)    {
            tOption = tOptions[tLoop];
    
            if (tOption.value == pValue)    {
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
<body leftmargin="0" topmargin="0"  onLoad="areaload()">
<form name="frm" method="post">
<input type="hidden" name="idx" value="<?=$idx?>">
<input type="hidden" name="pagenum" value="<?=$pagenum?>">
<input type="hidden" name="common_id" value="<?=$common_id?>">
<input type="hidden" name="origin_site" value="<?=$origin_site?>">
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
                <td>HOME > 차량관리 > 공통 차량 수정하기</td>
            </tr>
        </table>
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td height="45"><div class="hetxt">공통 차량 수정</div></td>
            </tr>
            <tr>
                <td height="20"></td>
            </tr>
        </table>
        
        <!-- 동기화 사이트 선택 섹션 (새로 추가) -->
        <div class="sync-sites">
            <h3>수정 내용을 동기화할 사이트 선택</h3>
            <p>선택한 모든 사이트에 동일한 내용이 수정 적용됩니다. 최소 1개 이상 선택해야 합니다.</p>
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
        
        <!-- 등록 폼 (기존 modify.php 코드 재사용) -->
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
                    <script language="JavaScript">
                        setComboOption($$("maker"), '<?=$edit['maker']?>')
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
                        setComboOption($$("cartype"), '<?=$edit['cartype']?>')
                    </script>
                    <select name="carkind" class="frmSelect">
                        <option value="">용도선택</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th>매물명</th>
                <td><input type="text" name="carname" size="45" value="<?=$edit['carname']?>"></td>
            </tr>
            <tr>
                <th>매물번호</th>
                <td><input name="carnum" type="text" id="carnum" size="30" value="<?=$edit['carnum']?>"></td>
            </tr>
            <!-- 나머지 필드들... (기존 modify.php 코드 유지) -->
            <tr>
                <th>매물가격</th>
                <td>
                    <input name="price" type="text" id="price" size="10" value="<?=$edit['price']?>"> 만원 (숫자만입력)&nbsp;&nbsp;&nbsp;&nbsp; 또는 &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="price_t" size="10" value="<?=$edit['price_t']?>"> (단가협의 또는 전화문의는 여기에 입력)
                </td>
            </tr>
            <tr>
                <th>주행거리</th>
                <td><input name="distance" type="text" size="10" value="<?=$edit['distance']?>"> 만km (숫자만입력)</td>
            </tr>
            <tr>
                <th>연식</th>
                <td>
                    <select name="makeyear" class="frmSelect">
                        <option value="">선택</option>
                    <?php for($ii=date("Y"); $ii >= 1990; $ii--) { ?>
                        <option value="<?=$ii?>" <?php if($edit['makeyear']==$ii) echo "selected" ?>>
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
                    <option value="<?=$ii?>" <?php if($edit['makemonth']==$ii) echo "selected" ?>>
                    <?=$ii?>
                    </option>
                    <?php } ?>
                    </select>
                    월
                </td>
            </tr>
            <!-- 나머지 필드들 계속... -->
            <tr>
                <th>톤수</th>
                <td>
                    <select name="ton" style="width:100px;" class="frmSelect">
                        <option value="">선택</option>
                        <option value="1">1</option>
                        <option value="1.2">1.2</option>
                        <!-- 기타 톤수 옵션... -->
                    </select>
                    <script language="JavaScript">
                        setComboOption($$("ton"), '<?=$edit['ton']?>')
                    </script>
                </td>
            </tr>
            <!-- 이하 생략... -->
            <tr>
                <th>차량상세정보</th>
                <td><textarea name="content" id="content" rows="25" style="width:100%"><?=$edit['content']?></textarea></td>
            </tr>
            <tr>
                <th>관리자메모</th>
                <td><input name="bigo" type="text" id="bigo" size="180" value="<?=$edit['bigo']?>"></td>
            </tr>
            <tr>
                <th>이미지등록</th>
                <td>
                    <div id="dragandrophandler">이미지를 드래그하여 이곳에 놓으십시오<br><br><span class="exp">대표이미지는 첫번째 이미지이며, 등록순으로 이미지가 보여집니다</span></div>
                    <?php
                        $query = "select * from carinfo_img where j_idx=$idx and j_file<>'' order by j_no desc";
                        $result = $db_function->select_db($query, $dbconn);    
                
                        while($rs=mysql_fetch_array($result))
                        {
                    ?>
                    <div id="d<?=$rs['idx']?>" class="statusbar" style="background:#efefef;">
                        <div class='filename'><?=$rs['j_file_org']?></div>
                        <div class="filesize"><?=$rs['j_filesize']?></div>
                        <div class='progressBar'><div style="width:100%;"></div></div>
                        <div class="del"><a href="javascript:del_div2('d<?=$rs['idx']?>')">del</a></div>
                        <input type="hidden" name="attachfile[]" value="<?=$rs['j_file']?>">
                        <input type="hidden" name="fname[]" value="<?=$rs['j_file_org']?>">
                        <input type="hidden" name="fsize[]" value="<?=$rs['j_filesize']?>">
                    </div>
                    <?php } ?>
                    <div id="editdata"></div>
                    <script>
                        // 기존 이미지 처리 및 업로드 관련 스크립트 (modify.php에서 복사)
                        function sendFileToServer(formData,status)
                        {
                            // 기존 sendFileToServer 함수 내용
                        }

                        function del_div2(rowcount)
                        {
                            // 기존 del_div2 함수 내용
                        }

                        function del_div(rowcount)
                        {
                            // 기존 del_div 함수 내용
                        }
                         
                        var rowCount=0;
                        function createStatusbar(obj)
                        {
                            // 기존 createStatusbar 함수 내용
                        }
                        function handleFileUpload(files,obj)
                        {
                            // 기존 handleFileUpload 함수 내용
                        }

                        $(document).ready(function()
                        {
                            // 기존 document.ready 함수 내용
                        });
                    </script>
                </td>
            </tr>
        </table>
        </div>
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td height="50" align="center"><a href="javascript:save()" class="reg-bti">공통 차량수정</a></td>
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
</script>