<?php
$check_post = isset($_POST['layout-v3']);
if ($check_post) {
	$content = $_POST['layout-v3'] ;
}else $content = '';

$local_file = dirname(__FILE__) . '\zip\index.html';
return var_dump($local_file);

$content_file1 = "<html class=\"translated-ltr \">
<head>
<meta charset=\"utf-8\">
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


<body>"
;


$content_file2 = "</body></html>";

$content_file = $content_file1.$content.$content_file2;

//return var_dump($content_file);
if (file_exists($local_file)){
   file_put_contents($local_file, $content_file);
}else 
	die(' Not Exits File index.html . Please Try again later and check link '.$local_file.'Is check index.html file exist ? ');




?>


<?php
$the_folder = dirname(__FILE__) . '/zip/'; 
		
$zip_file_name = 'appmagazine.zip';


$download_file= true;
//$delete_file_after_download= true; doesnt work!!


class FlxZipArchive extends ZipArchive {
    /** Add a Dir with Files and Subdirs to the archive;;;;; @param string $location Real Location;;;;  @param string $name Name in Archive;;; @author Nicolas Heimann;;;; @access private  **/

    public function addDir($location, $name) {
        $this->addEmptyDir($name);

        $this->addDirDo($location, $name);
     } // EO addDir;

    /**  Add Files & Dirs to archive;;;; @param string $location Real Location;  @param string $name Name in Archive;;;;;; @author Nicolas Heimann
     * @access private   **/
    private function addDirDo($location, $name) {
        $name .= '/';
        $location .= '/';

        // Read all Files in Dir
        $dir = opendir ($location);
        while ($file = readdir($dir))
        {
            if ($file == '.' || $file == '..') continue;
            // Rekursiv, If dir: FlxZipArchive::addDir(), else ::File();
            $do = (filetype( $location . $file) == 'dir') ? 'addDir' : 'addFile';
            $this->$do($location . $file, $name . $file);
        }
    } // EO addDirDo();
}

$za = new FlxZipArchive;
$res = $za->open($zip_file_name, ZipArchive::CREATE);
if($res === TRUE) 
{
    $za->addDir($the_folder, basename($the_folder));
    $za->close();
}
else  { echo 'Could not create a zip archive';}

if ($download_file)
{
    ob_get_clean();
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private", false);
    header("Content-Type: application/zip");
    header("Content-Disposition: attachment; filename=" . basename($zip_file_name) . ";" );
    header("Content-Transfer-Encoding: binary");
    header("Content-Length: " . filesize($zip_file_name));
    readfile($zip_file_name);
	$download_file= false;

}

//return $res;
?>