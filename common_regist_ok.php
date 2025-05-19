<?php
    include $_SERVER["DOCUMENT_ROOT"]."/common/db_info.php";
    include $_SERVER["DOCUMENT_ROOT"]."/common/myFunction.php";
    
    #######################################
    # DBConnection u
    $db_function = new db_function();
    #######################################
    
    include $_SERVER["DOCUMENT_ROOT"]."/common/CommonLib.php";
    include $_SERVER["DOCUMENT_ROOT"]."/api/config.php";  // API 설정 파일 포함
    
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
    
    // 선택된 동기화, 사이트 목록
    $sync_sites = isset($_POST['sync_sites']) ? $_POST['sync_sites'] : array();
    
    $imgcnt = count($attachfile)-1;
    
    $memo = addslashes($memo);
    $carname = addslashes($carname);
    $content = addslashes($content);
    $bigo = addslashes($bigo);
    $reg_date=$g4['time_ymdhis'];
    
    // 공통 등록 관련 데이터 준비
    $is_common = 1; // 공통 차량 여부
    $common_id = time(); // 공통 ID - UNIX timestamp
    $origin_site = $_POST['origin_site']; // 원래 등록된 사이트 정보
    
    // direct 처리 (기존 코드와 동일)
    if($direct != 'direct') {
        $direct = 'N';
    } else {
        $direct = 'Y';
    }
    
    // 현재 사이트에 차량 정보 먼저 등록
    $query = " insert into carinfo
                    set direct = '$direct',
                    maker = '$maker',
                    cartype = '$cartype',
                    carkind = '$carkind',
                    carname = '$carname',
                    carnumber = '$carnumber',
                    divinumber = '$divinumber',
                    pidnum = '$pidnum',
                    price = '$price', 
                    price_t = '$price_t', 
                    distance = '$distance',
                    makeyear = '$makeyear',
                    makemonth = '$makemonth',
                    makeyear2 = '$makeyear2',
                    makemonth2 = '$makemonth2',
                    ton = '$ton',
                    gear = '$gear',
                    color = '$color',                    
                    seize = '$seize',
                    pledge = '$pledge',
                    carnum = '$carnum',
                    option1 = '$option1',
                    option2 = '$option2',
                    option3 = '$option3',
                    option4 = '$option4',
                    option5 = '$option5',
                    option6 = '$option6',
                    option7 = '$option7',
                    option8 = '$option8',
                    option9 = '$option9',
                    option10 = '$option10',
                    option11 = '$option11',
                    option12 = '$option12',
                    boxlong = '$boxlong',
                    boxlong_text = '$boxlong_text',
                    shaft = '$shaft',
                    bigo = '$bigo',
                    content = '$content',
                    url = '$yurl',
                    reg_date = '$reg_date',
                    is_common = '$is_common',
                    common_id = '$common_id',
                    origin_site = '$origin_site' ";
    $db_function->insert_db($query,$dbconn);
    
    $idx = mysql_insert_id();
    
    // 이미지 파일 정보 DB에 저장
    $j = 0;
    for ($i=$imgcnt; $i>=0; $i--) {
        $query = "insert into carinfo_img
                    set j_idx = '$idx',
                    j_no = '$j',
                    j_file = '$attachfile[$i]',
                    j_filesize = '$fsize[$i]',
                    j_file_org = '$fname[$i]'";
        $db_function->insert_db($query,$dbconn);
        $j = $j+1;
    }
    
    // 다른 사이트에 API 호출을 통해 차량 정보 공유
    $sites = array(
        'jstruck' => 'https://xn--wl2bl5nu4g3ok.com/api/ctruck/create.php', // 주상트럭.com (https)
        'truk' => 'http://truk.co.kr/api/ctruck/create.php',                // http로 수정
        'truckpark' => 'http://truckpark.kr/api/ctruck/create.php',         // http로 수정
        'truck8949' => 'http://truck8949.kr/api/ctruck/create.php'          // http로 수정
    );
    
    $success_sites = array();
    $fail_sites = array();
    
    // 사이트 표시 이름
    $site_names = array(
        'jstruck' => '주상트럭.com',
        'truk' => 'truk.co.kr',
        'truckpark' => 'truckpark.kr',
        'truck8949' => 'truck8949.kr'
    );
    
    // 선택된 사이트만 처리
    foreach($sync_sites as $site_key) {
        // 현재 사이트는 이미 등록했으므로 건너뜀
        if ($site_key == $current_site) continue;
        
        // API URL 가져오기
        if (!isset($sites[$site_key])) continue;
        $api_url = $sites[$site_key];
        
        // 요청 데이터 준비
        $post_data = array(
            'api_key' => $api_keys[$site_key],
            'origin_site' => $origin_site,
            'common_id' => $common_id,
            'is_common' => 1,
            'direct' => $direct,
            'carnum' => $carnum,
            'carname' => $carname,
            'maker' => $maker,
            'cartype' => $cartype,
            'carkind' => $carkind,
            'carnumber' => $carnumber,
            'price' => $price,
            'price_t' => $price_t,
            'distance' => $distance,
            'makeyear' => $makeyear,
            'makemonth' => $makemonth,
            'makeyear2' => $makeyear2,
            'makemonth2' => $makemonth2,
            'ton' => $ton,
            'gear' => $gear,
            'color' => $color,
            'seize' => $seize,
            'pledge' => $pledge,
            'boxlong' => $boxlong,
            'boxlong_text' => $boxlong_text,
            'shaft' => $shaft,
            'bigo' => $bigo,
            'content' => $content,
            'url' => $yurl
        );
        
        // 이미지 정보 추가
        $img_files = array();
        for($i=0; $i<=$imgcnt; $i++) {
            $img_files[] = $attachfile[$i];
        }
        $post_data['images'] = implode('||', $img_files);
        
        // API 호출
        $response = callAPI($api_url, $post_data);
        
        // 결과 처리
        $result = json_decode($response, true);
        if($result && isset($result['status']) && $result['status'] == 'success') {
            $success_sites[] = $site_key;
        } else {
            $fail_sites[] = $site_key;
        }
    }
    
    // 결과 출력 및 리다이렉트
    if(count($fail_sites) > 0) {
        // 일부 실패한 경우
        $fail_site_names = array();
        foreach($fail_sites as $site_key) {
            $fail_site_names[] = isset($site_names[$site_key]) ? $site_names[$site_key] : $site_key;
        }
        $fail_msg = "일부 사이트에 등록 실패: " . implode(", ", $fail_site_names);
        echo "<script language=javascript>
              alert('공통 차량이 등록되었으나, $fail_msg');
              location.href = 'common_list.php';
              </script>";
    } else if(count($success_sites) > 0) {
        // 모두 성공한 경우
        echo "<script language=javascript>
              alert('공통 차량이 선택한 사이트에 성공적으로 등록되었습니다.');
              location.href = 'common_list.php';
              </script>";
    } else {
        // 선택한 사이트가 없거나 현재 사이트만 선택한 경우
        echo "<script language=javascript>
              alert('공통 차량이 등록되었습니다.');
              location.href = 'common_list.php';
              </script>";
    }
?>