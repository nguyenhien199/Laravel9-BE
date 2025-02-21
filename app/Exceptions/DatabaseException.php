<?php

namespace App\Exceptions;

use Illuminate\Support\Facades\DB;

/**
 * Class DatabaseException
 * throw Exception if there is an error about Database/Query
 *
 * @package App\Exceptions
 */
class DatabaseException extends \RuntimeException
{
    /**
     * The Database Connection name.
     *
     * @var string
     */
    public string $connectionName;

    /**
     * The SQL for the query.
     *
     * @var string
     */
    protected string $sql = '';

    /**
     * The Bindings for the query.
     *
     * @var array
     */
    protected array $bindings = [];

    /**
     * The list Error info.
     *
     * @var array
     */
    protected array $errorInfo = [];

    /**
     * Create a new Database Exception instance.
     *
     * @link https://php.net/manual/en/exception.construct.php
     * @param string          $message  [optional] <p>The Exception message to throw.</p>
     * @param mixed           $code     [optional] <p>The Exception code.</p>
     * @param null|\Throwable $previous [optional] <p>The previous throwable used for the exception chaining.</p>
     */
    public function __construct(string $message = '', mixed $code = 0, \Throwable $previous = null)
    {
        parent::__construct('', 0, $previous);
        $this->code = $code;
        $this->message = $message;

        $this->connectionName = DB::getName();
        if ($previous instanceof \Illuminate\Database\QueryException) {
            if (method_exists($previous, 'getConnectionName')) {
                $this->connectionName = $previous->getConnectionName();
            }
            $this->code = $previous->getCode();
            $this->sql = $previous->getSql();
            $this->bindings = $previous->getBindings();
            $this->errorInfo = $previous->errorInfo;

            if (app_debug()) {
                $this->message = $previous->getMessage();
            }
            else {
                $this->message = $previous->getPrevious()->getMessage();
            }
        }
    }

    /**
     * Get the Connection name for the query.
     *
     * @return string
     */
    public function getConnectionName(): string
    {
        return $this->connectionName;
    }

    /**
     * Get the SQL for the query.
     *
     * @return string
     */
    public function getSql(): string
    {
        return $this->sql;
    }

    /**
     * Get the Bindings for the query.
     *
     * @return array
     */
    public function getBindings(): array
    {
        return $this->bindings;
    }

    /**
     * Get the list Error info for the query.
     *
     * @return array
     */
    public function getErrorInfo(): array
    {
        return $this->errorInfo;
    }
}
