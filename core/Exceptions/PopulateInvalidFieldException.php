<?php

namespace Core\Exceptions;

use Exception;

class PopulateInvalidFieldException extends Exception
{
    private string $entityClass;
    private string $propertyName;

    function __construct(string $message, string $entityClass, string $propertyName)
    {
        $this->entityClass = $entityClass;
        $this->propertyName = $propertyName;
        $this->message = $message;

        parent::__construct($message);
    }

    /**
     * @return string
     */
    public function getEntityClass(): string
    {
        return $this->entityClass;
    }

    /**
     * @return string
     */
    public function getPropertyName(): string
    {
        return $this->propertyName;
    }

}
