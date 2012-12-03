<?php
namespace NewRelic;

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

    public function onBootstrap(Event $e)
    {
        $application = $e->getParam('application');
        $config      = $e->getParam('config');

        if (!extension_loaded('newrelic')) {
            return;
        }

        if (!isset($config['browser_timing'])) {
            $config['browser_timing'] = array();
        }
        if (!isset($config['browser_timing']['enabled'])) {
            $config['browser_timing']['enabled'] = false;
        }
        if (!isset($config['browser_timing']['auto_instrument'])) {
            $config['browser_timing']['auto_instrument'] = true;
        }

        if ($config['browser_timing']['enabled']) {
            ini_set(
                'newrelic.browser_monitoring.auto_instrument',
                $config['browser_timing']['auto_instrument']
            );

            if (!$config['browser_timing']['auto_instrument']) {
                $response = $application->getMvcEvent()->getResponse();
                $content = $response->getContent();

                $browserTimingHeader = newrelic_get_browser_timing_header();
                $browserTimingFooter = newrelic_get_browser_timing_footer();

                $response->setContent($content);
            }
        }
    }
}