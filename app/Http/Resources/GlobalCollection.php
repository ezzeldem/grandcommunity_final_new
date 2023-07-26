<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Route;

class GlobalCollection extends ResourceCollection
{
    private $pagination;
    private $base_name;

    public function __construct($resource, $collects)
    {
        $str = class_basename($collects);
        if(isset($str)){
            $this->base_name = strtolower(trim(preg_replace('/[A-Z]/', '_$0', $str),'_Resource')).'s';
        }else{
            $this->base_name = 'data';
        }

        if($resource instanceof LengthAwarePaginator){
            $queries = array();
            if(isset($_SERVER['QUERY_STRING'])){
                parse_str($_SERVER['QUERY_STRING'], $queries);
                if(isset($queries['page']))
                    unset($queries['page']);
            }
            $this->pagination = [
                'total' => $resource->total(),
                'count' => $resource->count(),
                'per_page' => $resource->perPage(),
                'next_page_url' => handleQueryInPagination($resource->nextPageUrl(),$queries),
                'prev_page_url' => handleQueryInPagination($resource->previousPageUrl(),$queries),
                'current_page' => $resource->currentPage(),
                'last_page' => $resource->lastPage(),
                'currentRoute' => Route::currentRouteName(),
            ];
            $resource = $resource->getCollection();
        }else{
            $this->pagination =[];
        }

        $this->collects = $collects;
        parent::__construct($resource);
    }
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data[$this->base_name] = $this->collection->values();
        if(count($this->pagination)>0){
            $data['pagination'] = $this->pagination;
        }
        return $data;
    }
}
