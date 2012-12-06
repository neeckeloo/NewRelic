<?php
namespace NewRelic\Service;

use NewRelic\Manager;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * NewRelic manager factory
 */
class ManagerFactory implements FactoryInterface
{
    /**
     * Create the NewRelic manager
     *
     * @param  ServiceLocatorInterface $serviceLocator
     * @return Manager
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $manager = new Manager();

        $config = $serviceLocator->get('Config');

        $cfg = $config['newrelic'];

        if (!empty($cfg['application']['name'])) {
            $manager->setApplicationName($cfg['application']['name']);
        }
        if (!empty($cfg['application']['license'])) {
            $manager->setApplicationLicense($cfg['application']['license']);
        }

        $manager->setBrowserTimingEnabled((bool) $cfg['browser_timing']['enabled']);
        $manager->setBrowserTimingAutoInstrument((bool) $cfg['browser_timing']['auto_instrument']);

        return $manager;
    }
}