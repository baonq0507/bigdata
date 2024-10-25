<?php

use App\Models\CarrierToken;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging;
use Illuminate\Support\Facades\Http;
function sendFirebaseNotification($deviceToken, $title, $body, $data = []) {
    try {
        // Lấy đường dẫn tới file firebase-credentials.json từ biến môi trường
        $firebaseCredentialsPath = getenv('FIREBASE_CREDENTIALS');
        // Tạo Factory với ServiceAccount từ file firebase-credentials.json
        $factory = (new Factory)->withServiceAccount(__DIR__.'/../'.$firebaseCredentialsPath);
        $messaging = $factory->createMessaging();

        $message = Messaging\CloudMessage::fromArray([
            'token' => $deviceToken,
            'notification' => [
                'title' => $title,
                'body' => $body
            ],
            'data' => $data
        ]);

        $messaging->send($message);
        return "Notification sent successfully";
    } catch (\Kreait\Firebase\Exception\MessagingException $e) {
        return "MessagingException: " . $e->getMessage();
    } catch (\Kreait\Firebase\Exception\FirebaseException $e) {
        return "FirebaseException: " . $e->getMessage();
    }
}

class TwoFactorAPI {
    private $ROOT_URL = "https://api.speedsms.vn/index.php";
    private $accessToken = "Your API Access Token";
    function __construct($api_key) {
        $this->accessToken = $api_key;
    }

    public function pinCreate($phoneNumber, $content, $appId) {

        $json = json_encode(array('to' => $phoneNumber, 'content' => $content, 'app_id' => $appId));

        $headers = array('Content-type: application/json');

        $url = $this->ROOT_URL.'/pin/create';
        $http = curl_init($url);
        curl_setopt($http, CURLOPT_HEADER, false);
        curl_setopt($http, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($http, CURLOPT_POSTFIELDS, $json);
        curl_setopt($http, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($http, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($http, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($http, CURLOPT_VERBOSE, 0);
        curl_setopt($http, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($http, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($http, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($http, CURLOPT_USERPWD, $this->accessToken.':x');
        $result = curl_exec($http);
        if(curl_errno($http))
        {
            return null;
        }
        else
        {
            curl_close($http);
            return json_decode($result, true);
        }
    }

    public function pinVerify($phoneNumber, $pinCode, $appId) {
        $json = json_encode(array('phone' => $phoneNumber, 'pin_code' => $pinCode, 'app_id' => $appId));

        $headers = array('Content-type: application/json');

        $url = $this->ROOT_URL.'/pin/verify';
        $http = curl_init($url);
        curl_setopt($http, CURLOPT_HEADER, false);
        curl_setopt($http, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($http, CURLOPT_POSTFIELDS, $json);
        curl_setopt($http, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($http, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($http, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($http, CURLOPT_VERBOSE, 0);
        curl_setopt($http, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($http, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($http, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($http, CURLOPT_USERPWD, $this->accessToken.':x');
        $result = curl_exec($http);
        if(curl_errno($http))
        {
            return null;
        }
        else
        {
            curl_close($http);
            return json_decode($result, true);
        }
    }
}
class SpeedSMSAPI {
    const SMS_TYPE_QC = 1; // loai tin nhan quang cao
    const SMS_TYPE_CSKH = 2; // loai tin nhan cham soc khach hang
    const SMS_TYPE_BRANDNAME = 3; // loai tin nhan brand name cskh
    const SMS_TYPE_NOTIFY = 4; // sms gui bang brandname Notify
    const SMS_TYPE_GATEWAY = 5; // sms gui bang so di dong ca nhan tu app android, download app tai day: https://speedsms.vn/sms-gateway-service/

    private $ROOT_URL = "https://api.speedsms.vn/index.php";
    private $accessToken = "Your API access token";

    function __construct($api_key) {
        $this->accessToken = $api_key;
    }

    public function getUserInfo() {
        $url = $this->ROOT_URL.'/user/info';
        $headers = array('Accept: application/json');

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_USERPWD, $this->accessToken.':x');

        $results = curl_exec($ch);

        if(curl_errno($ch)) {
            return null;
        }
        else {
            curl_close($ch);
        }
        return json_decode($results, true);
    }

    public function sendSMS($to, $smsContent, $smsType, $sender) {
        if (!is_array($to) || empty($to) || empty($smsContent))
            return null;

        $type = SpeedSMSAPI::SMS_TYPE_CSKH;
        if (!empty($smsType))
            $type = $smsType;

        if ($type < 1 || $type > 8)
            return null;

        if (($type == 3 || $type == 5 || $type == 7 || $type == 8) && empty($sender))
            return null;

        $json = json_encode(array('to' => $to, 'content' => $smsContent, 'sms_type' => $type, 'sender' => $sender));

        $headers = array('Content-type: application/json');

        $url = $this->ROOT_URL.'/sms/send';
        $http = curl_init($url);
        curl_setopt($http, CURLOPT_HEADER, false);
        curl_setopt($http, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($http, CURLOPT_POSTFIELDS, $json);
        curl_setopt($http, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($http, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($http, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($http, CURLOPT_VERBOSE, 0);
        curl_setopt($http, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($http, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($http, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($http, CURLOPT_USERPWD, $this->accessToken.':x');
        $result = curl_exec($http);
        if(curl_errno($http))
        {
            return null;
        }
        else
        {
            curl_close($http);
            return json_decode($result, true);
        }
    }

    public function sendMMS($to, $smsContent, $link, $sender) {
        if (!is_array($to) || empty($to) || empty($smsContent))
            return null;

        $type = SpeedSMSAPI::SMS_TYPE_CSKH;
        if (!empty($smsType))
            $type = $smsType;

        if ($type < 1 || $type > 8)
            return null;

        if (($type == 3 || $type == 5) && empty($sender))
            return null;

        $json = json_encode(array('to' => $to, 'content' => $smsContent, 'link' => $link, 'sender' => $sender));

        $headers = array('Content-type: application/json');

        $url = $this->ROOT_URL.'/mms/send';
        $http = curl_init($url);
        curl_setopt($http, CURLOPT_HEADER, false);
        curl_setopt($http, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($http, CURLOPT_POSTFIELDS, $json);
        curl_setopt($http, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($http, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($http, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($http, CURLOPT_VERBOSE, 0);
        curl_setopt($http, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($http, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($http, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($http, CURLOPT_USERPWD, $this->accessToken.':x');
        $result = curl_exec($http);
        if(curl_errno($http))
        {
            return null;
        }
        else
        {
            curl_close($http);
            return json_decode($result, true);
        }
    }

    public function sendVoice($to, $smsContent) {
        if (empty($to) || empty($smsContent))
            return null;

        $json = json_encode(array('to' => $to, 'content' => $smsContent));

        $headers = array('Content-type: application/json');

        $url = $this->ROOT_URL.'/voice/otp';
        $http = curl_init($url);
        curl_setopt($http, CURLOPT_HEADER, false);
        curl_setopt($http, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($http, CURLOPT_POSTFIELDS, $json);
        curl_setopt($http, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($http, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($http, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($http, CURLOPT_VERBOSE, 0);
        curl_setopt($http, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($http, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($http, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($http, CURLOPT_USERPWD, $this->accessToken.':x');
        $result = curl_exec($http);
        if(curl_errno($http))
        {
            return null;
        }
        else
        {
            curl_close($http);
            return json_decode($result, true);
        }
    }
}

class ViettelPostAPI
{
    private const ROOT_URL = "https://partner.viettelpost.vn";
    private $USERNAME;
    private $PASSWORD;

    public function __construct()
    {
        $this->USERNAME = env('VIETTEL_POST_USERNAME', '0969113654');
        $this->PASSWORD = env('VIETTEL_POST_PASSWORD', 'Cntt@123');
    }

    public function login()
    {
        $url = self::ROOT_URL . '/v2/user/login';
        $response = Http::withHeaders([
            'Content-Type' => 'application/json'
        ])->post($url, [
            'USERNAME' => $this->USERNAME,
            'PASSWORD' => $this->PASSWORD
        ]);

    return $response->json()['data']['token'];
    }

    public function loginFull()
    {
        $url = self::ROOT_URL . '/v2/user/ownerconnect';
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Token' => $this->login()
        ])->post($url, [
            'USERNAME' => $this->USERNAME,
            'PASSWORD' => $this->PASSWORD
        ]);

        if ($response->successful()) {
            $responseData = $response->json();
            if($responseData['status']==200){
                CarrierToken::updateOrCreate(
                    ['carrier_name' => 'viettelpost'],
                    ['token' => $responseData['data']['token'], 'expires_at' => now()]
                );
                return $response->body();
            }
            else{
                return null;
            }
        } else {
            return null; // Consider throwing an exception or logging this error
        }
    }

    public function getService($data)
    {
        $url = self::ROOT_URL . '/v2/order/getPriceAll';
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Token' => CarrierToken::where('carrier_name', 'viettelpost')->first()->token
        ])->post($url, $data);
        return $response->json();
    }

    public function getPrice($data)
    {
        $url = self::ROOT_URL . '/v2/order/getPrice';
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Token' => CarrierToken::where('carrier_name', 'viettelpost')->first()->token
        ])->post($url, $data);
        return $response->json();
    }

    public function createOrder($data)
    {
        $url = self::ROOT_URL . '/v2/order/createOrderNlp';
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Token' => CarrierToken::where('carrier_name', 'viettelpost')->first()->token
        ])->post($url, $data);
        return $response->json();
    }

    public function updateOrder($data)
    {
        $url = self::ROOT_URL . '/v2/order/updateOrder';
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Token' => CarrierToken::where('carrier_name', 'viettelpost')->first()->token
        ])->post($url, $data);
        return $response->json();
    }
}
