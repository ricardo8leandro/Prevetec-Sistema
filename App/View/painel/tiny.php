<script src="<?= DIR_PAGE; ?>public/nanospell/autoload.js"></script>

<form action="" method="POST" enctype="multipart/form-data">
  <textarea id="teste" name="editor" lang="pt-br" spellcheck="true">

    Welcome to TinyMCE!

  </textarea>

  <script>

    tinymce.init({
      selector: '#teste',
      plugins: 'autolink lists media table',
      toolbar: 'code table numlist bullist',
      toolbar_mode: 'floating ',
      tinycomments_mode: 'embedded',
      tinycomments_author: 'Prevetec',
      height : "500",
    });

  </script>

  <br>

  <script type="text/javascript">
    nanospell.ckeditor('teste',{
      dictionary : "en",  // 24 free international dictionaries  
      server : "php"      // can be php, asp, asp.net or java
   }); 
  </script>

  <button type="submit">enviar</button>

</form>