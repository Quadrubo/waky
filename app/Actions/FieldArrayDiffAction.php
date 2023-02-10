<?php

namespace App\Actions;

use Illuminate\Support\Str;

class FieldArrayDiffAction
{
    public function execute(array $newData, array $existingData, array $fields): array
    {
        $difference = [];

        // Loop first array
        foreach ($newData as $newDataKey => $newDataValue) {
            $matches = null;

            // Loop second array
            foreach ($existingData as $existingDataKey => $existingDataValue) {
                $fieldsMatch = true;

                // Loop fields
                foreach ($fields as $fieldKey => $field) {
                    if ($newDataValue[$field] !== $existingDataValue[$field]) {
                        if (gettype($newDataValue[$field]) == 'string') {
                            // Json check
                            if (Str::isJson($newDataValue[$field])) {
                                if (json_decode($newDataValue[$field], true) != $existingDataValue[$field]) {
                                    $fieldsMatch = false;
                                }
                            } else {
                                $fieldsMatch = false;
                            }
                        } else {
                            $fieldsMatch = false;
                        }
                    }
                }

                if ($fieldsMatch) {
                    $matches = true;
                    break;
                } else {
                    $matches = false;
                }
            }

            if (! $matches) {
                array_push($difference, $newDataValue);
            }
        }

        return $difference;
    }
}
