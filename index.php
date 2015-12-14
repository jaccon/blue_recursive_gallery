<?php
//include("functions.inc.php");
$localpath="/home1/tambord/public_html/dev/blue_recursive_gallery/"; // Patch to script
$localurl="http://dev.bluesystems.com.br/blue_recursive_gallery/";	// Script URL
$scan_directory="image_repository"; // folder with imagens
$path = realpath($scan_directory);
$filter=$_REQUEST['filter'];

// DROP DOWN MENU
function get_file_datetime($filename){
   $exif = exif_read_data($filename, 0, true);
   $timestamp=$exif['FILE']['FileDateTime'];
   return gmdate("d/m/Y H:i:s",$timestamp);
}


foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path)) as $filename)
{
      $imgsrc=str_replace($localpath,"",$filename);
      if((strpos($imgsrc,'._') !== false OR strpos($imgsrc,'.DS_Store') !== false) OR (strpos($imgsrc,'..') !== false OR !strpos($imgsrc,'.jpg') ) ){
	}else{
	    // verificado a data do metada da imagem e organizo no dropdown
	    $created_file=get_file_datetime($imgsrc);
	    $created_file=explode(" ",$created_file);
	    $created_file=($created_file[0]);
	    //$files[] = '<option value="'.$created_file.'">'.$created_file.'</option>';
	    $files2[]=$created_file;
	}
}

$novo_array = array_unique($files2);

foreach($novo_array as $data){
      $files3[]='<option value="'.$data.'">'.$data.'</option>';
}
$options = implode('',$files3);

?>
<html>
<head>
<style>
body{margin:0 0 0 0;}
ul li{ float: left; margin: 5px; }
img{ box-shadow: 2px 2px 5px #333; }
.header{background: #000;width:100%;height:35px;padding:10px;}
.header_left{float: left;width: 200px;}
.filter_bt{padding: 5px;background: #000;color:#fff;border:0;border-radius: 3px;}
.header_logo{font-size:30px;color: #fff;font-family:arial;}
</style>
</head>
<body>
<div class="container">
      <div class="header">
	    <div class="header_left">
		 <span class="header_logo">Blue Systems</span>
	    </div>
	    <div class="header_right">
		  <a href="?update=1" style="float: left;text-decoration: none;margin:10px 0 0 10px;color: #fff;font-family: arial;font-size:12px;">Atualizar</a>
	    </div>
	    
      </div>
      
      <ul>
	    <?php
		  // without filter
		 foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path)) as $filename)
		  {
			$imgsrc=str_replace($localpath,$localurl,$filename);
			$img=str_replace($localpath.$scan_directory,"",$filename);
			//$localurl.$scan_directory.$img
			
			if((strpos($imgsrc,'._') !== false OR strpos($imgsrc,'.DS_Store') !== false) OR (strpos($imgsrc,'..') !== false OR !strpos($imgsrc,'.jpg') ) ){
			  }else{
			      echo '<li>
				    <a href="'.$localurl.$scan_directory.$img.'" target="_blank"><img src="'."thumb.php?src=".$imgsrc."&w=150&h=95&rcz".'" /></a>
				    <div style="font-size:13px;font-family:arial;z-index:99999;position:absolute;margin:-25px 10px;color:#fff;text-shadow:1px 1px 1px #000;">'.get_file_datetime($filename).'</div>
				    </li>';
			  }
		  } 
	    ?>
      </ul>
</div>
</body>
</html>
