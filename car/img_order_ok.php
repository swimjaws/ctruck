<?
	include $_SERVER["DOCUMENT_ROOT"]."/common/db_info.php";
	include $_SERVER["DOCUMENT_ROOT"]."/common/myFunction.php";
	
	#######################################
	# DBConnection u
	$db_function = new db_function();
	#######################################
	
	include $_SERVER["DOCUMENT_ROOT"]."/common/CommonLib.php";
	mysql_query('set names utf8');
?>
<?
	if(!$_SESSION[admin_id]){
	echo "<script language=javascript>
		  location.href = '/adm/';
		  </script>";
	}

	echo "<pre>";
	print_r($_POST);
	echo "</pre>";
	
	asort($forder);
	
	echo "<pre>";
	print_r($forder);
	echo "</pre>";
	
	
	$ordlist = array();
	
	$no = 0;
	foreach($forder as $k => $v) {
		$query = "update carinfo_img set j_no='{$no}' where idx = '{$fidx[$k]}' limit 1";
		$db_function->insert_db($query,$dbconn);
		$no++;
		echo "<p>".$query."</p>";
		
	}
	
	echo("<meta http-equiv='refresh' content='0;url=img_order.php?idx=$idx&pagenum=$pagenum&keyfield=$keyfield&keyword=$keyword'>");
?>