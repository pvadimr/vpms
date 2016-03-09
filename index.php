<?
/*
	vpms: A simple newsletter system

    Copyright (C) 2016  Vadim Prishlyak
	http://pvadimr.ru/sw/vpms/
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
define ('VPMS_access', true);

include('./settings.php');
include('./lang/'.$lang);
session_start(); 
$hide=$_POST['hidden'];
$pass=$_POST['pass'];
$cat=$_GET['cat'];
$login=$_POST['login'];
$type=$_POST['type'];
$text=$_POST['text'];
require_once('header.php');
if (isset($_REQUEST['log_out']) or !isset($_SESSION['aa']))$_SESSION['aa']=0;
if ($_SESSION['aa']==0){
if ($hide!='' and $pass==$password_admin and $login==$login_admin){$_SESSION['aa']=1; $hide=null;}
else{
$content='<form action="" method=post>
<input value="goaa" type="hidden" name="hidden"/>
'.$lang_login.'&#160;&#160;<input type="text" name="login" value="" /><br />
'.$lang_password.'<input type="password" name="pass" value="" /><br /><br />
<input value="'.$lang_btn_login.'" type="submit" id="bb_blue"/>
</form>';
}
}
if ($_SESSION['aa']==1) {
$content.='<br><form action="./?log_out" method=post>
<a href="./?cat=recipients" id="bb_blue">'.$lang_btn_recipients.'</a>
<a href="./?cat=write" id="bb_blue">'.$lang_btn_write.'</a>
<a href="./?cat=pat" id="bb_blue">'.$lang_btn_pattern.'</a>
<a href="./?cat=conf" id="bb_blue">'.$lang_btn_settings.'</a>
<a href="./" id="bb_blue">'.$lang_btn_help.'</a>
<input value="log_out" type="hidden" name="log_out"/>
<input type=submit id="bb_blue" value="'.$lang_btn_logout.'" style="width:auto"/>
</form>
<br><br>';

switch($cat)
{
case "pat":
if($hide!=''){
file_put_contents('./patterns.dat',$text);
$content.='<h1>'.$lang_template_updated.'</h1>';
}
else{
$content.='
<form action="" method=post>
<input value="hidden" type="hidden" name="hidden"/>
<textarea name="text" class="text_edit" style="width:100%" rows=15>'.file_get_contents('./patterns.dat').'</textarea>
<input type=submit id="bb_gray" value="'.$lang_btn_save.'" style="width:auto"/>
</form>';}
break;
case "write":
$content.=$lang_write_message.'
<form action="work.php" method=post target="_blank" onsubmit="target_popup(this)">
<textarea name="mess" class="text_edit" style="width:100%" rows=15>'.file_get_contents('./preview.dat').'</textarea>
<input type=submit id="bb_gray" name="send" value="'.$lang_btn_send.'" style="width:auto"/>
<input type=submit id="bb_gray" name="save" value="'.$lang_btn_save.'" style="width:auto"/>
<input type=submit id="bb_gray" name="preview" value="'.$lang_btn_preview.'" style="width:auto"/>
</form>';
break;
case "conf":
$lang_counter = 0;

$content.="
<form action=\"\" method=post>
$lang_login <input type=text value=\"$login_admin\" name=\"admin\"><br>
$lang_password <input type=password value=\"$login_password\" name=\"password\"><br>
$lang_mail_from <input type=text value=\"$mail\" name=\"mail\"><br>
$lang_mail_bcc <input type=text value=\"$hide_mail\" name=\"hidemail\"><br>
$lang_lang <select>";
foreach (glob("lang/*.php") as $filename) {
	$filename = str_replace("lang/","",$filename);
    $content.="<option value=\"$filename\">$filename</option>\n";
}
$content.="</select><br>
$lang_subject <input type=text value=\"$set_subject\" name=\"subject\"><br>
<input type=submit id=\"bb_gray\" value=\"$lang_btn_save\" style=\"width:auto\"/>
</form>";
break;
case "recipients":
if($hide!=''){
file_put_contents('./hb.dat',$text);
$content.='<h1>'.$lang_template_updated.'</h1>';
}
else{
$content.='<form action="" method=post>
<input value="hidden" type="hidden" name="hidden"/>
<textarea name="text" style="width:100%" rows=15>'.file_get_contents('./hb.dat').'</textarea>
<input type=submit id="bb_gray" value="'.$lang_btn_save.'" style="width:auto"/>
</form>
';}
break;
default:
$content.= file_get_contents('./lang/'.$lang_help);
}

}

echo $content;

require_once('footer.php');
?>
