<?php
	$output_dir = "../../carimg/";
	if(isset($_FILES["file"]))
	{
	//Filter the file types , if you want.
		$strfile_name = $_FILES['file']['name'];
	
		$filename_ext = strtolower(array_pop(explode('.',$strfile_name)));
		$allow_file = array("jpg", "png", "bmp", "gif");
		
		$strfile_name = str_replace('%', '', urlencode(str_replace(' ', '_', $strfile_name)));
		$full_filename = explode(".", "$strfile_name");
		
		if(!in_array($filename_ext, $allow_file)) {
			echo "<script>alert('이미지파일만 등록이 가능합니다.');</script>";
		}else{
		
			if ($_FILES["file"]["error"] > 0)
			{
				echo "Error: " . $_FILES["file"]["error"] . "
				";
			}else{
				$fexist = true;
				$count1 = 0;
				while ($fexist)	{
					$same_file_exist = file_exists("$output_dir/$strfile_name");
					if($same_file_exist) {
						$count1 = $count1 + 1;
						$strfile_name = "$full_filename[0]"."_"."$count1".".$full_filename[1]";
					}else{
						$fexist = false;
					}
				}
		
				move_uploaded_file($_FILES["file"]["tmp_name"],$output_dir. $strfile_name);
				echo $strfile_name;
			}
		}
	}
?>