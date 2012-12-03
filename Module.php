<?php
namespace NewRelic;

use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;

class Module implements
    ConfigProviderInterface,
    ServiceProviderInterface,
    AutoloaderProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'logger' => function($sm) {
                    $logger = new \Zend\Log\Logger();

                    $writer = new \NewRelic\Log\Writer\NewRelic();
                    $logger->addWriter($writer);

                    return $logger;
                },
            ),
        );
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

    public function onBootstrap(MvcEvent $e)
    {
        $application = $e->getApplication();
        $config      = $application->getConfig();

        if (!extension_loaded('newrelic')) {
            return;
        }

        $cfg = $config['newrelic'];

        if ($cfg['browser_timing']['enabled']) {
            ini_set(
                'newrelic.browser_monitoring.auto_instrument',
                $cfg['browser_timing']['auto_instrument']
            );

            if (!$cfg['browser_timing']['auto_instrument']) {
                $application->getEventManager()->attach('finish', array($this, 'addBrowserTiming'), 100);
            }
        }
    }


    public function addBrowserTiming($e)
    {
        $response = $e->getResponse();
        $content = $response->getBody();

        $browserTimingHeader = newrelic_get_browser_timing_header();
        $browserTimingFooter = newrelic_get_browser_timing_footer();

        $content = str_replace('<head>', '<head>' . $browserTimingHeader, $content);
        $content = str_replace('</body>', $browserTimingFooter . '</body>', $content);

        $response->setContent($content);
    }
}