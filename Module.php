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
            'invokables' => array(
                'NewRelicLogWriter' => 'NewRelic\Log\Writer\NewRelic',
            ),
            'factories' => array(
                'NewRelicManager' => new \NewRelic\ManagerFactory,
                'logger' => function($sm) {
                    $logger = new \Zend\Log\Logger();

                    $writer = $sm->get('NewRelicLogWriter');
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

        /* @var $manager \NewRelic\Manager */
        $manager = $application->getServiceManager()->get('NewRelicManager');

        if (!$manager->extensionLoaded()) {
            return;
        }

        $applicationName = $manager->getApplicationName();
        if ($applicationName) {
            $params = array($applicationName);

            $applicationLicense = $manager->getApplicationLicense();
            if ($applicationLicense) {
                $params['license'] = $applicationLicense;
            }
            
            call_user_func_array('newrelic_set_appname', $params);
        }

        if ($manager->getBrowserTimingEnabled()) {
            ini_set(
                'newrelic.browser_monitoring.auto_instrument',
                $manager->getBrowserTimingAutoInstrument()
            );

            if (!$manager->getBrowserTimingAutoInstrument()) {
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