<?php
namespace NewRelicLogger;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    // Within class Module:
    public function onBootstrap(Event $e)
    {
        $application = $e->getParam('application');
        $config      = $e->getParam('config');

        if (extension_loaded('newrelic')) {
            $eventManager = $application->getEventManager();
            $eventManager->attach('bootstrap', array('newrelic_get_browser_timing_header'), 100);
            $eventManager->attach('finish', array('newrelic_get_browser_timing_footer'), 100);
        }
    }
}