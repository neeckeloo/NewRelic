<?php
namespace NewRelic;

use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use NewRelic\Service\LoggerFactory;
use NewRelic\Service\LogWriterFactory;
use NewRelic\Service\ManagerFactory;

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
                'NewRelicManager'   => new ManagerFactory,
                'NewRelicLogWriter' => new LogWriterFactory,
                'logger'            => new LoggerFactory,
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
                $application->getEventManager()->attach('finish', array($manager, 'addBrowserTiming'), 100);
            }
        }
    }
}