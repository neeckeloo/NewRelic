<?php

declare(strict_types=1);

namespace NewRelic\Listener;

use Zend\EventManager\EventManagerInterface as Events;
use Zend\Http\Request as HttpRequest;
use Zend\Mvc\MvcEvent;

class ResponseListener extends AbstractListener
{
    /**
     * @param  Events $events
     * @param  int    $priority
     * @return void
     */
    public function attach(Events $events, $priority = 100): void
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_FINISH, [$this, 'onResponse'], $priority);
    }

    public function onResponse(MvcEvent $e): void
    {
        $request = $e->getRequest();

        if (
            !$this->options->getBrowserTimingEnabled()
            || !$request instanceof HttpRequest
            || $request->isXmlHttpRequest()
        ) {
            $this->client->disableAutorum();
            return;
        }

        if ($this->options->getBrowserTimingAutoInstrument()) {
            \ini_set('newrelic.browser_monitoring.auto_instrument', '1');
            return;
        }

        $response = $e->getResponse();
        $content = $response->getContent();

        $browserTimingHeader = $this->client->getBrowserTimingHeader();
        $browserTimingFooter = $this->client->getBrowserTimingFooter();

        $content = \str_replace('<head>', '<head>' . $browserTimingHeader, $content);
        $content = \str_replace('</body>', $browserTimingFooter . '</body>', $content);

        $response->setContent($content);
    }
}
