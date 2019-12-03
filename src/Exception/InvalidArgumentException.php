<?php

declare(strict_types=1);

namespace NewRelic\Exception;

class InvalidArgumentException
    extends \InvalidArgumentException
    implements ExceptionInterface
{}
