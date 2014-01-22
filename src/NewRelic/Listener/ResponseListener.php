<?php
namespace NewRelic\Listener;

use Zend\EventManager\EventManagerInterface as Events;
use Zend\Mvc\MvcEvent;

class ResponseListener extends AbstractListener
{
    /**
     * @param  Events $events
     * @return void
     */
    public function attach(Events $events)
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_FINISH, array($this, 'onResponse'), 100);
    }

    /**
     * @param  MvcEvent $e
     * @return void
     */
    public function onResponse(MvcEvent $e)
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
        $content = $response->getContent();

        $browserTimingHeader = $this->client->getBrowserTimingHeader();
        $browserTimingFooter = $this->client->getBrowserTimingFooter();

        $content = str_replace('<head>', '<head>' . $browserTimingHeader, $content);
        $content = str_replace('</body>', $browserTimingFooter . '</body>', $content);

        $response->setContent($content);
    }
}