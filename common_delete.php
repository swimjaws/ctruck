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

    // 삭제할 차량의 정보 조회
    $query_car = "SELECT * FROM carinfo WHERE idx = '$idx'";
    $result_car = $db_function->select_db($query_car, $dbconn);
    $car_info = mysql_fetch_array($result_car);
    
    // 공통 차량인지 확인
    $is_common = $car_info['is_common'];
    $common_id = $car_info['common_id'];
    $origin_site = $car_info['origin_site'];
    
    // 현재 차량의 이미지 정보 가져오기 (삭제를 위해)
    $querydi = "SELECT * FROM carinfo_img WHERE j_idx = '$idx' ORDER BY j_no ASC";
    $result = $db_function->select_db($querydi, $dbconn);    
    while($rs = mysql_fetch_array($result)) {
        unlink($_SERVER['DOCUMENT_ROOT']."/carimg/{$rs['j_file']}");
    }
    
    // 현재 사이트에서 차량 정보 및 이미지 삭제
    $query = "DELETE FROM carinfo WHERE idx = '$idx'";
    $db_function->update_db($query, $dbconn);
    
    $queryd = "DELETE FROM carinfo_img WHERE j_idx = '$idx'";
    $db_function->delete_db($queryd, $dbconn);
    
    // 공통 차량이라면 다른 사이트에서도 삭제 처리
    if($is_common == 1 && $common_id) {
        $sites = array(
            'jstruck' => 'https://xn--wl2bl5nu4g3ok.com/api/ctruck/delete.php', // 주상트럭.com의 올바른 퓨니코드 (https)
            'truk' => 'http://truk.co.kr/api/ctruck/delete.php',                // http로 수정
            'truckpark' => 'http://truckpark.kr/api/ctruck/delete.php',         // http로 수정
            'truck8949' => 'http://truck8949.kr/api/ctruck/delete.php'          // http로 수정
        );
        
        $deleted_sites = array();
        $failed_sites = array();
        
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
            if($result && isset($result['status']) && $result['status'] == 'success') {
                $deleted_sites[] = $site_key;
            } else {
                $failed_sites[] = $site_key;
            }
        }
        
        // 다른 사이트 삭제 결과에 따라 메시지 출력
        if(count($failed_sites) > 0) {
            echo "<script>
                  alert('공통 차량이 삭제되었으나, 일부 사이트에서 삭제에 실패했습니다.');
                  parent.list();
                  </script>";
        } else {
            echo "<script>
                  alert('공통 차량이 모든 사이트에서 삭제되었습니다.');
                  parent.list();
                  </script>";
        }
    } else {
        // 일반 차량이면 기존과 동일하게 처리
        echo "<script>
              alert('삭제가 완료되었습니다.');
              parent.list();
              </script>";
    }
?>