<?php


class Gateway
{

    Const TokenURL = 'v1/Token';
    Const TimeURL = 'v1/Time';
    Const TranResultURL = 'v1/TranResult';
    Const CardHashURL = 'v1/CardHash';
    Const SettlementURL = 'v1/Settlement';
    Const VerifyURL = 'v1/Verify';
    Const CancelURL = 'v1/Cancel';
    Const ReverseURL = 'v1/Reverse';
	Const URL = 'https://ipgrest.asanpardakht.ir';

    private $invoiceId = null;
    private $amount = null;
    private $username = null;
    private $password = null;
    private $callBackURL = null;
    private $merchantConfigID = null;
    private static $instance = null;
    private function __construct () {}

    public static function make(){
        if (self::$instance === null) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function config($username,$password,$merchantConfigID,$callBackURL = null)
    {
        $this->username = $username;
        $this->password = $password;
        $this->callBackURL = $callBackURL;
        $this->merchantConfigID = $merchantConfigID;

        return self::$instance;
    }

    public function invoiceId($id)
    {
        $this->invoiceId = $id;
        return self::$instance;
    }

    public function amount($amount)
    {
        $this->amount = $amount;
        return self::$instance;
    }

    public function time()
    {
        return $this->callAPI('GET',self::TimeURL);
    }

    public function TranResult()
    {
        $res = $this->callAPI('GET',self::TranResultURL.'?'.http_build_query([
                'merchantConfigurationId' => $this->merchantConfigID,
                'localInvoiceId' => $this->invoiceId
            ]));
        return ['code' => $res['code'],'content' => json_decode($res['content'],true)];
    }

    public function CardHash()
    {
        return $this->callAPI('GET',self::CardHashURL.'?'.http_build_query([
            'merchantConfigurationId' => $this->merchantConfigID,
                'localInvoiceId' => $this->invoiceId
            ]));
    }

    public function token()
    {
		$this->callBackURL .= strpos($this->callBackURL, '?') === false? '?':'&';
        return $this->callAPI('POST',self::TokenURL,[
                'serviceTypeId' => 1,
                'merchantConfigurationId' => $this->merchantConfigID,
                'localInvoiceId' => $this->invoiceId,
                'amountInRials' => $this->amount,
                'localDate' => (string)(new DateTime('Asia/Tehran'))->format('Ymd His'),
                'callbackURL' => $this->callBackURL.http_build_query(['invoice' => $this->invoiceId]),
                'paymentId' => 0,
                'additionalData' => '',
        ]);
    }

    public function settlement($transId)
    {
       return $this->callAPI('POST',self::SettlementURL,[
            'merchantConfigurationId' => $this->merchantConfigID,
            'payGateTranId' => $transId
        ]);
    }

    public function verify($transId)
    {
       return $this->callAPI('POST',self::VerifyURL,[
            'merchantConfigurationId' => $this->merchantConfigID,
            'payGateTranId' => $transId
        ]);
    }

    public function reverse($transId)
    {
       return $this->callAPI('POST',self::ReverseURL,[
            'merchantConfigurationId' => $this->merchantConfigID,
            'payGateTranId' => $transId
        ]);
    }

    public function cancel($transId)
    {
       return $this->callAPI('POST',self::CancelURL,[
            'merchantConfigurationId' => $this->merchantConfigID,
            'payGateTranId' => $transId
        ]);
    }

    protected  function  callAPI($method, $url, $data = false)
    {
        $curl = curl_init();
        $url = self::URL.'/'.$url;
        switch ($method)
        {
            case 'POST':
                curl_setopt($curl, CURLOPT_POST, 1);
                if ($data){
                    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
                }
                break;
            default:
                if ($data){
                    $url = sprintf("%s?%s", $url, http_build_query($data));
                }
        }

        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Accept: application/json',
            'Usr: '.$this->username,
            'Pwd: '.$this->password,
            'Content-Type: application/json',
        ]);

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);

        $result = curl_exec($curl);
		if (curl_errno($curl))
			return ['content' => curl_error($curl), 'code' => curl_errno($curl)];		
        
		$httpcode = curl_getinfo($curl);
        curl_close($curl);

        return ['content' => $result,'code' => $httpcode['http_code']];
    }

    public static function redirect($token,$mobile = null)
    {
        echo '<html>';
        echo '<body>';
        echo '<script language="javascript" type="text/javascript">
                 function postRefId(refIdValue,mobile) {
                     var form = document.createElement("form");
                     form.setAttribute("method", "POST");
                     form.setAttribute("action",
                     "https://asan.shaparak.ir");
                     form.setAttribute("target", "_self");
                     var hiddenField = document.createElement("input");
                     hiddenField.setAttribute("name", "RefId");
                     hiddenField.setAttribute("value", refIdValue);
                     form.appendChild(hiddenField);
                     var mobileField = document.createElement("input");
                     mobileField.setAttribute("name", "mobileap");
                     mobileField.setAttribute("value", mobile);
                     form.appendChild(mobileField);
                     document.body.appendChild(form);
                     form.submit();
                     document.body.removeChild(form);
            } 
            postRefId('.$token.','.$mobile.')
        </script>';
        echo '</body>';
        echo '</html>';
    }
}


