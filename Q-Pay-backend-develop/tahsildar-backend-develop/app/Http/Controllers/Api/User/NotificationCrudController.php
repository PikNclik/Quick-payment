<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\BaseCrudController;
use App\Http\Requests\User\NotificationRequest;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Auth;

class NotificationCrudController extends BaseCrudController
{
    /** @var string */
    protected string $request = NotificationRequest::class;

    /**
     * NotificationCrudController constructor.
     * @param NotificationService $service
     */
    public function __construct(NotificationService $service)
    {
        parent::__construct($service);
    }
    public function index()
    {
        $request = resolve($this->request);
        $filters = $request->all();
        $filters['notifiable_id'] = Auth::id();
        $isPaginate = $request->isPaginate ?: "true";
        return $this->handleSharedMessage(
            $this->service->index(
                $this->columns,
                $this->with,
                $request->per_page ?? $this->length,
                $request->sort_keys ?? ['id'],
                $request->sort_dir ?? ['desc'],
                $filters,
                $this->searchableFields,
                $request->search ?? null,
                $this->searchInRelation,
                $request->withTrash ?? 0,
                $this->joinsArray,
                $isPaginate === 'true'
            )
        );
    }
}
