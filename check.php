<?php
require 'anet_php_sdk/AuthorizeNet.php';

class AuthNetConstant 
{
    const CREATE_CUSTOMER     = 1;
    const CREATE_SUBSCRIPTION = 2;
    const CREATE_PAYMENT      = 3;
}

define("AUTHORIZENET_API_LOGIN_ID", "3qv8XvM9tB4N");
define("AUTHORIZENET_TRANSACTION_KEY", "64M57a2M52fEjvbr");
define("AUTHORIZENET_SANDBOX", true);

if (isset($_GET['engagex'])) {
    $param = $_GET['engagex'];
    if($param == 'info') {
        phpinfo();
    }
    else if($param == 'coverage-insight') {
        $ch = curl_init('https://www.howsmyssl.com/a/check');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        curl_close($ch);
        
        $json = json_decode($data);
        echo "Connection uses " . $json->tls_version ."\n";
    }
    else if($param == AuthNetConstant::CREATE_CUSTOMER) {
        echo createCustomerProfile();
    }
    else if($param == AuthNetConstant::CREATE_SUBSCRIPTION) {
        echo createSubscription();
    }
    else if($param == AuthNetConstant::CREATE_PAYMENT) {
        echo createPayment();
    }
}



function createCustomerProfile() 
{
    $request = new AuthorizeNetCIM;
    // Create new customer profile
    $customerProfile                    = new AuthorizeNetCustomer;
    $customerProfile->description       = "Joven Barola";
    $customerProfile->merchantCustomerId= time();
    $customerProfile->email             = "jovenbarola@gmail.com";
    $response = $request->createCustomerProfile($customerProfile);
    if ($response->isOk()) {
        $customerProfileId = $response->getCustomerProfileId();
        return $customerProfileId;
    }
}

function createSubscription()
{
    $subscription                          = new AuthorizeNet_Subscription;
    $subscription->name                    = "PHP Monthly Magazine";
    $subscription->customerId              = "1512584978";
    $subscription->intervalLength          = "1";
    $subscription->intervalUnit            = "months";
    $subscription->startDate               = "2017-12-08";
    $subscription->totalOccurrences        = "12";
    $subscription->amount                  = "12.99";
    $subscription->creditCardCardNumber    = "6011000000000012";
    $subscription->creditCardExpirationDate= "2022-10";
    $subscription->creditCardCardCode      = "123";
    $subscription->billToFirstName         = "Rasmus";
    $subscription->billToLastName          = "Doe";
    
    // Create the subscription.
    $request = new AuthorizeNetARB;
    $response = $request->createSubscription($subscription);
    print_r($response);
    exit;
    $subscription_id = $response->getSubscriptionId();
    return $subscription_id;
}

function createPayment()
{
    $sale = new AuthorizeNetAIM;
    $sale->cust_id = "1512584978";
    $sale->amount = "5.99";
    $sale->card_num = '6011000000000012';
    $sale->exp_date = '04/15';
    $response = $sale->authorizeAndCapture();
    if ($response->approved) {
        $transaction_id = $response->transaction_id;
    }
    
    print_r($transaction_id);
    exit;
}
