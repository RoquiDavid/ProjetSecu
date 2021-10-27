<?php
    include 'con.php'; #Call du script du connection a la BD
    include 'config.php';


    function add_user($name, $password)
    {
        $pdo = connect();

        try {   
            $date = getdate()['year'] ."-". getdate()['mon']."-".getdate()['mday'];
            $stmt = $pdo->prepare("INSERT INTO users (User_Name, User_Password, Date_Create) VALUES (?, ?, ?)");
            $stmt->bindParam(1, $name);
            //hash the password
            $password = password_hash($password,PASSWORD_DEFAULT);
            $stmt->bindParam(2, $password);
            $stmt->bindParam(3, $date);

            // insertion d'une ligne
            
            $stmt->execute();
        } catch (Exception $e){
            echo "\nenter4";
            $pdo->rollback();
            throw $e;
        }
    }

    #Function to check if user exists by the name and the password
    function user_exists($name,$password){
        $pdo = connect();

        $req = $pdo->prepare('SELECT * FROM users WHERE User_Name=? AND User_Password=?');
        $req->bindParam(1,$name, PDO::PARAM_STR);
        #We hash the password
        $req->bindParam(2,$hash, PDO::PARAM_STR);
        $req->execute(); 
        $user = $req->fetch();
        return empty($user);        
    }

    #Function to check if user exists by the name
    function user_exists_name($name){
        $pdo = connect();

        $req = $pdo->prepare('SELECT * FROM users WHERE User_Name=? ');
        $req->bindParam(1,$name, PDO::PARAM_STR);
        $req->execute(); 
        $user = $req->fetch();
        return empty($user);

        
    }

    function createToken() {
		$seed = urlSafeEncode(random_bytes(8));
		$t = time();
		$hash = urlSafeEncode(hash_hmac('sha256', session_id() . $seed . $t, CSRF_TOKEN_SECRET, true));
		return urlSafeEncode($hash . '|' . $seed . '|' . $t);
	}

	function validateToken($token) {
		$parts = explode('|', urlSafeDecode($token));
		if(count($parts) === 3) {
			$hash = hash_hmac('sha256', session_id() . $parts[1] . $parts[2], CSRF_TOKEN_SECRET, true);
			if(hash_equals($hash, urlSafeDecode($parts[0]))) {
				return true;
			}
		}
		return false;
	}

	function urlSafeEncode($m) {
		return rtrim(strtr(base64_encode($m), '+/', '-_'), '=');
	}
	function urlSafeDecode($m) {
		return base64_decode(strtr($m, '-_', '+/'));
	}
?>