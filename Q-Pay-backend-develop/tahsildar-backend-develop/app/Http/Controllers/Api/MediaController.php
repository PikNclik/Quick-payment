<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\UploadMediaUrlRequest;
use App\Http\Requests\UploadMediaRequest;
use App\Http\Controllers\BaseController;
use App\Services\Shared\MediaService;
use Illuminate\Http\JsonResponse;

/**
 * Class MediaController
 * @package App\Http\Controllers
 */
class MediaController extends BaseController
{
    /** @var MediaService */
    protected MediaService $service;

    /**
     * MediaController constructor.
     * @param MediaService $service
     */
    public function __construct(MediaService $service)
    {
        $this->service = $service;
    }

    /**
     * @param UploadMediaRequest $request
     * @return JsonResponse
     */
    public function uploadMedia(UploadMediaRequest $request): JsonResponse
    {
        return $this->handleSharedMessage($this->service->uploadMedia($request->file('files')));
    }

    /**
     * @param UploadMediaUrlRequest $request
     * @return JsonResponse
     */
    public function uploadMediaFromUrl(UploadMediaUrlRequest $request): JsonResponse
    {
        return $this->handleSharedMessage($this->service->uploadMediaFromUrl($request->get('media_urls')));
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function deleteMedia($id): JsonResponse
    {
        return $this->handleSharedMessage($this->service->deleteMedia($id));
    }
}
