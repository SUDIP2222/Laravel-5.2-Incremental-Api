<?php

namespace App\Http\Controllers;

use App\Lesson;
use Illuminate\Http\Request;
use App\Acme\Transformers\LessonTransformer;
use App\Http\Requests;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Input;
use Symfony\Component\HttpFoundation\Response;

class LessonsController extends ApiController
{
    protected $lessonTransformer;

    /**
     * LessonsController constructor.
     * @param $lessonTransformer
     */
    public function __construct(LessonTransformer $lessonTransformer)
    {
        $this->lessonTransformer = $lessonTransformer;

        $this->middleware('auth.basic', ['only' => 'store']);


    }

    public function index(){

        // 1. all is bad -> lesson-12
        // 2. no way to attach meta data -> lesson-3
        // 3. Linking db structure to the API OutPut ->lesson -4-5
        // 4. no way to signal headers/response code

        //return Lesson::all(); //really bad practice
        $limit=Input::get('limit') ?: 3;
        $lessons=Lesson::paginate($limit);
        //dd(get_class_methods($lessons));

        return $this->respondWithPagination($lessons,[
            'data'=>$this->lessonTransformer->transformCollection($lessons->all()),
        ]);

    }

    public function show($id){

        $lesson=Lesson::find($id);

        if(! $lesson){

            return $this->respondNotFound('Lesson does not exist');
            /*return \Response::json([
                'error'=>[
                    'message'=>'Lesson does not exist',
                ]
            ],404);*/
        }

        return $this->respond([
            'data'=> $this->lessonTransformer->transform($lesson),
        ]);

    }

    public function store(Request $request){

        //dd('store');

        if(!Input::get('title') or !Input::get('body')) {

            return $this->setStatusCode(422)->respondWithError('Parameters failed validation for a lesson.');
        }

        Lesson::create($request->all());

        return $this->respondCreated('Lesson successfully created.');
    }





    /*public function transformCollcetion($lessons){
        return array_map([$this,'transform'],$lessons->toArray());
    }*/


   /* public function transform($lesson){

        return [
            'title'=>$lesson['title'],
            'body'=>$lesson['body'],
            'active'=>(boolean)$lesson['some_bool']
        ];

    }*/
}
