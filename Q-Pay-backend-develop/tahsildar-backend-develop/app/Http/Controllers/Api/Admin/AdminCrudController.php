<?php

namespace App\Http\Controllers\Api\Admin;

use App\Common\SharedMessages\ApiSharedMessage;
use App\Http\Controllers\BaseCrudController;
use App\Http\Requests\Admin\AdminRequest;
use App\Http\Requests\Admin\ChangePasswordRequest;
use App\Services\Admin\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminCrudController  extends BaseCrudController
{
    /** @var string */
    protected string $request = AdminRequest::class;

    protected array $with = ["role"];

    /**
     * AdminCrudController constructor.
     * @param AdminService $service
     */
    public function __construct(AdminService $service)
    {
        parent::__construct($service);
    }

    public function index()
    {
        $request = resolve($this->request);
        $filters = $request->all();
        if (!$request->hide_admin || $request->hide_admin != "false")
            $filters['hide_superadmin'] =  true;
        unset($filters['hide_admin']);
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

    public function update(int $id)
    {
        $request = resolve($this->request)->validated();

        if (!$request['password'])
            unset($request['password']);

        return $this->handleSharedMessage($this->service->update($id, $request));
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $user = Auth::user();

        if (!Hash::check($request->old_password, $user->password)) {
            return $this->handleSharedMessage(
                new ApiSharedMessage(__('errors.wrong_old_password'), [], false, null, 400)
            );
        }
        return $this->handleSharedMessage($this->service->update($user->id,['password' => $request->new_password]));
    }
}
