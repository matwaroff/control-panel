<?php
include 'config.php';
/**
 * Control Panel object
 *      used to create a secure control panel environment
 * @author  Mat Waroff
 * @version 1.0a
 */
class cpanel
{
    public $signedIn;
    public $fname;
    public $lname;
    public $permission;
    public $conn;
    public $id;
    public $statusstring;
    public $error;
    public $active;
    public $username;

    function __construct(){
        $this->signedIn = 0;
        $this->db();
    }

    /**
     * Log In Function
     * @param $user
     * @param $pass
     * @throws Exception
     */
    function login($user, $pass){
        $sql = "SELECT id, username, firstName, lastName, permission FROM users WHERE password='".$pass."';";
        $array = $this->fetchRow($sql);
        $username = $array['username'];
        $id = $array['id'];
        $fname = $array['firstName'];
        $lname = $array['lastName'];
        $status = $array['permission'];

        if($username != $user)
            throw new Exception("Incorrect password");
        $this->signedIn = 1;
        $this->id = $id;
        $this->permission = $status;
        $this->fname = $fname;
        $this->lname = $lname;
        $this->username = $username;
        $this->accessLog();
    }
    function logout(){
        setcookie("session", null, 0);
        session_destroy();
        $this->signedIn = 0;
    }



    /**
     * Initializes the DB
     */
    function db(){
        $this->conn = new mysqli('localhost', USERNAME, PASSWORD, DB);
    }



    /**
     * Gets all domains
     * @return array domain rows
     */
    function getDomains($admin = false){
        $sql = "SELECT d.domainID, d.ownerID, d.domainName, u.id, u.username FROM domains AS d LEFT JOIN users AS u ON u.id=d.ownerID";
        if(!$admin) $sql .= " WHERE d.ownerID = $this->id;";
        return $this->fetchRows($sql);
    }
    /**
     * Get domain based on the selected hash
     * @param $hash hashed domain ID
     * @return mixed domain array
     */
    function getDomain($hash){
        $domains = $this->getDomains();
        foreach($domains as $d){
            $curhash = hash("md5", $d['domainID']);
            if($curhash == $hash){
                return $d;
            }
        }
    }

    function getPage(){
        $fileName = basename($_SERVER['PHP_SELF']);
        $sql = "SELECT * FROM pages WHERE fileName = '$fileName';";
        return $this->fetchRow($sql);
    }

    function canAccess(){
        $permission = $this->getPage()['permission'];
        return ($this->signedIn == 1 && $permission <= $this->permission);
    }
    function isMyDomain($domain){
        $domains = $this->getDomains(true);
        foreach($domains as $d){
            if($d['domainName'] == $domain){
                return ($d['ownerID'] == $this->id);
            }
        }
    }


    function setStatus($status, $error = false){
        $this->statusstring = array("status" => $status);
        if($error == true){
            $this->statusstring['error'] = true;
        }
    }
    function getStatus(){
        $status = $this->statusstring;
        unset($this->statusstring);
        return $status;
    }
    function hasStatus(){
        return isset($this->statusstring);
    }

    function connect(){
        if(is_null($this->conn->sqlstate)){
            $this->db();
        }
    }
    function isAdmin(){
        return ($this->permission == 99);
    }
    function isActivated($userid){
        $sql = "SELECT permission FROM users WHERE id=$userid;";
        return ($this->fetchRow($sql)[0] != -1);
    }
    function activateUser($userid){
        if(!$this->isActivated($userid)){
            $sql = "UPDATE users SET permission=1 WHERE id=$userid;";
            $this->conn->query($sql);
            $this->setStatus("Successfully acitvated.");
        }else{
            $this->setStatus("ERROR: Could not activate user.", true);
        }
    }
    function newUsers(){
        $sql = "SELECT id FROM users WHERE permission=-1";
        $data = $this->fetchRows($sql);
        return(count($data));
    }

    /***
     * MYSQL Functions
     */
    /**
     * Fetches a single row using the SQL statement
     * @param $sql  sql statement
     * @return mixed    sql row
     */
    function fetchRow($sql){
        return $this->conn->query($sql)->fetch_array(MYSQLI_BOTH);
    }
    /**
     * Fetches an array of rows using the SQL statement
     * @param $sql sql statement
     * @return array    sql rows
     */
    function fetchRows($sql){
        $result = $this->conn->query($sql);
        $rows = array();
        while($row = $result->fetch_array(MYSQLI_ASSOC))
            array_push($rows, $row);
        return $rows;
    }

    function getSetting($key){
        $sql = "SELECT settingData FROM settings WHERE settingName = '$key';";
        return $this->fetchRow($sql)['settingData'];
    }
    function getInitials(){
        $sql = "SELECT firstName, lastName FROM users WHERE id=$this->id;";
        $names = $this->fetchRow($sql);
        $first = substr($names['firstName'], 0,1);
        $last = substr($names['lastName'], 0,1);
        return "$first$last";
    }


    /**
     * Settings Page
     */
    function updateSetting($key, $value){
        $sql = "UPDATE settings SET settingData='$value' WHERE settingName='$key';";
        $this->conn->query($sql);
    }

    function getUsers(){
        if(!$this->isAdmin()) return null;
        $sql = "SELECT id, username, firstName, lastName, email, permission FROM users";
        return $this->fetchRows($sql);
    }
    function addUser($user, $pass, $fname, $lname, $email, $admin){
        try{
            $user = $this->conn->real_escape_string(chop($user));
            $pass = hash("sha512", $this->conn->real_escape_string(chop($pass)));
            $fname = $this->conn->real_escape_string(chop($fname));
            $lname = $this->conn->real_escape_string(chop($lname));
            $email = $this->conn->real_escape_string(chop($email));
            $sql = "INSERT INTO users (username, password, firstName, lastName, email, permission) VALUES ('$user', '$pass', '$fname', '$lname', '$email', -1);";
            $this->conn->query($sql);
            //$this->requestAccess(mysqli_insert_id($this->conn), $user, $email);
            $this->setStatus("Successfully added user");
        }catch(Exception $e){
            $this->setStatus("ERROR: $e", true);
        }
    }
    function deleteUser($userid){
        $domainsql = "DELETE FROM domains WHERE ownerID=$userid;";
        $sql = "DELETE FROM users WHERE id=$userid;";
        if($this->isAdmin()){
            $this->conn->query($domainsql);
            if($this->conn->query($sql)){
                $this->setStatus("Successfully deleted user: $userid");
                header("Location: admin.php?users");
            }else{
                $this->setStatus("ERROR: user delete failed", true);
                header("Location: admin.php?users");
            }
        }else{
            $this->setStatus("NOT AN ADMIN", true);
            header("Location: index.php");
        }
    }

    function requestAccess($id, $user, $email){
        require_once('PHPMailer/PHPMailerAutoload.php');
        $mail = new PHPMailer();
        $body = "<h1>New Request</h1><ul><li>User: $user - ($id)</li><li>Email: $email</li></ul>";

        $mail->IsSMTP();                                      // set mailer to use SMTP
        $mail->Host = "box.humming.email";  // specify main and backup server
        $mail->SMTPAuth = true;     // turn on SMTP authentication
        $mail->Username = "mat@waroff.me";  // SMTP username
        $mail->Password = "Spirit10!"; // SMTP password
        $mail->Port = 587;
        $mail->SMTPSecure = 'tls';
        $mail->From = "mat@waroff.me";
        $mail->FromName = "New Request";
        $mail->AddAddress("request@waroff.me");
        $mail->IsHTML(true);
        $mail->Subject = "New User Request - $email";
        $mail->Body = $body;
        if(!$mail->Send()) throw new Exception($mail->ErrorInfo);

    }
    function debug(){
        $this->setStatus("Debug test");
    }
    function accessLog(){
        $timestamp = date('Y-m-d', strtotime("now"));
        $time = date('H:i:s', strtotime("now +4hr"));
        $sql = "INSERT INTO access_log (username, date, time) VALUES ('$this->username', '$timestamp', '$time');";
        $this->conn->query($sql);
    }
}