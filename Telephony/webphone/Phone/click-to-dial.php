<?php
session_start();
require '../../conf/url_page.php';

$server_ip = $Public_ip;
$name = $_SESSION['user'];
$user = $_SESSION['user'];
$pass = $_SESSION['pass'];
$server = $server_ip;
$domain = $server_ip;
$sokect ='8089';
$path ='/ws';


?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">

        <title>Browser Phone</title>
        <meta name="description" content="Browser Phone is a fully featured browser based WebRTC SIP phone for Asterisk. Designed to work with Asterisk PBX. It will connect to Asterisk PBX via web socket, and register an extension.  Calls are made between contacts, and a full call detail is saved. Audio and Video Calls can be recorded locally.">

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no"/>

        <!-- Cache -->
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate"/>
        <meta http-equiv="Expires" content="0"/>

        <link rel="icon" type="image/x-icon" href="favicon.ico">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.2/dist/sweetalert2.min.css">

        <!-- Styles -->
        <link rel="stylesheet" type="text/css" href="https://dtd6jl0d42sve.cloudfront.net/lib/Normalize/normalize-v8.0.1.css"/>
        <link rel="stylesheet preload prefetch" type="text/css" as="style" href="https://dtd6jl0d42sve.cloudfront.net/lib/fonts/font_roboto/roboto.css"/>
        <link rel="stylesheet preload prefetch" type="text/css" as="style" href="https://dtd6jl0d42sve.cloudfront.net/lib/fonts/font_awesome/css/font-awesome.min.css"/>
        <link rel="stylesheet" type="text/css" href="https://dtd6jl0d42sve.cloudfront.net/lib/jquery/jquery-ui-1.13.2.min.css"/>
        <link rel="stylesheet" type="text/css" href="https://dtd6jl0d42sve.cloudfront.net/lib/Croppie/Croppie-2.6.4/croppie.css"/>
        <link rel="stylesheet" type="text/css" href="phone.css"/>

        <!-- Provisioning -->
        <script type="text/javascript">
            // Provision runtime options can go here.
            var phoneOptions = {
                loadAlternateLang: true,
                SingleInstance: true,
                VoiceMailSubscribe: false,
                EnableTextMessaging: false,
                DisableFreeDial: false,
                DisableBuddies: false,
                ChatEngine: "SIMPLE",
                profileName:"<?= $name ?>",
                wssServer:"<?= $server ?>",
                WebSocketPort:"<?= $sokect ?>",
                ServerPath:"<?= $path ?>",
                SipDomain:"<?= $domain ?>",
                SipUsername:"<?= $user ?>",
                SipPassword:"<?= $pass ?>"
            }

            var web_hook_on_register = function(ua) {
                var user = <?= $user ?>;
                // alert(user);
    let urlParams = new URLSearchParams(window.location.search);

    if (urlParams.has("d")) {
        let numToDial = urlParams.get("d");
        let user = urlParams.get("user");

        window.setTimeout(function() {
            console.log("Performing click to Dial: ", user, numToDial);

            /**
             * Primary method for making a call. 
             * @param {string} type (required) Either "audio" or "video". Will setup UI according to this type.
             * @param {Buddy} buddy (optional) The buddy to dial if provided.
             * @param {sting} numToDial (required) The number to dial.
             * @param {string} CallerID (optional) If no buddy provided, one is generated automatically using this callerID and the numToDial
             * @param {Array<string>} extraHeaders = (optional) Array of headers to include in the INVITE eg: ["foo: bar"] (Note the space after the :)
             */
            DialByLine("audio", null, numToDial);
               //    himanshu
   // Ensure SweetAlert2 is loaded in the parent window
(function loadSweetAlertInParent() {
    const parentDocument = window.parent.document;

    // Load SweetAlert2 stylesheet
    const swalStylesheet = parentDocument.createElement('link');
    swalStylesheet.rel = 'stylesheet';
    swalStylesheet.href = 'https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css';
    parentDocument.head.appendChild(swalStylesheet);

    // Load SweetAlert2 script
    const swalScript = parentDocument.createElement('script');
    swalScript.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@11';
    parentDocument.head.appendChild(swalScript);
})();

setTimeout(() => {
    // Flag to track if the popup has been shown
    let isPopupShown = false;

    function check_live_status() {
        fetch(`/Telephony/agent/check_live_data.php?dialledNumber=${numToDial}`) 
            .then(response => response.json())
            .then(data => {
                if (data.status === 'Answer' && !isPopupShown) { // Ensure popup is only shown once for each "Answer"
                    isPopupShown = true; // Mark popup as shown

                    // Set interval to check for SweetAlert2 in the parent window
                    const checkSwal = setInterval(() => {
                        if (typeof window.parent.Swal !== 'undefined') {
                            clearInterval(checkSwal); // Clear interval once Swal is loaded

                            // Fetch data for the form
                            fetch(`/Telephony/agent/fetch_data.php?dialledNumber=${numToDial}`, {
                                method: 'GET',
                                headers: {
                                    'Content-Type': 'application/json'
                                }
                            })
                                .then(response => {
                                    if (!response.ok) {
                                        throw new Error('Network response was not ok');
                                    }
                                    return response.json();
                                })
                                .then(data => {
                                    if (data.get_call_lunch === "None") {
                                        // Do not show popup if no lunch is available
                                        return;
                                    }

                                    // Default values for the form fields
                                    let {
                                        company_name = '',
                                        employee_size = '',
                                        industry = '',
                                        country = '',
                                        city = '',
                                        department = '',
                                        designation = '',
                                        email = '',
                                        name = '',
                                        phone_number = numToDial,
                                        phone_2 = '',
                                        date = '',
                                        dialstatus = '',
                                        remark = ''
                                    } = {};

                                    // If data is available, populate the form fields
                                    if (data.length > 0) {
                                        ({
                                            company_name = '',
                                            employee_size = '',
                                            industry = '',
                                            country = '',
                                            city = '',
                                            department = '',
                                            designation = '',
                                            email = '',
                                            name = '',
                                            phone_number = '',
                                            phone_2 = '',
                                            date = '',
                                            dialstatus = '',
                                            remark = ''
                                        } = data[0]);
                                    } 

                                    // Fetch disposition data
                                    return fetch('/Telephony/agent/get_followup.php', {
                                        method: 'GET',
                                        headers: {
                                            'Content-Type': 'application/json'
                                        }
                                    })
                                        .then(response => {
                                            if (!response.ok) {
                                                throw new Error('Network response was not ok');
                                            }
                                            return response.json();
                                        })
                                        .then(dispodata => {
                                            if (dispodata.error) {
                                                throw new Error(dispodata.error);
                                            }

                                            // Process the fetched disposition data
                                            const inputOptions = dispodata.map(item => item.dispo);

                                            // Hide the popupContainer in the parent window
                                            const popupContainer = window.parent.document.getElementById('popupContainer');
                                            if (popupContainer) {
                                                popupContainer.style.display = 'none';
                                            }

                                                              // Display form in SweetAlert2 modal with prefilled data and disposition options
                    window.parent.Swal.fire({
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        title: "Fill the Form",
                        html: `<style>
                        .swal2-popup {
                            width: 45% !important; /* Adjust the width of the SweetAlert2 modal */
                            height: 100% !important; /* Adjust the height of the SweetAlert2 modal */
                            overflow-y: auto; /* Ensure content is scrollable if it overflows */
                        }
                        body {
                            font-family: Arial, sans-serif;
                            background-color: #f2f2f2;
                            margin: 0;
                            padding: 20px;
                        }
                        .form-section {
                            background-color: #ffffff;
                            padding: 20px;
                            margin-bottom: 20px;
                            border-radius: 8px;
                            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                        }
                        .form-section-title {
                            font-size: 18px;
                            font-weight: bold;
                            margin-bottom: 10px;
                            color: #333;
                        }
                        .form-input {
                            width: 100%;
                            padding: 10px;
                            margin-bottom: 10px;
                            border: 1px solid #ccc;
                            border-radius: 4px;
                            box-sizing: border-box;
                            font-size: 16px;
                        }
                        .form-button {
                            background-color: #4CAF50;
                            border: none;
                            color: white;
                            padding: 10px 15px;
                            text-align: center;
                            text-decoration: none;
                            display: inline-block;
                            font-size: 10px;
                            margin-top: 8px;
                            cursor: pointer;
                            border-radius: 4px;
                        }
                        .form-button:hover {
                            background-color: #45a049;
                        }
                        .cancel-button {
                                background-color: #f44336; /* Red background for cancel */
                                margin-left: 10px; /* Space between buttons */
                            }
                            .cancel-button:hover {
                                background-color: #e53935;
                            }
                        .row {
                            display: flex;
                            flex-wrap: wrap;
                            margin: 0 -10px; /* Adjust for columns padding */
                        }
                        .col-4, .col-6, .col-2 {
                            padding: 0 10px; /* Column padding */
                            box-sizing: border-box;
                        }
                        .col-4 {
                            flex: 0 0 33.33%;
                            max-width: 33.33%;
                        }
                        .col-6 {
                            flex: 0 0 50%;
                            max-width: 50%;
                        }
                        .col-2 {
                            flex: 0 0 16.67%;
                            max-width: 16.67%;
                        }
                    </style>
                        <form id="dataForm">
                         <!--   <div class="form-section">
                                <div class="form-section-title">Company Information</div>
                                <div class="row">
                                    <div class="col-4">
                                        <input class="form-input" type="text" placeholder="Company Name" name="company_name" value="${company_name}">
                                    </div>
                                    <div class="col-4">
                                        <input class="form-input" type="text" placeholder="Employee Size" name="employee_size" value="${employee_size}">
                                    </div>
                                    <div class="col-4">
                                        <input class="form-input" type="text" placeholder="Industry" name="industry" value="${industry}">
                                    </div>
                                </div>
                            </div>  
                            <div class="form-section">
                                <div class="form-section-title">Location Information</div>
                                <div class="row">
                                    <div class="col-6">
                                        <input class="form-input" type="text" placeholder="Country" name="country" value="${country}">
                                    </div>
                                    <div class="col-6">
                                        <input class="form-input" type="text" placeholder="City" name="city" value="${city}">
                                    </div>
                                </div>
                            </div> --> 
                            <div class="form-section">
                                <div class="form-section-title">Contact Information</div>
                                <div class="row">
                                 <!--    <div class="col-4">
                                        <input class="form-input" type="text" placeholder="Department" name="department" value="${department}">
                                    </div>
                                    <div class="col-4">
                                        <input class="form-input" type="text" placeholder="Designation" name="designation" value="${designation}">
                                    </div> --> 
                                    <div class="col-6">
                                        <input class="form-input" type="email" placeholder="Email" name="email" value="${email}">
                                    </div>
                                    <div class="col-6">
                                        <input class="form-input" type="text" placeholder="Name" name="name" value="${name}" required>
                                    </div>
                                    <div class="col-6">
                                        <input class="form-input" type="text" placeholder="Phone Number" name="phone_number" value="${phone_number}" required>
                                    </div>
                                    <div class="col-6">
                                        <input class="form-input" type="text" placeholder="Phone 2" name="phone_2" value="${phone_2}">
                                    </div>
                                </div>
                            </div>
                            <div class="form-section">
                                <div class="form-section-title">Additional Information</div>
                                <div class="row">
                                    <div class="col-6">
                                        <input class="form-input" type="date" placeholder="Date" name="date" value="${date}">
                                    </div>
                                    <div class="col-6">
                                        <select class="form-input" name="dialstatus" id="dialstatus">
                                        ${inputOptions.map(option => `
                                        <option value="${option}" ${option === dialstatus ? 'selected' : ''}>${option}</option>
                                    `).join('')}
                                        </select>
                                    </div>
                                                                        <div class="col-12">
                                        <textarea class="form-input" placeholder="Enter Remark" name="remark" id="remark">${remark}</textarea>
                                    </div>
                                </div>
                            </div>
                            <button class="form-button" type="button" onclick="window.parent.submitForm()">Submit</button>

                            <button class="form-button cancel-button" type="button" onclick="window.parent.Swal.close()">Cancel</button>

                            </form>
                        `,
                        showConfirmButton: false
                    });
                                            // Form submission function
                                            window.parent.submitForm = function() {
                                                const form = window.parent.document.getElementById('dataForm');
                                                const formData = new FormData(form);

                                                const name = formData.get('name');
                                                const phoneNumber = formData.get('phone_number');

                                                if (!phoneNumber) {
                                                    window.parent.Swal.fire({
                                                        title: "Error",
                                                        text: "Phone Number is required.",
                                                        icon: "error",
                                                        confirmButtonText: "OK"
                                                    });
                                                    return;
                                                }

                                                // Submit form data
                                                fetch('/Telephony/agent/submit_data.php', {
                                                    method: 'POST',
                                                    body: formData
                                                })
                                                    .then(response => response.json())
                                                    .then(result => {
                                                        if (result.success) {
                                                            const popupContainer = window.parent.document.getElementById('popupContainer');
                                                            if (popupContainer) {
                                                                popupContainer.style.display = 'block';
                                                            }
                                                            window.parent.Swal.fire({
                                                                title: "Success",
                                                                text: "Data submitted successfully",
                                                                icon: "success",
                                                                showConfirmButton: false,
                                                                timer: 1000
                                                            });
                                                        } else {
                                                            throw new Error(result.message);
                                                        }
                                                    })
                                                    .catch(error => {
                                                        window.parent.Swal.fire({
                                                            title: "Error",
                                                            text: error.message,
                                                            icon: "error",
                                                            showConfirmButton: false,
                                                            timer: 1000
                                                        });
                                                    });
                                            };
                                        });
                                })
                                .catch(error => {
                                    window.parent.Swal.fire({
                                        title: "Error",
                                        text: error.message,
                                        icon: "error",
                                        showConfirmButton: false,
                                        timer: 1000
                                    });
                                });
                        }
                    }, 1000);
                }
            })
            .catch(error => console.error('Error checking session:', error));
    }

    // Check live status every 5 seconds (5000 milliseconds)
    setInterval(() => { 
        // isPopupShown = false;  // Reset the popup flag after a period of time, so the popup can show again if needed
        check_live_status();    // Call the function to check status
    }, 5000);
 
}, 1000);  
                 }, 1000);
    }
};
  var web_hook_on_registrationFailed = function(e){
                window.parent.CloseWindow();
            }
            var web_hook_on_unregistered = function(){
                window.parent.CloseWindow();
            }
            var web_hook_on_terminate = function(session){
                window.setTimeout(function(){
                    window.parent.CloseWindow();
                }, 1000);
            }

        </script>
    </head>

    <body>
        <!-- Loading Animation -->
        <div class=loading>
            <span class="fa fa-circle-o-notch fa-spin"></span>
        </div>

        <!-- The Phone -->
        <div id=Phone></div>
    </body>

    <!-- Loadable Scripts -->
    <script type="text/javascript" src="https://dtd6jl0d42sve.cloudfront.net/lib/jquery/jquery-3.6.1.min.js"></script>
    <script type="text/javascript" src="https://dtd6jl0d42sve.cloudfront.net/lib/jquery/jquery-ui-1.13.2.min.js"></script>
    <script type="text/javascript" src="phone.js"></script>

    <!-- Deferred Scripts -->
    <script type="text/javascript" src="https://dtd6jl0d42sve.cloudfront.net/lib/jquery/jquery.md5-min.js" defer="true"></script>
    <script type="text/javascript" src="https://dtd6jl0d42sve.cloudfront.net/lib/Chart/Chart.bundle-2.7.2.min.js" defer="true"></script>
    <script type="text/javascript" src="https://dtd6jl0d42sve.cloudfront.net/lib/SipJS/sip-0.20.0.min.js" defer="true"></script>
    <script type="text/javascript" src="https://dtd6jl0d42sve.cloudfront.net/lib/FabricJS/fabric-2.4.6.min.js" defer="true"></script>
    <script type="text/javascript" src="https://dtd6jl0d42sve.cloudfront.net/lib/Moment/moment-with-locales-2.24.0.min.js" defer="true"></script>
    <script type="text/javascript" src="https://dtd6jl0d42sve.cloudfront.net/lib/Croppie/Croppie-2.6.4/croppie.min.js" defer="true"></script>
    <script type="text/javascript" src="https://dtd6jl0d42sve.cloudfront.net/lib/XMPP/strophe-1.4.1.umd.min.js" defer="true"></script>

</html>