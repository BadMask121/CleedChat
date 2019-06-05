<?php
    error_reporting(E_ALL);
     class  Utility 
    {

            static function encrypt($data=null,$key)
        {
                $encrypted = null;
                $method = 'aes-256-cbc';
                // IV must be exact 16 chars (128 bit)
                $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
                try {
                    (is_null($encrypted) && (!is_null($data)) && (!is_null($key))) ? ($encrypted = base64_encode(openssl_encrypt($data, $method, $key, OPENSSL_RAW_DATA, $iv))) : $encrypted;

                } catch (\Exception $th) {
                    return $th;
                }
                return $encrypted;
        }


            //decrypt function
            static function decrypt($data,$key)
        {
            $method = 'aes-256-cbc';
            $decrypted = null;
            // IV must be exact 16 chars (128 bit)
            $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
            try{
                (is_null($decrypted) && (!is_null($data)) && (!is_null($key))) ? ($decrypted = openssl_decrypt(base64_decode($data), $method, $key,OPENSSL_RAW_DATA,$iv)) : $decrypted;
            }catch(\Exception $e){
                return $e;
            }

            return $decrypted;
        }
                static function mtrne($n)
        {   $w ='';
            $h =  md5("abcdefghijklxmnop1234567890ABCDEFX");
            $max = strlen($h);

            for($i=0; $i < $n ; $i++){
                    $w .= version_compare(phpversion(), '5', '>=') ? $h[mt_rand(0, $max-1)]  :  $h[rand(0, $max-1)]; 

            }
            return $w;    
        }


            static function nrand($n)
        {
            $w = '';
            $h =  "abcdefghijklmnop1234567890ABCDEFGHXZ";
            for($i = -$n ; $i < $n ; $i++){
                $w .= version_compare(phpversion(), '5', '>=') ? $h[mt_rand(0,strlen($h)) -1 ] : $h[rand(0,strlen($h)) -1];
            }
            return $w ;
        }
            static function getDateTime()
        {
            date_default_timezone_get();
            $date = date('d/m/Y H:i:s A', time());
            return $date;
        }
            static function request_post(){return ($_SERVER['REQUEST_METHOD'] == 'POST') ? true : false;}
            static function request_get(){return ($_SERVER['REQUEST_METHOD'] == 'GET') ? true : false;}
            static function update_database_config($db_host,$db_user,$db_pass,$db_base)
        {
            $file = dirname(__DIR__) . '\config.json';
            $data = array(array(
                "DB_HOST"       => $db_host,
                "DB_USERNAME"   => $db_user,
                "DB_PASSWORD"   => $db_pass,
                "DB_BASE"       => $db_base
            ));

            $object = serialize(json_decode(json_encode($data), FALSE));
            
                if(is_writable($file))
            {
                    if(!$handle = fopen($file,'w'))
                {
                    return false;
                }
                    if(fwrite($handle,$object) === FALSE)
                {
                    return false;
                }
                fclose($handle);
            }else{
                return false;
            }

            return true;
        }

            static function is_serialized( $data ) 
        {
            // if it isn't a string, it isn't serialized
            if ( !is_string( $data ) )
                return false;
            $data = trim( $data );
            if ( 'N;' == $data )
                return true;
            if ( !preg_match( '/^([adObis]):/', $data, $badions ) )
                return false;
            switch ( $badions[1] ) {
                case 'a' :
                case 'O' :
                case 's' :
                    if ( preg_match( "/^{$badions[1]}:[0-9]+:.*[;}]\$/s", $data ) )
                        return true;
                    break;
                case 'b' :
                case 'i' :
                case 'd' :
                    if ( preg_match( "/^{$badions[1]}:[0-9.E-]+;\$/", $data ) )
                        return true;
                    break;
            }
            return false;
        }

            static function unzip($path,$file_details)
        {   
            $file_tmp_loca = $file_details[ZIP_FILETMP_LOCATION];
            $file_ext = $file_details[ZIP_FILE_EXTENTION];

            if($file_ext != 'zip')return false;
            
            $zip = new ZipArchive;
            $res = $zip->open($file_tmp_loca);
                if ($res === TRUE) 
            {
               if( $zip->extractTo($path)){
                    $zip->close();
                    return true;
               }
            }
            return false;
        }

            static function validateEmail($email)
        {
            // SET INITIAL RETURN VARIABLES

                $emailIsValid = FALSE;

            // MAKE SURE AN EMPTY STRING WASN'T PASSED

                if (!empty($email))
                {
                    // GET EMAIL PARTS

                        $domain = ltrim(stristr($email, '@'), '@') . '.';
                        $user   = stristr($email, '@', TRUE);

                    // VALIDATE EMAIL ADDRESS

                        if
                        (
                            !empty($user) &&
                            !empty($domain) &&
                            checkdnsrr($domain)
                        )
                        {$emailIsValid = TRUE;}
                }

            // RETURN RESULT

                return $emailIsValid;
        }



    }//END OF CLASS

?>