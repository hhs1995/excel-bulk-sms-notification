<?php 	
include('../config.php'); 
include(MODEL.'NotificationModel.php');

$noti_model = new NotificationModel();            

$form = $_POST['form'];

switch ($form) {

    case 'add-sn':
            
            // get uploaded filename
            $upload_path     = "../excel-uploads/".$_POST['upload-path'];                
            // Excel reader
            require('../excel-reader/php-excel-reader/excel_reader2.php');
            require('../excel-reader/SpreadsheetReader.php');
            
            $excel_arr = [];
            // read excel file
            try
            {
              $Spreadsheet = new SpreadsheetReader($upload_path);
              $Sheets = $Spreadsheet -> Sheets();
              foreach ($Sheets as $Index => $Name)
              {
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

            // phone number index
            $phone_index = $_POST['phone'];
            $subtitle = $_POST['subtitle'];

            // replace tags with php variables
            $message = preg_replace("/[[]/", '$', $_POST['message']);
            $message = preg_replace("/[]]/", '', $message);
            
            // get users from database
            $users = $noti_model->getUserList();
            
            for ($i=1; $i < count($excel_arr); $i++) { 
                $dbvalue_key = -1;
                $final_message = $message;
                $excel_arr[$i][$phone_index];
                // check if mobile number is there in database
                $dbvalue_key = array_search($excel_arr[$i][$phone_index],$users['mobile']);

                // if user registered in database
                if ($dbvalue_key!==false) {
                    foreach ($excel_arr[0] as $key => $value) {
                        // get dynamic variable name
                        $inputValue = preg_replace("/[^a-zA-Z0-9]/", '', $value);
                        
                        // create dynamic variable
                        $$inputValue = $excel_arr[$i][$key];
                        
                        // replace strings values in message with dynamic values
                        $final_message = str_replace("$".$inputValue, $$inputValue, $final_message);
                    }
                    
                    /* SMS and Notification functions Defined in 'assets/functions.php' */
                    //send SMS
                    sendSMS($users['mobile'][$dbvalue_key],$final_message);
                    
                    //send Notification
                    sendNotification($users['apikey'][$dbvalue_key],$final_message,$subtitle);
                    $status = 1;                 
                }
            }
            echo $status;
        
          break;

    default:
        # code...
        break;
}

?>