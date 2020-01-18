<?php

namespace App\Services\Article;

use App\Constants\Constants;
use App\Repositories\Repository;
use Illuminate\Http\UploadedFile;

class ArticleService
{
    private $articleRepo;

    public function __construct()
    {
        $this->articleRepo = new Repository(Constants::PREFIX_ARTICLE);
    }

    public function store(string $id, UploadedFile $article)
    {
        // store the file in a repo
        return $this->articleRepo->save($id, $article->get());
    }

    public function publicIndex()
    {
        return $this->articleRepo->getAll();
    }
}
