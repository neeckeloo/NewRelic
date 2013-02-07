<?php
namespace NewRelic\Listener;

use NewRelic\Client;
use Zend\EventManager\EventManagerInterface as Events;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\Mvc\MvcEvent;

class InitBrowserTimingListener implements ListenerAggregateInterface
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var array
     */
    protected $listeners = array();

    /**
     * @param Client $client
     * @return void
     */
    public function setClient(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param Events $events
     * @return void
     */
    public function attach(Events $events)
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_FINISH, array($this, 'initBrowserTiming'), 100);
    }

    /**
     * @param Events $events
     * @return void
     */
    public function detach(Events $events)
    {
        foreach ($this->listeners as $index => $listener) {
            if ($events->detach($listener)) {
                unset($this->listeners[$index]);
            }
        }
    }

    /**
     * @param MvcEvent $e
     * @return void
     */
    public function initBrowserTiming(MvcEvent $e)
    {
        $configuration = $this->client->getConfiguration();

        if (!$configuration->getBrowserTimingEnabled()) {
            return;
        }

        if ($configuration->getBrowserTimingAutoInstrument()) {
            ini_set(
                'newrelic.browser_monitoring.auto_instrument',
                $configuration->getBrowserTimingAutoInstrument()
            );
            return;
        }

        $response = $e->getResponse();
        $content = $response->getBody();

        $browserTimingHeader = $this->client->getBrowserTimingHeader();
        $browserTimingFooter = $this->client->getBrowserTimingFooter();

        $content = str_replace('<head>', '<head>' . $browserTimingHeader, $content);
        $content = str_replace('</body>', $browserTimingFooter . '</body>', $content);

        $response->setContent($content);
    }
}