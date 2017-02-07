<?php

use Shopware\Models\Shop\Shop;

class Shopware_Controllers_Backend_Twofactorauth extends Shopware_Controllers_Backend_ExtJs
{
    public function indexAction() {}

    public function loadAction()
    {
        parent::loadAction();

        /** @var \Shopware\Models\Shop\Repository $shopRepository */
        $shopRepository = $this->container->get('models')->getRepository(Shop::class);
        $shop = $shopRepository->getActiveDefault();

        $secret = $this->container->get('shyim_googleauth.verification')->createSecret();
        $this->View()->qrCode = $this->container->get('shyim_googleauth.verification')->getQRCodeGoogleUrl($shop->getHost(), $secret);
        $this->View()->secret = $secret;
    }

    public function enableAction()
    {
        /** @var \Shopware_Components_Auth $auth */
        $auth = $this->container->get('auth');

        /** @var \Zend_Auth_Storage_Session $session */
        $session = $auth->getStorage();

        $result = $session->read();
        $result->twofacDone = true;

        $session->write($result);

        $this->container->get('dbal_connection')->update('s_core_auth_attributes', [
            'twofac_enabled' => 1,
            'twofac_secret'  => $this->Request()->getParam('secret')
        ], ['authID' => $auth->getIdentity()->id]);
    }
}