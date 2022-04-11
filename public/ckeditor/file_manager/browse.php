<?php  
header("Content-Type: text/html; charset=utf-8\n");  
header("Cache-Control: no-cache, must-revalidate\n");  
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

$http = 'https://';

if($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off"){
    $http = 'https://';
}

$dir_base = $http.$_SERVER['HTTP_HOST'];

if(!defined('DIR_TEMPLATE'))
    define('DIR_TEMPLATE', $dir_base.'/public/template/assets/');


// e-z params  
$dim = 150;         /* image displays proportionally within this square dimension ) */  
$cols = 4;          /* thumbnails per row */
$thumIndicator = ''; /* e.g., *image123_th.jpg*) -> if not using thumbNails then use empty string */  
?>  
<!DOCTYPE html>
<html>  
<head>  
    <title>browse file</title>  
    <meta charset="utf-8">
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="<?= DIR_TEMPLATE; ?>css/bootstrap/bootstrap.css" /> 

    <!-- datatables Styling  -->
    <link rel="stylesheet" href="<?= DIR_TEMPLATE; ?>css/plugins/datatables/jquery.dataTables.css" />
    
    <!-- Fonts  -->
    <link href='http://fonts.googleapis.com/css?family=Raleway:400,500,600,700,300' rel='stylesheet' type='text/css'>
    
    <!-- Base Styling  -->
    <link rel="stylesheet" href="<?= DIR_TEMPLATE; ?>css/app/app.v1.css" />
    <link rel="stylesheet" type="text/css" href="browse.css">

</head>  
<body>

 <!-- Preloader -->
    <div class="loading-container">
      <div class="loading">
        <div class="l1">
          <div></div>
        </div>
        <div class="l2">
          <div></div>
        </div>
        <div class="l3">
          <div></div>
        </div>
        <div class="l4">
          <div></div>
        </div>
      </div>
    </div>
    <!-- Preloader -->
<table class="table">  

<?php  

$dir = $dir_base.'/public/ckeditor/uploads/';
$dir_src = $_SERVER['DOCUMENT_ROOT'] . '/public/ckeditor/uploads/';

$dir = rtrim($dir, '/'); // the script will add the ending slash when appropriate

if(isset($_POST['remove'])){
    if(file_exists($dir_src.'/'.$_POST['remove'])){
        unlink($dir_src.'/'.$_POST['remove']);
    }
}

$files = scandir($dir_src);  

$images = array();

if(count($images) == 0){
    echo "<center><h2>Não há imagens na galeria</h2></center>";
}

foreach($files as $file){
    // filter for thumbNail image files (use an empty string for $thumIndicator if not using thumbnails )
    if( !preg_match('/'. $thumIndicator .'\.(jpg|jpeg|png|gif)$/i', $file) )  
        continue;  

    $thumbSrc = $dir . '/' . $file;  
    $fileBaseName = str_replace('_th.','.',$file);  

    $image_info = getimagesize($thumbSrc);  
    $_w = $image_info[0];  
    $_h = $image_info[1]; 

    if( $_w > $_h ) {       // $a is the longer side and $b is the shorter side
        $a = $_w;  
        $b = $_h;  
    } else {  
        $a = $_h;  
        $b = $_w;  
    }     

    $pct = $b / $a;     // the shorter sides relationship to the longer side

    if( $a > $dim )   
        $a = $dim;      // limit the longer side to the dimension specified

    $b = (int)($a * $pct);  // calculate the shorter side

    $width =    $_w > $_h ? $a : $b;  
    $height =   $_w > $_h ? $b : $a;  

    $btn = '<button class="btn btn-danger btn-remove" value="'.$file.'">X</button>';

    // produce an image tag
    $str = sprintf($btn.'<img src="%s" width="%d" height="%d" title="%s" alt="">',   
        $thumbSrc,  
        $width,  
        $height,  
        $fileBaseName  
    );  

    // save image tags in an array
    $images[] = str_replace("'", "\\'", $str); // an unescaped apostrophe would break js  

}

$numRows = floor( count($images) / $cols );  

if( count($images) % $cols != 0 )  
    $numRows++;  


// produce the correct number of table rows with empty cells
for($i=0; $i<$numRows; $i++)   
    echo "\t<tr>" . implode('', array_fill(0, $cols, '<td></td>')) . "</tr>\n\n";  

?>  
</table>
<form class="remove" method="post">
    <input type="hidden" class="remove" name="remove" value="">
</form>

<script>  

// make a js array from the php array
images = [  
<?php   

foreach( $images as $v)  
    echo sprintf("\t'%s',\n", $v);  

?>];  

tbl = document.getElementsByTagName('table')[0];  

td = tbl.getElementsByTagName('td');  

// fill the empty table cells with the img tags
for(var i=0; i < images.length; i++)  
    td[i].innerHTML = images[i];  


// event handler to place clicked image into CKeditor
tbl.onclick =   

    function(e) {  

        var tgt = e.target || event.srcElement,  
            url;  

        if( tgt.nodeName != 'IMG' )  
            return;  

        url = '<?php echo $dir;?>' + '/' + tgt.title;  
        this.onclick = null;  
        // $_GET['CKEditorFuncNum'] was supplied by CKeditor
        window.opener.CKEDITOR.tools.callFunction(<?php echo $_GET['CKEditorFuncNum']; ?>, url);  
        window.close();  
    }  
</script>
    <!-- JQuery v1.9.1 -->
    <script src="<?= DIR_TEMPLATE; ?>js/jquery/jquery-1.9.1.min.js" type="text/javascript"></script>

    <!-- Bootstrap -->
    <script src="<?= DIR_TEMPLATE; ?>js/bootstrap/bootstrap.min.js"></script>

    <!-- NanoScroll -->
    <script src="<?= DIR_TEMPLATE; ?>js/plugins/nicescroll/jquery.nicescroll.min.js"></script>


    <!-- Data Table -->
    <script src="<?= DIR_TEMPLATE; ?>js/plugins/datatables/jquery.dataTables.js"></script>
    <script src="<?= DIR_TEMPLATE; ?>js/plugins/datatables/DT_bootstrap.js"></script>
    <script src="<?= DIR_TEMPLATE; ?>js/plugins/datatables/jquery.dataTables-conf.js"></script>
    <script src="<?= DIR_TEMPLATE; ?>js/app/custom.js" type="text/javascript"></script>
    <script type="text/javascript" src="remove-image.js"></script>
</body>  
</html> 