<?php 

set_time_limit(0);
ini_set('memory_limit', '-1');

//---- Database host, name user and pass.
//---- Change these to match your mysql database.

$db_host = 'localhost';	//---- Database host(usually localhost).
$db_name = 'jpofficedb_japan';	//---- Your database name.
$db_user = 'jpofficedb_japan';	//---- Your database username.
$db_pass = 'ZvmAb6H3z6wBSKmG';	//---- Your database password.
$dowhat = "backup";

function __backup_mysql_database($params)
{
    $mtables = array(); $contents = "-- Database: `".$params['db_to_backup']."` --\n";
    
    $mysqli = new mysqli($params['db_host'], $params['db_uname'], $params['db_password'], $params['db_to_backup']);
    if ($mysqli->connect_error) {
        die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
    }

	$mysqli->set_charset("utf8");
    
    $results = $mysqli->query("SHOW TABLES");
    
    while($row = $results->fetch_array()){
        if (!in_array($row[0], $params['db_exclude_tables'])){
            $mtables[] = $row[0];
        }
    }

    foreach($mtables as $table){
        $contents .= "-- Table `".$table."` --\n";
        
        $results = $mysqli->query("SHOW CREATE TABLE ".$table);
        while($row = $results->fetch_array()){
            $contents .= $row[1].";\n\n";
        }

        $results = $mysqli->query("SELECT * FROM ".$table);
        $row_count = $results->num_rows;
        $fields = $results->fetch_fields();
        $fields_count = count($fields);
        
        $insert_head = "INSERT INTO `".$table."` (";
        for($i=0; $i < $fields_count; $i++){
            $insert_head  .= "`".$fields[$i]->name."`";
                if($i < $fields_count-1){
                        $insert_head  .= ', ';
                    }
        }
        $insert_head .=  ")";
        $insert_head .= " VALUES\n";        
                
        if($row_count>0){
            $r = 0;
            while($row = $results->fetch_array()){
                if(($r % 400)  == 0){
                    $contents .= $insert_head;
                }
                $contents .= "(";
                for($i=0; $i < $fields_count; $i++){
                    $row_content =  str_replace("\n","\\n",$mysqli->real_escape_string($row[$i]));
                    
                    switch($fields[$i]->type){
                        case 8: case 3:
                            $contents .=  $row_content;
                            break;
                        default:
                            $contents .= "'". $row_content ."'";
                    }
                    if($i < $fields_count-1){
                            $contents  .= ', ';
                        }
                }
                if(($r+1) == $row_count || ($r % 400) == 399){
                    $contents .= ");\n\n";
                }else{
                    $contents .= "),\n";
                }
                $r++;
            }
        }
    }
    
    if (!is_dir ( $params['db_backup_path'] )) {
            mkdir ( $params['db_backup_path'], 0777, true );
     }
    
    $backup_file_name = "sql-backup-".date( "d-m-Y--h-i-s").".sql";
         
    $fp = fopen($backup_file_name ,'w+');
    if (($result = fwrite($fp, $contents))) {
        echo "Backup file created '--$backup_file_name' ($result)"; 
    }
    fclose($fp);
}

////////////////////////////////////////////////////////////////////////////////
//
//		Class name: mysql_backup
//		PHP version: 4.0.2
//		Function: Back up/Restore a MySql db.
//		Written by: Peyman Hooshmandi Raad
//		Date: Jan 9, 2003
//		Contact: captain5ive@yahoo.com
//=============================================================================
//
//		Methods:
//=============================================================================
//		1) Backup this method will back up the whole database.
//		$output: text file name and path(the one that holds backup)
//		$structure_only: (true / false)
//				true : backup method will only make backup from tables NOT the data.
//				false : backup method will make backup from tables and the data(WHOLE DB).
//
//		2) Restor This method will create table with data from a txt file.
//
//		Copyright: this class is free for non commercial uses.
//
////////////////////////////////////////////////////////////////////////////////
class mysql_backup
{
	//---- Class Variables.
	//---------------------
	var $host; //---- host name e.g. localhost
	var $db; //---- db name
	var $user; //---- db username
	var $pass; //---- db password
	var $output; //---- file name(sqldata.txt)
	var $structure_only; //---- Output method : true/false
	var $fptr; //---- Do Not change this.
	//---------------------

	//---- Constructor function: This will Inisialize variables.
	//----------------------------------------------------------
	function mysql_backup($host,$db,$user,$pass,$output,$structure_only)
	{
		set_time_limit (120);
		$this->host = $host;
		$this->db = $db;
		$this->user = $user;
		$this->pass = $pass;
		$this->output = $output;
		$this->structure_only = $structure_only;
	}
	//----------------------------------------------------------

	//---- This will create the sqldata.txt file.
	//-------------------------------------------
	function _Mysqlbackup($host,$dbname, $uid, $pwd, $output, $structure_only)
	{

		if (strval($this->output)!="") $this->fptr=fopen($this->output,"w"); else $this->fptr=false;

		//connect to MySQL database
		$con=mysql_connect($this->host,$this->user, $this->pass);
		$db=mysql_select_db($dbname,$con);

		@mysql_query("SET NAMES UTF8", $con);
		//open back-up file ( or no file for browser output)

		//set up database
		//out($this->fptr, "create database $dbname;\n\n");

		//enumerate tables
		$res=mysql_query( 'SHOW TABLES FROM `' . $dbname  . '`') or die("Query SHOW TABLES FROM " . $dbname . " failed: " . mysql_error());
		$nt=mysql_num_rows($res);

		$tables = array();
		while ($row = mysql_fetch_assoc($res)) {
		   $tables[] = current($row);
		}
		
		$excludeTables = array();
		//$excludeTables = array('ps_category', 'ps_category_group', 'ps_category_lang', 'ps_category_product', 'ps_category_shop');
		for ($a=0;$a<$nt;$a++)
		{
			$tablename=$tables[$a];

			if (in_array($tablename, $excludeTables)) continue;
			
			//start building the table creation query
			$sql="create table $tablename\n(\n";

			$query = "select * from `$tablename`";
			$res2=mysql_query($query,$con) or die("Query $query failed: " . mysql_error());
			$nf=mysql_num_fields($res2);
			$nr=mysql_num_rows($res2);

			$fl="";

			if ($this->structure_only!=true)
			{
				//parse out the table's data and generate the SQL INSERT statements in order to replicate the data itself...
				for ($c=0;$c<$nr;$c++)
				{
					$sql="REPLACE into $tablename ($fl) values (";

					$row=mysql_fetch_row($res2);

					for ($d=0;$d<$nf;$d++)
					{
						if ($row[$d] === NULL)
						{
							$sql.= "NULL";
						}
						else
						{
							$sql.="\"".mysql_real_escape_string(strval($row[$d]))."\"";
						}

						if ($d<($nf-1)) $sql.=", ";

					}

					$sql.=");" . PHP_EOL;
					//echo $sql;
					$this->_Out($sql);

				}

				$this->_Out('');

			}
			
			if ($this->structure_only==true)
			{

				$result2 = mysql_query("SHOW CREATE TABLE `".$tablename."`") or die("Query " . "SHOW CREATE TABLE `".$tablename."`" . " failed: " . mysql_error());
				$row2 = mysql_fetch_row($result2);
				$sql = '';
				if (trim($row2[1]))
				{
					$sql .= $row2[1] . ";\n";
					$this->_Out($sql);
				}
				
				$this->_Out("");

			}

			mysql_free_result($res2);

		}

		if ($this->fptr!=false) fclose($this->fptr);






		return 0;

	}
	//-------------------------------------------

	//---- This will Open sqldata.txt.
	//--------------------------------
	function _Open()
	{
		$filename = $this->output;
		$fp = fopen( $filename, "r" ) or die("Couldn't open $filename");
		while ( ! feof( $fp ) )
		{
			$line = fgets( $fp, 1024 );
			$SQL .= "$line";
		}
		return $SQL;
	}
	//--------------------------------

	//---- This will Restore data in sqldata.txt
	//------------------------------------------
	
	//---------------------------------------------------------

	//---- This will put data in sqldata.txt
	//------------------------------------------
	function _out($s)
	{
		if ($this->fptr==false) echo("$s"); else fputs($this->fptr,$s);
	}
	//------------------------------------------

	//---- This is the function to be called for backup.
	//--------------------------------------------------
	function Backup()
	{
		$this->_Mysqlbackup($this->host,$this->db,$this->user,$this->pass,$this->output,$this->structure_only);
		return 1;
	}
	//--------------------------------------------------
}

function Zip($source, $destination)
{
	if (!extension_loaded('zip') || !file_exists($source)) {
		return false;
	}

	$zip = new ZipArchive();
	if (!$zip->open($destination, ZIPARCHIVE::CREATE)) {
		return false;
	}

	$source = str_replace('\\', '/', realpath($source));

	if (is_dir($source) === true)
	{
		$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);

		foreach ($files as $file)
		{
			$file = str_replace('\\', '/', $file);

			// Ignore "." and ".." folders
			if( in_array(substr($file, strrpos($file, '/')+1), array('.', '..')) )
				continue;

			$file = realpath($file);

			if (is_dir($file) === true)
			{
				$zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
			}
			else if (is_file($file) === true)
			{
				$zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
			}
		}
	}
	else if (is_file($source) === true)
	{
		$zip->addFromString(basename($source), file_get_contents($source));
	}

	return $zip->close();
}

if ($dowhat == "backup") {

	$structure_only = true;
		$output = 'backup_structure.sql';
		$backup = new mysql_backup($db_host,$db_name,$db_user,$db_pass,$output,$structure_only);
		$backup->backup();	
		$file = dirname(__FILE__) . '/' . $output;
		Zip($file, $file . '.zip');
	
	$structure_only = false;
	$output = 'backup_data.sql';
	$backup = new mysql_backup($db_host,$db_name,$db_user,$db_pass,$output,$structure_only);
	$backup->backup();

	$file = dirname(__FILE__) . '/' . $output;
	Zip($file, $file . '.zip');
}

$para = array(
    'db_host'=> $db_host,  //mysql host
    'db_uname' => $db_user,  //user
    'db_password' => $db_pass, //pass
    'db_to_backup' => $db_name, //database name
    'db_backup_path' => dirname(__FILE__), //where to backup
    'db_exclude_tables' => array() //tables to exclude
);

//__backup_mysql_database($para);
?>