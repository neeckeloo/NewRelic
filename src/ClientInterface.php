<?php

declare(strict_types=1);

namespace NewRelic;

interface ClientInterface
{
    /**
     * Returns true if newrelic extension is loaded.
     */
    public function extensionLoaded(): bool;

    /**
     * Sets the name of the application.
     */
    public function setAppName(string $name, string $license = null): void;

    /**
     * Returns the JavaScript string to inject as part of the header for browser timing.
     *
     * @param bool $flag This indicates whether or not surrounding script tags should be returned as part of the string.
     */
    public function getBrowserTimingHeader(bool $flag = true): ?string;

    /**
     * Returns the JavaScript string to inject as part of the footer for browser timing.
     *
     * @param bool $flag This indicates whether or not surrounding script tags should be returned as part of the string.
     */
    public function getBrowserTimingFooter(bool $flag = true): ?string;

    /**
     * Reports an error at this line of code, with complete stack trace.
     */
    public function noticeError(string $message, string $exception = null): void;

    /**
     * Sets the name of the transaction.
     */
    public function nameTransaction(string $name): void;

    /**
     * Stop recording the web transaction immediately.
     */
    public function endOfTransaction(): void;

    /**
     * Do not generate metrics for this transaction.
     */
    public function ignoreTransaction(): void;

    /**
     * Do not generate Adpex metrics for this transaction.
     */
    public function ignoreApdex(): void;

    /**
     * Whether to mark as a background job or web application.
     */
    public function backgroundJob(bool $flag = true): void;

    /**
     * Enable/disable capturing of URL parameters for displaying in transaction traces.
     */
    public function captureParams(bool $enabled = true): void;

    /**
     * Adds a custom metric with the specified name and value.
     */
    public function addCustomMetric(string $name, $value): void;

    /**
     * Add a custom parameter to the current web transaction with the specified value.
     */
    public function addCustomParameter(string $key, $value): void;

    /**
     * Add user defined functions or methods to the list to be instrumented.
     */
    public function addCustomTracer(string $name): void;

    /**
     * Prevents output filter from attempting to insert RUM Javascript.
     */
    public function disableAutorum(): void;
}
