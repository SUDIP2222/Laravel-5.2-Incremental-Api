<?php

namespace App\Http\Controllers;

use App\Lesson;
use App\Tag;
use Illuminate\Http\Request;
use App\Acme\Transformers\TagTransformer;
use App\Http\Requests;

class TagsController extends ApiController
{
    protected $tagTransformer;

    public function __construct(TagTransformer $tagTransformer)
    {
        $this->tagTransformer = $tagTransformer;
    }

    public function index($lessonId=null){

        $tags = $this->getTags($lessonId);

        return $this->respond([
            'data' => $this->tagTransformer->transformCollection($tags->all())
        ]);
    }

    /**
     * @param $lessonId
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getTags($lessonId)
    {
        return $lessonId ? Lesson::findOrFail($lessonId)->tags : Tag::all();

    }
}
