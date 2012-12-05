<?php
namespace NewRelic;

use Zend\EventManager\Event;

class Manager
{
    /**
     * @var string
     */
    protected $applicationName = null;

    /**
     * @var string
     */
    protected $applicationLicense = null;

    /**
     * @var boolean
     */
    protected $browserTimingEnabled;

    /**
     * @var boolean
     */
    protected $browserTimingAutoInstrument;

    /**
     * @var string
     */
    protected $transactionName = null;

    /**
     * Returns true if newrelic extension is loaded
     *
     * @return boolean
     */
    public function extensionLoaded()
    {
        return extension_loaded('newrelic');
    }

    /**
     * @param string $name
     * @return Manager
     */
    public function setApplicationName($name)
    {
        $this->applicationName = (string) $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getApplicationName()
    {
        return $this->applicationName;
    }

    /**
     * @param string $license
     * @return Manager
     */
    public function setApplicationLicense($license)
    {
        $this->applicationLicense = (string) $license;

        return $this;
    }

    /**
     * @return string
     */
    public function getApplicationLicense()
    {
        return $this->applicationLicense;
    }

    /**
     * @param boolean $enabled
     * @return Manager
     */
    public function setBrowserTimingEnabled($enabled)
    {
        $this->browserTimingEnabled = (bool) $enabled;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getBrowserTimingEnabled()
    {
        return $this->browserTimingEnabled;
    }

    /**
     * @param boolean $enabled
     * @return Manager
     */
    public function setBrowserTimingAutoInstrument($enabled)
    {
        $this->browserTimingAutoInstrument = (bool) $enabled;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getBrowserTimingAutoInstrument()
    {
        return $this->browserTimingAutoInstrument;
    }

    /**
     * Insert the New Relic browser timing header and footer into html response.
     *
     * @param type $e
     */
    public function addBrowserTiming(Event $e)
    {
        $response = $e->getResponse();
        $content = $response->getBody();

        $browserTimingHeader = newrelic_get_browser_timing_header();
        $browserTimingFooter = newrelic_get_browser_timing_footer();

        $content = str_replace('<head>', '<head>' . $browserTimingHeader, $content);
        $content = str_replace('</body>', $browserTimingFooter . '</body>', $content);

        $response->setContent($content);
    }

    /**
     * Reports an error at this line of code, with complete stack trace.
     *
     * @param string $message
     * @param string $exception
     */
    public function noticeError($message, $exception = null)
    {
        if (!$this->extensionLoaded()) {
            return;
        }

        if (!$exception) {
            newrelic_notice_error($message);
        } else {
            newrelic_notice_error($message, $exception);
        }
    }

	/**
	 * Sets the transaction name
	 *
	 * @param string $name
	 */
	public function setTransactionName($name)
    {
        $this->transactionName = (string) $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getTransactionName()
    {
        return $this->transactionName;
    }

	/**
	 * Sets the name of the transaction
	 *
	 * @param string $name
	 */
	public function nameTransaction()
    {
        if (!$this->extensionLoaded()) {
            return;
        }
 
		newrelic_name_transaction($this->getTransactionName());
	}
}