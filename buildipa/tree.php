
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<title>IOS Build</title>
	<link rel="StyleSheet" href="dtree.css" type="text/css" />
	<script type="text/javascript" src="dtree.js"></script>
</head>

<body>

<h1>IOS Build</h1>

<div class="dtree">

	<p><a href="javascript: d.openAll();">open all</a> | <a href="javascript: d.closeAll();">close all</a></p>

	<script type="text/javascript">
		<!--

		d = new dTree('d');
		d.add(0,-1,'All IOS Builds');
<?php
// create by siglea on Tuesday 15th of October 2013 08:43:55 PM
 
function createURL($fileName){
	$host = $_SERVER['HTTP_HOST'];
	$baseURI = substr($_SERVER['REQUEST_URI'],0,strrpos($_SERVER['REQUEST_URI'],'/') + 1);
	$fileURL = 'http://'.$host.$baseURI.$fileName;
	if(strpos($fileName,".plist",0) > 0){
		return	"itms-services://?action=download-manifest&url=".$fileURL;
	}else{
		return $fileURL;
	}
}

function createAmark($URL,$name,$left){
	return '<a style="margin-left:'.($left * 30 ).'px;" href="'.$URL.'">'.$name.'</a>';
}

function createSeparatorMark($name,$width){
	return "<h3>".$name."</h3><hr size='2' align='left' width='".(5 * $width)."%'/>";
}

function myscandir($path){
	$mydir = dir($path);
	$dirName = dirname(__FILE__);

	foreach(scandir($path,1) as $file){
		$p = $path.'/'.$file;
		if(($file != ".") AND ($file != "..")){
			$fileName = substr($p,strlen($dirName) + 1);
			if(is_dir($p) && count(scandir($path,1)) > 0){
				echo createSeparatorMark($fileName,substr_count($fileName,'/'));
				myscandir($p);
			}else{
				echo createAmark(createURL($fileName),$fileName,substr_count($fileName,'/')).'<br>';
			}	
	    }
	}       
}

function createDtree($idx,$parent,$fileName,$isDir = 0){
	if($isDir != 1 && strrpos($fileName,'.ipa') <= 0 && strrpos($fileName,'.plist') <= 0)
            return;
	$displayName = substr($fileName,strrpos($fileName,'/') >= 0 ? strrpos($fileName,'/') + 1 : 0);
	if($isDir == 1)
		echo "d.add(".$idx.",".$parent.",'".$displayName."');"; 
	else
		echo "d.add(".$idx.",".$parent.",'".$displayName."','".createURL($fileName)."');"; 
}

$index = 0;
function treescandir($path,$parent){
	$mydir = dir($path);
	$dirName = dirname(__FILE__);
	global $index;

	foreach(scandir($path,1) as $file){
		$p = $path.'/'.$file;
		if(($file != ".") AND ($file != "..")){
			++$index;
			$fileName = substr($p,strlen($dirName) + 1);
			if(is_dir($p)){
				createDtree($index,$parent,$fileName,1);
				treescandir($p,$index);
			}else{
				createDtree($index,$parent,$fileName,0);
			}	
	    }
	}       
}

treescandir(dirname(__FILE__),0);	    
?>
		document.write(d);

		//-->
	</script>

</div>

<p><a href="mailto&#58;drop&#64;destroydrop&#46;com">&copy;2002-2003 Geir Landr&ouml;</a></p>
<?php
	echo("IOS & QA Team On : ".date("l dS \of F Y h:i:s A") . "<br />");
?>
</body>

</html>
