<?php
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use yii\base\Component;

class CashMoney extends Component
{
    public $client_id;
    public $client_secret;
    private $apiContext; // paypal's API context

    // override Yii's object init()
    public function init()
    {
        $this->apiContext = new ApiContext(
            new OAuthTokenCredential($this->client_id, $this->client_secret)
        );
    }

    public function getContext()
    {
        return $this->apiContext;
    }
}
