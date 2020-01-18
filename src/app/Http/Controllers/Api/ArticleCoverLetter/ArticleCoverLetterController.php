<?php

namespace App\Http\Controllers\Api\ArticleCoverLetter;

use App\Constants\Constants;
use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleCoverLetter\ArticleCoverLetterUploadRequest;
use App\Services\Article\ArticleService;
use App\Services\CoverLetter\CoverLetterService;
use Illuminate\Support\Str;

class ArticleCoverLetterController extends Controller
{
    private $articleService;
    private $coverLetterService;

    public function __construct(
        ArticleService $articleService,
        CoverLetterService $coverLetterService
    ) {
        $this->articleService = $articleService;
        $this->coverLetterService = $coverLetterService;
    }

    public function store(ArticleCoverLetterUploadRequest $request)
    {
        $requestData = $request->validated();

        $id = Str::random(Constants::ID_LENGTH);

        $this->articleService->store(
            $id,
            $requestData['article']
        );
        $this->coverLetterService->store(
            $id,
            $requestData['coverLetter']
        );

        return $id;
    }
}
