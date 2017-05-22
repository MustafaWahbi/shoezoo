<?php
include_once('catalogApi.php');
include_once('orderApi.php');

class kskShoezoo{
    /*************** all product ********/
    private  $dropShippingOrder;
    private  $dropShippingProducts;

    function __construct(){
        $this->dropShippingOrder = new DropShippingOrder();
    }

    /* download the file */
    function getProducts(){
        $this->dropShippingProducts = new DropShippingCatalog();

        $response = $this->dropShippingProducts->getCatalogList(true);
        if (isset($response->success) && $response->success) {

            $filePath=$response->file; //URL
            $destination='downloads/'.time().'.csv';//time()

            // download fiel to destination
            file_put_contents($destination, fopen($filePath, 'r'));

            return $destination; // return with file new file path

        } else {
            //echo "<pre>" . print_r($response->getMessage(), 1) . "</pre>";
            return 0;
        }


    }

    /* delete file */
    function deleteProductsFile($destination)
    {
        if (!unlink($destination))
        {
            return 0;
        }
        else
        {
            return 1;
        }
    }
    /********* orders *********/
    /* reserveOrder */
    function reserveOrder($orderId,$products){


        $orderData = array(
            'orderNumber' => $orderId, //generate unique order number
            'productList' => array($products)
        );

        $response = $this->dropShippingOrder->createOrder($orderData);


        if (isset($response->success) && $response->success)
        {
            $jsondata=json_encode($response);
            return json_decode($jsondata, true);
        }
        else return 0;
    }

    /* confirm check */
    function confirmCheck($orderId)
    {
        $response = $this->dropShippingOrder->heartbeatOrder($orderId);//return invoiceId
        if (isset($response->success) && $response->success)
        {
            $jsondata=json_encode($response);
            return json_decode($jsondata, true);        }
        else return 0;
    }

    /* confirm Order */
    function confirmOrder($orderId)
    {
        $response = $this->dropShippingOrder->finalizeOrder($orderId);//return invoiceId
        if (isset($response->success) && $response->success)
        {
            $jsondata=json_encode($response);
            return json_decode($jsondata, true);        }
        else return 0;
    }

    /* cancel Order */
    function cancelOrder($orderId)
    {
        $response = $this->dropShippingOrder->cancelOrder($orderId);//return get all list
        if (isset($response->success) && $response->success)
        {
            $jsondata=json_encode($response);
            return json_decode($jsondata, true);        }
        else return 0;
    }

    /* cancel Order */
    function getOrderList()
    {
        $response = $this->dropShippingOrder->getOrderList();//return get all list
        if (isset($response->success) && $response->success) {
            $jsondata=json_encode($response);
            return json_decode($jsondata, true);        }
        else return 0;
    }
}



?>