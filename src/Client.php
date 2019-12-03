<?php
namespace NewRelic;

class Client implements ClientInterface
{
    public function extensionLoaded(): bool
    {
        return \extension_loaded('newrelic');
    }

    public function setAppName(string $name, string $license = null): void
    {
        if (!$this->extensionLoaded()) {
            return;
        }

        $params = [$name];

        if ($license) {
            $params['license'] = $license;
        }

        \call_user_func_array('newrelic_set_appname', $params);
    }

    public function getBrowserTimingHeader(bool $flag = true): ?string
    {
        if (!$this->extensionLoaded()) {
            return null;
        }

        return \newrelic_get_browser_timing_header($flag);
    }

    public function getBrowserTimingFooter(bool $flag = true): ?string
    {
        if (!$this->extensionLoaded()) {
            return null;
        }

        return \newrelic_get_browser_timing_footer($flag);
    }

    public function noticeError(string $message, string $exception = null): void
    {
        if (!$this->extensionLoaded()) {
            return;
        }

        if (!$exception) {
            \newrelic_notice_error($message);
        } else {
            \newrelic_notice_error($message, $exception);
        }
    }

    public function nameTransaction(string $name): void
    {
        if ($this->extensionLoaded()) {
            \newrelic_name_transaction($name);
        }
    }

    public function endOfTransaction(): void
    {
        if ($this->extensionLoaded()) {
            \newrelic_end_of_transaction();
        }
    }

    public function ignoreTransaction(): void
    {
        if ($this->extensionLoaded()) {
            \newrelic_ignore_transaction();
        }
    }

    public function ignoreApdex(): void
    {
        if ($this->extensionLoaded()) {
            \newrelic_ignore_apdex();
        }
    }

    public function backgroundJob(bool $flag = true): void
    {
        if ($this->extensionLoaded()) {
            \newrelic_background_job($flag);
        }
    }

    public function captureParams(bool $enabled = true): void
    {
        if ($this->extensionLoaded()) {
            \newrelic_capture_params($enabled);
        }
    }

    public function addCustomMetric(string $name, $value): void
    {
        if ($this->extensionLoaded()) {
            \newrelic_custom_metric($name, $value);
        }
    }

    public function addCustomParameter(string $key, $value): void
    {
        if ($this->extensionLoaded()) {
            \newrelic_add_custom_parameter($key, $value);
        }
    }

    public function addCustomTracer(string $name): void
    {
        if ($this->extensionLoaded()) {
            \newrelic_add_custom_tracer($name);
        }
    }

    public function disableAutorum(): void
    {
        if ($this->extensionLoaded()) {
            \newrelic_disable_autorum();
        }
    }
}
