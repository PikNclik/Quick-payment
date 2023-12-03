<?php

namespace App\Services\Shared;

use App\Common\SharedMessages\ApiSharedMessage;
use App\Repositories\Eloquent\MediaRepository;

class MediaService
{
    /** @var MediaRepository */
    protected MediaRepository $repository;

    /**
     * MediaService constructor.
     * @param MediaRepository $repository
     */
    public function __construct(MediaRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $payload
     * @return ApiSharedMessage
     */
    public function uploadMedia($payload)
    {
        return new ApiSharedMessage(__('success.store', ['model' => 'media']),
            $this->repository->uploadMedia($payload),
            true,
            null,
            200
        );
    }

    /**
     * @param $urls
     * @return ApiSharedMessage
     */
    public function uploadMediaFromUrl($urls)
    {
        return new ApiSharedMessage(__('success.store', ['model' => 'media']),
            $this->repository->uploadMediaFromUrl($urls),
            true,
            null,
            200
        );
    }

    /**
     * @param $id
     * @return ApiSharedMessage
     */
    public function deleteMedia($id)
    {
        return new ApiSharedMessage(__('success.store', ['model' => 'media']),
            $this->repository->deleteMedia($id),
            true,
            null,
            200
        );
    }
}
