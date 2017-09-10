# excel-bulk-sms-notification
Send Bulk SMS/Notifications to users registered in DB

PHP + Javascript + HTML + Bootstrap

Features:

1. Upload Excel Sheet (.xls or .xlsx)
2. Create Custom Messages Using the values from excel sheet
3. Send bulk sms or GCM notification to users registered in DB

Configuration
----------------

1. Change root folder name in assets/config.php	

	```
	define("ROOT_DIR",$DOCUMENT_ROOT."/bulk-sms/assets/");

	define("WWWROOT",'http://'. $HTTP_HOST . '/bulk-sms/');
	```
	a. Replace 'bulk-sms' with your folder name in htdocs if testing on local system

	b. Remove 'bulk-sms' if hosting on live server

2. Change DB Settings in assets/config.php
	
	```
	define("DB_HOST", "localhost");
	
	define("DB_USER", "root");
	
	define("DB_PSSWD", "");
	
	define("DB_NAME", "test");
	```

3. Create `users` Table with gcmId and phoneNumber columns
	
4. Add API Keys in assets/config.php
	
	```	
	define("SMS_API", "SMS API KEY");
	define("API_ACCESS_KEY", "GCM/FIREBASE API KEY");
	```

Use
----------------

1. Upload excel sheet in step - 1 form. After successful upload, columns from first row of excel sheet will be displayed in step-2 form

2. Sending SMS?Notification
	a. Select the field in phone numbers are present in the excel sheet. 
	b. Enter a subtitle to be displayed
	c. Double click on the select box to add fields to message box (Message Contents)
	d. Edit the message to be sent
