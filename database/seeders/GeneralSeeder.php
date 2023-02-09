<?php

namespace Database\Seeders;

use App\Actions\FieldArrayDiffAction;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class GeneralSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(string $class, array $fields, array $data, bool $hasRelationships, bool $addTimestamps, FieldArrayDiffAction $fieldArrayDiffAction)
    {
        $allFields = [];

        foreach ($data as $entry) {
            foreach ($entry as $fieldKey => $fieldValue) {
                $allFields[$fieldKey] = $fieldKey;
            }
        }

        $timestamps = ['created_at' => Carbon::now(), 'updated_at' => Carbon::now()];

        $data = array_map(function ($entry) use ($allFields, $timestamps, $addTimestamps) {
            if ($addTimestamps) {
                foreach ($timestamps as $timestampKey => $timestampValue) {
                    if (! array_key_exists($timestampKey, $entry)) {
                        $entry[$timestampKey] = $timestampValue;
                    }
                }
            }

            foreach ($allFields as $field) {
                if (! array_key_exists($field, $entry)) {
                    $entry[$field] = null;
                }
            }

            return $entry;
        }, $data);

        $query = null;

        foreach ($data as $entry) {
            $whereFields = [];

            foreach ($fields as $field) {
                array_push($whereFields, [$field, '=', $entry[$field]]);
            }

            if (is_null($query)) {
                $query = $class::select($fields)->where($whereFields);
            } else {
                $query->orWhere($whereFields);
            }
        }

        $existingData = $query->get()->toArray();

        $data = $fieldArrayDiffAction->execute($data, $existingData, $fields);

        if ($hasRelationships) {
            foreach ($data as $entry) {
                $relationships = [];
                if (array_key_exists('relationships', $entry)) {
                    if (! is_null($entry['relationships'])) {
                        $relationships = $entry['relationships'];
                    }
                    unset($entry['relationships']);
                }

                $item = $class::create($entry);

                foreach ($relationships as $relationship => $relationModels) {
                    $item->{$relationship}()->attach($relationModels);
                }

                $item->save();
            }
        } else {
            $class::insert($data);
        }
    }
}
