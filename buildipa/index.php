<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<title>IOS Builds</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
</head>

<body>

<?php 

$apps = array("RenrenOfficial-iOS-Concept" => "人人概念版","RenrenOfficial-iPad" => "人人Ipad","RRSpring" => "人人Iphone");
$buildTypeNight = 'NightBuild';
$buildTypeCI = 'CI';
$ua = $_SERVER['HTTP_USER_AGENT'];

function isIOS(){
	global $ua;
	return (stripos($ua,"iPhone") || stripos($ua,"iPod") || stripos($ua,"iPad"));	
}
?>

<h1><a href='index.php'>HOME</a> <a href='tree.php'>Document Tree</a>  <a href='http://10.2.76.47:8080/jenkins'>jenkins</a></h1>
<table width="100%">
<?php
	foreach(array_keys($apps) as $appStr){
		echo "<tr><td><h1><a href='index.php?app=".$appStr."&type=".$buildTypeCI."'>".$apps[$appStr]." ".$buildTypeCI."</a></h1></td>";
		echo "<td><h1><a href='index.php?app=".$appStr."&type=".$buildTypeNight."'>".$apps[$appStr]." ".$buildTypeNight."</a></h1></td></tr>";
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
	if($isDir != 1 && !strrpos($fileName,'.ipa')  && !strrpos($fileName,'.plist'))
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
	global $apps;
	foreach($documents as $doc){
   			if($doc["isDir"] == 1 && ($doc["displayName"] === $type)){
      			if((strrpos($doc["URL"],$appName.'/APP/'.$stype) > 0)){
					echo createSeparatorMark($apps[$appName]." ".$doc["displayName"]);      
      			}
   			}
   			if($doc["isDir"] == 0 && strrpos($doc["URL"],$appName.'/APP/'.$type) > 0 )
   			{
				if(isIOS() && strrpos($doc["displayName"],'ipa') > 0)
					continue;
   				echo createAmark($doc["URL"],$doc["displayName"]);
   			}
	}
}
treescandir(dirname(__FILE__),0);

echo createSeparatorMark("");

$app = $_REQUEST["app"];
$type = $_REQUEST["type"];

if($app && array_key_exists($app,$apps) && $type 
	&& ($type === $buildTypeNight || $type === $buildTypeCI)){
	createApps($app,$type);
}else{
	foreach(array_keys($apps) as $appStr){
		createApps($appStr,$buildTypeCI);
		createApps($appStr,$buildTypeNight);
	}

}

?>

<?php
    echo createSeparatorMark("");
    echo("IOS & QA Team On : ".date("l dS \of F Y h:i:s A") . "<br />".$ua);
?>
</body>

</html>
