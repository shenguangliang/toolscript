<html>
<body>

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

function createAmark($URL,$name){
	return '<a href="'.$URL.'">'.$name.'</a>';
}

function createSeparatorMark($name){
	return "<h3>".$name."</h3><hr size='2' align='left' width='40%'/>";
}

function myscandir($path){
	$mydir = dir($path);
	$dirName = dirname(__FILE__);
   
	foreach(scandir($path,1) as $file){
		$p = $path.'/'.$file;
		if(($file != ".") AND ($file != "..")){
			$fileName = substr($p,strlen($dirName) + 1);
			if(is_dir($p)){
				echo createSeparatorMark($fileName);
				myscandir($p);
			}else{
				echo createAmark(createURL($fileName),$fileName).'<br>';
			}	
	    }
	}       
}

echo "<h1>IOS Build</h1>";
echo createSeparatorMark("");

myscandir(dirname(__FILE__));	    

echo createSeparatorMark("");
echo("IOS & QA Team On : ".date("l dS \of F Y h:i:s A") . "<br />");

?>

</body>
</html>
