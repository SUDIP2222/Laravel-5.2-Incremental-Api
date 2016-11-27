<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Illuminate\Contracts\Pagination\Paginator;
use App\Http\Requests;
use Illuminate\Http\Response as IlluminateResponse;


class ApiController extends Controller
{

    protected $statusCode=200;


    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param mixed $statusCode
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    public function respondNotFound($message='Not Found'){

        return $this->setStatusCode(IlluminateResponse::HTTP_NOT_FOUND)->respondWithError($message);
    }


    public function respond($data, $headers = [])
    {
        return \Response::json($data, $this->getStatusCode(), $headers);
    }

    public function respondWithError($message)
    {
        return $this->respond([
            'error' => [
                'message' => $message,
                'status_code' => $this->getStatusCode()
            ]
        ]);
    }


    public function respondInternalError($message="Internal Error"){   //return this->respondInternalError()
        return $this->setStatusCode(500)->respondWithError($message);
    }

    /**
     * @param $lessons
     * @return mixed
     */
    public function respondWithPagination(Paginator $lessons, $data)
    {

        $data = array_merge($data, [
            'paginator' => [
                'total_count' => $lessons->total(),
                'total_pages' => $lessons->lastPage(),
                'current_page' => $lessons->currentPage(),
                'limit' => $lessons->perPage(),

            ]
        ]);

        return $this->respond($data);
        /*return $this->respond([

            $data,
            'paginator' => [
                'total_count' => $lessons->total(),
                'total_pages' => $lessons->lastPage(),
                'current_page' => $lessons->currentPage(),
                'limit' => $lessons->perPage(),

            ],

        ]);*/
    }

    /**
     * @return mixed
     */
    public function respondCreated($message)
    {
        return $this->setStatusCode(201)->respond([
            'message' => $message
        ]);
    }


}
