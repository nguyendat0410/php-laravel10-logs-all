<?php

namespace Core;

use Core\Exceptions\PopulateInvalidFieldException;

trait Entity {
    /**
     * @throws PopulateInvalidFieldException
     */
    public function populate(array $inputData  = []): void
    {
        foreach ($inputData as $propertyName => $propertyValue) {
            if (!property_exists(static::class, $propertyName)) {
                throw new PopulateInvalidFieldException(
                    sprintf('assigning on non-existing property (%s) at %s', $propertyName, __CLASS__),
                    __CLASS__,
                    $propertyName
                );
            }
            $this->{$propertyName} = $propertyValue;
        }
    }
}
