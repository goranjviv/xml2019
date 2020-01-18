<?php

namespace App\Repositories;

use DOMDocument;
use Illuminate\Support\Facades\Storage;

class Repository
{
    private $disk;
    private $path;

    public function __construct(string $documentPrefix)
    {
        $this->disk = Storage::disk(config('repositories.disk'));
        $this->path = config('repositories.path') . '/' . $documentPrefix;
    }

    public function getById(string $id)
    {
        $filePath = $this->path . '/' . $id;

        return $this->disk->exists($filePath)
            ? $this->disk->get($filePath)
            : null;
    }

    // e.g. comparatorFn: (fieldValue, value) => fieldValue === value;
    public function getBy(array $fieldNames, array $values, callable $comparatorFn)
    {
        $results = [];

        // filenames in $this->path
        $files = $this->disk->files($this->path);
        foreach ($files as $file) {
            $fileContent =  $this->disk->get($file);
            // TODO: create xml handler from fileContent
            // $domDocument = new DOMDocument;
            // $domDocument->loadXML($fileContent);
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
                $results[last(explode('/', $file))] = $fileContent;
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

    public function getAll()
    {
        return $this->getBy([], [], function ($fieldValue, $value) {
            return true;
        });
    }

    public function save(string $id, string $fileContents)
    {
        // TODO: validate the file contents against xml schema

        // write the file contents
        $this->disk->put(
            $this->path . '/' . $id,
            $fileContents
        );

        return $id;
    }
}
