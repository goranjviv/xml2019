<?php

namespace App\Http\Controllers\Api\ArticleCoverLetter;

use App\Constants\Constants;
use App\Constants\UserConstants;
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

    public function index()
    {
        $editor = auth()->user() && auth()->user()['role'] === UserConstants::ROLE_EDITOR;

        // TODO: index only stuff that passed peer review
        // if not logged in

        $articles = $this->articleService->publicIndex();

        $response = array_map(function ($article, $id) use ($editor) {
            $retval = [
                'id' => $id,
                'article' => $article,
            ];

            if ($editor) {
                $retval['coverLetter'] = $this->coverLetterService->show($id);
            }

            return $retval;
        }, $articles, array_keys($articles));

        return $response;
    }
}
