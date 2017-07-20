<?php

//  include 'conf.php';

  if ($_FILES["company_logo"]["error"] > 0)
  {
     echo "<font size = '5'><font color=\"#e31919\">Error: NO CHOSEN FILE <br />";
     echo"<p><font size = '5'><font color=\"#e31919\">INSERT TO DATABASE FAILED";
   }
   else
   {
     move_uploaded_file($_FILES["company_logo"]["tmp_name"],"company_logo/" . $_FILES["image"]["name"]);
     echo"<font size = '5'><font color=\"#0CF44A\">SAVED<br>";

     $file="company_logo/".$_FILES["company_logo"]["name"];
     $sql="INSERT INTO company (company_logo) VALUES ('$file')";

     if (!mysql_query($sql))
     {
        die('Error: ' . mysql_error());
     }
     echo "<font size = '5'><font color=\"#0CF44A\">SAVED TO DATABASE";

   }

   mysql_close();

?>