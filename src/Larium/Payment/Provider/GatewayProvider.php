<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

namespace Larium\Payment\Provider;

use Larium\Payment\PaymentProviderInterface;
use Larium\Payment\PaymentSourceInterface;
use AktiveMerchant\Billing\CreditCard;

class GatewayProvider implements PaymentProviderInterface
{
    protected $gateway_class;

    protected $gateway_options = array();

    protected $gateway;

    public function authorize($amount, PaymentSourceInterface $source, array $options=array())
    {

    }

    public function purchase($amount, PaymentSourceInterface $source=null, array $options=array())
    {
        $response = new Response();

        $cc = new CreditCard($source->getOptions());

        $r = $this->getGateway()->purchase($amount, $cc, $options);
        $response->setSuccess($r->success());

        return $response;
    }

    public function capture($amount, $authorization, array $options=array())
    {

    }

    /**
     * Sets the gateway class name to use for transaction.
     *
     * @param string $gateway_class
     * @access public
     * @return void
     */
    public function setGatewayClass($gateway_class)
    {
        $this->gateway_class = $gateway_class;
    }

    public function getGateway()
    {
        if (null === $this->gateway) {
            $class = $this->gateway_class;

            if (null === $class) {
                throw new \InvalidArgumentException("Gateway class not defined.");
            }

            $this->gateway = new $class($this->gateway_options);
        }

        return $this->gateway;
    }

    /**
     * Sets gateway options.
     * Options could be login information for gateway, currency etc, depends on
     * each gataway class.
     *
     * @param array $gateway_options
     * @access public
     * @return void
     */
    public function setGatewayOptions(array $gateway_options=array())
    {
        $this->gateway_options = $gateway_options;
    }
}
