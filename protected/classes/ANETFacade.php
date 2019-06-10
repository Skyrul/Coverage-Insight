<?php
/**
 * @author Joven
 **/
require(AUTHORIZENET_SDK);

class ANETFacade 
{
    
    /**
     * @param array $data {
     *      @option string description
     *      @option string email
     * }
     *
     * @return int $customer_profile_id
     */
    public static function save_customer_profile($data)
    {
        $request = new AuthorizeNetCIM;
        
        // Create new customer profile
        $customerProfile                    = new AuthorizeNetCustomer;
        $customerProfile->description       = $data['description'];
        $customerProfile->merchantCustomerId= time();
        $customerProfile->email             = $data['email'];
        
        $exp_date  = explode('/', $data['exp_date']);
        $exp_month = date('m', mktime(0, 0, 0, $exp_date[0], 10));
        $exp_year  = $exp_date[1];
        
        // Create new customer payment profile
        $paymentProfile = new AuthorizeNetPaymentProfile;
        $paymentProfile->customerType = "individual";
        $paymentProfile->payment->creditCard->cardNumber = $data['card_num'];
        $paymentProfile->payment->creditCard->expirationDate = $exp_year.'-'.$exp_month; //"2017-4";;
        $paymentProfile->billTo->company = $data['description'];
        $paymentProfile->billTo->firstName = (isset($data['firstName'])) ? $data['firstName'] : '-';
        $paymentProfile->billTo->lastName  = (isset($data['lastName'])) ? $data['lastName'] : '-';
        $paymentProfile->billTo->address = $data['bill_address'];
        $paymentProfile->billTo->city = $data['bill_city'];
        $paymentProfile->billTo->state = $data['bill_state'];
        $paymentProfile->billTo->zip = $data['bill_zipcode'];
        $paymentProfile->billTo->phoneNumber = $data['bill_phone'];
        $customerProfile->paymentProfiles[] = $paymentProfile;
        
        $response = $request->createCustomerProfile($customerProfile);
        if ($response->isOk())  {
            return array(
                'status'=>'success',
                'customerProfileId'=>$response->getCustomerProfileId(),
                'paymentProfileId' =>$response->getCustomerPaymentProfileIds(),
            );
        } else {
            return array(
                'status'=>'error',
                'msg'=>$response->getErrorMessage(),
            );
        }
    }
    
    /**
     * @param string $customerProfileId
     * @param string $customerPaymentProfileId
     *
     * @return void
     */
    public static function update_customer_profile($customerProfileId, $customerPaymentProfileId, $data)
    {
        $request = new AuthorizeNetCIM;
        
        $exp_date  = explode('/', $data['exp_date']);
        $exp_month = date('m', mktime(0, 0, 0, $exp_date[0], 10));
        $exp_year  = $exp_date[1];
        
        // Create new customer payment profile
        $paymentProfile = new AuthorizeNetPaymentProfile;
        $paymentProfile->customerType = "individual";
        $paymentProfile->payment->creditCard->cardNumber = $data['card_num'];
        $paymentProfile->payment->creditCard->expirationDate = $exp_year.'-'.$exp_month; //"2017-4";;
        $paymentProfile->billTo->company = $data['description'];
        $paymentProfile->billTo->firstName = '-';
        $paymentProfile->billTo->lastName  = '-';
        $paymentProfile->billTo->address = $data['bill_address'];
        $paymentProfile->billTo->city = $data['bill_city'];
        $paymentProfile->billTo->state = $data['bill_state'];
        $paymentProfile->billTo->zip = $data['bill_zipcode'];
        $paymentProfile->billTo->phoneNumber = $data['bill_phone'];
        
        $response = $request->updateCustomerPaymentProfile($customerProfileId, $customerPaymentProfileId, $paymentProfile);
        if ($response->isOk())  {
            return array(
                'status'=>'success',
                'msg'=>'Record updated'
            );
        } else {
            return array(
                'status'=>'error',
                'msg'=>$response->getErrorMessage(),
            );
        }
    }
    
    /**
     * @param string $customerProfileId
     *
     * @return void
     */
    public static function get_customer_profile($customerProfileId)
    {
        $request = new AuthorizeNetCIM;
        $response = $request->getCustomerProfile($customerProfileId);

        return $response;
    }
    
    /**
     * @param string $customerProfileId
     * @param string $customerPaymentProfileId
     *
     * @return void
     */
    public static function get_customer_payment_profile($customerProfileId, $customerPaymentProfileId)
    {
        $request = new AuthorizeNetCIM;
        $response = $request->getCustomerPaymentProfile($customerProfileId, $customerPaymentProfileId);
        return $response->xml;
    }
    
    

    /**
     * @param string $customerProfileId
     * @param string $customerPaymentProfileId
     *
     * @return void
     */
    public static function delete_customer_profile($customerProfileId)
    {
        $request = new AuthorizeNetCIM;
        $response = $request->deleteCustomerProfile($customerProfileId);
        if ($response->isOk()) {
            return array(
                'status'=>'success',
            );
        } else {
            return array(
                'status'=>'error',
                'msg'=>$response->getMessageText(),
            );
        }
    }
    
    /**
     * @param string $customerProfileId
     * @param string $customerPaymentProfileId
     *
     * @return void
     */
    public static function delete_payment_profile($customerProfileId, $customerPaymentProfileId)
    {
        $request = new AuthorizeNetCIM;
        $response = $request->deleteCustomerPaymentProfile($customerProfileId, $customerPaymentProfileId);
        if ($response->isOk()) {
            return array(
                'status'=>'success',
            );
        } else {
            return array(
                'status'=>'error',
                'msg'=>$response->getMessageText(),
            );
        }
    }
    
    
    /**
     * @param array $data {
     *      @option string cust_id
     *      @option string amount
     *      @option string card_num
     *      @option string exp_date
     * }
     *
     * @return int $transaction_id
     */
    public static function save_payment($data) 
    {
        $sale = new AuthorizeNetAIM;
        $sale->cust_id  = $data['cust_id'];
        $sale->last_name   = (isset($data['last_name']) ? $data['last_name'] : '-');
        $sale->first_name   = (isset($data['first_name']) ? $data['first_name'] : '-');
        $sale->company  = $data['company'];
        $sale->address  = $data['address'];
        $sale->city     = $data['city'];
        $sale->state    = $data['state'];
        $sale->zip      = $data['zip'];
        $sale->country  = $data['country'];
        $sale->phone    = $data['phone'];
        $sale->email    = $data['email'];
        $sale->amount   = $data['amount'];
        $sale->card_num = $data['card_num'];
        $sale->exp_date = $data['exp_date'];
        $sale->invoice_num = $data['invoice_num'];
        $sale->description = $data['description'];
        $response = $sale->authorizeAndCapture();
        if ($response->approved) 
            return array(
                'status'=>EnumStatus::SUCCESS,
                'transaction_id'=>$response->transaction_id,
            );
        else
            return array(
                'status'=>EnumStatus::ERROR,
                'msg'=>$response->error_message,
            );
    }
    
    public static function save_transaction($customerProfileId,$paymentProfileId, $data)
    {
        $request = new AuthorizeNetCIM;
        
        // Create Auth & Capture Transaction
        $transaction = new AuthorizeNetTransaction;
        
        $transaction->customerProfileId = $customerProfileId;
        $transaction->customerPaymentProfileId = $paymentProfileId;
        //$transaction->customerShippingAddressId = $customerAddressId;
        $transaction->amount = $data['amount'];
        
        $lineItem              = new AuthorizeNetLineItem();
        $lineItem->itemId      = $data['itemno'];
        $lineItem->name        = $data['itemname'];
        $lineItem->description = $data['itemdesc'];
        $lineItem->quantity    = $data['qty'];
        $lineItem->taxable     = false;
        $lineItem->unitPrice   = $data['amount'];
        
        
        $transaction->lineItems[] = $lineItem;
        
        $response = $request->createCustomerProfileTransaction("AuthCapture", $transaction);
        $transactionResponse = $response->getTransactionResponse();
        $transactionId = $transactionResponse->transaction_id;
        
        if ($response->isOk()) {
            return array(
                'status'=>EnumStatus::SUCCESS,
                'transaction_id'=>$transactionId,
            );
        } else {
            return array(
                'status'=>EnumStatus::ERROR,
                'msg'=>$response->getErrorMessage(),
            );
        }
                
    }
    
    
}

