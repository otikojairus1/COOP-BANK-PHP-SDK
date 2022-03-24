<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SDKController extends Controller
{
    public function CoopToMpesaPay(){

        $CK = "hgcy___p9DJrlRIe0DjzGrl7kO4a";
        $SK = "xvgPTBADFM4oCQJIwQ85bsftBXsa";

        // generating access token

        $authorization = base64_encode("$CK:$SK");

$header = array("Authorization: Basic {$authorization}");

$content = "grant_type=client_credentials";

    //echo $authorization;

$curl = curl_init();

curl_setopt_array($curl, array(

CURLOPT_URL => "https://developer.co-opbank.co.ke:8243/token",

CURLOPT_HTTPHEADER => $header,

CURLOPT_SSL_VERIFYPEER => false,

CURLOPT_RETURNTRANSFER => true,

CURLOPT_POST => true,

CURLOPT_POSTFIELDS => $content

));

$response = curl_exec($curl);

//curl_close($curl);


if ($response === false) {

echo "Failed";

echo curl_error($curl);

//curl_close($curl);

echo "Failed";

exit(0);

}

$token= json_decode($response)->access_token;

// simulating cash transfer

$url = "https://openapi-sandbox.co-opbank.co.ke/FundsTransfer/External/A2M/Mpesa/1.0.0/";

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
   "accept: application/json",
   "Content-Type: application/json",
   "Authorization: Bearer ".$token,
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
$phone="254722753364";
$data = '{
    "CallBackUrl":"https://6f32-154-123-73-201.ngrok.io/api/ft-callback",
    "Destinations":[
        {"MobileNumber":'.$phone.',
            "Narration":"Stationary Payment",
            "ReferenceNumber":"4sfssdjf7ji6508dfsf9a1_1",
            "Amount":"777"
        }],
        "MessageReference":"40ca1sdsdddwees65086089a1",
        "Source":{
            "Narration":"Supplier Payment",
            "Amount":"777",
            "TransactionCurrency":"KES",
            "AccountNumber":"36001873000"}
        }';

curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
$data = json_decode($resp);
curl_close($curl);


        return response()->json(['response'=>$data]);
    }



    public function IFTAccountToAccount(){

        $CK = "hgcy___p9DJrlRIe0DjzGrl7kO4a";
        $SK = "xvgPTBADFM4oCQJIwQ85bsftBXsa";

        // generating access token

        $authorization = base64_encode("$CK:$SK");

$header = array("Authorization: Basic {$authorization}");

$content = "grant_type=client_credentials";

    //echo $authorization;

$curl = curl_init();

curl_setopt_array($curl, array(

CURLOPT_URL => "https://developer.co-opbank.co.ke:8243/token",

CURLOPT_HTTPHEADER => $header,

CURLOPT_SSL_VERIFYPEER => false,

CURLOPT_RETURNTRANSFER => true,

CURLOPT_POST => true,

CURLOPT_POSTFIELDS => $content

));

$response = curl_exec($curl);

//curl_close($curl);


if ($response === false) {

echo "Failed";

echo curl_error($curl);

//curl_close($curl);

echo "Failed";

exit(0);

}

$token= json_decode($response)->access_token;


        //simulating the payment
        $url = "https://openapi-sandbox.co-opbank.co.ke/FundsTransfer/Internal/A2A/2.0.0/";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        $headers = array(
           "accept: application/json",
           "Content-Type: application/json",
           "Authorization: Bearer ".$token,
        );
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        
        $data = '{"MessageReference":"40ca18c67689uhith086zj9a1","CallBackUrl":"https://a1b8-102-167-246-73.ngrok.io/callback","Source":{"AccountNumber":"36001873000","Amount":777,"TransactionCurrency":"KES","Narration":"Supplier Payment"},"Destinations":[{"ReferenceNumber":"40caueu98iuigu65086089a1_1","AccountNumber":"54321987654321","Amount":"777","TransactionCurrency":"KES","Narration":"Electricity Payment"}]}';
        
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        
        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        
        $resp = curl_exec($curl);
        curl_close($curl);
       // var_dump($resp);
        $data = json_decode($resp);

        return response()->json(['response'=>$data]);
          
           

    }

    public function callback(Request $request){
        $saved = $request;
        return response()->json(['response'=>$request]);
    }

    public function COOPFullAccountStatement(){
        
$url = "https://openapi-sandbox.co-opbank.co.ke/Enquiry/FullStatement/Account/1.0.0/";

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
   "accept: application/json",
   "Content-Type: application/json",
   "Authorization: Bearer eyJ4NXQiOiJNell5TlRrMVpEZ3laVFEyTmpBMlpUSXlNR1V5Wm1Rek5qZzFNVEV4TlRjeE16RTRPVGsyT0ROa1pERm1PVGRsWVRsa1ltUTNOVFpsTWpZMlltVTBPUSIsImtpZCI6Ik16WXlOVGsxWkRneVpUUTJOakEyWlRJeU1HVXlabVF6TmpnMU1URXhOVGN4TXpFNE9UazJPRE5rWkRGbU9UZGxZVGxrWW1RM05UWmxNalkyWW1VME9RX1JTMjU2IiwiYWxnIjoiUlMyNTYifQ.eyJzdWIiOiJvdGlrb2phaXJ1c0BjYXJib24uc3VwZXIiLCJhdWQiOiJoZ2N5X19fcDlESnJsUkllMERqekdybDdrTzRhIiwibmJmIjoxNjQ3OTY0MjA0LCJhenAiOiJoZ2N5X19fcDlESnJsUkllMERqekdybDdrTzRhIiwic2NvcGUiOiJhbV9hcHBsaWNhdGlvbl9zY29wZSBkZWZhdWx0IiwiaXNzIjoiaHR0cHM6XC9cL2RldmVsb3Blci5jby1vcGJhbmsuY28ua2U6OTQ0M1wvb2F1dGgyXC90b2tlbiIsImV4cCI6MTY0Nzk2NzgwNCwiaWF0IjoxNjQ3OTY0MjA0LCJqdGkiOiJhZmIxMWEzZS1iYmFmLTQ1NTgtYWEzMi00Njk4NTUxNTM0M2UifQ.FnVGT_8RhHEQo1WthTRkAD9SsWnoVAG1KM7-DiW1eza0S-8nTd2c5BlxYaT-FB4clv-zZ14kxGwdjIu3rn5Lt0a8dOtFgOMChy6u3QtVe0wnB8Mu5LCqF3kLgYa62iaR8gX0Q1ygMNdDAwxT41ERmlKCWboub2aiDTauyKuKVndIsE2K5DoikSa3B5IKz5AmQFA35B86jaq-KWP5YBIHy6NG0FVzucBYYGIb4oC0TPYKi2Mn4z5Jr-Q-ojs67_8ALLGxigHYeZhq2eb1ABZVoYg3Lv4SZV4jOZ4870ViEe5JPAtY69dEDe2MGwVltHz31wEp0TpsWsy5RtWdibsEtA",
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

$data = '{"MessageReference":"40ca18c6765086089a1","AccountNumber":"36001873000","StartDate":"2021-10-01","EndDate":"2022-01-01"}';

curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
curl_close($curl);
var_dump($resp);

    }

    public function pesaLinkSendToAccount(){
        

$url = "https://openapi-sandbox.co-opbank.co.ke/FundsTransfer/External/A2A/PesaLink/1.0.0/";

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
   "accept: application/json",
   "Content-Type: application/json",
   "Authorization: Bearer eyJ4NXQiOiJNell5TlRrMVpEZ3laVFEyTmpBMlpUSXlNR1V5Wm1Rek5qZzFNVEV4TlRjeE16RTRPVGsyT0ROa1pERm1PVGRsWVRsa1ltUTNOVFpsTWpZMlltVTBPUSIsImtpZCI6Ik16WXlOVGsxWkRneVpUUTJOakEyWlRJeU1HVXlabVF6TmpnMU1URXhOVGN4TXpFNE9UazJPRE5rWkRGbU9UZGxZVGxrWW1RM05UWmxNalkyWW1VME9RX1JTMjU2IiwiYWxnIjoiUlMyNTYifQ.eyJzdWIiOiJvdGlrb2phaXJ1c0BjYXJib24uc3VwZXIiLCJhdWQiOiJoZ2N5X19fcDlESnJsUkllMERqekdybDdrTzRhIiwibmJmIjoxNjQ4MTQwODYzLCJhenAiOiJoZ2N5X19fcDlESnJsUkllMERqekdybDdrTzRhIiwic2NvcGUiOiJhbV9hcHBsaWNhdGlvbl9zY29wZSBkZWZhdWx0IiwiaXNzIjoiaHR0cHM6XC9cL2RldmVsb3Blci5jby1vcGJhbmsuY28ua2U6OTQ0M1wvb2F1dGgyXC90b2tlbiIsImV4cCI6MTY0ODE0NDQ2MywiaWF0IjoxNjQ4MTQwODYzLCJqdGkiOiI0OGMxMjBlNS01YjY5LTQ2NjQtODY1MC01MmMyMjY1ZWM3NWMifQ.Cn6jgcWmITGjoWvWL3T-sENqlETtvYr9NPfVvy5gbq1rR01Rj0SLLnZ4ko-lTRszIODqK4V42a0u8p4Q_z0J_dA4baSC38uCv_mlSglOlet93nnVJstfu3uf0XP-cJfysgUAp1eKpZq2bFdukmhp57reg7zL06ZSUjiZJYzHKwJ5mqsvPjVgH0vShRM0B9nvPWF6krDI6eK0Gn9mmbaPl360ZMKV2JugAc660d03g146-HQsG0mpKlPacph4bQGNvZRQZ6Vtvs0FaPxDLaR8ZNt3d0LyeU6NPnCWlK7YVChvDf_uNMvt0_fDsBadP58WFfMGz4sJvqu5eBLJkGLB1A",
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

$data = '{"MessageReference":"40ca18c676sjjs5086089a1","CallBackUrl":"https://yourdomain.com/ft-callback","Source":{"AccountNumber":"36001873000","Amount":777,"TransactionCurrency":"KES","Narration":"Supplier Payment"},"Destinations":[{"ReferenceNumber":"40ca18cksk6765086089a1_1","AccountNumber":"54321987654321","BankCode":"11","Amount":"777","TransactionCurrency":"KES","Narration":"Electricity Payment"}]}';

curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
curl_close($curl);
var_dump($resp);




    }

    public function pesaLinkToPhone(){
    

$url = "https://openapi-sandbox.co-opbank.co.ke/FundsTransfer/External/A2M/PesaLink/1.0.0/";

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
   "accept: application/json",
   "Content-Type: application/json",
   "Authorization: Bearer eyJ4NXQiOiJNell5TlRrMVpEZ3laVFEyTmpBMlpUSXlNR1V5Wm1Rek5qZzFNVEV4TlRjeE16RTRPVGsyT0ROa1pERm1PVGRsWVRsa1ltUTNOVFpsTWpZMlltVTBPUSIsImtpZCI6Ik16WXlOVGsxWkRneVpUUTJOakEyWlRJeU1HVXlabVF6TmpnMU1URXhOVGN4TXpFNE9UazJPRE5rWkRGbU9UZGxZVGxrWW1RM05UWmxNalkyWW1VME9RX1JTMjU2IiwiYWxnIjoiUlMyNTYifQ.eyJzdWIiOiJvdGlrb2phaXJ1c0BjYXJib24uc3VwZXIiLCJhdWQiOiJoZ2N5X19fcDlESnJsUkllMERqekdybDdrTzRhIiwibmJmIjoxNjQ4MTQxMzcyLCJhenAiOiJoZ2N5X19fcDlESnJsUkllMERqekdybDdrTzRhIiwic2NvcGUiOiJhbV9hcHBsaWNhdGlvbl9zY29wZSBkZWZhdWx0IiwiaXNzIjoiaHR0cHM6XC9cL2RldmVsb3Blci5jby1vcGJhbmsuY28ua2U6OTQ0M1wvb2F1dGgyXC90b2tlbiIsImV4cCI6MTY0ODE0NDk3MiwiaWF0IjoxNjQ4MTQxMzcyLCJqdGkiOiI3Mzk4ZmUxZi0yNDM2LTRjNWYtOGQ0Ny0wZmExZTg4OGI2NWIifQ.bzNZvEzwRBcUF0zGR9yIxOpPDP4VL9tamJF7cXOCRvmEQkny4qEh98im1BEXbDZIxFhK85oVL_9F4hP6uVmPDxRUt_OO0FPpQMHb-mFCCUepNJK7eZDqjXnzOyr45kR3EewKQjqDHKGhsq2IBdAjqxcOwp3C0IYrMvqfRMMFSqSN-LPgF6C_-uqMrHzQE9sw9MPUcRqMSW0LOaPbjOAVpKY5HQKOKH9OFiU5HZnLcmP9E-uktvX6BiP5ECJLg3nl9wY_cNn_UYIuBwE7ikxmwFqF2Qbtib41szSQvgSnvp9o5MgfDsRGhD1u8z9FxBhOvZaX3jfp8kyVPJklUn_wPg",
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

$data = '{"MessageReference":"40ca18c67x65086089a1","CallBackUrl":"https://yourdomain.com/ft-callback","Source":{"AccountNumber":"36001873000","Amount":777,"TransactionCurrency":"KES","Narration":"Supplier Payment"},"Destinations":[{"ReferenceNumber":"40ca18c67ss65086089a1_1","PhoneNumber":"0722753364","Amount":"777","TransactionCurrency":"KES","Narration":"Electricity Payment"}]}';

curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
curl_close($curl);
var_dump($resp);



    }

    public function accountBalance(){
        

$url = "https://openapi-sandbox.co-opbank.co.ke/Enquiry/AccountBalance/1.0.0/";

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
   "accept: application/json",
   "Content-Type: application/json",
   "Authorization: Bearer eyJ4NXQiOiJNell5TlRrMVpEZ3laVFEyTmpBMlpUSXlNR1V5Wm1Rek5qZzFNVEV4TlRjeE16RTRPVGsyT0ROa1pERm1PVGRsWVRsa1ltUTNOVFpsTWpZMlltVTBPUSIsImtpZCI6Ik16WXlOVGsxWkRneVpUUTJOakEyWlRJeU1HVXlabVF6TmpnMU1URXhOVGN4TXpFNE9UazJPRE5rWkRGbU9UZGxZVGxrWW1RM05UWmxNalkyWW1VME9RX1JTMjU2IiwiYWxnIjoiUlMyNTYifQ.eyJzdWIiOiJvdGlrb2phaXJ1c0BjYXJib24uc3VwZXIiLCJhdWQiOiJoZ2N5X19fcDlESnJsUkllMERqekdybDdrTzRhIiwibmJmIjoxNjQ4MTQxNjI4LCJhenAiOiJoZ2N5X19fcDlESnJsUkllMERqekdybDdrTzRhIiwic2NvcGUiOiJhbV9hcHBsaWNhdGlvbl9zY29wZSBkZWZhdWx0IiwiaXNzIjoiaHR0cHM6XC9cL2RldmVsb3Blci5jby1vcGJhbmsuY28ua2U6OTQ0M1wvb2F1dGgyXC90b2tlbiIsImV4cCI6MTY0ODE0NTIyOCwiaWF0IjoxNjQ4MTQxNjI4LCJqdGkiOiI1YjU2NjMzNi0yYmUwLTQ2NTEtODhiYS00YTEwOGJhZmZhNjgifQ.dDpxIsKEfYKPqpKYpgKESVeCLxVxsTkrNC9pC29Fl9Qk5uw5xCb1sI31kurWLsoGqwLzAXhdD2SmOU3fXFFHpV5wZRMI1c4aMtFTMWZ_TlCZyEVUUAHjl5ooYG6-Y0J6hxLCKEpAzgJhe4-WYAiPchmLOwqRHN3mKkhHb_cD0Ehx4wsDBkxaxeEMSF3evkfeB-UOU8JEra4la0S79rgKg7Z-74Yq1qJXDdcTUc69FSTsjwyC8Zgq1R-PBKOHYwAB2Jz0iHnMe_UopRqTZwXjJssXnJ3IyS9AKXUQ7QS7RT7ijSxLYRxTUmFSQcWbyjSTWRw3Y4n3OrduEiRCtiI2Cw",
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

$data = '{"MessageReference":"40ca18c6765086089a1","AccountNumber":"36001873000"}';

curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
curl_close($curl);
var_dump($resp);



    }
}
