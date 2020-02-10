<?php
include 'src/Bitrix24.php';
class Example {
	public $Bitrix24;
public function __construct(){	
$this->Bitrix24 = new Bitrix24(
    array(
        'companyDomain' => 'b24-845dx1.bitrix24.com/', //Bitrix24 company URL
        'scope' => 'calendar,crm,user,telephony', //Bitrix24 auth scopes. Available variants: https://training.bitrix24.com/rest_help/rest_sum/premissions_scope.php

        //Auth data
        'auth' => array(
            //Bitrix24 User auth data
            'login'    => 'angsuman_chatterjee@otscom.com',
            'password' => 'newDelhi@18',

            //Bitrix24 App auth data
            'clientId' => 'local.5e3d52437a5670.48630122',
            'clientSecret' => 'QnB594Bd76Nrjcocr3wNK1MvbXo8aeqIfg8Nb0ZgtZat6iIOG6'
        ),       
    )   
);

}

function eventGet(){
	$dealData = $this->Bitrix24->callMethod("calendar.event.get", array(
	'type'=> 'user',
    'ownerId'=> '1',
    'from'=> '2020-02-10',
    'to'=> '2021-03-22'
));
	echo '<pre>';
	print_r($dealData); 
}

function eventDelete(){
	$dealData = $this->Bitrix24->callMethod("calendar.event.delete", array(
	'id'=>3,
	'type'=> 'user',
    'ownerId'=> '1'
)); 
	echo '<pre>';
	print_r($dealData); 
} 
 
function eventAdd(){
$dealData = $this->Bitrix24->callMethod("calendar.event.add", array('type'=> 'user',
     'ownerId'=> '1',
     'name'=> 'Valentine day',
     'description'=> 'Description for event',
     'from'=> '2020-02-14',
     'to'=> '2020-02-20',
     'section'=> 3
   
   )); 	 
	echo '<pre>';
	print_r($dealData); 
}
}
$ex = new Example();
echo '========================Event add=============================';
$ex->eventAdd();
echo '========================Event Delete=============================';
$ex->eventDelete();
echo '========================Event Get=============================';
$ex->eventGet();

