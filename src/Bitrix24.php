<?php
include 'AuthModule.php';

class Bitrix24
{
    private $authobj;
    private $config;

    /**
     * Bitrix24 constructor.
     * @param array $config Bitrix24 configuration.
     *  Configuration parameters example:
     *  array(
     *      'companyDomain' => 'example.bitrix24.com', //Bitrix24 company URL
     *      'scope' => 'crm,user,telephony', //Bitrix24 auth scopes. Available variants: https://training.bitrix24.com/rest_help/rest_sum/premissions_scope.php
     *
     *      //Auth data
     *      'auth' => array(
     *          //Bitrix24 User auth data
     *          'login'    => 'user@bitrix24.com',
     *          'password' => '1234',
     *
     *          //Bitrix24 App auth data
     *          'clientId' => 'local.55a6ca262e8482.12345678',
     *          'clientSecret' => 'eOk9XtOWbdTjUgQmBL1MYNpKl0Jwt11JLHYHIADX62f3c6PA29'
     *      ),
     *
     *      //Database config
     *      'database' => array(
     *          'settingsTableName' => 'config',
     *          'settingsKeyName' => 'key',
     *          'settingsValueName' => 'value'
     *      )
     *  )
     * @param array $mysqliConnection Mysqli connection array
     */


    /**
     * @param string $method For available methods see documentation: https://training.bitrix24.com/rest_help/rest_sum/index.php
     * @param array $data For available parameters see documentation: https://training.bitrix24.com/rest_help/rest_sum/index.php
     * @return mixed Data array from Bitrix24 REST API / null if nothing received
     */
	 
	public function __construct($config = array())
    {
       
        $this->config = $config;
		//print_r($this->config);
		$this->authobj = new AuthModule($config);
		
    } 
	
    public function callMethod($method, $data = array())
    {
	
		
		
		$c = curl_init('https://' . $this->config['companyDomain'] . 'rest/' . $method . '.json?auth=' . $this->authobj->auth());
		//die;
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($c, CURLOPT_POST, true);
        curl_setopt($c, CURLOPT_POSTFIELDS, http_build_query($data));
        $response = json_decode(curl_exec($c), true);
        if (isset($response['result']))
            return $response['result'];
        else
            return null;
    }
}