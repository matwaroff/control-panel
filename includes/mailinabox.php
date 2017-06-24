<?php
define('miabuser', "mat@waroff.me");
define('miabpass', "Spirit10!");
/**
 * Created by PhpStorm.
 * User: Mat
 * Date: 6/20/2017
 * Time: 6:46 PM
 */
class mailinabox
{
    public $domain;
    public $ch;
    private $user;
    private $pass;
    private $data;

    function __construct($mainurl, $data)
    {
        $this->domain = $mainurl;
        $this->user = miabuser;
        $this->pass = miabpass;
        $this->data = $data;
    }

    /**
     * Returns an array of options based on your input
     * @param $jsonurl The url to the mailinabox api action
     * @param $method GET, POST, PUT
     * @param $fields Fields for post and put : STRING
     * @return array
     */
    function options($jsonurl, $method, $fields){
        $options = array(
            CURLOPT_URL => $jsonurl,
            CURLOPT_USERPWD => "$this->user:$this->pass",
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
            CURLOPT_USE_SSL => 1,
        );
        if($method == CURLOPT_POST){
            $options[CURLOPT_POST] = 1;
            $options[CURLOPT_POSTFIELDS] = $fields;
        }elseif($method == CURLOPT_PUT){
            $options[CURLOPT_PUT] = 1;
        }
        return $options;
    }
    function newRequest($options){
        $this->ch = curl_init();
        curl_setopt_array($this->ch, $options);
        $output = curl_exec($this->ch);
        $info = curl_getinfo($this->ch);
        return array("output" => $output, "info" => $info);
    }



    function emailsRequest($domain){
        $jsonurl = "https://$this->domain/admin/mail/users";
        $options = $this->options($jsonurl);
        $data = $this->newRequest($options);
        $outputarray = explode("\n", $data['output']);
        $finaloutput = array();
        if(isset($domain)){
            foreach(array_keys($outputarray) as $user){
                if(is_null($outputarray[$user]) || $outputarray[$user] == "") continue;
                $exuser = explode("@", $outputarray[$user]);
                if($exuser[1] == $domain){
                    array_push($finaloutput, $outputarray[$user]);
                }
            }
        }else{
            $finaloutput = $outputarray;
        }
        return array("output" => $finaloutput, "info" => $data['info']);
    }

    function newUser($email, $pass){
        $jsonurl = "https://$this->domain/admin/mail/users/add";
        $logininfo = "email=$email&password=$pass";
        $options = $this->options($jsonurl, CURLOPT_POST, $logininfo);
        $data = $this->newRequest($options);
        return $data;
    }
    function removeUser($email){
        $jsonurl = "https://$this->domain/admin/mail/users/remove";
        $logininfo = "email=$email";
        $options = $this->options($jsonurl, CURLOPT_POST, $logininfo);
        $data = $this->newRequest($options);
        $this->data->setStatus("Removed User: $email");
        return $data;
    }
    function updateUser($user, $pass){
        $jsonurl = "https://$this->domain/admin/mail/users/password";
        //VALIDATE INPUT
        $logininfo = "email=$user&password=$pass";
        $options = $this->options($jsonurl, CURLOPT_POST, $logininfo);
        $data = $this->newRequest($options);
        return $data;
    }
}