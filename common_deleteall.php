<?php
    include $_SERVER["DOCUMENT_ROOT"]."/common/db_info.php";
    include $_SERVER["DOCUMENT_ROOT"]."/common/myFunction.php";
    
    #######################################
    # DBConnection u
    $db_function = new db_function();
    #######################################
    
    include $_SERVER["DOCUMENT_ROOT"]."/common/CommonLib.php";
    include $_SERVER["DOCUMENT_ROOT"]."/api/config.php";  // API 설정 파일 포함
    
    if(!$_SESSION['admin_id']){
        echo "<script language=javascript>
              location.href = '/adm/';
              </script>";
    }

    // 사이트별 공통 차량 삭제 결과 추적
    $common_deleted = 0;
    $common_failed = 0;

    for($i=0; $i<count($chk); $i++){
        // 공통 차량인지 확인
        $query_car = "SELECT * FROM carinfo WHERE idx = '{$chk[$i]}'";
        $result_car = $db_function->select_db($query_car, $dbconn);
        $car_info = mysql_fetch_array($result_car);
        
        $is_common = $car_info['is_common'];
        $common_id = $car_info['common_id'];
        
        // 이미지 파일 삭제
        $querydi = "SELECT * FROM carinfo_img WHERE j_idx='{$chk[$i]}' ORDER BY j_no ASC";
        $result = $db_function->select_db($querydi, $dbconn);    
        while($rs = mysql_fetch_array($result)) {
            unlink($_SERVER['DOCUMENT_ROOT']."/carimg/{$rs['j_file']}");
        }
        
        // 이미지 정보 삭제
        $queryd = "DELETE FROM carinfo_img WHERE j_idx='{$chk[$i]}'";
        $db_function->delete_db($queryd, $dbconn);
        
        // 차량 정보 삭제
        $query = "DELETE FROM carinfo WHERE idx='{$chk[$i]}'";
        $db_function->update_db($query, $dbconn);
        
        // 공통 차량이라면 다른 사이트에서도 삭제 처리
        if($is_common == 1 && $common_id) {
            $sites = array(
                'jstruck' => 'https://xn--wl2bl5nu4g3ok.com/api/ctruck/delete.php', // 주상트럭.com의 올바른 퓨니코드 (https)
                'truk' => 'http://truk.co.kr/api/ctruck/delete.php',                // http로 수정
                'truckpark' => 'http://truckpark.kr/api/ctruck/delete.php',         // http로 수정
                'truck8949' => 'http://truck8949.kr/api/ctruck/delete.php'          // http로 수정
            );
            
            $all_success = true;
            
            // 사이트별 API 호출로 삭제 요청
            foreach($sites as $site_key => $api_url) {
                // 현재 사이트는 이미 삭제했으므로 건너뜀
                if($site_key == $current_site) continue;
                
                // API 호출 데이터 준비
                $post_data = array(
                    'api_key' => $api_keys[$site_key],
                    'common_id' => $common_id
                );
                
                // API 호출
                $response = callAPI($api_url, $post_data);
                
                // 결과 처리
                $result = json_decode($response, true);
                if(!($result && isset($result['status']) && $result['status'] == 'success')) {
                    $all_success = false;
                }
            }
            
            if($all_success) {
                $common_deleted++;
            } else {
                $common_failed++;
            }
        }
    }

    // 삭제 결과 메시지 구성
    $message = "삭제가 완료되었습니다.";
    if($common_deleted > 0) {
        $message .= " " . $common_deleted . "개의 공통 차량이 모든 사이트에서 삭제되었습니다.";
    }
    if($common_failed > 0) {
        $message .= " " . $common_failed . "개의 공통 차량은 일부 사이트에서 삭제에 실패했습니다.";
    }
?>
<script language="JavaScript">
    alert("<?php echo $message; ?>");
    parent.result_ok();
</script>