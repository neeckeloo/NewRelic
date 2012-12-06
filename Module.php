<?php
namespace NewRelic;

use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ServiceManager\ServiceManager;
use Zend\Stdlib\ResponseInterface as Response;
use NewRelic\Service\LoggerFactory;
use NewRelic\Service\LogWriterFactory;
use NewRelic\Service\ManagerFactory;

class Module implements
    ConfigProviderInterface,
    ServiceProviderInterface,
    AutoloaderProviderInterface
{
    /**
     * @var ServiceManager
     */
    protected $ServiceManager;

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'NewRelicManager'   => new ManagerFactory,
                'NewRelicClient'    => new ClientFactory,
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
        $this->serviceManager = $application->getServiceManager();

        $client = $this->getClient();
        
        if (!$client->extensionLoaded()) {
            return;
        }

        $manager = $this->getManager();

        /* @var $eventManager \Zend\EventManager\EventManager */
        $eventManager = $application->getEventManager();

        $eventManager->attach('route', function(MvcEvent $e) use ($client) {
            $matches = $e->getRouteMatch();
            $route   = $matches->getMatchedRouteName();

            $client->nameTransaction($route);
        });

        $eventManager->attach('finish', function(MvcEvent $e) use ($manager, $client) {
            $client->setAppName(
                $manager->getApplicationName(),
                $manager->getApplicationLicense()
            );

        }, 100);
        $eventManager->attach('finish', array($this, 'initBrowserTiming'), 100);
    }

    public function initBrowserTiming(MvcEvent $e)
    {
        $manager = $this->getManager();

        if ($manager->getBrowserTimingEnabled()) {
            ini_set(
                'newrelic.browser_monitoring.auto_instrument',
                $manager->getBrowserTimingAutoInstrument()
            );

            if (!$manager->getBrowserTimingAutoInstrument()) {
                $response = $e->getResponse();
                $content = $response->getBody();

                $client = $this->getClient();

                $browserTimingHeader = $client->getBrowserTimingHeader();
                $browserTimingFooter = $client->getBrowserTimingFooter();

                $content = str_replace('<head>', '<head>' . $browserTimingHeader, $content);
                $content = str_replace('</body>', $browserTimingFooter . '</body>', $content);

                $response->setContent($content);
            }
        }
    }

    /**
     * @return \NewRelic\Manager
     */
    public function getManager()
    {
        return $this->serviceManager->get('NewRelicManager');
    }

    /**
     * @return \NewRelic\Client
     */
    public function getClient()
    {
        return $this->serviceManager->get('NewRelicClient');
    }
}