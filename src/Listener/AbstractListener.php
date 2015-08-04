<?php
namespace NewRelic\Listener;

use NewRelic\ClientAwareInterface;
use NewRelic\ClientAwareTrait;
use NewRelic\ModuleOptionsAwareInterface;
use NewRelic\ModuleOptionsAwareTrait;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;

abstract class AbstractListener implements ClientAwareInterface, ListenerAggregateInterface, ModuleOptionsAwareInterface
{
    use ClientAwareTrait;
    use ListenerAggregateTrait;
    use ModuleOptionsAwareTrait;
}
