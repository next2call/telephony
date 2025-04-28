<?php


$callerNumber = $_REQUEST['callerNumber'];
$receiverNumber =  $_REQUEST['receiverNumber'];



$key = $_REQUEST['key'];

if($key == "v8v6bti89692vc60b2o9nu")
{



 $ipServer = "127.0.0.1";
  $port = "5038";
  $protocolServer = "tcp";

  $username = "cron";
  // Replace with your password (refered to as "secret" in /etc/asterisk/manager.conf)
  $password = "1234";

  // Internal phone line to call from
  $internalPhoneline = $callerNumber;

  $ws = false; //Set 'true' if you use WebSocket protocol transport in your Asterisk Server

  $context = 'vicidial_master';

  //Starting script
  if($ws){
    $port .= "/ws";
  }

  $socket = stream_socket_client("$protocolServer://$ipServer:$port");
//echo  $target = $sip . $number;
$target = "$callerNumber" . $receiverNumber;
  if($socket)
  {
      // Prepare authentication request
      $authenticationRequest = "Action: Login\r\n";
      $authenticationRequest .= "Username: $username\r\n";
      $authenticationRequest .= "Secret: $password\r\n";
      $authenticationRequest .= "Events: off\r\n\r\n";
      // Send authentication request
      $authenticate = stream_socket_sendto($socket, $authenticationRequest);
      if($authenticate > 0)
      {
          // Wait for server response
          usleep(200000);
          // Read server response
          $authenticateResponse = fread($socket, 4096);
          // Check if authentication was successful
          if(strpos($authenticateResponse, 'Success') !== false)
          {
              echo "Initiating call.\n";
              // Prepare originate request
              $originateRequest = "Action: Originate\r\n";
              $originateRequest .= "Channel: local/$internalPhoneline\r\n";
              $originateRequest .= "Callerid: $callerNumber\r\n";
              $originateRequest .= "Exten: 97$target\r\n";
              $originateRequest .= "Context: $context\r\n";
              $originateRequest .= "Priority: 0\r\n";
              $originateRequest .= "Async: yes\r\n\r\n";
              // Send originate request
              $originate = stream_socket_sendto($socket, $originateRequest);
              if($originate > 0)
              {
                  // Wait for server response
                  usleep(200000);
                  // Read server response
                  $originateResponse = fread($socket, 4096);
              }

          }
       }
    }



}
else
{
echo "Error";
}

?>