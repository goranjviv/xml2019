<?php

namespace App\Services\CoverLetter;

use App\Constants\Constants;
use App\Repositories\Repository;
use Illuminate\Http\UploadedFile;

class CoverLetterService
{
    private $coverLetterRepo;

    public function __construct()
    {
        $this->coverLetterRepo = new Repository(Constants::PREFIX_COVER_LETTER);
    }

    public function store(string $id, UploadedFile $coverLetter)
    {
        // store the file in a repo
        return $this->coverLetterRepo->save($id, $coverLetter->get());
    }
}
