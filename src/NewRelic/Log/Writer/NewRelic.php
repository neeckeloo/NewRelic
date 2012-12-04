<?php
namespace NewRelic\Log\Writer;

use Zend\Log\Writer\AbstractWriter;
use NewRelic\Manager;

class NewRelic extends AbstractWriter
{
    /**
     * @var Manager
     */
    protected $manager;

    /**
     * @param Manager $manager
     * @return \NewRelic\Log\Writer\NewRelic
     */
    public function setManager(Manager $manager)
    {
        $this->manager = $manager;

        return $this;
    }

    /**
     * @return Manager
     */
    public function getManager()
    {
        return $this->manager;
    }

    /**
     * Write a message to NewRelic.
     *
     * @param array $event event data
     * @return void
     */
    protected function doWrite(array $event)
    {
        $this->getManager()->noticeError($event['message']);
    }
}