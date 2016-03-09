<?php
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
if (!defined ('VPMS_access')) { Header ('Location: index.php'); exit; }
print "<!DOCTYPE html>";
print "<html>\n";
print "<head>\n";
print "<meta charset=\"".$lang_encoding."\">\n";
print '<title>'.$lang_title.'</title>';
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