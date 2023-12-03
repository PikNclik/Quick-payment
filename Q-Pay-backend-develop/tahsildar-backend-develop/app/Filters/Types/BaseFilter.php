<?php

namespace App\Filters\Types;

/**
 * Class BaseFilter
 * @package App\Filters\Types
 */
class BaseFilter
{
    /** @var string */
    protected string $columnName;

    /** @var string */
    protected string $operator;

    /**
     * BaseFilter constructor.
     * @param string $columnName
     * @param string $operator
     */
    public function __construct(string $columnName, string $operator = '=')
    {
        $this->columnName = $columnName;
        $this->operator = $operator;
    }

    /**
     * @param array $filters
     * @return mixed|null
     */
    protected function checkColumnExisting(array $filters)
    {
        return isset($filters[$this->columnName]) ? $filters[$this->columnName] : null;
    }
}
