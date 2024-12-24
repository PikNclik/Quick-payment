<?php

namespace App\Services\Admin;

use App\Common\SharedMessages\ApiSharedMessage;
use App\Models\BankTranslation;
use App\Repositories\Eloquent\AuditRepository;
use App\Repositories\Eloquent\BankRepository;
use App\Repositories\Eloquent\BankTranslationRepository;
use App\Repositories\Eloquent\CityRepository;
use App\Repositories\Eloquent\ProfessionRepository;
use App\Repositories\Eloquent\SystemBankDataRepository;
use App\Services\BaseService;

class AuditService
{
    private AuditRepository $repository;
    private BankTranslationRepository $bankTranslationRepository;
    private string $modelName = "audit";

    public function __construct(AuditRepository $repository,
    BankTranslationRepository $bankTranslationRepository
     )
    {
        $this->repository = $repository;
        $this->bankTranslationRepository = $bankTranslationRepository;
    }

    public function getAuditData($perPage, $filters = [], $sortKeys = ['id'], $sortDir = ['asc'], $isPaginate = true): ApiSharedMessage
    {

        $auditData = $this->repository->getAuditData($perPage, $filters, $sortKeys, $sortDir, $isPaginate);
        foreach ($auditData as $entry) {
            $oldValues = $entry->old_values;
            $newValues = $entry->new_values;
            if($entry->auditable_type == 'App\\Models\\BankTranslation'){
                $bankTranslation= $this->bankTranslationRepository->findById($entry->auditable_id);
                if (array_key_exists('name', $oldValues)) {
                    $oldValues['name_'.$bankTranslation->locale]= $oldValues['name'];
                    unset($oldValues['name']);
                }
                if (array_key_exists('name', $newValues)) {
                    $newValues['name_'.$bankTranslation->locale]= $newValues['name'];
                    unset($newValues['name']);
                }

            }

            $this->getEntityNameById($oldValues,$newValues,'bank_id','bank', BankRepository::class);
            $this->getEntityNameById($oldValues,$newValues,'city_id','city', CityRepository::class);
            $this->getEntityNameById($oldValues,$newValues,'profession_id','profession', ProfessionRepository::class);
            $this->getEntityNameById($oldValues,$newValues,'system_bank_data_id','system_bank_data', SystemBankDataRepository::class,'bank_account_number');

            $entry->old_values = $oldValues;
            $entry->new_values = $newValues;
        }

        return new ApiSharedMessage(
            __('success.import', ['model' => $this->modelName]),
            $auditData,
            true,
            null,
            200
        );
    }

    private function getEntityNameById(&$oldValues,&$newValues,$entityId,$entityName,$repository,$displayedColumn="name"){

        if (array_key_exists($entityId, $oldValues)) {
            if (isset($oldValues[$entityId])) {
                $tmpName = resolve($repository)->findById($oldValues[$entityId])[$displayedColumn];
                $oldValues[$entityName] = $tmpName;
            } else {
                $oldValues[$entityName] = null;
            }
        }
        if (array_key_exists($entityId, $newValues)) {
            if (isset($newValues[$entityId])) {
                $tmpName = resolve($repository)->findById($newValues[$entityId])[$displayedColumn];
                $newValues[$entityName] = $tmpName;
            } else {
                $newValues[$entityName] = null;
            }
        }
        unset($oldValues[$entityId]);
        unset($newValues[$entityId]);

    }
}
