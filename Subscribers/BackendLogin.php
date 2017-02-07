<?php

namespace ShyimGoogleAuthenticator\Subscribers;

use Enlight\Event\SubscriberInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class BackendLogin implements SubscriberInterface
{
    /**
     * @var string
     */
    private $viewDir;

    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct($viewDir, ContainerInterface $container)
    {
        $this->viewDir = $viewDir;
        $this->container = $container;
    }

    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PostDispatch_Backend_Login' => 'onPostDispatchLogin',
            'Enlight_Controller_Action_Backend_Login_login' => 'onBackendLogin'
        ];
    }

    public function onBackendLogin(\Enlight_Event_EventArgs $args)
    {
        /** @var \Shopware_Controllers_Backend_Index $subject */
        $subject = $args->getSubject();

        $username = $subject->Request()->get('username');

        $attributes = $this->container->get('dbal_connection')->fetchAssoc('SELECT * FROM s_core_auth_attributes WHERE authID = (SELECT id FROM s_core_auth WHERE username = ?)', [$username]);

        if (!empty($attributes['twofac_enabled'])) {
            if (!$this->container->get('shyim_googleauth.verification')->verifyCode($attributes['twofac_secret'], $subject->Request()->getParam('code'))) {
                $subject->View()->success = false;

                return true;
            }
        }
    }

    public function onPostDispatchLogin(\Enlight_Event_EventArgs $args)
    {
        /** @var \Shopware_Controllers_Backend_Index $subject */
        $subject = $args->getSubject();

        if ($subject->Request()->getActionName() == 'load') {
            $subject->View()->addTemplateDir($this->viewDir);
            $subject->View()->extendsTemplate('overrides/backend/login/view/form/form.js');
        }
    }
}