<?php

namespace ShyimGoogleAuthenticator\Subscribers;

use Enlight\Event\SubscriberInterface;
use Enlight_Template_Manager;

class Controller implements SubscriberInterface
{
    /**
     * @var string
     */
    private $pluginDir;

    /**
     * @var string
     */
    private $viewDir;

    /**
     * @var Enlight_Template_Manager
     */
    private $template;

    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Dispatcher_ControllerPath_Backend_Twofactorauth' => 'onTwofactorauth',
        ];
    }

    /**
     * @param $pluginDir
     * @param $viewDir
     * @param Enlight_Template_Manager $template
     */
    public function __construct(
        $pluginDir,
        $viewDir,
        Enlight_Template_Manager $template
    ) {
        $this->pluginDir = $pluginDir;
        $this->viewDir = $viewDir;
        $this->template = $template;
    }

    public function onTwofactorauth()
    {
        $this->template->addTemplateDir($this->viewDir);

        return $this->pluginDir . '/Controllers/Backend/Twofactorauth.php';
    }
}
