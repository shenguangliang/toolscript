<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<title>IOS Builds</title>
</head>

<body>

<?php 

$apps = array("RenrenOfficial-iOS-Concept","RenrenOfficial-iPad","RRSpring");
$buildTypeNight = 'NightBuild';
$buildTypeCI = 'CI';

?>

<h1><a href='index.php'>HOME</a> <a href='tree.php'>Document Tree</a>  <a href='http://10.2.76.47:8080/jenkins'>jenkins</a></h1>
<table width="100%">
<?php
	foreach($apps as $appStr){
		echo "<tr><td><h1><a href='index.php?app=".$appStr."&type=".$buildTypeCI."'>".$appStr." ".$buildTypeCI."</a></h1></td>";
		echo "<td><h1><a href='index.php?app=".$appStr."&type=".$buildTypeNight."'>".$appStr." ".$buildTypeNight."</a></h1></td></tr>";
	}
?>
</table>

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
	return '<h2><a href="'.$URL.'">'.$name.'</a></h2>';
}

function createSeparatorMark($name){
	return "<h1>".$name."</h1><hr size='2' align='left' width='40%'/>";
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

function createApps($appName,$type = "CI"){
	global $documents;
	foreach($documents as $doc){
   			if($doc["isDir"] == 1 && ($doc["displayName"] === $type)){
      			if((strrpos($doc["URL"],$appName.'/APP/'.$stype) > 0)){
					echo createSeparatorMark($appName." ".$doc["displayName"]);      
      			}
   			}
   			if($doc["isDir"] == 0 && strrpos($doc["URL"],$appName.'/APP/'.$type) > 0 )
   			{
   				echo createAmark($doc["URL"],$doc["displayName"]);
   			}
	}
}
treescandir(dirname(__FILE__),0);

echo createSeparatorMark("");

$app = $_REQUEST["app"];
$type = $_REQUEST["type"];

if($app && in_array($app,$apps) && $type 
	&& ($type === $buildTypeNight || $type === $buildTypeCI)){
	createApps($app,$type);
}else{
	foreach($apps as $appStr){
		createApps($appStr,$buildTypeCI);
		createApps($appStr,$buildTypeNight);
	}

}

?>

<?php
    echo createSeparatorMark("");
	echo("IOS & QA Team On : ".date("l dS \of F Y h:i:s A") . "<br />");
?>
</body>

</html>
