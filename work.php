<?php
/*
	vpms: A simple newsletter system

    Copyright (C) 2016  Vadim Prishlyak
	http://sw.pvadimr.ru
	pvadimr@outlook.com

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>
*/

include('./settings.php');
include('./lang/'.$lang);

session_start(); 
if($_SESSION['aa']==0) {
	print "access error";
	die();
}


preg_match_all('/(.*?)\|(.*?)\|/s',file_get_contents('./hb.dat'), $recipients);
$patterns = file_get_contents('./patterns.dat');
$text=$_POST['mess'];
$counter=count($recipients[0])-1;

$subject = $set_subject;
if (isset($_POST['send'])) 
{
	$to_send = $counter + 1;
	print "<html>\n<head>\n<meta content=\"text/html; charset='.$lang_encoding.'\" http-equiv=\"content-type\">\n<title>'.$lang_sending.'</title>";
	print "<a href=\"javascript: self.close ()\">".$lang_btn_close."</a>";
	print "\n<br>".$lang_to_send.":<strong>$to_send</strong>";
	for($i=0; $i<=$counter; $i++) {
	
	$pattern=$patterns;
	$pattern=str_replace('$name$',$recipients[1][$i],$pattern);
	$pattern=str_replace('$message$',$text,$pattern);

	$headers  = "Content-type: text/html; charset=".$lang_encoding." \r\n"; 
	$headers .= "From: ".$mail."\r\n"; 


	$to=$recipients[2][$i];
	
	print "\n<br>".$lang_sending_to.": <strong>".$to."</strong>";
	mail($to, $subject, $pattern, $headers);
}
print "\n<br>".$lang_sending_successfull.".";
print '<script>setTimeout(function () { self.close();}, 2000);</script>';
print "\n</body>\n</html>";
}
if (isset($_POST['preview'])){
	print "<html>\n<head>\n<meta content=\"text/html; charset=".$lang_encoding."\" http-equiv=\"content-type\">\n<title>".$lang_preview."</title>";
	print "\n</head>\n<body>";
	print "<a href=\"javascript: self.close ()\">".$lang_btn_close."</a>";
	$pattern=$patterns;
	$pattern=str_replace('$name$',"<strong>username</strong>",$pattern);
	$pattern=str_replace('$message$',$text,$pattern);
	print "\n</body>\n</html>";

	print "$pattern";
}
if (isset($_POST['save'])){
	file_put_contents('./preview.dat',$text);
	print "<html>\n<head>\n<meta content=\"text/html; charset=".$lang_encoding."\" http-equiv=\"content-type\">\n<title>".$lang_saving_email."</title>";
	print '<script>setTimeout(function () { self.close();}, 1000);</script>';
	print "</head>\n<body>";
	print "\n<form name=\"close_form\">";
	print "\n<br>".$lang_message_saved.".";
	print "<br><a href=\"javascript: self.close ()\">".$lang_btn_close."</a>";
	print "\n</body>\n</html>";
}

?>
