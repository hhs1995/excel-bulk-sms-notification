<?php 

	class NotificationModel  {

        // retrieve User List
        public function getUserList() 
        {
            $prod_sql = "SELECT gcmId, phoneNumber FROM users";
            $exc_res = mysql_query($prod_sql);
            while ($row = mysql_fetch_assoc($exc_res)) {
                $res['mobile'][] = $row['phoneNumber'];
                $res['apikey'][] = $row['gcmId'];
            }
            if(is_array($res)){
                return $res;
            } 
            else {
                return 0;
            }
        }
	}
 ?>