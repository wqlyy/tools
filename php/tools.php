<?php
	//图片缩放函数（等比例）
	//
	//
	function thumb($src_file,$dst_w,$dst_h){

		$srcarr = getimagesize($src_file);
		switch ($srcarr[2]) {
			case 1:
				$imagecreatefrom = "imagecreatefromgif";
				$imageout = "imagegif";
				break;
			case 2:
				$imagecreatefrom = "imagecreatefromjpeg";
				$imageout = "imagejpeg";
				break;
			case 3:
				$imagecreatefrom = "imagecreatefrompng";
				$imageout = "imagepng";
				break;
		}

		$src_image = $imagecreatefrom($src_file);

		//等比例处理
		$src_w = imagesx($src_image);
		$src_h = imagesy($src_image);

		$scale = ($src_w/$dst_w)>($src_h/$dst_h) ? ($src_w/$dst_w) : ($src_h/$dst_h);
		//取整
		$dst_w = floor($src_w/$scale);
		$dst_h = floor($src_h/$scale);

		$dst_image = imagecreatetruecolor($dst_w,$dst_h);
		$dst_x = 0;
		$dst_y = 0;
		$src_x = 0;
		$src_y = 0;

		
		imagecopyresampled($dst_image,$src_image,$dst_x,$dst_y,$src_x,$src_y,$dst_w,$dst_h,$src_w,$src_h);
		$t_name = 't_'.basename($src_file);
		$t_dir = dirname($src_file);
		$s_file = $t_dir.'/'.$t_name;
		$imageout($dst_image,$s_file);
	}
	//测试
	thumb('timg.jpg',200,200);



		//删除非空目录
	function delDir($dir){
		$files = scandir($dir);
		foreach ($files as $key => $value) {
			if($key>1){
				$file = $dir.'/'.$value;
				if(is_dir($file)){
					delDir($file);
				}else{
					unlink($file);
				}
			}
		}
		rmdir($dir);
	}
	//测试
	delDir($dir)
?>