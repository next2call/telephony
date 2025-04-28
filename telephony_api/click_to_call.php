<?php

// Set the response header to JSON
header('Content-Type: application/json');

// Retrieve and decode JSON data from the POST body
$requestData = json_decode(file_get_contents("php://input"), true);

$response = []; // Array to store response messages

if (!$requestData) {
    $response['status'] = 'error';
    $response['message'] = 'Invalid JSON input.';
    echo json_encode($response);
    exit;
}

$leadId = $requestData['lead_id'];
$callerNumber = $requestData['customer_number'];
$receiverNumber = $requestData['agent_phone_no'];
$campaignId = $requestData['campaign_id'];
$user = $requestData['user'];
$key = $requestData['key'];

// Validate the secret key for security
if ($key != "jbti89692vc60b2o9nu7647" || empty($callerNumber) || empty($receiverNumber)) {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request parameters.';
    echo json_encode($response);
    exit;
}

$ipServer = "127.0.0.1";
$port = "5038";
$protocolServer = "tcp";
$username = "cron";
$password = "1234";
$context = 'telephony';

$target = "$callerNumber" . $receiverNumber;

$socket = stream_socket_client("$protocolServer://$ipServer:$port");

if ($socket) {
    // Prepare and send authentication request
    $authenticationRequest = "Action: Login\r\n";
    $authenticationRequest .= "Username: $username\r\n";
    $authenticationRequest .= "Secret: $password\r\n";
    $authenticationRequest .= "Events: off\r\n\r\n";
    $authenticate = stream_socket_sendto($socket, $authenticationRequest);

    if ($authenticate > 0) {
        usleep(200000);
        $authenticateResponse = fread($socket, 4096);

        if (strpos($authenticateResponse, 'Success') !== false) {
            $response['status'] = 'success';
            $response['message'] = 'Authentication successful, initiating call.';

            // Prepare and send originate request
            $originateRequest = "Action: Originate\r\n";
            $originateRequest .= "Channel: local/$callerNumber\r\n";
            $originateRequest .= "Callerid: $callerNumber\r\n";
            $originateRequest .= "Exten: 97$receiverNumber\r\n";
            $originateRequest .= "Context: $context\r\n";
            $originateRequest .= "Priority: 0\r\n";
            $originateRequest .= "Async: yes\r\n\r\n";
            $originate = stream_socket_sendto($socket, $originateRequest);

            if ($originate > 0) {
                usleep(200000);
                $originateResponse = fread($socket, 4096);
                $response['call_response'] = $originateResponse;
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Authentication failed.';
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Failed to send authentication request.';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Unable to connect to Asterisk server.';
}

// Output the response as JSON
echo json_encode($response);
?>
