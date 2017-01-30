<?php 
  include 'assets/config.php';  

  if (isset($_FILES['excel-file']))
  {
    $Filepath = $_FILES['excel-file']['tmp_name'];
  }
  if(isset($_FILES['excel-file'])&&($_FILES['excel-file']["name"]!=''))
  {
      $mode = 0777;                                   
      $target_dir     = "assets/excel-uploads/";
      if(!is_dir($target_dir))
      {
          mkdir($target_dir,$mode, true);          
      }

      $filename_arr = explode(".",$_FILES["excel-file"]["name"]);
      $file_ext = $filename_arr[count($filename_arr)-1];
      $file_name      = time()."uploaded_file".rand().".".$file_ext;
      $upload_path    = $target_dir.$file_name;
      move_uploaded_file($_FILES["excel-file"]["tmp_name"],$upload_path);
  }
  
  // Excel reader from http://code.google.com/p/php-excel-reader/
  require('assets/excel-reader/php-excel-reader/excel_reader2.php');
  require('assets/excel-reader/SpreadsheetReader.php');

  $excel_arr = [];
  try
  {
    $Spreadsheet = new SpreadsheetReader($upload_path);
    $BaseMem = memory_get_usage();

    $Sheets = $Spreadsheet -> Sheets();

    foreach ($Sheets as $Index => $Name)
    {
      $Time = microtime(true);

      $Spreadsheet -> ChangeSheet($Index);

      foreach ($Spreadsheet as $Key => $Row)
      {
        if ($Row)
        {
          $excel_arr[] = $Row;
        }
      }
    }
  }
  catch (Exception $E)
  {
    $error = $E -> getMessage();
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Excel</title>
  <link rel="shortcut icon" href="favicon.png" type="image/x-icon">
  <!-- Admin CSS -->
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet"  type="text/css" href="assets/dist/css/AdminLTE.min.css">
  <!-- Skin CSS -->
  <link rel="stylesheet"  type="text/css" href="assets/dist/css/skins/skin-blue.min.css">    
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="assets/js/jquery.min.js"></script> 
</head>
<body>   
  <div class="container-fluid"> <!-- div closed in footer -->   
    <!-- Main Header -->
    <style type="text/css">
      .select2-selection__rendered{
        padding-left: 10px !important;
      }
      .select2-container--default .select2-selection--multiple{
        border-radius: 0px !important;
        border: 1px solid #d2d6de;
      }
      .select2-selection__choice{
        color: black !important;
      }
    </style>
    <!-- Content Wrapper. Contains page content -->
    <div class="col-md-12">
      <!-- Main content -->
      <section class="content">
        <div class="tab-pane fade in active">
          <!-- Add Excel form -->
          <!-- form start -->
          <h3>Step 1:</h3>
          <form role="form" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST" enctype="multipart/form-data" id="add-excel-form" name="add-excel-form">
            <div class="box-body">
              <div class="form-group col-md-5">
                <label for="exe-image">Upload Excel</label><br/>
                <div class="input-group col-md-12">
                  <span class="input-group-btn">
                    <span class="btn btn-primary btn-file">
                      Browse&hellip; <input type="file" name="excel-file" id="excel-file" onchange="showimagepreview(this)">
                    </span>
                  </span>
                  <input type="text" class="form-control" readonly value="<?php echo $_FILES['excel-file']['name'] ?>">
                </div>
                <span class="red" id="error-excel-file"></span>
              </div>
              <div class="col-md-12" id="excel-add-button">
                <button type="submit" id="add-excel" class="btn btn-primary">Upload</button>
                <hr>
              </div>
            </div><!-- /.box-body -->
          </form>
        </div>
        <div class="tab-pane fade in active">
          <!-- Send Notification form start -->
          <h3>Step 2:</h3>
          <form role="form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="send-notification-form">
            <div class="box-body">
              <div class="form-group col-md-5">
                <label for="store-name">Phone Number Field</label>
                <select id="phone" name="phone" class="form-control" required="required">
                  <option value="" style="display:none">Select</option>
                  <?php 
                  foreach ($excel_arr[0] as $key => $value) {
                    ?>
                    <option value="<?php echo $key ?>"><?php echo htmlspecialchars_decode($value) ?></option>
                    <?php
                  } ?>
                </select>
                <span class="red" id="error-phone"></span>
              </div>
              <div class="form-group col-md-5">
                <label for="subtitle">Notification Sub-title</label>
                <input type="text" class="form-control" id="subtitle" name="subtitle" placeholder="Enter ..." value="" required>
                <span class="red" id="error-subtitle"></span>
              </div>
              <div class="clearfix"></div>
              <div class="form-group col-md-5">
                <label for="store-name">Select Message Fields (Double click to select fields)</label>
                <select id="message-fields" name="message-fields" ondblclick="addToMessage()" class="form-control" multiple>
                  <option value="" style="display:none">Select</option>
                  <?php 
                  foreach ($excel_arr[0] as $key => $value) {
                    ?>
                    <option value="<?php echo "[".preg_replace("/[^a-zA-Z0-9]/", '', $value)."]" ?>"><?php echo htmlspecialchars_decode($value) ?></option>
                    <?php
                  } ?>
                </select>
                <span class="red" id="error-distributor"></span>
              </div>
              <div class="form-group col-md-7">
                <label for="message">Message Contents</label>
                <textarea name="message" id="message" class="form-control" rows="5" required="required"  placeholder="Enter ..."></textarea>
                <span class="red" id="error-message"></span>
              </div>
              <div class="clearfix"></div>
            </div><!-- /.box-body -->
            <div class="box-footer">
              <input type="hidden" name="upload-path" id="upload-path" value="<?php echo $file_name ?>">
              <div class="col-md-1" id="sn-add-button" style="display:block">
                <button type="submit" id="add-sn" class="btn btn-primary" onclick="sendNotification(this.id)">Save</button>
              </div>
              <div class="col-md-1" id="add-sn-spinner" style="display:none">
                <h6 class="text-center btn btn-success no-margin-top">&nbsp; <i class="icon fa fa-spinner fa-spin"></i> &nbsp;</h6>
              </div>
              <div class="col-md-1" id="add-sn-msg" style="display:none">
                <h6 class="text-center btn btn-success no-margin-top">&nbsp; <i class="icon fa fa-check"></i> &nbsp;</h6>
              </div>
            </div>
          </form>
        </div>
      </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
    <!--  Product js -->
    <script src="<?php echo JS.'notification.js?ver='.filemtime("assets/js/notification.js").''; ?>"></script>
    <script type="text/javascript">
      $(document).on('change', '.btn-file :file', function() {
        var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
        console.log(input.get(0).files);
      });

      $(document).ready( function() {
        $('.btn-file :file').on('fileselect', function(event, numFiles, label) {

          var input = $(this).parents('.input-group').find(':text'),
          log = numFiles > 1 ? numFiles + ' files selected' : label;

          if( input.length ) {
            input.val(log);
          } else {
            if( log ) alert(log);
          }

        });
      });

      function addToMessage() {
        var tag = $('#message-fields').val()
        var cursorPos = $('#message').prop('selectionStart');
        var v = $('#message').val();
        var textBefore = v.substring(0,  cursorPos );
        var textAfter  = v.substring( cursorPos, v.length );
        $('#message').val( textBefore+ tag[0] +textAfter );
      }
    </script>
    <!-- Main Footer -->
    <footer class="main-footer">
      <!-- To the right -->
      <div class="pull-right">
        Developed and Maintained By: <strong>Ketan Velip</strong>
      </div>
      <!-- Default to the left -->
      <strong>&copy; 2017 <a href="#">Excel Bulk SMS-Notification</a>.</strong>
    </footer>
  </div><!-- ./wrapper -->
  <!-- REQUIRED JS SCRIPTS -->
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <!-- Bootstrap 3.3.5 -->
  <script src="assets/js/bootstrap.min.js"></script>
  <!-- AdminLTE App -->
  <script src="assets/dist/js/app.min.js"></script>
  <!-- FastClick -->
  <script src="assets/plugins/fastclick/fastclick.min.js"></script>
  <!-- SlimScroll -->
  <script src="assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
  <script type="text/javascript" src="assets/js/smoothscroll.js"></script>
</body>
</html>