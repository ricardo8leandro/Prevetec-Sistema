<?php
  $arr_scripts = isset($this->list['load_scripts']) ? $this->list['load_scripts'] : null;

  function load_script($nm_item, $arr_scripts){
    if(is_array($arr_scripts) && in_array($nm_item, $arr_scripts)){
      return true;
    }
  }
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
      <meta http-equiv="Expires" content="0">
      <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
      <meta http-equiv="Pragma" content="no-cache">
      
      <meta http-equiv="Content-Type" content="text/html; charset=euc-jp">  
      <title>Prevetec | <?= $this->getTitle(); ?></title>
      <meta name="description" content="<?= $this->getDescription(); ?>">
      <meta name="keywords" content="<?= $this->getKeywords(); ?>">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- Bootstrap core CSS -->

      <!-- variaveis globais -->
      <script type="text/javascript"> 
        var DIR_PAGE    =  <?= "'".DIR_PAGE."'"; ?>;
        const EDITOR_NAME = <?= "'".WYSIWYG_NAME."'"; ?>;
      </script>
      <script src="<?= DIR_JS; ?>global.js"></script>

      <script src="<?= DIR_TEMPLATE; ?>assets/js/jquery/jquery-1.9.1.min.js"></script>
      <link rel="stylesheet" href="<?= DIR_TEMPLATE; ?>assets/css/bootstrap/bootstrap.css" /> 

      <!-- Calendar Styling  -->
      <?php if(load_script('calendar',$arr_scripts)){ ?>
      <link rel="stylesheet" href="<?= DIR_TEMPLATE; ?>assets/css/plugins/calendar/calendar.css" />
      <link rel="stylesheet" href="<?= DIR_TEMPLATE; ?>assets/css/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.css" />
      <?php } ?>

      <?php if(load_script('validator',$arr_scripts)){ ?>
      <link rel="stylesheet" href="<?= DIR_TEMPLATE; ?>assets/css/bootstrap-validator/bootstrap-validator.css" />
      <?php } ?>

      <!-- CKEDITOR -->
      <?php 
        if(load_script('editor',$arr_scripts)){
          include DIR_VIEW.'editor_link.php';
          include DIR_VIEW.'editor_script.php';
          load_editor_link(WYSIWYG_NAME,WYSIWYG_API_KEY);
        }
      ?>
      
      <!-- Fonts  -->
      <link href='https://fonts.googleapis.com/css?family=Raleway:400,500,600,700,300' rel='stylesheet' type='text/css'>
      
      <!-- Base Styling  -->
      <link rel="stylesheet" href="<?= DIR_TEMPLATE; ?>assets/css/app/app.v1.css" />

     	<link rel="stylesheet" href="<?= DIR_CSS; ?>style.css?a=<?= date('U'); ?>">
     	<!-- ICONE DA ABA DO SITE -->
     	<link rel="icon" href="<?= DIR_IMG; ?>favicon.ico">
      
      <?= $this->addHead(); ?>
      <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
      <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
      <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
    </head>
    <body data-ng-app>
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
        <main>
          <?= $this->addMenu(); ?>
          <div class="warper container-fluid">
          <?php if(!empty($this->getMenu())){ ?>
            <div class="page-header col-ms-offset-1">
              
              <!-- <h1><?= $this->list['item_name'] ?>
                <small> <?= $this->list['sub_item_name']; ?></small>
              </h1> -->

            </div>
          <?php } ?>
            <?= $this->addMain(); ?>
          </div>
          
          <?php if(!empty($this->getMenu())){ ?>
            </section>
            <?php 
              if(isset($_SESSION['prev_chat_active']) && $_SESSION['prev_chat_active']){
                include 'chat.php';
              } 
            ?>
          <?php } ?>
        </main>

        <footer>
            <script src="<?= DIR_TEMPLATE; ?>assets/js/plugins/underscore/underscore-min.js"></script>
            <!-- Bootstrap -->
            <script src="<?= DIR_TEMPLATE; ?>assets/js/bootstrap/bootstrap.min.js"></script>
            
            <!-- Globalize -->
            <script src="<?= DIR_TEMPLATE; ?>assets/js/globalize/globalize.min.js"></script>
            
            <!-- NanoScroll -->
            <script src="<?= DIR_TEMPLATE; ?>assets/js/plugins/nicescroll/jquery.nicescroll.min.js"></script>
            
            <?php if(load_script('chart',$arr_scripts)){ ?>
              <!-- Chart JS -->
              <script src="<?= DIR_TEMPLATE; ?>assets/js/plugins/DevExpressChartJS/dx.chartjs.js"></script>
              <script src="<?= DIR_TEMPLATE; ?>assets/js/plugins/DevExpressChartJS/world.js"></script>
              <!-- For Demo Charts -->
              <script src="<?= DIR_TEMPLATE; ?>assets/js/plugins/DevExpressChartJS/demo-charts.js"></script>
              <script src="<?= DIR_TEMPLATE; ?>assets/js/plugins/DevExpressChartJS/demo-vectorMap.js">
              </script>
            <?php } ?>
            
            <!-- Sparkline JS -->
            <script src="<?= DIR_TEMPLATE; ?>assets/js/plugins/sparkline/jquery.sparkline.min.js"></script>
            <!-- For Demo Sparkline -->
            <script src="<?= DIR_TEMPLATE; ?>assets/js/plugins/sparkline/jquery.sparkline.demo.js"></script>
            
            <?php if(load_script('calendar',$arr_scripts)){ ?>
              <!-- Calendar JS -->
              <script src="<?= DIR_TEMPLATE; ?>assets/js/plugins/calendar/calendar.js"></script>
              <!-- Calendar Conf -->
              <script src="<?= DIR_TEMPLATE; ?>assets/js/plugins/calendar/calendar-conf.js"></script>
            <?php } ?>
            
            <?php if(load_script('validator',$arr_scripts)){ ?>
              <script src="<?= DIR_TEMPLATE; ?>assets/js/plugins/bootstrap-validator/bootstrapValidator.min.js"></script>
              <script src="<?= DIR_TEMPLATE; ?>assets/js/plugins/bootstrap-validator/bootstrapValidator-conf.js"></script>
            <?php } ?>

            <?php if( load_script('datatable',$arr_scripts) ){ ?>
            <!-- Data Table -->
            <script src="<?= DIR_TEMPLATE; ?>assets/js/plugins/datatables/jquery.dataTables.js"></script>
            <script src="<?= DIR_TEMPLATE; ?>assets/js/plugins/datatables/DT_bootstrap.js"></script>
            <script src="<?= DIR_TEMPLATE; ?>assets/js/plugins/datatables/jquery.dataTables-conf.js"></script>
            <?php } ?>

            <!-- Custom JQuery -->
            <script src="<?= DIR_TEMPLATE; ?>assets/js/app/custom.js" type="text/javascript"></script>

            <script src="<?= DIR_JS; ?>vanilla-masker/lib/vanilla-masker.js"></script>
            <script src="<?= DIR_JS; ?>mascaras.js"></script>

            <script type="text/javascript" src="<?= DIR_JS; ?>main.js"></script>
            <?= $this->addFooter(); ?>
        </footer>
        <!-- fim da div container fluid -->
    </body>
    <!-- Modal -->
    <div class="modal fade" id="modalExcluir" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="exampleModalLabel">Excluir Item</h4>
          </div>              
          <div class="modal-body">
            Tem certeza que deseja excluir este item?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
            <button type="button" class="btn btn-primary btnConfirmDelete" value="">Sim</button>
          </div>
        </div>
      </div>
    </div>
</html>