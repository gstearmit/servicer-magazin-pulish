<?php
$check_post = isset($_POST['layout-v3']);
if ($check_post) {
	$content = $_POST['layout-v3'] ;
}else $content = '';

$local_file = dirname(__FILE__) . '\savelayout.html';

$content_file1 = "<html class=\"translated-ltr \">
<head>
<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">
<meta name=\"title\" content=\"applications magazine publishing \">
<meta name=\"description\" content=\"applications magazine publishing \">
<meta name=\"keywords\" content=\"applications magazine publishing \">
<title>applications magazine publishing </title>

<!-- Le styles -->
<link href=\"css/bootstrap-combined.min.css\" rel=\"stylesheet\">
<link href=\"css/layoutit.css\" rel=\"stylesheet\">

<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
		<script src=\"js/html5shiv.js\"></script>
	<![endif]-->

	<!-- Fav and touch icons -->
	<link rel=\"shortcut icon\" href=\"img/favicon.png\">
	
	<script type=\"text/javascript\" src=\"js/jquery-2.0.0.min.js\"></script>
	<!--[if lt IE 9]>
	<script type=\"text/javascript\" src=\"http://code.jquery.com/jquery-1.9.1.min.js\"></script>
	<![endif]-->
	<script type=\"text/javascript\" src=\"js/bootstrap.min.js\"></script>
	<script type=\"text/javascript\" src=\"js/jquery-ui.js\"></script>
	<script type=\"text/javascript\" src=\"js/jquery.ui.touch-punch.min.js\"></script>
<script type=\"text/javascript\" src=\"js/jquery.htmlClean.js\"></script>
<script type=\"text/javascript\" src=\"ckeditor/ckeditor.js\"></script><style>.cke{visibility:hidden;}</style>
<script type=\"text/javascript\" src=\"ckeditor/config.js\"></script>
<script type=\"text/javascript\" src=\"js/scripts.js\"></script>


<body style=\"min-height: 86px; cursor: auto;\" class=\"edit\">
<div class=\"navbar navbar-inverse navbar-fixed-top\">
  <div class=\"navbar-inner\">
    <div class=\"container-fluid\">
      <button data-target=\"nav-collapse\" data-toggle=\"collapse\" class=\"btn btn-navbar\" type=\"button\"> <span class=\"icon-bar\"></span> <span class=\"icon-bar\"></span> <span class=\"icon-bar\"></span> </button>
      <a class=\"brand\" href=\"#\"><img src=\"img/favicon.png\"><font>magazine publishing</font></a>
      <div class=\"nav-collapse collapse\">
      	<ul class=\"nav\" id=\"menu-layoutit\">
          <li class=\"divider-vertical\"></li>
          <li>
            <div class=\"btn-group\">
              <a class=\"btn btn-primary\" href=\"http://#\" target=\"_blank\"><i class=\"icon-home icon-white\"></i><font>Index</font></a>
            </div>
            <div class=\"btn-group\" data-toggle=\"buttons-radio\">
              <button type=\"button\" id=\"edit\" class=\"btn btn-primary active\"><i class=\"icon-edit icon-white\"></i><font>Edit</font></button>
              <button type=\"button\" class=\"btn btn-primary\" id=\"devpreview\"><i class=\"icon-eye-close icon-white\"></i><font>Layout editor files</font></button>
              <button type=\"button\" class=\"btn btn-primary\" id=\"sourcepreview\"><i class=\"icon-eye-open icon-white\"></i><font>Preview</font></button>
            </div>
            <div class=\"btn-group\">
              <button type=\"button\" class=\"btn btn-primary\" data-target=\"#downloadModal\" rel=\"/build/downloadModal\" role=\"button\" data-toggle=\"modal\"><i class=\"icon-chevron-down icon-white\"></i><font>Downloading</font></button>
              <button class=\"btn btn-primary\" href=\"/share/index\" role=\"button\" data-toggle=\"modal\" data-target=\"#shareModal\"><i class=\"icon-share icon-white\"></i><font>Chia sẻ</font></button>
              <button class=\"btn btn-primary\" href=\"#clear\" id=\"clear\"><i class=\"icon-trash icon-white\"></i><font><font>Delete</font></font></button>
            </div>
            <div class=\"btn-group\">
            <!--  
								<button class=\"btn btn-primary\" href=\"#undo\" id=\"undo\"><i class=\"icon-arrow-left icon-white\"></i><font>Quay lại</font></button>
								<button class=\"btn btn-primary\" href=\"#redo\" id=\"redo\"><i class=\"icon-arrow-right icon-white\"></i><font>Đi tiếp</font></button>
		   -->
			</div>
          </li>
        </ul>
       
      </div>
      <!--/.nav-collapse --> 
    </div>
  </div>
</div>";


$content_file2 = "</body></html>";

$content_file = $content_file1.$content.$content_file2;

if (file_exists($local_file)){
	file_put_contents($local_file,$content_file);
}else
	die(' Not Exits File savelayout . Please Try again later and check link '.$local_file.'Is check savelayout.html file exist ? ');




?>