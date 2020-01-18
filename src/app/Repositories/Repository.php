<?php

namespace App\Repositories;

use DOMDocument;
use Illuminate\Support\Facades\Storage;

class Repository
{
    private $documentPrefix;
    private $disk;
    private $path;

    public function __construct(string $documentPrefix)
    {
        $this->documentPrefix = $documentPrefix;
        var_dump(config('repositories.disk'));
        $this->disk = Storage::disk(config('repositories.disk'));
        $this->path = config('repositories.path');
    }

    // e.g. comparatorFn: (fieldValue, value) => fieldValue === value;
    public function getBy(array $fieldNames, array $values, callable $comparatorFn)
    {
        $results = [];

        // filenames in $this->path . '/' . $this->documentPrefix
        $files = $this->disk->files($this->path . '/' . $this->documentPrefix);
        foreach ($files as $file) {
            $fileContent =  $this->disk->get($file);
            // create xml handler from fileContent
            $xml = DOMDocument::loadXML($fileContent);
            // TODO: field values
            $fieldValues = [];
            $fits = true;
            foreach ($fieldValues as $index => $fieldValue) {
                if (!$comparatorFn($fieldValue, $values[$index])) {
                    $fits = false;
                    break;
                }
            }

            if ($fits) {
                $results[$file] = $fileContent;
            }
        }


        return count($results)
            ? $results
            : null;
    }

    public function getOne(array $fieldNames, array $values, callable $comparatorFn)
    {
        $results = $this->getBy($fieldNames, $values, $comparatorFn);

        return $results
            ? $results[0]
            : null;
    }

    public function save(string $id, string $fileContents)
    {
        // TODO: validate the file contents against xml schema

        // write the file contents
        $this->disk->put(
            $this->path . '/' . $this->documentPrefix . '/' . $id,
            $fileContents
        );

        return $id;
    }
}
