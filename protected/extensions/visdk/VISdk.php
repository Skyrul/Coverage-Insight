<?php
require dirname(__FILE__) . '/classes/HTTPVerbs.php';

class VISdk
{
    private $_uid = '';
    private $_pwd = '';
    private $_base_endpoint = 'https://rest.virtualincentives.com/v4/json';
    
    function __construct($uid, $pwd)
    {
        $this->_uid = $uid;
        $this->_pwd = $pwd;
    }

    public function XhrRequest($endpoint, $http_verb, $payload = '')
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$endpoint);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $http_verb);
        if ($http_verb == HTTPVerbs::POST) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        } 
        else if ($http_verb == HTTPVerbs::GET) {
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Authorization
        $uid_pwd = base64_encode($this->_uid . ':' . $this->_pwd);
        $headers = [
            'Content-Type: application/json',
            'Authorization: Basic '. $uid_pwd,
            'Host: rest.virtualincentives.com'
        ];
        
        // Get Output
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $server_output = curl_exec ($ch);
        curl_close ($ch);

        return $server_output;
    }

    public function CreateOrder($payload)
    {
        $endpoint = $this->_base_endpoint . "/orders";
        return $this->XhrRequest($endpoint, HTTPVerbs::POST, $payload);
    }

    public function GetOrders()
    {
        $endpoint = $this->_base_endpoint . "/orders";
        return $this->XhrRequest($endpoint, HTTPVerbs::GET, '');
    }

    public function GetOrdersByStatus($pstatus)
    {
        $endpoint = $this->_base_endpoint . "/orders?status=". $pstatus;
        return $this->XhrRequest($endpoint, HTTPVerbs::GET, '');
    }

    public function GetOrdersByNumber($pnumber)
    {
        $endpoint = $this->_base_endpoint . '/orders/'. $pnumber;
        return $this->XhrRequest($endpoint, HTTPVerbs::GET, '');
    }

    public function GetBrands()
    {
        $endpoint = $this->_base_endpoint . '/products'. $pnumber;
        return $this->XhrRequest($endpoint, HTTPVerbs::GET, '');
    }

    public function GetBrand($psku)
    {
        $endpoint = $this->_base_endpoint . '/products/'. $psku;
        return $this->XhrRequest($endpoint, HTTPVerbs::GET, '');
    }

    public function GetBrandFaceplate()
    {
        $endpoint = $this->_base_endpoint . '/products/'. $psku . '/faceplate';
        return $this->XhrRequest($endpoint, HTTPVerbs::GET, '');
    }

    public function GetBrandMarketing()
    {
        $endpoint = $this->_base_endpoint . '/products/'. $psku . '/marketing';
        return $this->XhrRequest($endpoint, HTTPVerbs::GET, '');
    }

    public function GetBrandTerms()
    {
        $endpoint = $this->_base_endpoint . '/products/'. $psku . '/terms';
        return $this->XhrRequest($endpoint, HTTPVerbs::GET, '');
    }

    public function GetMasterFundingBalances()
    {
        $endpoint = $this->_base_endpoint . '/balances';
        return $this->XhrRequest($endpoint, HTTPVerbs::GET, '');
    }

    public function GetProgramBalances()
    {
        $endpoint = $this->_base_endpoint . '/balances/programs';
        return $this->XhrRequest($endpoint, HTTPVerbs::GET, '');
    }

    public function GetProgramBalance($pprogram_id)
    {
        $endpoint = $this->_base_endpoint . '/programs/' . $pprogram_id;
        return $this->XhrRequest($endpoint, HTTPVerbs::GET, '');
    }

    public function GetPrograms()
    {
        $endpoint = $this->_base_endpoint . '/programs';
        return $this->XhrRequest($endpoint, HTTPVerbs::GET, '');
    }

    public function GetProgramBrands($pprogram_id)
    {
        $endpoint = $this->_base_endpoint . '/programs/'. $pprogram_id . '/products';
        return $this->XhrRequest($endpoint, HTTPVerbs::GET, '');
    }

    public function GetProgramBrand($pprogram_id, $psku)
    {
        $endpoint = $this->_base_endpoint . '/programs/'. $pprogram_id . '/products/' . $psku;
        return $this->XhrRequest($endpoint, HTTPVerbs::GET, '');
    }

}