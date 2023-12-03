<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MenuResource extends ResourceCollection
{
    private string $resourceName;
    public function __construct($resource,string $resourceName)
    {
        parent::__construct($resource);
        $this->resourceName = $resourceName;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = ['data' => $this->resourceName::collection($this->collection)];
        $pagination = new PaginationDataResource($this);
        $pagination_data = $pagination->toArray($this);
        return array_merge($data,$pagination_data);
    }
}
