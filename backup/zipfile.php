<?php 
// $storeDir = dirname(__FILE__);
// 
// if (file_put_contents($storeDir . '/doctoradmin.zip', fopen('http://www.testphonedokters.com/backup/doctoradmin.zip', 'r')))
// {
// 	die('done');
// }
// die('Can not download zip file');


error_reporting(E_ALL);
ini_set('display_errors', 1);
@set_time_limit(0);
ini_set('memory_limit', '-1');

function Zip($source, $destination)
{
		if(!file_exists($source)) return ;
		
	if (!extension_loaded('zip')) {
		die('extension zip not loaded');
	}

	$zip = new ZipArchive();
	if (!$zip->open($destination, ZIPARCHIVE::CREATE)) {
		die('can not open the destination');
	}

	$source = str_replace('\\', '/', realpath($source));

	if (is_dir($source) === true)
	{
		$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);
		$filesIgnore = array('.tar', '.zip', '.pdf', '.gz');
		$folderIgnore = array(
		);
		
		foreach ($files as $file)
		{
			$file = str_replace('\\', '/', $file);
			$break = false;
			foreach ($filesIgnore as $fileIgnore)
			{
				if (strpos($file, $fileIgnore) !== false)
				{
					$break = true;
					break;
				}
			}
			
			foreach ($folderIgnore as $folderi)
			{
				if (strpos($file, $folderi) !== false)
				{
					$break = true;
					break;
				}
			}
			
			if ($break)
				continue;

			// Ignore "." and ".." folders
			if( in_array(substr($file, strrpos($file, '/')+1), array('.', '..')) )
				continue;

			$file = realpath($file);

			if (is_dir($file) === true)
			{
				//var_dump($file); echo '<br />';				
				$zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
			}
			else if (is_file($file) === true && file_exists($file) && is_readable($file))
			{
				$zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
			}
		}		
	}
	else if (is_file($source) === true && file_exists($source) && is_readable($source))
	{
		$zip->addFromString(basename($source), file_get_contents($source));
	}

	return $zip->close();
}

function unZip($file)
{
	// get the absolute path to $file
	$path = pathinfo(realpath($file), PATHINFO_DIRNAME);
	
	$zip = new ZipArchive;
	$res = $zip->open($file);
	if ($res === TRUE) {
		// extract it to the path we determined above
		$zip->extractTo($path);
		$zip->close();
		echo "WOOT! $file extracted to $path";
	} else {
	echo "Doh! I couldn't open $file";
	}
}
$storeDir = dirname(__FILE__);
$zipDir = dirname(dirname(__FILE__));

// $arrayDir = array(
// 	'pdfArticle',
// 	'images',
// 	'assets',
// 	'themes',
// 	'protected',
// 	'framework',
// 	'js',
// 	'marketAreaPicture',
// 	'marketAreaPicture',
// 	'marketAreaPicture',
// 	'marketAreaPicture',
// );
// foreach ($arrayDir as $sDir)
// {
	var_dump(Zip($zipDir , $storeDir . '/'. 'backup.zip'));
// }
// unZip(dirname($storeDir) . '/' . 'backup.zip');
die('done');
?>