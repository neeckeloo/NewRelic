<?php
namespace NewRelic;

interface ModuleOptionsInterface
{
    public function setApplicationName(string $name = null): self;

    public function getApplicationName(): ?string;

    public function setLicense(string $license = null): self;

    public function getLicense(): ?string;

    public function setBrowserTimingEnabled(bool $enabled): self;

    public function getBrowserTimingEnabled(): bool;

    public function setBrowserTimingAutoInstrument(bool $enabled): self;

    public function getBrowserTimingAutoInstrument(): bool;

    public function setExceptionsLoggingEnabled(bool $enabled): self;

    public function getExceptionsLoggingEnabled(): bool;

    public function setIgnoredTransactions(array $transactions): self;

    public function getIgnoredTransactions(): array;

    public function setBackgroundJobs(array $transactions): self;

    public function getBackgroundJobs(): array;

    public function setIgnoredApdex(array $transactions): self;

    public function getIgnoredApdex(): array;

    public function setListeners(array $listeners): self;

    public function getListeners(): array;

    public function setTransactionNameProvider(string $provider): self;

    public function getTransactionNameProvider(): ?string;
}
