<?php

namespace App\Traits;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;

trait ApiResponser
{
    /**
     * @param     $data
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function successResponse($data, $code = 200)
    {
        return response()->json($data, $code);
    }


    /**
     * @param     $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function errorResponse($message, $code = 401)
    {
        return response()->json(['data' => ['error' => $message, 'code' => $code]], $code);
    }

    /**
     * @param mixed $collection
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function showAll($collection, $transformer = null, $code = 200)
    {
        if (empty($collection) || is_array($collection)) {
            return $this->successResponse(['data' => $collection], $code);
        }

        //$collection = $this->filterData($collection);
        //$collection = $this->sortData($collection);
        //$collection = $this->paginate($collection);

        if($transformer){
            $collection = $this->transformData($collection, $transformer);
            return $this->successResponse($collection, $code);
        }

        $collection = $this->cacheResponse($collection);

        switch (get_class($collection)) {
            case 'Illuminate\Http\Resources\Json\AnonymousResourceCollection':
                //Laravel Resource
                return $collection->response()->setStatusCode($code);
                break;
            case 'Illuminate\Support\Collection':
                //Laravel Colletion
                return $this->successResponse($collection, $code);
                break;
            default:
                return $this->successResponse($collection, $code);
                break;
        }

    }


    /**
     * @param mixed $instance
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function showOne($instance, $code = 200)
    {
        if ($instance instanceof JsonResource){
            return $instance->response()->setStatusCode($code);
        }


        return $this->successResponse($instance, $code);

    }


    /**
     * @param     $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function showMessage($message, $code = 200, $result = null)
    {
        $response = [
            'data' => [
                'msj' => $message,
                'code' => $code
            ]
        ];
        if (!empty($result)) {
            $response['data']['result'] = $result;
        }
        return $this->successResponse($response, $code);
    }

    /**
     * @param Collection $collection
     * @return Collection
     */
    protected function filterData(Collection $collection)
    {
        foreach (request()->query() as $query => $value) {

            if (isset($value)) {
                $collection = $collection->where($query, $value);
            }
        }

        return $collection;
    }

    protected function sortData(Collection $collection)
    {
        if (request()->has('sort_by')) {

            $collection = $collection->sortBy->{request()->sort_by};
        }
        return $collection;
    }

    /**
     * @param Collection $collection
     * @return LengthAwarePaginator
     */
    protected function paginate(Collection $collection)
    {
        $rules = [
            'per_page' => 'integer|min:2|max:500'
        ];

        Validator::validate(request()->all(), $rules);

        $page = LengthAwarePaginator::resolveCurrentPage();

        $perPage = 15;
        if (request()->has('per_page')) {
            $perPage = (int) request()->per_page;
        }

        $results = $collection->slice(($page - 1) * $perPage, $perPage)->values();

        $paginated = new LengthAwarePaginator($results, $collection->count(), $perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
        ]);

        $paginated->appends(request()->all());

        return $paginated;
    }

    protected function transformData($data, $transformer)
    {
        $transformation = fractal($data, new $transformer);

        return $transformation->toArray();
    }

    protected function cacheResponse($data)
    {
        $useCache = request()->get('cache') === 'true';

        $url = request()->url();
        //Remove cache key from params
        $queryParams = array_diff_key(request()->query(), array_flip(array('cache')));

        ksort($queryParams);

        $queryString = http_build_query($queryParams);

        $fullUrl = "{$url}?{$queryString}";

        if($useCache)
        {
            return Cache::remember($fullUrl, 30/60, function() use($data) {
                return $data;
            });
        }
        else
        {
            Cache::put($fullUrl, $data, 30/60);
            return $data;
        }
    }
}
