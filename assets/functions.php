<?php

	function sanitise($input){

		$input = stripslashes($input);

		$input = trim($input);

		$input = htmlspecialchars($input);

		$input = htmlentities($input);

		$input = mysql_real_escape_string($input);

		$input = strip_tags($input);

		return $input;

	}


	/*
		CODE TO SEND SMS
	*/
    function sendSMS($recipient, $message){
    	$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "SMS STRING GIVEN BY SMS SERVICE PROVIDER");
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
    }


    /*
		SEND GCM NOTIFICATION
    */
    function sendNotification($registrationIds,$heading,$subtitle){
        
        $msg = array
        (
            'message'   => $heading,
            'title'     => "TITLE",
            'subtitle'  => $subtitle,
            'tickerText'    => $subtitle,
            'vibrate'   => 1,
            'sound'     => 1,
            'largeIcon' => 'large_icon',
            'smallIcon' => 'small_icon',
            'noti_type' => 2
        );

        $fields = array
        (
            'registration_ids'  => $registrationIds,
            'data'          => $msg
        );
         
        $headers = array
        (
            'Authorization: key=' . API_ACCESS_KEY,
            'Content-Type: application/json'
        );
        
        // Set POST variables
        $url = 'https://gcm-http.googleapis.com/gcm/send';
         
        // Open connection
        $ch = curl_init();
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        // Close connection
        curl_close($ch);
        return $result;
    }
?>