<?php

class Abstract_Api
{
    protected $_client;
    protected $_session;
    //protected $_soap_wsdl_v2 = 'http://dev157.shoezoo.com/api/v2_soap?wsdl';
    protected $_soap_wsdl_v2 = 'http://dev157.shoezoo.com/api/v2_soap?wsdl';
    protected $_soap_user = 'menashopping_api_dev';
    protected $_soap_pass = 'u4NQy247DdA4dhXWP92l7';
    protected $_storeTimeZone = 'America/Los_Angeles';

    /**
     * @return SoapClient
     */
    protected function _getClient()
    {
        if (!$this->_client) {
            $this->_client = new SoapClient($this->_soap_wsdl_v2, array('trace' => 1, 'cache_wsdl' => 0));
        }
        return $this->_client;
    }

    /**
     * @return mixed
     */
    public function getSession()
    {
        if (!$this->_session) {
            $this->_session = $this->_getClient()->login($this->_soap_user, $this->_soap_pass);
        }
        return $this->_session;
    }

    public function getStoreCurrentTimestamp()
    {
        $dateTimeZoneStore = new DateTimeZone($this->_storeTimeZone);
        $dateTimeStore = new DateTime("now", $dateTimeZoneStore);
        $date = $dateTimeStore->format('Y-m-d H:i:s');
        return strtotime($date);
    }
}

?>