<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<title>IOS Build</title>
</head>

<body>

<h1><a href='tree.php'>Document Tree</a></h1>

<h1>IOS Build</h1>

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

$documents = array();

function createDtree($idx,$parent,$fileName,$isDir = 0){
	if($isDir != 1 && strrpos($fileName,'.ipa') <= 0 && strrpos($fileName,'.plist') <= 0)
            return;
    global $documents;
	$displayName = substr($fileName,strrpos($fileName,'/') > 0 ? strrpos($fileName,'/') + 1 : 0);
	
	$document = array("index" => $idx,"parent" => $parent,"displayName" => $displayName , "isDir" =>  $isDir ,"URL" => createURL($fileName));
	$documents[$idx] = $document;
}

function createAmark($URL,$name){
	return '<h5><a href="'.$URL.'">'.$name.'</a></h5>';
}

function createSeparatorMark($name){
	return "<h3>".$name."</h3><hr size='2' align='left' width='40%'/>";
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

createSeparatorMark("");

foreach($documents as $doc){
   if($doc["isDir"] == 0 && (strrpos($doc["URL"],'RenrenOfficial-iOS-Concept/APP') > 0 
   							|| strrpos($doc["URL"],'RenrenOfficial-iPad/APP') > 0
   							|| strrpos($doc["URL"],'RRSpring/APP') > 0)){
   		echo createAmark($doc["URL"],$doc["displayName"])."<br/><br/>";
   }
}
?>

<?php
	createSeparatorMark("");
	echo("IOS & QA Team On : ".date("l dS \of F Y h:i:s A") . "<br />");
?>
</body>

</html>
