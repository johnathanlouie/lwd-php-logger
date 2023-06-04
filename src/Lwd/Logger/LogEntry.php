<?php

namespace Lwd\Logger;

use DateTime;
use Exception;

/**
 * Data object for log entries.
 *
 * @author Johnathan Louie
 */
class LogEntry {

    /** @var string|null */
    public $message = null;

    /** @var string|null */
    public $level = null;

    /** @var DateTime|null */
    public $timestamp = null;

    /** @var Exception|null */
    public $exception = null;

    /** @var string|null String that classifies log messages. Also known as channels. */
    public $category = null;

    /** @var string|null */
    public $requestUrl = null;

    /** @var string|null */
    public $queryString = null;

    /** @var string|null */
    public $httpMethod = null;

    /** @var string|null */
    public $serverAddress = null;

    /** @var string|null */
    public $clientAddress = null;

    /** @var array */
    public $customFields = [];

}
