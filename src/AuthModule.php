<?php 
class AuthModule
{
    private $config;
    private $lastUpdateTime = 0;
    private $authCode;

	public function __construct($config = array())
    {
       
        $this->config = $config;
		//print_r($this->config);die;
		
    } 

    public function auth()
    {
        $_url = 'https://' . $this->config['companyDomain']; 
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $_url);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $res = curl_exec($ch);
        $l = '';
        if (preg_match('#Location: (.*)#', $res, $r)) {
            $l = trim($r[1]);
        }

        curl_setopt($ch, CURLOPT_URL, $l);
        $res = curl_exec($ch);
	
        preg_match('#name="backurl" value="(.*)"#', $res, $math);
        $post = http_build_query([
            'AUTH_FORM' => 'Y',
            'TYPE' => 'AUTH',
            'backurl' => 'https://demotbs.com/dev/bit/test.php',
            'USER_LOGIN' => $this->config['auth']['login'],
            'USER_PASSWORD' => $this->config['auth']['password'],
            'USER_REMEMBER' => 'Y'
        ]);
        curl_setopt($ch, CURLOPT_URL, 'https://www.bitrix24.net/auth/');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        $res = curl_exec($ch);
        $l = '';
        if (preg_match('#Location: (.*)#', $res, $r)) {
            $l = trim($r[1]);
        }

        curl_setopt($ch, CURLOPT_URL, $l);
        $res = curl_exec($ch);
        $l = '';
        if (preg_match('#Location: (.*)#', $res, $r)) {
            $l = trim($r[1]);
        }

        curl_setopt($ch, CURLOPT_URL, $l);
        $res = curl_exec($ch);
		
        curl_setopt($ch, CURLOPT_URL, 'https://' . $this->config['companyDomain'] . '/oauth/authorize/?response_type=code&client_id=' . $this->config['auth']['clientId']);
		$res = curl_exec($ch);
		
		
		
		
		
	
		
		$l = '';
        if (preg_match('#Location: (.*)#', $res, $r)) {
            $l = trim($r[1]);
        }
        preg_match('/code=(.*)&do/', $l, $code);
        $code = $code[1];		
        curl_setopt($ch, CURLOPT_URL, 'https://' . $this->config['companyDomain'] . '/oauth/token/?grant_type=authorization_code&client_id=' . $this->config['auth']['clientId'] . '&client_secret=' . $this->config['auth']['clientSecret'] . '&code=' . $code . '&scope=' . $this->config['scope']);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $res = curl_exec($ch);
		//print_r($res); die;
		
        curl_close($ch);
        $resArr = explode(',', $res);
        $this->authCode = str_replace(array('{"access_token":"', '"'), array('', ''), $resArr[0]); 
        return $this->authCode;
		//$this->setAppCode();
    }
}