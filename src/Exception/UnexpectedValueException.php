<?php

declare(strict_types=1);

namespace NewRelic\Exception;

class UnexpectedValueException
    extends \UnexpectedValueException
    implements ExceptionInterface
{}
