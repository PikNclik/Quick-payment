<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaginationDataResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'current_page' => $this->currentPage(),
            "next_page_url" => $this->nextPageUrl(),
            "path" => $this->path(),
            "per_page" => $this->perPage(),
            "prev_page_url" => $this->previousPageUrl(),
            "to" => $this->lastItem(),
            "total" => $this->total(),
            "first_page_url" => $this->url(1),
            "from" => $this->firstItem(),
            "last_page" => $this->lastPage(),
            "last_page_url" => $this->url($this->lastPage()),
        ];
    }
}
