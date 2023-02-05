<?php

namespace App\Actions;

class FieldArrayDiffAction
{
    public function execute(array $array1, array $array2, array $fields): array
    {
        $difference = [];

        foreach ($array1 as $value1) {
            $found = false;
            foreach ($array2 as $value2) {
                $equalFields = true;
                foreach ($fields as $field) {
                    if ($value1[$field] != $value2[$field]) {
                        if (static::isValidJson($value1[$field])) {
                            if (json_decode($value1[$field], true) != $value2[$field]) {
                                $equalFields = false;
                            }
                        } else {
                            $equalFields = false;
                        }
                    }
                }

                if ($equalFields) {
                    $found = true;
                    break;
                }
            }
            if (! $found) {
                array_push($difference, $value1);
            }
        }

        return $difference;
    }

    private static function isValidJson($string)
    {
        json_decode($string);

        return json_last_error() === JSON_ERROR_NONE;
    }
}
