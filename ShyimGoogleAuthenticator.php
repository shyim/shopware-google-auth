<?php

namespace ShyimGoogleAuthenticator;

use Shopware\Components\Plugin;
use Shopware\Components\Plugin\Context\InstallContext;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class ShyimGoogleAuthenticator extends Plugin
{
    public function install(InstallContext $context)
    {
        $this->container->get('shopware_attribute.crud_service')->update('s_core_auth_attributes', 'twofac_enabled', 'boolean', [
            'displayInBackend' => true,
            'label'            => 'Two factor authentication activated?'
        ]);

        $this->container->get('shopware_attribute.crud_service')->update('s_core_auth_attributes', 'twofac_secret', 'text');
    }

    public function build(ContainerBuilder $container)
    {
        $container->setParameter('shyim_google_auth.plugin_dir', $this->getPath());
        parent::build($container);
    }
}