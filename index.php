<?
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
$hide=$_POST['hidden'];
$pass=$_POST['pass'];
$cat=$_GET['cat'];
$login=$_POST['login'];
$type=$_POST['type'];
$text=$_POST['text'];
print "<!DOCTYPE html>";
print "<html>\n";
print "<head>\n";
print "<meta charset=\"".$lang_encoding."\">\n";
print '<title>'.$lang_title.'</title>';
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
<a href="./?cat=recipients" id="bb_gray">'.$lang_btn_recipients.'</a>
<a href="./?cat=write" id="bb_gray">'.$lang_btn_write.'</a>
<a href="./?cat=pat" id="bb_blue">'.$lang_btn_pattern.'</a>
<a href="./?cat=conf" id="bb_blue">'.$lang_btn_settings.'</a>
<a href="./" id="bb_blue">'.$lang_btn_help.'</a>
<input value="log_out" type="hidden" name="log_out"/>
<input type=submit id="bb_gray" value="'.$lang_btn_logout.'" style="width:auto"/>
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
?>
<link rel="stylesheet" href="./css.css" type="text/css" media="screen" />
<script src="js/tinymce/tinymce.min.js"></script>
<script>tinymce.init({
  mode : "specific_textareas",  language: '<?php print $lang_tinymce?>', editor_selector:'text_edit',
  theme: 'modern',
  plugins: [
    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
    'searchreplace wordcount visualblocks visualchars code fullscreen',
    'insertdatetime media nonbreaking save table contextmenu directionality',
    'template paste textcolor colorpicker textpattern imagetools'
  ],
  toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
  toolbar2: 'print preview media | forecolor backcolor emoticons code',
  image_advtab: true,
  templates: [
    { title: 'Test template 1', content: 'Test 1' },
    { title: 'Test template 2', content: 'Test 2' }
  ],
  content_css: [
    '//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
    '//www.tinymce.com/css/codepen.min.css'
  ]
 });
 </script>
 <script>
 function target_popup(form) {
    window.open('', 'formpopup', 'width=750,height=400,resizeable,scrollbars');
    form.target = 'formpopup';
}
 </script>
 </head>
<body><div id="message" style="display: none;"><h1></h1></div>
<div id="message" class="load" style="display: none;"><img src="./loading.gif" /></div>
<center>

<h1><a style="text-decoration: none;" href="./"><img src="images/logo.jpg"></a></h1>

<h2 style="margin-top:5px"></h2>
<br/><br/>

<div class="block">
<?echo $content;?>
</div>
</center>
<center>(c) 2016 Prishlyak Vadim<br>
</b></center>
</body></html>
