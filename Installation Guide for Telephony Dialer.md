# Contents {#contents .TOC-Heading .unnumbered}

[**1.** **Section: Overview** [2](#section-overview)](#section-overview)

[**2.** **Section: OS Installation**
[2](#section-os-installation)](#section-os-installation)

[**3.** **Section: WebRTC Install/SSL Certificate**
[2](#create-bootable-usb)](#create-bootable-usb)

[**Prerequisites** [2](#prerequisites)](#prerequisites)

[**Steps: Vicidial web phone Configuration**
[2](#steps-vicidial-web-phone-configuration)](#steps-vicidial-web-phone-configuration)

[**4.** **Section: User/Phone Creation**
[5](#_Toc186903875)](#_Toc186903875)

[**5.** **Section: Campaign Creation**
[6](#_Toc186903876)](#_Toc186903876)

[**6.** **Section: List Creation** [7](#_Toc186903877)](#_Toc186903877)

[**7.** **Section: Dial Plan/SIP Registration (Carrier Configuration)**
[7](#section-dial-plansip-registration-carrier-configuration)](#section-dial-plansip-registration-carrier-configuration)

[**Overview** [7](#overview)](#overview)

[**Role in PBX Systems**
[7](#role-in-pbx-systems)](#role-in-pbx-systems)

[**Template of Account Entry**
[8](#template-of-account-entry)](#template-of-account-entry)

[**Extension Configuration**
[8](#extension-configuration)](#extension-configuration)

[**Dial Plan** [8](#dial-plan)](#dial-plan)

[**8.** **Section: Dispositions (Customized)**
[25](#_Toc186903884)](#_Toc186903884)

[**9.** **Section: Database Creation**
[25](#_Toc186903885)](#_Toc186903885)

[**10.** **Section: Sample File Input (Data Upload)**
[25](#_Toc186903886)](#_Toc186903886)

[**11. Introduction** [25](#introduction)](#introduction)

[**1.1 Overview of Cloud Telephony**
[25](#overview-of-cloud-telephony)](#overview-of-cloud-telephony)

[**1.2 Purpose of the Manual**
[26](#purpose-of-the-manual)](#purpose-of-the-manual)

[**12. System Access** [26](#system-access)](#system-access)

[**2.1 VPN Connection** [26](#vpn-connection)](#vpn-connection)

[**2.2 Troubleshooting VPN Issues:**
[26](#troubleshooting-vpn-issues)](#troubleshooting-vpn-issues)

[**2.2 Port Enablement** [26](#port-enablement)](#port-enablement)

[**2.3 Access URLs** [27](#access-urls)](#access-urls)

[**2.4 Login Credentials** [27](#login-credentials)](#login-credentials)

[**Admin:** [27](#admin)](#admin)

[**Agent:** [27](#agent)](#agent)

[**Password Security:** [27](#password-security)](#password-security)

[**13. Admin Panel** [27](#admin-panel)](#admin-panel)

[**3.1 Overview** [27](#overview-1)](#overview-1)

[**Phone Dashboard** [27](#phone-dashboard)](#phone-dashboard)

[**Live Call Dashboard**
[27](#live-call-dashboard)](#live-call-dashboard)

[**Agent-Wise List:** [28](#agent-wise-list)](#agent-wise-list)

[**Agent Summary:** [28](#agent-summary)](#agent-summary)

[**Total Stats:** [28](#total-stats)](#total-stats)

[**3.2 Profile** [29](#profile)](#profile)

[**Admin profile** [29](#admin-profile)](#admin-profile)

[**View Details:** [29](#view-details)](#view-details)

[**Edit Profile:** [29](#edit-profile)](#edit-profile)

[**3.3 Campaign Management** [30](#_Toc174369122)](#_Toc174369122)

[**Campaign Creation** [30](#campaign-creation)](#campaign-creation)

[**Fill Out Required Fields:**
[30](#fill-out-required-fields)](#fill-out-required-fields)

[**Configure Call Routing:**
[31](#configure-call-routing)](#configure-call-routing)

[**Copy Campaign:** [31](#copy-campaign)](#copy-campaign)

[**3.4 User Management** [33](#user-management)](#user-management)

[**Adding Users** [33](#adding-users)](#adding-users)

[**Complete the User Form:**
[33](#complete-the-user-form)](#complete-the-user-form)

[**Save the User Details:**
[33](#save-the-user-details)](#save-the-user-details)

[**Removing Users** [33](#removing-users)](#removing-users)

[**Viewing Agent Breaks**
[34](#viewing-agent-breaks)](#viewing-agent-breaks)

[**Login Report** [35](#login-report)](#login-report)

[**Access the \"Login Report\":**
[35](#access-the-login-report)](#access-the-login-report)

[**View Report Details:**
[35](#view-report-details)](#view-report-details)

[**Export the Report:** [35](#export-the-report)](#export-the-report)

[**All Agent Report** [36](#all-agent-report)](#all-agent-report)

[**Total Call Stats:** [36](#total-call-stats)](#total-call-stats)

[**Total Disposition Stats:**
[36](#total-disposition-stats)](#total-disposition-stats)

[**3.5 Groups** [37](#extensions)](#extensions)

[**User Groups**
[37](#user-extension-listings)](#user-extension-listings)

[**Creating or Copying User Groups**
[37](#creating-or-copying-user-extension)](#creating-or-copying-user-extension)

[**User Group Listing** [38](#_Toc186903931)](#_Toc186903931)

[**View User Group List:** [38](#_Toc186903932)](#_Toc186903932)

[**Manage User Groups:** [38](#_Toc186903933)](#_Toc186903933)

[**3.6 IVR Menu** [39](#ivr-menu)](#ivr-menu)

[**Add New Group** [39](#add-new-group)](#add-new-group)

[**Fill Out the Form:** [39](#fill-out-the-form)](#fill-out-the-form)

[**Save the Group:** [39](#save-the-group)](#save-the-group)

[**3.7 Data Upload** [40](#data-upload)](#data-upload)

[**Navigate to Data Upload:**
[40](#navigate-to-data-upload)](#navigate-to-data-upload)

[**Manage Lead Lists:** [40](#manage-lead-lists)](#manage-lead-lists)

[**Copy List:** [41](#_Toc186903941)](#_Toc186903941)

[**Show List:** [41](#show-list)](#show-list)

[**3.8 Blocking Numbers** [42](#blocking-numbers)](#blocking-numbers)

[**Add Blocked Number** [42](#add-blocked-number)](#add-blocked-number)

[**Manage Blocked Numbers**
[42](#manage-blocked-numbers)](#manage-blocked-numbers)

[**3.9 Disposition Management**
[43](#disposition-management)](#disposition-management)

[**Add or Edit Dispositions**
[43](#add-or-edit-dispositions)](#add-or-edit-dispositions)

[**View Disposition List**
[43](#view-disposition-list)](#view-disposition-list)

[**3.10 Call Reports** [44](#call-reports)](#call-reports)

[**Accessing Call Reports**
[44](#accessing-call-reports)](#accessing-call-reports)

[**View Total Call Report**
[44](#view-total-call-report)](#view-total-call-report)

[**Search Specific Agent Recordings**
[45](#search-specific-agent-recordings)](#search-specific-agent-recordings)

[**3.11 Lead Reports** [45](#lead-reports)](#lead-reports)

[**Accessing Lead Reports**
[45](#accessing-lead-reports)](#accessing-lead-reports)

[**View Lead Reports** [45](#view-lead-reports)](#view-lead-reports)

[**Entries per Page:** [46](#entries-per-page)](#entries-per-page)

[**Filter and Search** [46](#filter-and-search)](#filter-and-search)

[**Search by Agent and Date:**
[46](#search-by-agent-and-date)](#search-by-agent-and-date)

[**3.12 IVR Converter** [46](#ivr-converter)](#ivr-converter)

[**Create Speech** [46](#create-speech)](#create-speech)

[**View and Manage IVR List**
[48](#view-and-manage-ivr-list)](#view-and-manage-ivr-list)

[**14. Agent Interface** [48](#agent-interface)](#agent-interface)

[**4.1 Overview** [48](#overview-2)](#overview-2)

[**Web RTC Phone Integration:**
[48](#web-rtc-phone-integration)](#web-rtc-phone-integration)

[**Call Handling** [49](#call-handling)](#call-handling)

[**Auto-Dialing:** [49](#auto-dialing)](#auto-dialing)

[**Initial Setup: Allowing Microphone Access**
[49](#initial-setup-allowing-microphone-access)](#initial-setup-allowing-microphone-access)

[**•** **How to grant permission:**
[49](#_Toc186903968)](#_Toc186903968)

[**Register Your Account**
[50](#register-your-account)](#register-your-account)

[**Secure WebSocket Server (TLS):**
[50](#secure-websocket-server-tls)](#secure-websocket-server-tls)

[**o** **Server IP** [50](#_Toc186903971)](#_Toc186903971)

[**o** **WebSocket Port** [50](#_Toc186903972)](#_Toc186903972)

[**o** **WebSocket Path** [50](#_Toc186903973)](#_Toc186903973)

[**Account Credentials:**
[50](#account-credentials)](#account-credentials)

[**o** **Full Name** [50](#_Toc186903975)](#_Toc186903975)

[**o** **Domain/IP:** [50](#_Toc186903976)](#_Toc186903976)

[**o** **SIP Username** [50](#_Toc186903977)](#_Toc186903977)

[**o** **SIP Password** [50](#_Toc186903978)](#_Toc186903978)

[**o** **Voicemail Subscription (MWI):**
[50](#_Toc186903979)](#_Toc186903979)

[**o** **Chat Engine** [50](#_Toc186903980)](#_Toc186903980)

[**o** **Audio Settings:** [50](#_Toc186903981)](#_Toc186903981)

[**o** **Appearance Settings** [50](#_Toc186903982)](#_Toc186903982)

[**o** **Notification Settings:** [50](#_Toc186903983)](#_Toc186903983)

[**Save and Register:** [50](#_Toc186903984)](#_Toc186903984)

[**Using the Phone Interface**
[51](#using-the-phone-interface)](#using-the-phone-interface)

[**Dial Pad** [51](#dial-pad)](#dial-pad)

[**Add a Contact** [52](#add-a-contact)](#add-a-contact)

[**o** **Full Name** [52](#_Toc186903988)](#_Toc186903988)

[**o** **Allow DND (Do Not Disturb):**
[52](#_Toc186903989)](#_Toc186903989)

[**o** **Basic Extension / Address Book Contact**
[52](#_Toc186903990)](#_Toc186903990)

[**o** **Title/Description:** [52](#_Toc186903991)](#_Toc186903991)

[**o** **Extension Number** [52](#_Toc186903992)](#_Toc186903992)

[**o** **Subscribe to Device State Notifications:**
[52](#_Toc186903993)](#_Toc186903993)

[**o** **Mobile Number & Email:** [52](#_Toc186903994)](#_Toc186903994)

[**o** **Contact Numbers:** [52](#_Toc186903995)](#_Toc186903995)

[**o** **Auto Delete:** [52](#_Toc186903996)](#_Toc186903996)

[**Managing Your Account**
[53](#managing-your-account)](#managing-your-account)

[**Refresh Registration**
[53](#refresh-registration)](#refresh-registration)

[**Configure Extension**
[53](#configure-extension)](#configure-extension)

[**Auto Answer** [53](#auto-answer)](#auto-answer)

[**Call Waiting** [53](#_Toc186904001)](#_Toc186904001)

[**Troubleshooting** [54](#troubleshooting)](#troubleshooting)

[**•** **Server Connection** [54](#_Toc186904003)](#_Toc186904003)

[**•** **Account Credentials** [54](#_Toc186904004)](#_Toc186904004)

[**•** **Audio Problems** [54](#_Toc186904005)](#_Toc186904005)

[**•** **Network Connectivity** [54](#_Toc186904006)](#_Toc186904006)

[**•** **No Incoming Calls** [54](#_Toc186904007)](#_Toc186904007)

[**Post-Call Agent Disposition:**
[54](#post-call-agent-disposition)](#post-call-agent-disposition)

[**Availability Management**
[55](#availability-management)](#availability-management)

[**Status Management:** [55](#status-management)](#status-management)

[**•** **Setting Status:**
[55](#setting-status-agents-can-set-their-status-to-indicate-their-current-availability.-the-available-statuses-include)](#setting-status-agents-can-set-their-status-to-indicate-their-current-availability.-the-available-statuses-include)

[**** **Ready: Indicates that the agent is available to handle calls.**
[55](#ready-indicates-that-the-agent-is-available-to-handle-calls.)](#ready-indicates-that-the-agent-is-available-to-handle-calls.)

[**** **Lunch Break: Indicates that the agent is on a scheduled lunch
break.**
[55](#lunch-break-indicates-that-the-agent-is-on-a-scheduled-lunch-break.)](#lunch-break-indicates-that-the-agent-is-on-a-scheduled-lunch-break.)

[**** **Bio Break: Indicates that the agent is taking a short break.**
[55](#bio-break-indicates-that-the-agent-is-taking-a-short-break.)](#bio-break-indicates-that-the-agent-is-taking-a-short-break.)

[**** **Other Predefined Statuses: Additional statuses may be available
depending on your organization's requirements.**
[55](#other-predefined-statuses-additional-statuses-may-be-available-depending-on-your-organizations-requirements.)](#other-predefined-statuses-additional-statuses-may-be-available-depending-on-your-organizations-requirements.)

[**•** **Managing Availability:**
[55](#managing-availability-adjust-your-status-as-needed-to-reflect-your-current-availability-accurately.-this-helps-in-ensuring-efficient-call-routing-and-handling.-for-example-setting-the-status-to-lunch-break-will-prevent-new-calls-from-being-routed-to-you-during-this-time.)](#managing-availability-adjust-your-status-as-needed-to-reflect-your-current-availability-accurately.-this-helps-in-ensuring-efficient-call-routing-and-handling.-for-example-setting-the-status-to-lunch-break-will-prevent-new-calls-from-being-routed-to-you-during-this-time.)

[**4.2 Profile** [56](#profile-1)](#profile-1)

[**Viewing and Editing Profile Details:**
[56](#viewing-and-editing-profile-details)](#viewing-and-editing-profile-details)

[**Actions:** [56](#actions)](#actions)

[**4.3 Data Upload** [57](#data-upload-1)](#data-upload-1)

[**Upload Lead Lists:** [57](#upload-lead-lists)](#upload-lead-lists)

[**•** **Use the \"Data Upload\" section to upload lead lists in Excel
format.**
[57](#use-the-data-upload-section-to-upload-lead-lists-in-excel-format.)](#use-the-data-upload-section-to-upload-lead-lists-in-excel-format.)

[**•** **Total Upload Data Includes:**
[57](#total-upload-data-includes)](#total-upload-data-includes)

[**** **ID: Unique identifier for each lead.**
[57](#id-unique-identifier-for-each-lead.)](#id-unique-identifier-for-each-lead.)

[**** **Name: Lead's name.**
[57](#name-leads-name.)](#name-leads-name.)

[**** **Number: Lead's phone number.**
[57](#number-leads-phone-number.)](#number-leads-phone-number.)

[**** **Status: Current status of the lead.**
[57](#status-current-status-of-the-lead.)](#status-current-status-of-the-lead.)

[**4.4 Call Reporting** [57](#call-reporting)](#call-reporting)

[**4.5 Lead Report** [58](#lead-report)](#lead-report)

[**4.6 Agent Status** [58](#_Toc186904031)](#_Toc186904031)

[**4.7 Block Numbers:** [59](#block-numbers)](#block-numbers)

[**15. Troubleshooting** [59](#troubleshooting-1)](#troubleshooting-1)

[**5.1 Common Issues** [59](#common-issues)](#common-issues)

[**Connection Problems:**
[59](#connection-problems)](#connection-problems)

[**Access Issues:** [60](#access-issues)](#access-issues)

[**5.2 Contacting Support**
[60](#contacting-support)](#contacting-support)

**  
**

# **[Section: Overview]{.underline}**

This document provides step-by-step instructions to install and
configure an open-source telephony dialer. Follow these guidelines to
set up your system for efficient call management and telephony
operations.

Open Telephony Dialer is an open-source telephony dialer solution
designed to provide organizations with an efficient, customizable, and
scalable way to manage outbound and inbound calls. It supports multiple
telephony protocols such as SIP, VoIP, and PSTN (Public Switched
Telephone Network), allowing integration with a variety of telephony
systems. This solution is ideal for call centers, customer support
services, sales teams, and anyone requiring a reliable dialing system.

The dialer is built with flexibility in mind, enabling users to adjust
the system for their specific needs. It offers a variety of call
management features including auto-dialing, predictive dialing,
interactive voice response (IVR), call logging, and reporting.

# **[Section: OS Installation]{.underline}**

Telephony software OS installation involves setting up an operating
system or platform specifically designed to manage and handle telephony
services such as voice, video, and messaging. The process can include
installing software on both hardware systems (physical telephony
systems) and virtual environments (cloud-based or virtual machines).
Here\'s an overview of the typical installation process.

#### **Download vicibox server**

Use the link: <https://download.vicidial.com/vicibox/server/>

- Download latest Vicibox Server STD Media.

- Go to download Rufus from this link: <https://rufus.ie/en/>

- Download latest version of Rufus and create the bootable drive using
  Rufus.![](media/image1.jpeg){width="2.75in" height="3.50625in"}

#### **Create bootable USB**

- Use tool like **Rufus** or **Etcher** to create a bootable USB from
  the downloaded ISO.

- Device: Select device in which you want to boot Vicibox (Please do not
  select your Personal Hard Disk or SSD).

- Boot Selection: Select Vicibox ISO file.

- Rest all the configuration settings are automatic detect, we don't
  need to change.

- Click start and select the ISO image mode.

#### **Install Vicibox on Virtual Machine**

- Download Virtual Box <https://www.virtualbox.org/wiki/Downloads>

- Download Window host option to download (If you use any other
  operating, you can choose another one)

- ![](media/image2.jpg){width="6.5in" height="3.4631944444444445in"}Open
  Virtual Box and click to new.

- Name: Any Name

- ISO Image: Select your Vicibox ISO image from your drive

- Type: Linux

- Version: openSUSE(64-bit)

- Click on next

- Hardware Section:

- Base Memory: At least 4096 MB or Above

- Processors: At least @CPUs

- Virtual Hard Disk: At least 200GB

- Click on Finish

- Go to Settings in Network section:

- Attached to: Bridget Adapter

- Name: Select your Network

- System Section: Select your disk where your want to install vicibox.

- Click on Start

#### **Install Vicibox**

- Click on Install Vicibox

- Destroying your all data "Click on Continue".

- Wait for some time (Vicibox raw file installing and verifying).

- Vicibox Login: Type "root"

- Password: type "vicidial"

- Click on start

- Select system locale: en_us

- Select Keyboard Layout: us

- Click on continue

- Agree with license: click on yes

- Select your Time zone: like **ASIA/KOLKATA**

- Create and confirm root password.

- You will get DHCP IP Address.

- Login vicibox with exiting login ID and Password

<!-- -->

- Would you like to install update? Write **y** here and then click
  enter.

> **Note:** All the repository data will be installed automatically on
> the server. If repository data will not be downloaded due to network
> issue, kindly follow the whole process again.

#### **Close firewall of the server**  {#close-firewall-of-the-server}

- For using this command: yast firewall.

- In start up section: Select Stop and Do not start.

#### **Assign IP address**  {#assign-ip-address}

- Change dynamic IP to static IP for using the command: yast lan

- Network setting: Click on edit.

- Select statically assigned IP and fill IP from same network.

- Fill subnet mask like: 255.255.255.0

- Click on next.

- Go to Hostname/DNS.

- Fill DNS server like google (8.8.8.8).

- Go to Routing.

- Fill your default gateway.

- Your dynamic IP will be changed into static IP.

#### **Web Access**  {#web-access}

- For web access type command: vicibox-express.

- Then press y and enter.

- Access your IP on the browser

- Login as an Administrator, Default Login Id: 6666, password: 1234

- Continue to Initial Setup, set your phone and server password and
  Re-login

- Go to User and modify 6666 user and give all permission (1) in admin
  interface section

# **[Section: WebRTC Install/SSL Certificate]{.underline}**

WebRTC (Web Real-Time Communication) is a technology that enables
real-time audio, video, and data sharing between web browsers without
needing to install plugins. For WebRTC applications to work securely and
efficiently over the internet, they must operate over **HTTPS** (secure
HTTP), which requires an SSL (Secure Sockets Layer) certificate. This
ensures that the communication is encrypted and protected from
interception.

### Prerequisites {#prerequisites .unnumbered}

1\. Vicibox 9 or later

2\. asterisk 13 and above (vicibox 9 inbuilt)

3\. Mozilla or chrome

### Steps: Vicidial web phone Configuration {#steps-vicidial-web-phone-configuration .unnumbered}

1.  Generate Self Signed Certificate in Linux  
    2. address the self-signed certificate and key in Apache  
    3. Asterisk configuration to support webrtc  
    4. download the Vic Phone to the agent web directory  
    5. Vicidial configuration to enable the vici phone as web phone.  
    6. Final workaround to support webrtc with self-signed certificate.

> 7\. Download WinSCP and Putty from this link <http://103.113.27.42/OS>

#### **[STEP 1: Generate Self Signed Certificate using openSSL]{.underline}** {#step-1-generate-self-signed-certificate-using-openssl .unnumbered}

- Open Putty and enter your server IP address and press enter

- Accept the warning

- Login SSH console with your login ID and Password

\--Copy-Paste\-- it's a single line command.

openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout
/etc/apache2/ssl.key/viciphone.key -out
/etc/apache2/ssl.crt/viciphone.crt

- Write country name like for India (IN)

- Select your state, Locality, Organization, Organization unit name

- Common Name: Your server IP Address

- Email ID.

Note: The default path of ssl in vici box is /etc./apache2/ssl.crt and
/etc./apache2/ssl.key

#### **[STEP 2: Apache configuration.]{.underline}** {#step-2-apache-configuration. .unnumbered}

**[STEP 2.1]{.underline}**

- Open WinSCP and click on new

- Write your server IP address, user Id and Password then click to login

edit the vici box vhost file.

vi /etc/apache2/vhost.d/0000-default-ssl.conf

edit the below line with your certificate name

SSLEngine on

SSLCertificateFile /etc./apache2/ssl.crt/viciphone.crt

SSLCertificateKeyFile /etc./apache2/ssl.key/viciphone.key

save the file.

**[Step 2.2: Redirect All HTTP to HTTPS connection]{.underline}**

Edit the below mentioned file

 vi /etc./apache2/vhost.d/0000.default.conf

Add below line after Document Root as shown below

Document Root /srv/www/htdocs

Redirect permanent / https://yourserverip/   

save the file

Restart Apache

**systemctl restart apache2**

#### **[ STEP 3: Asterisk configuration to support webrtc]{.underline}** {#step-3-asterisk-configuration-to-support-webrtc .unnumbered}

**[STEP 3.1:]{.underline} **

Edit /etc/asterisk/http.conf and make sure below settings enabled

vi /etc/asterisk/http.conf

enabled=yes

bindaddr=0.0.0.0

bindport=8088

tlsenable=yes

tlsbindaddr=0.0.0.0:8089

tlscertfile=/etc/apache2/ssl.crt/viciphone.crt

tlsprivatekey=/etc/apache2/ssl.key/viciphone.key

save the file.

**STEP 3.2:**

Edit /etc/asterisk/modules.conf

vi /etc/asterisk/modules.conf

add the below entry if not enabled before.

load =\> res_http_websocket.so

save the file

**Reboot the server once**, so the asterisk startup with HTTP WebSocket
loaded,  
to confirm websocket is loaded, run the below command 

**asterisk -rx \'http show status\'**

make sure it says 

**"HTTPS Server Enabled and Bound to 0.0.0.0:8089"**

If not showing so you can this command: **systemctl start asterisk**

and then again run the command: **asterisk -rx \'http show status\'**

and make sure it says: **"HTTPS Server Enabled and Bound to
0.0.0.0:8089"**

#### **[ Step 4: Downloading the Viciphone]{.underline}** {#step-4-downloading-the-viciphone .unnumbered}

SSH to your vicibox and run below commands

cd /var/tmp

git clone https://github.com/vicimikec/ViciPhone.git

cd ViciPhone

cp -r src /srv/www/htdocs/agc/viciphone

chmod -R 755 /srv/www/htdocs/agc/viciphone

#### **[ Step 5: Vicidial configuration]{.underline}** {#step-5-vicidial-configuration .unnumbered}

#### Make sure the vicidial admin interface is accessible via **https**  {#make-sure-the-vicidial-admin-interface-is-accessible-via-https .unnumbered}

#### **Step 5.1:** {#step-5.1 .unnumbered}

Go to Admin -\> System Settings

Change the WebPhone URL

Wephone URL: <https://192.168.29.99/agc/viciphone/viciphone.php>

**Step 5.2:**

Go to ADMIN -\> Servers

configure the External Server IP: 

Web Socket URL: wss://192.168.29.99:8089/ws (Write your server IP)

**Step 5.3**

**Vicidial Websocket Template**

Go to Admin -\> Templates

Create a new template with below entries (edit the cert path) with name
vici template

type=friend

host=dynamic

encryption=yes

avpf=yes

icesupport=yes

directmedia=no

transport=wss

force_avp=yes

dtlsenable=yes

dtlsverify=no

dtlscertfile=/etc/apache2/ssl.crt/viciphone.crt

dtlsprivatekey=/etc/apache2/ssl.key/viciphone.key

dtlssetup=actpass

rtcp_mux=yes

#### **Step 6:** **Creating Campaign, User and Phone** {#step-6-creating-campaign-user-and-phone .unnumbered}

Go to campaign -\> Add a new campaign

- Campaign ID, Name, Description: you can use any name

- Admin User Group: Admin-vicidial

- Active: Y

- Hopper Level:200

- Local call time: 24 hours

- Submit

Go to User -\> Add a new user

- User ID like 1001

- Password: You can create any type

- Full Name

- User group: Admin-Vicidial

- Submit

Go to Admin -\> Phones \> add A New Phone (default)

- Phone Extension, Dial plan number, Voicemail Box, Outbound caller ID:
  Same as user ID like 1001

- Admin User Group: Admin-Vicidial

- Agent Screen login, Login password, registration password you can
  create.

- Status: Active

- Click on Submit

after adding a new phone edit the below settings

1. Set as Webphone: Y

2. Webphone Auto-Answer: Y

3. Use External Server IP: N   

4\. Template: select the template ViciPhone WebRTC

**Step 7. Browser Workaround**

Login using this link: <https://192.168.1.39/agc/vicidial.php>

# **[Install Telephony Dialer on the server]{.underline}**

<https://next2call.com/Telephony%20project/>

1.  Click on Telephony Dialer using above link

2.  Click on Telephony Database

3.  It Will download in ZIP

4.  Go to Download File

5.  Extract the File

6.  ![](media/image3.jpeg){width="6.5in"
    height="4.3909722222222225in"}Open WinSCP

7.  Host Name: Your Server IP

8.  User Name: Root

9.  Password: Your SSH Password

10. Click Login then Click Accept

11. Click on .. Directory

12. Go to SRV \> www \> htdocs

13. From Local Drive Copy paste the file to Server (htdocs)

14. Go to Telephony Folder \> Conf \> Open url page.php

15. Ip needs to be replaced from Existing IP

16. Then save the file (Ctrl S)

17. Go to Putti

18. Follow The below Command Step by Step

- mysql -u root -p

- Enter your Root Password

- CREATE DATABASE telephony_db;

- SHOW DATABASES;

- EXIT;

- mysql -u root -p

- CREATE USER \'corn\'@\'localhost\' IDENTIFIED BY \'1234\';

- GRANT ALL PRIVILEGES ON vicidial.\* TO \'cron\'@\'localhost\';

- FLUSH PRIVILEGES;

- EXIT

- mysql -u cron -p

- GRANT ALL PRIVILEGES ON telephony_db.\* TO \'cron\'@\'localhost\'
  IDENTIFIED BY \'1234\';

- FLUSH PRIVILEGES;

- EXIT;

- SHOW DATABASES;

- DROP DATABASE telephony_db;

- CREATE DATABASE telephony_db;

- GRANT ALL PRIVILEGES ON telephony_db.\* TO \'cron\'@\'localhost\'
  IDENTIFIED BY \'1234\';

- FLUSH PRIVILEGES;

- USE telephony_db;

- Open <https://yourserverip/phpMyAdmin/>

- Username: cron

- Password: 1234

- Click on new if telephony_db is not there

- create database telephony_db

- Create

- Scroll down

- Browse the file telephony_db which you have downloaded from
  <https://www.next2call.com/Telephony%20project/>

- scroll down and click on import

- Login: <https://yourserverip/Telephony/>

- Create User

# **[Section: Dial Plan/SIP Registration (Carrier Configuration)]{.underline}**

## Overview {#overview .unnumbered}

SIP (Session Initiation Protocol) configuration is critical for
establishing and managing communication sessions within a PBX (Private
Branch Exchange) system. It enables seamless voice and video calls and
is a cornerstone of modern telephony.

Approaches to SIP Configuration

1.  IP Address-Based SIP Configuration or Registration

In this method, we only need the trunk IP and the username for the SIP
account. No registration string is required for SIP configuration,
making it straightforward to implement.

2.  User and Password-Based Configuration

This approach involves creating a registration string and setting up the
account entry with the carrier. It requires the username and password
for authentication, offering a more secure setup.

## Role in PBX Systems {#role-in-pbx-systems .unnumbered}

SIP (Session Initiation Protocol) is essential for establishing and
managing communication sessions in PBX systems. It enables seamless
voice and video calls, making it a cornerstone of modern telephony.

## Template of Account Entry {#template-of-account-entry .unnumbered}

- Open Putty with your SSH ID/Password

- cd /etc/asterisk/

- nano sip.conf

- Go to Last

- Copy Account Entry

- Change your IP

> \[Come2VoIP\] type=peer host=xxx.xxx.xx.xx disallow=all allow=ulaw
> allow=alaw dtmfmode=rfc2833 context=trunkinbound qualify=yes
> canreinvite=yes port=5060 insecure=port, invite nat=force_rport,
> comedia

## Extension Configuration {#extension-configuration .unnumbered}

Extension configuration is crucial for effective communication within an
organization. In Asterisk, extensions are configured to define the
behavior of incoming and outgoing calls. This includes managing call
logs, handling dial tones, and facilitating call transfers.

### Dial Plan {#dial-plan .unnumbered}

The dial plan defines how calls are processed in a PBX system. Below is
your dial plan configuration:

- nano extensions.conf

- Go to Last

- Copy Dial Plan

\[telephony\]

; LISTEN on the call

exten =\> \_99XXXX,1,NoOp(Spying on \${EXTEN:-4})

same =\> n,Set(SPY=\${EXTEN:-4})

same =\> n,ChanSpy(SIP/\${SPY})

same =\> n,Hangup()

; Barge on the call

exten =\> \_98XXXX,1,NoOp(Barging on \${EXTEN:-4})

same =\> n,Set(SPY=\${EXTEN:-4})

same =\> n,ChanSpy(SIP/\${SPY},B)

same =\> n,Hangup()

; WHISPER on the call

exten =\> \_97XXXX,1,NoOp(WHISPER on \${EXTEN:-4})

same =\> n,Set(SPY=\${EXTEN:-4})

same =\> n,ChanSpy(SIP/\${SPY},wq)

same =\> n,Hangup()

;local call

exten =\> \_XXXX,1,Answer()

same =\> n,NoOp(local call exten to exten)

same =\>
n,Set(ARRAY(time_zone)=\${CURL(http://localhost/telephony_api/get_zone.php?extension=\${CALLERID(num)})})

same =\>
n,Set(ARRAY(from,to,start)=\${CALLERID(num)},\${EXTEN},\${STRFTIME(\${EPOCH},\${time_zone},%Y-%m-%d-%H:%M:%S)})

same =\> n,Set(ARRAY(localexten)=\${from})

same =\> n,Set(FILENAME=\${from}\${to}\${start}\${UNIQUEID}.wav)

same =\> n,MixMonitor(/srv/www/htdocs/telephony_rec/\${FILENAME})

same =\>
n,Set(\_LIVEIN=\${CURL(http://localhost/telephony_api/live.php?uniqueid=\${UNIQUEID}&did=\${localexten}&call_from=\${from}&call_to=\${to}&direction=outbound&Agent=\${from}&status=Ringing)})

same =\>
n,NoOP(http://localhost/telephony_api/live.php?uniqueid=\${UNIQUEID}&did=\${localexten}&call_from=\${from}&call_to=\${to}&direction=outbound&Agent=\${from}&status=Ringing)

same =\>
n,Dial(sip/\${to},55,RgM(macro928,\${UNIQUEID},default,\${from}))

same =\> n,Set(\_side=CALLER)

same =\> n,Hangup()

;predictive no dial

exten =\> \_96X.,1,Answer()

same =\>
n,Set(ARRAY(time_zone)=\${CURL(http://localhost/telephony_api/get_zone.php?extension=\${CALLERID(num)})})

same =\>
n,Set(ARRAY(from,to,start)=\${CALLERID(num)},\${EXTEN:-11},\${STRFTIME(\${EPOCH},\${time_zone},%Y-%m-%d-%H:%M:%S)})

same =\>
n,Set(ARRAY(stta,localexten,moh,ringtime,campaign_id)=\${CURL(http://localhost/telephony_api/get_did.php?extension=\${from})})

same =\>
n,Set(FILENAME=\${from}\${localexten}\${to}\${start}\_\${UNIQUEID}.wav)

same =\> n,MixMonitor(/srv/www/htdocs/telephony_rec/\${FILENAME})

same =\>
n,Set(\_LIVEIN=\${CURL(http://localhost/telephony_api/live.php?uniqueid=\${UNIQUEID}&did=\${localexten}&call_from=\${localexten}&call_to=\${to}&direction=outbound&Agent=\${from}&status=Ringing)})

same =\>
n,NoOP(http://localhost/telephony_api/live.php?uniqueid=\${UNIQUEID}&did=\${localexten}&call_from=\${from}&call_to=\${to}&direction=outbound&Agent=\${from}&status=Ringing)

same =\> n,Set(CALLERID(num)=\${localexten})

same =\> n,Set(CALLERID(name)=\${from})

same =\>
n,Dial(sip/\${to}@3261800000,\${ringtime},RgM(macro935,\${UNIQUEID},\${moh},\${from}))

same =\> n,Set(\_side=CLIENT)

same =\> n,Hangup()

;Moble No dial domastic

exten =\> \_0X.,1,Answer()

same =\>
n,Set(ARRAY(time_zone)=\${CURL(http://localhost/telephony_api/get_zone.php?extension=\${CALLERID(num)})})

same =\>
n,Set(ARRAY(from,to,start)=\${CALLERID(num)},\${EXTEN:-11},\${STRFTIME(\${EPOCH},\${time_zone},%Y-%m-%d-%H:%M:%S)})

same =\>
n,Set(ARRAY(stta,localexten,moh,ringtime,campaign_id)=\${CURL(http://localhost/telephony_api/get_did.php?extension=\${from})})

same =\>
n,Set(FILENAME=\${from}\${localexten}\${to}\${start}\_\${UNIQUEID}.wav)

same =\> n,MixMonitor(/srv/www/htdocs/telephony_rec/\${FILENAME})

same =\>
n,Set(\_LIVEIN=\${CURL(http://localhost/telephony_api/live.php?uniqueid=\${UNIQUEID}&did=\${localexten}&call_from=\${localexten}&call_to=\${to}&direction=outbound&Agent=\${from}&status=Ringing)})

same =\>
n,NoOP(http://localhost/telephony_api/live.php?uniqueid=\${UNIQUEID}&did=\${localexten}&call_from=\${from}&call_to=\${to}&direction=outbound&Agent=\${from}&status=Ringing)

same =\> n,Set(CALLERID(num)=\${localexten})

same =\> n,Set(CALLERID(name)=\${from})

same =\>
n,Dial(sip/\${localexten:5}\${to}@200server,\${ringtime},RgM(macro928,\${UNIQUEID},\${moh},\${from}))

same =\> n,Set(\_side=CLIENT)

same =\> n,Hangup()

;moble no dial

exten =\> \_X.,1,Answer()

same =\>
n,Set(ARRAY(time_zone)=\${CURL(http://localhost/telephony_api/get_zone.php?extension=\${CALLERID(num)})})

same =\>
n,Set(ARRAY(from,to,start)=\${CALLERID(num)},\${EXTEN:-11},\${STRFTIME(\${EPOCH},\${time_zone},%Y-%m-%d-%H:%M:%S)})

same =\>
n,Set(ARRAY(stta,localexten,moh,ringtime,campaign_id)=\${CURL(http://localhost/telephony_api/get_did.php?extension=\${from})})

same =\>
n,Set(FILENAME=\${from}\${localexten}\${to}\${start}\_\${UNIQUEID}.wav)

same =\> n,MixMonitor(/srv/www/htdocs/telephony_rec/\${FILENAME})

same =\>
n,Set(\_LIVEIN=\${CURL(http://localhost/telephony_api/live.php?uniqueid=\${UNIQUEID}&did=\${localexten}&call_from=\${localexten}&call_to=\${to}&direction=outbound&Agent=\${from}&status=Ringing)})

same =\>
n,NoOP(http://localhost/telephony_api/live.php?uniqueid=\${UNIQUEID}&did=\${localexten}&call_from=\${from}&call_to=\${to}&direction=outbound&Agent=\${from}&status=Ringing)

same =\> n,Set(CALLERID(num)=\${localexten})

same =\> n,Set(CALLERID(name)=\${from})

same =\>
n,Dial(sip/\${to}@3261800000,\${ringtime},RgM(macro928,\${UNIQUEID},\${moh},\${from}))

same =\> n,Set(\_side=CALLER)

same =\> n,Hangup()

exten =\>
h,1,Set(\_livedel=\${CURL(http://localhost/telephony_api/live.php?uniqueid=\${UNIQUEID}&status=delete)})

same =\>
n,Set(ARRAY(time_zone)=\${CURL(http://localhost/telephony_api/get_zone.php?extension=\${from})})

same =\>
n,Set(\_endtime=\${STRFTIME(\${EPOCH},\${time_zone},%Y-%m-%d-%H:%M:%S)})

; Check status

same =\> n,GotoIf(\$\[\${LEN(\${to})} = 4\]?\_local:\_external)

same =\>
n(\_local),Set(\_cdrentryOutbound=\${CURL(http://localhost/telephony_api/live_cdr.php?uniqueid=\${UNIQUEID}&did=\${localexten}&call_to=\${from}&call_from=\${to}&start_time=\${start}&duration=\${ANSWEREDTIME}&call_status=\${DIALSTATUS}&end_time=\${endtime}&server_url=https://localhost/telephony_rec/&record_url=\${FILENAME}&direction=outbound&hangup=\${side}&campaign_id=\${campaign_id})})

same =\>
n,Set(\_cdrentryInbound=\${CURL(http://localhost/telephony_api/live_cdr.php?uniqueid=\${UNIQUEID}&did=\${to}&call_to=\${to}&call_from=\${from}&start_time=\${start}&duration=\${ANSWEREDTIME}&call_status=\${DIALSTATUS}&end_time=\${endtime}&server_url=https://localhost/telephony_rec/&record_url=\${FILENAME}&direction=inbound&hangup=\${side}&campaign_id=\${campaign_id})})

same =\> n,Hangup()

same =\>
n(\_external),Set(\_cdrentryOutbound=\${CURL(http://localhost/telephony_api/live_cdr.php?uniqueid=\${UNIQUEID}&did=\${localexten}&call_to=\${from}&call_from=\${to}&start_time=\${start}&duration=\${ANSWEREDTIME}&call_status=\${DIALSTATUS}&end_time=\${endtime}&server_url=https://localhost/telephony_rec/&record_url=\${FILENAME}&direction=outbound&hangup=\${side}&campaign_id=\${campaign_id})})

same =\> n,Hangup()

\[telephony in\]

exten =\> \_X.,1,Answer()

same =\>
n(StartCall),Set(ARRAY(time_zone)=\${CURL(http://localhost/telephony_api/get_zone.php?did_number=\${EXTEN})})

same =\>
n,Set(ARRAY(from,to,start,channel)=\${CALLERID(num)},\${EXTEN},\${STRFTIME(\${EPOCH},\${time_zone},%Y-%m-%d-%H:%M:%S)},\${CHANNEL})

same =\>
n,Set(ARRAY(if,status)=\${CURL(http://localhost/telephony_api/get_block_no.php?number=\${from}&did_number=\${to})})

; Check block status

same =\> n,GotoIf(\$\[\"\${if}\"=\"1\"\]?hang:continue)

same =\>
n(continue),Set(ARRAY(stta,localexten,ivr,location,moh,ringtime,key_index,type,no_agent,campaign_id)=\${CURL(http://localhost/telephony_api/get_extension.php?key_index=1&did_number=\${to}&dtmf=)})

same =\>
n,Set(\_FILENAME=\${from}\_\${to}\_\${localexten}\_\${start}\_\${UNIQUEID}.wav)

; Check status and route call

same =\> n,GotoIf(\$\[\"\${stta}\"=\"1\"\]?afterivr:ivr_check)

; After office hours handling

same =\> n(afterivr),Playback(\${location}\${ivr})

same =\>
n,Set(\_LIVEIN=\${CURL(http://localhost/telephony_api/live.php?uniqueid=\${UNIQUEID}&did=\${to}&call_from=\${from}&call_to=\${localexten}&direction=inbound&Agent=\${localexten}&status=Ringing)})

same =\>
n,NoOp(http://localhost/telephony_api/live.php?uniqueid=\${UNIQUEID}&did=\${to}&call_from=\${from}&call_to=\${localexten}&direction=inbound&Agent=\${localexten}&status=Ringing)

same =\> n,Hangup()

; IVR and Dial Handling

same =\>
n(ivr_check),GotoIf(\$\[\"\${stta}\"=\"2\"\]?ivrplaydial:ingroup)

; IVR and Dial Handling in group

same =\>
n(ingroup),GotoIf(\$\[\"\${stta}\"=\"3\"\]?ivrplaydialgroup:ivrplaymobile)

; IVR and Dial Handling Agent mobile No

same =\>
n(ivrplaymobile),GotoIf(\$\[\"\${stta}\"=\"4\"\]?ivrplaydialmobile:ivrplaymobilegroup)

; IVR and Dial Handling Agent mobile No in group

same =\>
n(ivrplaymobilegroup),GotoIf(\$\[\"\${stta}\"=\"5\"\]?ivrplaydialmobileingroup:NoAgent)

; NO Agent

same =\> n(NoAgent),GotoIf(\$\[\"\${stta}\"=\"0\"\]?NoAgentfound:wrong)

; WRONG

same =\> n(wrong),GotoIf(\$\[\"\${stta}\"=\"6\"\]?SomWrong:Agcall)

;agent did call

same =\> n(Agcall),GotoIf(\$\[\"\${stta}\"=\"7\"\]?AgentCall:menu)

; call menu

same =\> n(menu),GotoIf(\$\[\"\${stta}\"=\"8\"\]?callMenu:week)

; week off

same =\> n(week),GotoIf(\$\[\"\${stta}\"=\"9\"\]?week_off:hang)

; NO Agent found

same =\> n(NoAgentfound),NoOp(Starting No Agent found moh)

same =\>
n,Set(\_LIVEIN=\${CURL(http://localhost/telephony_api/live.php?uniqueid=\${UNIQUEID}&did=\${to}&call_from=\${from}&call_to=\${localexten}&direction=inbound&Agent=\${localexten}&status=Ringing)})

same =\>
n,NoOp(http://localhost/telephony_api/live.php?uniqueid=\${UNIQUEID}&did=\${to}&call_from=\${from}&call_to=\${localexten}&direction=inbound&Agent=\${localexten}&status=Ringing)

same =\> n,StartMusicOnHold(default) ; Use default MOH

same =\> n,Wait(40)

same =\> n,Goto(StartCall)

same =\> n,Hangup()

; week off ivr

same =\> n(week_off),Playback(\${location}\${ivr})

same =\>
n,Set(\_LIVEIN=\${CURL(http://localhost/telephony_api/live.php?uniqueid=\${UNIQUEID}&did=\${to}&call_from=\${from}&call_to=\${localexten}&direction=inbound&Agent=\${localexten}&status=Ringing)})

same =\>
n,NoOp(http://localhost/telephony_api/live.php?uniqueid=\${UNIQUEID}&did=\${to}&call_from=\${from}&call_to=\${localexten}&direction=inbound&Agent=\${localexten}&status=Ringing)

same =\> n,Hangup()

; Somthing Wrong

same =\> n(SomWrong),NoOp(Somthing Wrong)

same =\>
n,Set(\_LIVEIN=\${CURL(http://localhost/telephony_api/live.php?uniqueid=\${UNIQUEID}&did=\${to}&call_from=\${from}&call_to=\${localexten}&direction=inbound&Agent=\${localexten}&status=Ringing)})

same =\>
n,NoOp(http://localhost/telephony_api/live.php?uniqueid=\${UNIQUEID}&did=\${to}&call_from=\${from}&call_to=\${localexten}&direction=inbound&Agent=\${localexten}&status=Ringing)

same =\> n,Hangup()

; Campaign call in local webphone Agent

same =\> n(ivrplaydial),NoOp(Campaign call in Agent)

same =\> n,GotoIf(\$\[\'\${ivr}\'=\'0\'\]?AgentCheck:ivrplay)

same =\>
n(AgentCheck),GotoIf(\$\[\'\${localexten}\'=\'NOAGENT\'\]?dialnext:dialing)

same =\> n(ivrplay),Playback(\${location}\${ivr})

same =\>
n(dialing),Set(ARRAY(stta,localexten,ivr,location,moh,ringtime,key_index,type,no_agent,campaign_id)=\${CURL(http://localhost/telephony_api/get_extension.php?key_index=1&did_number=\${to}&dtmf=)})

same =\> n,GotoIf(\$\[\'\${type}\'=\'ring_all\'\]?All:othty)

same =\> n(All),Set(\_localtype=Ring_All)

same =\> n,Goto(live)

same =\> n(othty),Set(\_localtype=\${localexten})

same =\>
n(live),Set(\_LIVEIN=\${CURL(http://localhost/telephony_api/live.php?uniqueid=\${UNIQUEID}&did=\${to}&call_from=\${from}&call_to=\${to}&direction=inbound&Agent=\${localtype}&status=Ringing)})

same =\>
n,Set(\_FILENAME=\${from}\_\${to}\_\${localtype}\_\${start}\_\${UNIQUEID}.wav)

same =\>
n,Set(MONITOR_FILENAME=/srv/www/htdocs/telephony_rec/\${FILENAME})

same =\> n,MixMonitor(\${MONITOR_FILENAME})

same =\>
n,NoOp(http://localhost/telephony_api/live.php?uniqueid=\${UNIQUEID}&did=\${to}&call_from=\${from}&call_to=\${to}&direction=inbound&Agent=\${localtype}&status=Ringing)

same =\> n,Set(CALLERID(num)=\${from})

same =\> n,Set(CHANNEL(musicclass)=custom-\${moh}) ; Ensure MOH class is
set

same =\>
n,Dial(SIP/\${localexten},\${ringtime},RgM(macro5568,\${UNIQUEID},\${moh}))

same =\> n,Set(\_side=AGENT)

; Handle the call status and update the CDR

same =\> n,GotoIf(\$\[\'\${DIALSTATUS}\'=\'ANSWER\'\]?hang:dialnext)

; NO Agent found dialnext

same =\> n(dialnext),NoOp(Starting No Agent found moh)

same =\> n,NoOp(Entering dialnext with Agent)

same =\>
n,Set(ARRAY(stta,localexten,ivr,location,moh,ringtime,key_index,type,no_agent,campaign_id)=\${CURL(http://localhost/telephony_api/get_extension.php?key_index=1&did_number=\${to}&dtmf=)})

same =\>
n,NoOP(http://localhost/telephony_api/get_extension.php?key_index=1&did_number=\${to}&dtmf=)

same =\>
n,Set(\_LIVEIN=\${CURL(http://localhost/telephony_api/live.php?uniqueid=\${UNIQUEID}&did=\${to}&call_from=\${from}&call_to=\${localexten}&direction=inbound&Agent=\${localexten}&status=Ringing)})

same =\> n,StopMixMonitor()

same =\> n,NoOp(Recording has been stopped)

same =\> n,Background(\${location}\${no_agent})

same =\> n,Wait(2)

; Update CDR entry and delete live call status

same =\>
n,Set(\_cdrentryInbound=\${CURL(http://localhost/telephony_api/live_cdr.php?uniqueid=\${UNIQUEID}&did=\${to}&call_to=\${localexten}&call_from=\${from}&start_time=\${start}&duration=\${ANSWEREDTIME}&call_status=\${DIALSTATUS}&end_time=\${endtime}&server_url=https://localhost/telephony_rec/&record_url=\${FILENAME}&direction=inbound&hangup=\${side}&campaign_id=\${campaign_id})})

same =\>
n,Set(\_livedel=\${CURL(http://localhost/telephony_api/live.php?uniqueid=\${UNIQUEID}&status=delete)})

same =\> n,Goto(ivrplaydial)

same =\> n,Hangup()

; local webphone Agent did

same =\> n(AgentCall),NoOp(call agent did)

same =\>
n,Set(\_FILENAME=\${from}\_\${to}\_\${localexten}\_\${start}\_\${UNIQUEID}.wav)

same =\>
n,Set(MONITOR_FILENAME=/srv/www/htdocs/telephony_rec/\${FILENAME})

same =\> n,MixMonitor(\${MONITOR_FILENAME})

same =\>
n,Set(\_LIVEIN=\${CURL(http://localhost/telephony_api/live.php?uniqueid=\${UNIQUEID}&did=\${to}&call_from=\${from}&call_to=\${localexten}&direction=inbound&Agent=\${localexten}&status=Ringing)})

same =\>
n,NoOp(http://localhost/telephony_api/live.php?uniqueid=\${UNIQUEID}&did=\${to}&call_from=\${from}&call_to=\${localexten}&direction=inbound&Agent=\${localexten}&status=Ringing)

same =\> n,Set(CALLERID(num)=\${from})

same =\> n,Set(CHANNEL(musicclass)=custom-\${moh}) ; Ensure MOH class is
set

same =\>
n,Dial(SIP/\${localexten},55,Rgm(custom-\${moh})M(macro5568,\${UNIQUEID},default))

same =\> n,Set(\_side=AGENT)

same =\> n,Hangup()

; Ingroup call in local webphone Agent

same =\> n(ivrplaydialgroup),Read(keypressed,\${location}\${ivr},1,s,25)

same =\> n,GotoIf(\$\[\"\${keypressed}\"=\"\"\]?timeout:process_key)

; Timeout handler

same =\> n(timeout),Playback(vm-goodbye)

same =\> n,Hangup()

; Process key press

same =\> n(process_key),GotoIf(\$\[\${keypressed} \>= 1 & \${keypressed}
\<= 8\]?valid_key:invalid_key)

same =\> n(dialgroup),NoOp(ivrplaydialgroup menu Enter)

same =\>
n(valid_key),Set(ARRAY(stta,localexten,ivr,location,moh,ringtime,key_index)=\${CURL(http://103.113.27.238/telephony_api/get_extension.php?key_index=\${key_index}&did_number=\${to}&dtmf=\${keypressed})})

same =\>
n,Set(MONITOR_FILENAME=/srv/www/htdocs/telephony_rec/\${FILENAME})

same =\> n,MixMonitor(\${MONITOR_FILENAME})

same =\>
n,Set(\_LIVEIN=\${CURL(http://localhost/telephony_api/live.php?uniqueid=\${UNIQUEID}&did=\${to}&call_from=\${from}&call_to=\${localexten}&direction=inbound&Agent=\${localexten}&status=Ringing)})

same =\>
n,NoOp(http://localhost/telephony_api/live.php?uniqueid=\${UNIQUEID}&did=\${to}&call_from=\${from}&call_to=\${localexten}&direction=inbound&Agent=\${localexten}&status=Ringing)

same =\> n,Set(CALLERID(num)=\${from})

same =\> n,Set(CHANNEL(musicclass)=custom-\${moh}) ; Ensure MOH class is
set

same =\>
n,Dial(SIP/\${localexten},\${ringtime},Rgm(custom-\${moh})M(macro5568,\${UNIQUEID},\${moh}))

same =\> n,Set(\_side=AGENT)

; Handle the call status and update the CDR

same =\>
n,GotoIf(\$\[\"\${DIALSTATUS}\"=\"ANSWER\"\]?hang:dialingnextgroup)

; NO Agent found dialnext

same =\> n(dialingnextgroup),NoOp(Starting No Agent found moh)

same =\> n,NoOp(Entering dialnext with keypressed=\${keypressed} and
key_index=\${key_index})

same =\> n,Set(PREV_KEYPRESSED=\${keypressed})

same =\> n,Set(PREV_KEY_INDEX=\${key_index})

same =\>
n,Set(ARRAY(stta,localexten,ivr,location,moh,ringtime,key_index,type,no_agent,campaign_id)=\${CURL(http://localhost/telephony_api/get_extension.php?key_index=\${PREV_KEY_INDEX}&did_number=\${to}&dtmf=\${PREV_KEYPRESSED})})

same =\>
n,NoOP(http://localhost/telephony_api/get_extension.php?key_index=\${PREV_KEY_INDEX}&did_number=\${to}&dtmf=\${PREV_KEYPRESSED})

same =\> n,StopMixMonitor()

same =\> n,NoOp(Recording has been stopped)

same =\> n,Background(\${location}\${no_agent})

same =\> n,Wait(2)

; Update CDR entry and delete live call status

same =\>
n,Set(ARRAY(status,localexten)=\${CURL(http://localhost/telephony_api/live.php?uniqueid=\${UNIQUEID}&status=delete)})

same =\>
n,Set(ARRAY(time_zone)=\${CURL(http://localhost/telephony_api/get_zone.php?did_number=\${EXTEN})})

same =\>
n,Set(\_endtime=\${STRFTIME(\${EPOCH},\${time_zone},%Y-%m-%d-%H:%M:%S)})

same =\>
n,Set(\_cdrentryInbound=\${CURL(http://localhost/telephony_api/live_cdr.php?uniqueid=\${UNIQUEID}&did=\${to}&call_to=\${localexten}&call_from=\${from}&start_time=\${start}&duration=\${ANSWEREDTIME}&call_status=\${DIALSTATUS}&end_time=\${endtime}&server_url=https://localhost/telephony_rec/&record_url=\${FILENAME}&direction=inbound&hangup=\${side}&campaign_id=\${campaign_id})})

same =\> n,Goto(dialgroup)

same =\> n,Hangup()

; Invalid key press handler

same =\> n(invalid_key),Playback(invalid)

same =\> n,Goto(ivrplaydialgroup)

; Start of call menu

same =\> n(callMenu),NoOp(Start of call menu)

same =\> n,Read(keypressed,\${location}\${ivr},1,s,1,25)

same =\>
n,GotoIf(\$\[\"\${keypressed}\"=\"\"\]?timeouta:process_key_menu)

; Timeout handler

same =\> n(timeouta),NoOp(Caller did not press any key)

same =\> n,Playback(vm-goodbye)

same =\> n,Hangup()

; Process key press

same =\> n(process_key_menu),GotoIf(\$\[\${keypressed} \>= 1 &
\${keypressed} \<= 8\]?valid_key_menu:invalid_key_menu)

; Valid key press handling

same =\> n(valid_key_menu),NoOp(Entering valid_key_menu with
keypressed=\${keypressed} and key_index=\${key_index})

same =\>
n,Set(ARRAY(stta,localexten,ivr,location,moh,ringtime,key_index,type,no_agent,campaign_id)=\${CURL(http://localhost/telephony_api/get_extension.php?did_number=\${to}&dtmf=\${keypressed})})

same =\> n,GotoIf(\$\[\"\${stta}\"=\"0\"\]?invalid_key_menu:checknext)

same =\> n(checknext),GotoIf(\$\[\"\${ivr}\"=\"1\"\]?callmen:callMenu)

same =\> n(callmen),NoOp(call menu Enter)

same =\>
n,Set(MONITOR_FILENAME=/srv/www/htdocs/telephony_rec/\${FILENAME})

same =\> n,MixMonitor(\${MONITOR_FILENAME})

same =\>
n,Set(\_LIVEIN=\${CURL(http://localhost/telephony_api/live.php?uniqueid=\${UNIQUEID}&did=\${to}&call_from=\${from}&call_to=\${localexten}&direction=inbound&Agent=\${localexten}&status=Ringing)})

same =\>
n,NoOp(http://localhost/telephony_api/live.php?uniqueid=\${UNIQUEID}&did=\${to}&call_from=\${from}&call_to=\${localexten}&direction=inbound&Agent=\${localexten}&status=Ringing)

same =\> n,Set(CALLERID(num)=\${from})

same =\> n,Set(CHANNEL(musicclass)=custom-\${moh}) ; Ensure MOH class is
set

same =\>
n,Dial(SIP/\${localexten},\${ringtime},Rgm(custom-\${moh})M(macro5568,\${UNIQUEID},\${moh}))

same =\> n,Set(\_side=AGENT)

; Handle the call status and update the CDR

same =\> n,GotoIf(\$\[\"\${DIALSTATUS}\"=\"ANSWER\"\]?hang:dialingnext)

; NO Agent found dialnext

same =\> n(dialingnext),NoOp(Starting No Agent found moh)

same =\> n,NoOp(Entering dialnext with keypressed=\${keypressed} and
key_index=\${key_index})

same =\> n,Set(PREV_KEYPRESSED=\${keypressed})

same =\> n,Set(PREV_KEY_INDEX=\${key_index})

same =\>
n,Set(ARRAY(stta,localexten,ivr,location,moh,ringtime,key_index,type,no_agent,campaign_id)=\${CURL(http://localhost/telephony_api/get_extension.php?key_index=\${PREV_KEY_INDEX}&did_number=\${to}&dtmf=\${PREV_KEYPRESSED})})

same =\>
n,NoOP(http://localhost/telephony_api/get_extension.php?key_index=\${PREV_KEY_INDEX}&did_number=\${to}&dtmf=\${PREV_KEYPRESSED})

same =\> n,StopMixMonitor()

same =\> n,NoOp(Recording has been stopped)

same =\> n,Background(\${location}\${no_agent})

same =\> n,Wait(2)

; Update CDR entry and delete live call status

same =\>
n,Set(ARRAY(status,localexten)=\${CURL(http://localhost/telephony_api/live.php?uniqueid=\${UNIQUEID}&status=delete)})

same =\>
n,Set(ARRAY(time_zone)=\${CURL(http://localhost/telephony_api/get_zone.php?did_number=\${EXTEN})})

same =\>
n,Set(\_endtime=\${STRFTIME(\${EPOCH},\${time_zone},%Y-%m-%d-%H:%M:%S)})

same =\>
n,Set(\_cdrentryInbound=\${CURL(http://localhost/telephony_api/live_cdr.php?uniqueid=\${UNIQUEID}&did=\${to}&call_to=\${localexten}&call_from=\${from}&start_time=\${start}&duration=\${ANSWEREDTIME}&call_status=\${DIALSTATUS}&end_time=\${endtime}&server_url=https://localhost/telephony_rec/&record_url=\${FILENAME}&direction=inbound&hangup=\${side}&campaign_id=\${campaign_id})})

same =\> n,Goto(callmen)

same =\> n,Hangup()

; Invalid key press handler

same =\> n(invalid_key_menu),NoOp(invalid_key_menu)

same =\> n,Goto(callMenu)

; Hangup handler

same =\> n(hang),Hangup()

; Hangup handler and CDR logging

exten =\>
h,1,Set(ARRAY(status,localexten)=\${CURL(http://localhost/telephony_api/live.php?uniqueid=\${UNIQUEID}&status=delete)})

same =\>
n,Set(ARRAY(time_zone)=\${CURL(http://localhost/telephony_api/get_zone.php?did_number=\${EXTEN})})

same =\>
n,Set(\_endtime=\${STRFTIME(\${EPOCH},\${time_zone},%Y-%m-%d-%H:%M:%S)})

same =\>
n,Set(\_cdrentryInbound=\${CURL(http://localhost/telephony_api/live_cdr.php?uniqueid=\${UNIQUEID}&did=\${to}&call_to=\${localexten}&call_from=\${from}&start_time=\${start}&duration=\${ANSWEREDTIME}&call_status=\${DIALSTATUS}&end_time=\${endtime}&server_url=https://localhost/telephony_rec/&record_url=\${FILENAME}&direction=inbound&hangup=\${side}&campaign_id=\${campaign_id})})

; Macro for handling agent interaction

\[macro-macro5568\]

exten =\> s,1,NoOp(Call answered by \${CALLERID(num)})

same =\>
n,Set(\_liveupdateuser=\${CURL(http://localhost/telephony_api/live.php?uniqueid=\${ARG1}&status=Answer&Agent=\${CALLERID(num)})})

same =\> n,Set(CHANNEL(musicclass)=custom-\${ARG2})

# **11. [Introduction]{.underline}** {#introduction .unnumbered}

##  1.1 **Overview of Cloud Telephony** {#overview-of-cloud-telephony .unnumbered}

- Cloud telephony refers to telecommunication services hosted on cloud
  servers rather than on-premises hardware. This model offers
  scalability, flexibility, and integration with various business
  applications. Key features typically include:

<!-- -->

- Call Routing: Directs incoming calls to the appropriate department or
  agent based on predefined rules.

- Campaign Management: Manages marketing campaigns, including call lists
  and scheduling.

- Real-Time Monitoring: Allows administrators to monitor and interact
  with live calls and agent activities.

##  1.2 **Purpose of the Manual** {#purpose-of-the-manual .unnumbered}

- This manual provides a comprehensive guide for:

<!-- -->

- Accessing and securing the cloud telephony server.

- Using the Admin Panel for configuration and management.

- Operating the Agent Interface effectively.

- Creating, launching, and managing telephony campaigns.

- Troubleshooting common issues and maintaining system health.

#  **12. [System Access]{.underline}** {#system-access .unnumbered}

##  **2.1 VPN Connection** {#vpn-connection .unnumbered}

- Connect to VPN:

<!-- -->

- Ensure you have the VPN client installed as per the company's
  guidelines.

- Open the VPN client and enter the provided credentials.

- Connect to the designated VPN server to ensure secure access to the
  telephony system.

## **2.2 Troubleshooting VPN Issues:** {#troubleshooting-vpn-issues .unnumbered}

- Check your internet connection and VPN credentials if you cannot
  connect.

- Contact IT support if the problem persists.

##  **2.2 Port Enablement** {#port-enablement .unnumbered}

- Access Port Configuration:

<!-- -->

- Open your web browser and navigate to: \[https://XXX.XXX.X.XXX:8089/\]
  (<https://XXX.XXX.X.XXX:8089/>).

- Authenticate to access this configuration page if required.

<!-- -->

- Enable Necessary Ports:

<!-- -->

- Follow the on-screen instructions to ensure the necessary ports are
  open.

- Typically involves configuring your firewall or router to allow
  traffic through specific ports (e.g., 8089).

##  2.3 Access URLs {#access-urls .unnumbered}

- Admin Panel URL: https://XXX.XXX.XX.XXX/Telephony/

- Agent Interface URL: https:// XXX.XXX.XX.XXX /Telephony/

##  2.4 Login Credentials {#login-credentials .unnumbered}

### Admin: {#admin .unnumbered}

- User ID: 8888

- Password: 4UK935k5qTiwsx

### Agent: {#agent .unnumbered}

- User ID: 8881

- Password: D08I7fpMOK

### Password Security: {#password-security .unnumbered}

- Change passwords periodically and use strong, unique passwords for
  each account.

#  {#section .unnumbered}

#  13. Admin Panel {#admin-panel .unnumbered}

The Admin Panel is the central hub for managing the cloud telephony
system. It allows administrators to handle various tasks including user
management, call routing, campaign management, and real-time monitoring
of calls. This manual provides a detailed guide to all functionalities
available in the Admin Panel.

## 3.1 Overview {#overview-1 .unnumbered}

### Phone Dashboard {#phone-dashboard .unnumbered}

- View ongoing calls, including details and agent statuses.

- Barge In: Use this feature to listen to live calls for support.

### Live Call Dashboard {#live-call-dashboard .unnumbered}

- Shows the number of logged-in agents, available agents, paused agents,
  agents in call, and call queue statistics.

### Agent-Wise List:  {#agent-wise-list .unnumbered}

Display detailed information including:

- Start Time

- Agent Name

- Call From

- Call To

- Call Status

- Duration

- Direction

###  Agent Summary: {#agent-summary .unnumbered}

- View the current status of agents (e.g., Ready, Paused, ).

- Monitor the last call details for each agent.

<!-- -->

- Ready/Pause: See if agents are ready to take calls or are on pause.

- Login/Talk/Answer/Cancel/Other: View agent activities and statuses.

### Total Stats:![](media/image4.jpeg){width="6.5in" height="2.8944444444444444in"} {#total-stats .unnumbered}

- Login/Talk/Answer/Cancel/Other: View agent activities and statuses.

## 3.2 Profile {#profile .unnumbered}

### Admin profile  {#admin-profile .unnumbered}

- Profile Management

<!-- -->

- Viewing and Editing Admin Profile

### View Details: {#view-details .unnumbered}

- View your profile information including Name, Contact Information, and
  Email.

### Edit Profile: {#edit-profile .unnumbered}

- Click \"Edit Profile\".

- Update fields (Name, Contact Information, Email).

- Click \"Save\" to apply changes.

![](media/image5.jpeg){width="6.5in" height="2.8743055555555554in"}

## 3.4 User Management {#user-management .unnumbered}

### Adding Users {#adding-users .unnumbered}

To add a new user to the system, follow these steps:

- Navigate to the \"Add User\" Section:

<!-- -->

- Go to the \"Add List\" menu.

- Select \"Add Agent.\"

### Complete the User Form: {#complete-the-user-form .unnumbered}

- Fill in the required fields:

<!-- -->

- **Name:** Enter the full name of the user.

- **Email**: Provide the user's email address.

- **Role**: Select the user's role from the available options (e.g.,
  agent, team leader, admin).

- **Campaign Assignments**: Assign campaigns to the user if applicable.

### Save the User Details: {#save-the-user-details .unnumbered}

- Click the \"Save\" button to add the user to the system.

### Removing Users {#removing-users .unnumbered}

To remove a user from the system, follow these steps:

- Select the User:

<!-- -->

- From the user list, select the user you wish to remove.

<!-- -->

- Initiate Removal:

<!-- -->

- Click \"Remove\" from the action menu.

<!-- -->

- Confirm the Removal:

<!-- -->

- A confirmation prompt will appear. Confirm the action to delete the
  user from the system.

![](media/image6.jpeg){width="6.895833333333333in" height="4.53125in"}

![](media/image7.jpeg){width="6.5in" height="3.7618055555555556in"}

### Viewing Agent Breaks {#viewing-agent-breaks .unnumbered}

To view details about agent breaks:

- Navigate to the \"Agent Breaks\" Section:

<!-- -->

- Go to the \"Agent Breaks\" menu.

<!-- -->

- View Break Details:

<!-- -->

- The section will display details such as Name, Break Time, and
  Duration of each break.

<!-- -->

- Export Data:

<!-- -->

- If needed, click the \"Export\" button to download the data for
  reporting purposes.

![](media/image8.jpeg){width="6.604166666666667in"
height="2.8944444444444444in"}

###  Login Report {#login-report .unnumbered}

To access and view the login report:

### Access the \"Login Report\": {#access-the-login-report .unnumbered}

- Go to the \"Login Report\" section.

### View Report Details: {#view-report-details .unnumbered}

- The report includes:

<!-- -->

- User ID: Identifies the user.

- Login Time: Time when the user logged in.

- Logout Time: Time when the user logged out.

- Total Time: Duration of the user\'s session.

### Export the Report: {#export-the-report .unnumbered}

- Click the \"Export\" option to download the report.

![](media/image9.jpeg){width="6.854166666666667in"
height="2.8847222222222224in"}

###  All Agent Report {#all-agent-report .unnumbered}

To view detailed statistics on agent performance:

### Total Call Stats: {#total-call-stats .unnumbered}

- View call statistics displayed in pie chart format, including:

<!-- -->

- Canceled Calls

- Total Calls

- Answered Calls

- Other Call Types

### Total Disposition Stats: {#total-disposition-stats .unnumbered}

- View disposition statistics, which reflect the outcomes recorded by
  agents after each call.

- The stats are displayed in a pie chart format.

![](media/image10.png){width="6.5in" height="2.8680555555555554in"}

![](media/image11.png){width="6.5in" height="1.7506944444444446in"}

[]{#_Toc174369122 .anchor}3.3 Campaign Management

### Campaign Creation {#campaign-creation .unnumbered}

- Access Campaigns Interface:

<!-- -->

- Go to the \"Campaigns\" section and select \"Create New Campaign\" or
  \"Copy Campaign.\"

### Fill Out Required Fields: {#fill-out-required-fields .unnumbered}

- Campaign ID: Unique identifier.

- Campaign Name: Descriptive name.

- Campaign Type: Inbound, outbound, or both.

- Inbound/Outbound CID: Caller IDs.

- IVR Settings: Upload or choose IVR audio files (e.g., welcome message,
  after-hours).

- Ring Time: Select 30, 40, or 60 seconds.

- Next Agent Call: Choose from Random, Rank, Ring All, or Longest Wait
  Time.

- Week Off: Select a day of the week as a week off.

- Call Launch: Choose \"None\" or \"Form\". Select \"Form\" to prompt
  agents to fill out a form after a call ends; \"None\" skips the form.

### Configure Call Routing: {#configure-call-routing .unnumbered}

- None: Direct forwarding to an agent.

- Group: IVR options like \"Press 1 for Sales\" or \"Press 2 for
  Support.\"

- Call Menu: Sequential IVR prompts (e.g., \"Press 1 for A,\" then
  \"Press 3 or 4\"; \"Press 2 for B,\" then \"Press 5 or 6\").

<!-- -->

- Set Active Status:

<!-- -->

- Yes/No.

### Copy Campaign: {#copy-campaign .unnumbered}

- ***Start Copy Process:***

  - Go to the \"Campaigns\" section.

  - Click on \"Copy Campaign.\"

<!-- -->

- ***Select Campaign to Copy:***

  - Choose the specific campaign you want to copy from the list of
    existing campaigns.

- ***Enter New Campaign Details:***

  - ***New Campaign ID:*** Assign a new unique identifier for the copied
    campaign.

  - ***New Campaign Name:*** Provide a new descriptive name for the
    copied campaign.

- ***Complete and Save:***

  - Review the details and settings.

  - Save the new campaign configuration.

This guide should help you effectively manage and create campaigns while
ensuring you maintain the necessary details and configurations.

![](media/image12.jpeg){width="6.5in" height="1.1423611111111112in"}

![](media/image13.png){width="6.5in" height="3.767361111111111in"}

![](media/image14.png){width="6.5in" height="2.472916666666667in"}

##   {#section-1 .unnumbered}

## 3.5 Extensions {#extensions .unnumbered}

### User Extension Listings {#user-extension-listings .unnumbered}

### Creating or Copying User Extension {#creating-or-copying-user-extension .unnumbered}

- Add Extension

  - Extension ID

  - Extension Name

  - Campaign Name

  - Enter Press Key

  - Select User than Submit

![](media/image15.jpeg){width="6.5in" height="2.8847222222222224in"}

![](media/image16.jpeg){width="6.739583333333333in"
height="3.1284722222222223in"}

## 3.6 IVR Menu {#ivr-menu .unnumbered}

### Add New Group {#add-new-group .unnumbered}

- Click on \"Add New Group.\"

### Fill Out the Form: {#fill-out-the-form .unnumbered}

- Group ID: Enter a unique identifier for the group.

- Group Name: Provide a descriptive name for the group

- Campaign Name: Assign the relevant campaign to the group.

- Menu Name: Specify the name for the IVR menu.

- Press Key: Enter the key or code that callers will press to access
  this menu.

### Save the Group: {#save-the-group .unnumbered}

- Click \"Submit\" to create the new Menu IVR group.

![](media/image17.jpeg){width="6.8125in" height="3.1381944444444443in"}

##  3.7 Data Upload {#data-upload .unnumbered}

Lead List Management

Upload and Manage Lead Lists

### Navigate to Data Upload: {#navigate-to-data-upload .unnumbered}

- Go to the \"Data Upload\" section in your system.

### Manage Lead Lists: {#manage-lead-lists .unnumbered}

Add New List:

- Click \"Add New List\" to import lead data.

<!-- -->

- Fill Out the Form:

<!-- -->

- List ID: Enter a unique identifier for the list.

- List Name: Provide a name for the list.

- List Description: Add a brief description of the list.

- Campaign: Select the campaign to which the list will be assigned.

- Active: Choose \"Yes\" or \"No\" to activate or deactivate the list.

- Click \"Submit\" to save the list.

![](media/image18.png){width="6.5in" height="2.0215277777777776in"}

### Copy List: {#copy-list .unnumbered}

- Enter the List ID of the existing list to copy from.

- Enter the List ID for the new list to copy to.

- The List ID will be visible in the interface.

![](media/image19.png){width="6.5in" height="1.9069444444444446in"}

###  {#section-2 .unnumbered}

### Show List: {#show-list .unnumbered}

- View details of existing lead lists, including:

<!-- -->

- List ID: Identifier for the list.

- Name: Name of the lead list.

- Description: Brief description of the list.

- Lead Count: Number of leads in the list.

- Campaign: Associated campaign.

- Active: Status (active/inactive).

- Create Time: Creation time of the list.

- Action: Options to view, edit, or download the list.

<!-- -->

- Use the \"Download\" option to save the list data.

![](media/image20.png){width="6.5in" height="2.1284722222222223in"}

## 3.10 Call Reports {#call-reports .unnumbered}

### Accessing Call Reports {#accessing-call-reports .unnumbered}

- Navigate to Call Reports:

<!-- -->

- Go to the \"Call Reports\" section in your system.

### View Total Call Report {#view-total-call-report .unnumbered}

- Report Details:

<!-- -->

- ID: Unique identifier for the call.

- Agent Name: Name of the agent who handled the call.

- Agent ID: Identifier for the agent.

- Call From: Caller's number.

- Call To: Recipient's number.

- Campaign Name: Associated campaign.

- Start Time: Time when the call started.

- Duration: Length of the call.

- Direction: Call direction (incoming/outgoing).

- Status: Call status (completed, missed, etc.).

- Hangup: Reason or time of hangup.

- Recordings: Links to call recordings.

<!-- -->

- Filtering:

<!-- -->

- Use the filter options to narrow down results based on criteria such
  as agent, date range, or status.

<!-- -->

- Export Report:

<!-- -->

- Click the \"Export\" button to download the report in your preferred
  format.

### Search Specific Agent Recordings {#search-specific-agent-recordings .unnumbered}

- Search Parameters:

<!-- -->

- Select Agent: Choose the specific agent from the dropdown menu.

- From Date: Enter the start date for the search range.

- To Date: Enter the end date for the search range.

<!-- -->

- Search Results:

<!-- -->

- Click \"Search\" to view call reports and recordings for the selected
  agent within the specified date range.

![](media/image21.jpeg){width="6.864583333333333in"
height="2.8944444444444444in"}

## 3.11 Lead Reports {#lead-reports .unnumbered}

### Accessing Lead Reports {#accessing-lead-reports .unnumbered}

- Navigate to Lead Reports:

<!-- -->

- Go to the \"Lead Reports\" section in your system.

### View Lead Reports {#view-lead-reports .unnumbered}

- Report Details:

<!-- -->

- ID: Unique identifier for the lead.

- Agent ID: Identifier for the agent who handled the lead.

- Caller Name: Name of the caller.

- Caller Number: Phone number of the caller.

- Email: Email address of the caller.

- Dial Status: Status of the call (e.g., completed, missed).

- Date: Date when the lead was recorded.

### Entries per Page: {#entries-per-page .unnumbered}

- Adjust the number of entries displayed per page if applicable.

### Filter and Search {#filter-and-search .unnumbered}

- Filter Options:

<!-- -->

- Use available filters to narrow down results based on criteria such as
  dial status, date, or specific recordings.

### Search by Agent and Date: {#search-by-agent-and-date .unnumbered}

- Select Agent: Choose the specific agent from the dropdown menu.

- From Date: Enter the start date for the search range.

- To Date: Enter the end date for the search range.

- Click \"Search\" to view filtered lead reports.

![](media/image22.jpeg){width="6.5in" height="2.8847222222222224in"}

## 3.8 Blocking Numbers {#blocking-numbers .unnumbered}

### Add Blocked Number {#add-blocked-number .unnumbered}

- Add New Blocked Number:

<!-- -->

- Enter the phone number you wish to block.

- Click \"Add\" to include the number in the blocked list.

![](media/image23.png){width="6.5in" height="1.8666666666666667in"}

### Manage Blocked Numbers {#manage-blocked-numbers .unnumbered}

- View and Manage Blocked Numbers:

<!-- -->

- In the \"Blocked Number\" interface, you can view a list of all
  blocked numbers.

- Details Displayed:

<!-- -->

- Serial Number: Unique identifier for each entry.

- Blocked Number: The phone number that has been blocked.

- Status: Indicates whether the number is active or inactive.

- Date: Date when the number was blocked.

- Action: Options to delete or manage the blocked number.

![](media/image24.png){width="6.5in" height="1.8694444444444445in"}

## 3.9 Disposition Management {#disposition-management .unnumbered}

### Add or Edit Dispositions {#add-or-edit-dispositions .unnumbered}

- Add New Disposition:

<!-- -->

- Click \"Add New Disposition.\"

- Type the name of the new disposition (e.g., \"No Answer,\" \"Test
  Call,\" \"Wrong Number,\" \"Not Interested\").

- Click \"Submit\" to save the new disposition.

<!-- -->

- Edit Existing Dispositions:

<!-- -->

- Locate the disposition you wish to edit.

- Click the \"Edit\" icon next to the disposition.

- Update the disposition name as needed.

- Click \"Update\" to save the changes.

![](media/image25.jpeg){width="6.5in" height="2.0097222222222224in"}

### View Disposition List {#view-disposition-list .unnumbered}

- Interface Details:

<!-- -->

- Serial Number: Unique identifier for each disposition.

- Disposition Name: Name of the disposition.

- Status: Indicates whether the disposition is active or inactive.

- Date: Date when the disposition was added or last updated.

- Action: Options to edit or delete:

- Edit: Click the \"Edit\" icon to modify the disposition.

- Delete: Click the \"Delete\" icon to remove the disposition from the
  list.

![](media/image26.png){width="6.5in" height="2.3333333333333335in"}

## 3.12 IVR Converter {#ivr-converter .unnumbered}

### Create Speech {#create-speech .unnumbered}

- Write Speech:

<!-- -->

- Enter the text for your IVR audio according to your requirements.

<!-- -->

- Select Language:

<!-- -->

- Choose from available languages:

<!-- -->

- Hindi

- English

- Gujarati

- Marathi

- Tamil

- Kannada

- Telugu

- Oriya

- Punjabi

- Assamese

<!-- -->

- Both female and male voice options are available.

<!-- -->

- Select Type:

<!-- -->

- Choose the type of IVR:

<!-- -->

- After Voice: Instructions or prompts after the initial greeting.

- Welcome: Greeting or introductory message.

<!-- -->

- Select Campaign:

<!-- -->

- Choose the campaign to which the IVR will be assigned.

<!-- -->

- Submit:

<!-- -->

- Click \"Submit\" to generate the IVR audio.

![](media/image27.png){width="6.5in" height="2.308333333333333in"}

### View and Manage IVR List {#view-and-manage-ivr-list .unnumbered}

- IVR List Details:

<!-- -->

- Serial Number: Unique identifier for each IVR entry.

- Type: Type of IVR (e.g., After Voice, Welcome).

- Campaign: Associated campaign.

- File: Link to the generated IVR audio file.

- Date: Date when the IVR was created.

- Action: Options to view, edit, or delete the IVR.

<!-- -->

- Search IVR:

<!-- -->

- Use the search functionality to find specific IVR entries.

![](media/image28.png){width="6.5in" height="1.8944444444444444in"}

# 14. Agent Interface {#agent-interface .unnumbered}

The Agent Interface is a comprehensive platform that enables agents to
efficiently handle calls, manage their availability, and access
reporting features. It provides all the necessary tools for agents to
perform their tasks effectively and streamline their workflow.

## 4.1 Overview {#overview-2 .unnumbered}

### Web RTC Phone Integration: {#web-rtc-phone-integration .unnumbered}

![](media/image29.png){width="2.2379800962379703in"
height="2.223992782152231in"}

- Web-Based Softphone: The agent interface includes a web-based
  softphone with essential features such as:

<!-- -->

- Mute/Unmute: Control the microphone during calls.

- Pause/Resume: Temporarily pause call activities or resume as needed.

- Dial Pad: Access a numeric keypad for making calls.

- Call Transfer: Transfer calls to other agents or departments.

- Call Recording: Record calls for quality assurance or training
  purposes.

- Call Conferencing: Set up conference calls with multiple participants.

### Call Handling {#call-handling .unnumbered}

- Making and Receiving Calls:

<!-- -->

- Outbound Calls: Use the dial pad available on the interface to
  initiate outbound calls. Simply enter the phone number and press the
  call button to start the call.

- Incoming Calls: Manage incoming calls through the interface. Answer,
  reject, or forward calls as needed, and access relevant call controls

### Auto-Dialing: {#auto-dialing .unnumbered}

- Toggle Auto-Dialing: Activate or deactivate the auto-dial feature
  using the toggle switch. When enabled, the system will automatically
  dial leads from a predefined list.

- Manage Auto-Dialed Leads: Review the status of leads dialed through
  the auto-dialer. Agents can view lead details, update lead statuses,
  and take appropriate actions based on the outcome of each call.

*Phone: This Manual guide will walk you through how to configure and use
WebRTC for voice communication, including account setup, phone interface
configuration, and common troubleshooting.*

## Initial Setup: Allowing Microphone Access {#initial-setup-allowing-microphone-access .unnumbered}

Before using a WebRTC-based phone, ensure that you allow microphone
access to the application. If you deny microphone permissions, you will
encounter a \"User Media Error.\"

- []{#_Toc186903968 .anchor}**How to grant permission:  
  **When prompted by your browser to allow access to your microphone,
  click \"Allow.\" If you\'re not prompted, you can manually enable
  microphone access in your browser
  settings.![](media/image30.png){width="3.047707786526684in"
  height="1.242590769903762in"}

> ![](media/image31.png){width="2.3544619422572177in"
> height="3.399381014873141in"}

##  Register Your Account {#register-your-account .unnumbered}

To register your WebRTC phone account, follow these steps:

## Secure WebSocket Server (TLS): {#secure-websocket-server-tls .unnumbered}

- []{#_Toc186903971 .anchor}**Server IP**: Enter the server\'s IP
  address that supports WebRTC connections.

- []{#_Toc186903972 .anchor}**WebSocket Port**: Typically, this is
  **8089** or another port number designated by your provider.

- []{#_Toc186903973 .anchor}**WebSocket Path**: The WebSocket path is
  generally /WS.

## Account Credentials: {#account-credentials .unnumbered}

- []{#_Toc186903975 .anchor}**Full Name**: Enter your full name for the
  account (optional).

- []{#_Toc186903976 .anchor}**Domain/IP:** Provide the IP address or
  domain name of your SIP server.

- []{#_Toc186903977 .anchor}**SIP Username**: Enter the SIP username
  assigned to you, e.g., 5201.

- []{#_Toc186903978 .anchor}**SIP Password**: Enter the SIP password
  provided by your provider.

- []{#_Toc186903979 .anchor}**Voicemail Subscription (MWI):** You can
  skip this step unless you wish to subscribe to voicemail features.

- []{#_Toc186903980 .anchor}**Chat Engine**: Choose SIP (default), or if
  required, you can select XMPP.

- []{#_Toc186903981 .anchor}**Audio Settings:** Typically, you can leave
  this on the default setting unless specified otherwise.

- []{#_Toc186903982 .anchor}**Appearance Settings**: Adjust according to
  your preferences.

- []{#_Toc186903983 .anchor}**Notification Settings:** Enable
  notifications to receive alerts for incoming calls, messages, etc.

> []{#_Toc186903984 .anchor}**Save and Register:** After entering the
> necessary information, click \"Save\" to complete the setup.

![](media/image32.png){width="2.227247375328084in"
height="3.3347167541557305in"}
![](media/image33.png){width="2.25755905511811in"
height="3.136174540682415in"}

![](media/image34.png){width="1.4444247594050743in"
height="2.075145450568679in"}
![](media/image35.png){width="1.635424321959755in"
height="2.2647747156605424in"}![](media/image36.png){width="1.7051093613298338in"
height="2.381666666666667in"}

## Using the Phone Interface {#using-the-phone-interface .unnumbered}

Once registered, you will have access to the WebRTC phone interface.
Below are the key sections of the interface:

### Dial Pad {#dial-pad .unnumbered}

- Access the numeric keypad to make calls. Simply dial the desired
  number and hit the call button.

> ![](media/image37.png){width="2.3570363079615047in"
> height="3.77584208223972in"}

## Add a Contact {#add-a-contact .unnumbered}

To add a new contact, follow these steps:

- []{#_Toc186903988 .anchor}**Full Name**: Enter the full name of the
  contact.

- []{#_Toc186903989 .anchor}**Allow DND (Do Not Disturb):** Set this
  according to your preference if you want to block incoming calls or
  messages.

- []{#_Toc186903990 .anchor}**Basic Extension / Address Book Contact**:
  You can enter a basic extension number or choose from your address
  book if the contact is already saved.

- []{#_Toc186903991 .anchor}**Title/Description:** Add a title or
  description for the contact (e.g., \"Work\" or \"Manager\").

- []{#_Toc186903992 .anchor}**Extension Number**: Enter the contact\'s
  extension number.

- []{#_Toc186903993 .anchor}**Subscribe to Device State Notifications:**
  Enable this option if you want to receive notifications when the
  contact\'s device is available or unavailable.

- []{#_Toc186903994 .anchor}**Mobile Number & Email:** Add mobile
  numbers and email addresses for the contact.

- []{#_Toc186903995 .anchor}**Contact Numbers:** Optionally, you can add
  additional contact numbers (e.g., Contact Number1, Contact Number2).

- []{#_Toc186903996 .anchor}**Auto Delete:** Decide whether to
  automatically delete this contact after a certain time or event.

**Save the contact** by clicking the \"Add\" button.

![](media/image38.png){width="2.6916940069991253in"
height="3.7880500874890637in"}
![](media/image39.png){width="2.5682250656167978in"
height="3.66790135608049in"}

## Managing Your Account {#managing-your-account .unnumbered}

### Refresh Registration {#refresh-registration .unnumbered}

- To refresh your registration or start a new session, go to **Account
  Reference** and initiate a **New Session**.

![](media/image40.png){width="2.4109765966754155in"
height="1.7523665791776029in"}

### Configure Extension {#configure-extension .unnumbered}

### Auto Answer {#auto-answer .unnumbered}

Enable this feature to automatically answer incoming calls. Set this to
automatically answer incoming calls. If enabled, your phone will pick up
the call as soon as it rings.

[]{#_Toc186904001 .anchor}**Call Waiting**

Enable or disable the call waiting feature, which allows you to answer a
second call while already on a call.

## Troubleshooting {#troubleshooting .unnumbered}

If you encounter any issues such as failure to register, audio problems,
or connection drops, check the following:

- *\"***User Media Error***\"*: This usually happens when microphone
  access is denied. Make sure to allow your browser to access the
  microphone.

- []{#_Toc186904003 .anchor}**Server Connection**: Verify the WebSocket
  server IP and port settings.

- []{#_Toc186904004 .anchor}**Account Credentials**: Double-check your
  SIP username and password.

- []{#_Toc186904005 .anchor}**Audio Problems**: If you can\'t hear the
  other party or they can\'t hear you, verify that the correct
  microphone and speaker are selected in your browser\'s settings.

- []{#_Toc186904006 .anchor}**Network Connectivity**: Ensure that your
  device has a stable internet connection and that your firewall or
  network settings are not blocking WebRTC traffic.

- []{#_Toc186904007 .anchor}**No Incoming Calls**: Ensure your account
  is properly registered and that notifications are enabled. Check the
  configuration for any Do Not Disturb (DND) settings that might be
  blocking incoming calls.

> Regularly check for updates and review settings to ensure smooth
> operation.

###  {#section-3 .unnumbered}

### Post-Call Agent Disposition: {#post-call-agent-disposition .unnumbered}

Disposition Form: After completing a call, agents are required to fill
out a post-call disposition form. This form includes fields for:

- Company Name: Enter the name of the company associated with the call.

- Location: Provide the location details relevant to the call.

- Contact Information: Record any new or updated contact information
  obtained during the call.

- Additional Notes: Add any extra notes or observations that may be
  useful for future references.

![WhatsApp Image 2024-07-03 at
11.10.20_16a6933d](media/image41.jpeg){width="6.5in" height="5.3in"}

By utilizing these features, agents can enhance their productivity,
manage calls more effectively, and maintain accurate records of their
interactions.

### Availability Management {#availability-management .unnumbered}

### Status Management: {#status-management .unnumbered}

### Setting Status: Agents can set their status to indicate their current availability. The available statuses include: {#setting-status-agents-can-set-their-status-to-indicate-their-current-availability.-the-available-statuses-include}

### Ready: Indicates that the agent is available to handle calls. {#ready-indicates-that-the-agent-is-available-to-handle-calls.}

### Lunch Break: Indicates that the agent is on a scheduled lunch break. {#lunch-break-indicates-that-the-agent-is-on-a-scheduled-lunch-break.}

### Bio Break: Indicates that the agent is taking a short break. {#bio-break-indicates-that-the-agent-is-taking-a-short-break.}

### Other Predefined Statuses: Additional statuses may be available depending on your organization's requirements. {#other-predefined-statuses-additional-statuses-may-be-available-depending-on-your-organizations-requirements.}

### Managing Availability: Adjust your status as needed to reflect your current availability accurately. This helps in ensuring efficient call routing and handling. For example, setting the status to "Lunch Break" will prevent new calls from being routed to you during this time. {#managing-availability-adjust-your-status-as-needed-to-reflect-your-current-availability-accurately.-this-helps-in-ensuring-efficient-call-routing-and-handling.-for-example-setting-the-status-to-lunch-break-will-prevent-new-calls-from-being-routed-to-you-during-this-time.}

### By effectively managing your status, you contribute to a smoother workflow and better overall call management. ![](media/image42.png){width="6.5in" height="3.973611111111111in"} {#by-effectively-managing-your-status-you-contribute-to-a-smoother-workflow-and-better-overall-call-management. .unnumbered}

##  4.2 Profile {#profile-1 .unnumbered}

Profile management

### Viewing and Editing Profile Details: {#viewing-and-editing-profile-details .unnumbered}

> Agents can view and edit their profile details to ensure accurate and
> up-to-date information. The profile management section includes the
> following fields:

- **User Name:** Your username.

- **Full Name:** Your full name (editable).

- **Outbound CLI:** Caller ID number (editable).

- **Status:** Current availability status.

### Actions: {#actions .unnumbered}

- Click Edit Profile to update your User ID, Outbound CLI, and Full
  Name.

![](media/image43.png){width="6.5in" height="1.1201388888888888in"}

## 4.3 Data Upload {#data-upload-1 .unnumbered}

### Upload Lead Lists: {#upload-lead-lists .unnumbered}

### Use the \"Data Upload\" section to upload lead lists in Excel format. {#use-the-data-upload-section-to-upload-lead-lists-in-excel-format.}

### Total Upload Data Includes:

### ID: Unique identifier for each lead. {#id-unique-identifier-for-each-lead.}

### Name: Lead's name. {#name-leads-name.}

### Number: Lead's phone number. {#number-leads-phone-number.}

### Status: Current status of the lead. {#status-current-status-of-the-lead.}

![](media/image44.png){width="6.5in" height="1.0291666666666666in"}

##  4.4 Call Reporting {#call-reporting .unnumbered}

- Access and Analyze: View and analyze call reports using various
  filters.

- Report Details: Each report entry includes:

  - ID

  - Agent

  - Call From

  - Call To

  - Start Time

  - Duration

  - Direction

  - Status

  - Hangup

  - Recordings

- Search and Display:

  - Entries per Page: Set the number of entries shown per page.

  - Search: Use the search functionality to find specific reports.

![](media/image45.png){width="6.5in" height="0.9041666666666667in"}

## 4.5 Lead Report {#lead-report .unnumbered}

- Access: Agents can view lead reports in their panel.

- Report Details: Each report entry includes:

  - ID

  - Caller Name

  - Caller Number

  - Email

  - Dial Status

  - Date

- Search and Display:

  - Entries per Page: Adjust the number of entries displayed per page.

  - Search: Use the search feature to find specific leads.

![](media/image46.png){width="6.5in" height="1.2493055555555554in"}

## 4.6 Agent Status {#agent-status .unnumbered}

- View Other Agents\' Status: Agents can see the status of other agents,
  including:

  - Sr.: Serial number.

  - Agents: Name or ID of the agents.

  - Status: Current availability status (e.g., Ready, Pause).

  - Last Call: Time or details of the most recent call.

  - Ready/Pause: Time spent in Ready or Pause status.

  - Login: Time logged in.

  - Talk: Time spent talking on calls.

  - Answer: Number of calls answered.

  - Cancel: Number of calls canceled.

  - Other: Any other relevant metrics.

  - Total: Aggregate of relevant metrics.

![](media/image47.png){width="6.5in" height="2.152083333333333in"}

## 4.7 Block Numbers: {#block-numbers .unnumbered}

- Access: Go to the \"Block Numbers\" section.

- Add Numbers: Enter the number and click \"Add\" to block it.

- Manage: View and manage blocked numbers and their status.

![](media/image48.png){width="6.5in" height="1.425in"}

![](media/image49.png){width="6.5in" height="1.9243055555555555in"}

# 15. Troubleshooting {#troubleshooting-1 .unnumbered}

##  5.1 Common Issues {#common-issues .unnumbered}

### Connection Problems: {#connection-problems .unnumbered}

- Verify VPN connection and port settings.

- Check network and firewall configurations.

### Access Issues: {#access-issues .unnumbered}

- Confirm URLs and login credentials.

- Ensure user roles and permissions are correct.

##  5.2 Contacting Support {#contacting-support .unnumbered}

- Phone: 9650866007

- Email: <support@next2call.com>

- Provide detailed information about the issue for faster resolution.
