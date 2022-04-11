<style type="text/css">
	#cert_viewer1,#cert_viewer2{
		width:100%;
		height:50px;
	}
</style>

<form action="" method="POST" enctype="multipart/form-data">
	<div class="form-group">
        <div class="col-sm-12 text-center">
            <h3>Primeiro Certificado</h3>
            <div class="col-sm-12">
	            <div style="clear:both">
	               <iframe id="cert_viewer1" frameborder="0" scrolling="no" ></iframe>
            	</div>
            </div>

            <input 
                type="file" name="cert1" 
                id="cert1"  onchange="PreviewImage(1);" style="display:none">

            <input 
                type="file" name="cert2" 
                id="cert2"  onchange="PreviewImage(2);" style="display:none">

            
            <div class="col-sm-offset-4 col-sm-4">
            	<br><br>
                <button type="button" id="btnAddCert1" class="btn btn-warning btn-block" >
                    Enviar primeiro certificado
                </button>
                <br>
            </div> 
                
            <hr>
            
            <div class="col-sm-12">
                <h3>Segundo Certificado</h3>
                <div style="clear:both">
                   <iframe id="cert_viewer2" frameborder="0" scrolling="no" ></iframe>
                </div>
            </div>

            <div class="col-sm-offset-4 col-sm-4">
            <br>
                <button type="button" id="btnAddCert2" class="btn btn-warning btn-block" >
                    Enviar segundo certificado
                </button>
                <br>
            </div>
         <!--    <br>
            <hr>
            <div class="col-sm-offset-4 col-sm-4">
                <button type="submit"  class="btn btn-success btn-block" >
                    Salvar
                </button>
            </div> -->
        </div>
    </div>
</form>
<script type="text/javascript">
	var url_cert_pdf1 = '';
    var url_cert_pdf2 = '';

	<?php 
	    $req_cert_pdf1 = DIR_REQ."public/laudosPDF/cert1.pdf";
	    $path_cert_pdf1 = DIR_PAGE."public/laudosPDF/cert1.pdf";

        $req_cert_pdf2 = DIR_REQ."public/laudosPDF/cert2.pdf";
        $path_cert_pdf2 = DIR_PAGE."public/laudosPDF/cert2.pdf";

	    if(file_exists($req_cert_pdf1)){
            echo 'url_cert_pdf1  = "'.$path_cert_pdf1.'";';
        }

        if(file_exists($req_cert_pdf1)){
            echo 'url_cert_pdf2  = "'.$path_cert_pdf2.'";';
        }
	?>

    if(url_cert_pdf1 != ''){
        $('#cert_viewer1').attr('src',url_cert_pdf1);
        $('#cert_viewer1').css('height','600px');
    }

    if(url_cert_pdf2 != ''){
        $('#cert_viewer2').attr('src',url_cert_pdf2);
        $('#cert_viewer2').css('height','600px');
    }

    function PreviewImage(nr) {
        $('form').trigger('submit');
        $('#btnAddCert1').attr('disabled','disabled');
        $('#btnAddCert2').attr('disabled','disabled');
        return;
        // pdffile     = document.getElementById("cert"+nr).files[0];
        // pdffile_url = URL.createObjectURL(pdffile);
        // $('#cert_viewer'+nr).attr('src',pdffile_url);
        // $('#cert_viewer'+nr).css('height','600px');
    }

    var msg = <?= "'".$this->list['msg']."'"; ?>;

    if(msg != '') alert(msg);

</script>


    