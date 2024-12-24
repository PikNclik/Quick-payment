<?php

namespace App\Repositories\Eloquent;

use App\Models\Admin;
use App\Models\Bank;
use App\Models\BankTranslation;
use App\Models\Commission;
use App\Models\Setting;
use App\Models\TerminalBank;
use App\Models\TransactionToDo;
use App\Models\User;
use App\Models\WorkingDayHoliday;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Models\Audit;

class AuditRepository
{
    private $auditableTypeNames = [
        'App\Models\BankTranslation' => 'Bank',
        'App\Models\Bank' => 'Bank',
        'App\Models\User' => 'Merchant',
        'App\Models\TerminalBank' => 'Terminal Account',
        'App\Models\TransactionToDo' => 'Transaction To Do',
        'App\Models\WorkingDayHoliday' => 'Working Days',
        'App\Models\Setting' => 'Setting',
        'App\Models\Commission' => 'Commission',
    ];
    /**
     * AuditRepository constructor.
     * @param Audit $model
     */
    public function __construct(Audit $model) {}


    public function getAuditData($perPage, $filters = [], $sortKeys = ['id'], $sortDir = ['asc'], $isPaginate = true)
    {
        $auditableNames = $this->auditableTypeNames;
        $query = Audit::join('admins', function ($join) {
            $join->on('audits.user_id', '=', 'admins.id')
                ->where('audits.user_type', '=', Admin::class);
        })->leftJoin('bank_translations', function ($join) {
            $join->on('audits.auditable_id', '=', 'bank_translations.id')
                ->where('audits.auditable_type', '=', BankTranslation::class);
        })->leftJoin('commissions', function ($join) {
            $join->on('audits.auditable_id', '=', 'commissions.id')
                ->where('audits.auditable_type', '=', Commission::class);
        })->leftJoin('terminal_banks as internal', 'commissions.id', 'internal.internal_commission_id')
            ->leftJoin('terminal_banks as external', 'commissions.id', 'external.external_commission_id');

        // Apply filters
        $query->where("audits.user_type", Admin::class)->where('audits.new_values','!=','[]');
        foreach ($filters as $key => $value) {
            if ($key == "user_id") {
                $query->where($key, $value);
            } else if ($key == 'model') {
                if ($value == 'merchant') {
                    $query->where('auditable_type', User::class);
                } else if ($value == 'transaction_to_do') {
                    $query->where('auditable_type', TransactionToDo::class);
                } else if ($value == 'terminal_bank') {
                    $query->where('auditable_type', TerminalBank::class);
                } else if ($value == 'setting') {
                    $query->where('auditable_type', Setting::class);
                } else if ($value == 'workingDays') {
                    $query->where('auditable_type', WorkingDayHoliday::class);
                } else if ($value == 'bank') {
                    $query->whereIn('auditable_type', [BankTranslation::class, Bank::class]);
                } else if ($value == 'commission') {
                    $query->where('auditable_type', Commission::class);
                }
            } else if ($key == "id" && $value != null) {
                $query->where(function ($subQuery) use ($value) {
                    $subQuery->where(function ($q) use ($value) {
                        $q->where('audits.auditable_type', BankTranslation::class)
                            ->where('bank_translations.bank_id', $value);
                    })
                        ->orWhere(function ($q) use ($value) {
                            $q->where('audits.auditable_type', Commission::class)
                            ->where(function ($q1)  use ($value) {
                                $q1->where('internal.id',$value)->orWhere('external.id',$value) ;
                            });
                        })
                        ->orWhere(function ($q) use ($value) {
                            $q->whereNotIn('audits.auditable_type', [BankTranslation::class, Commission::class])
                                ->where('audits.auditable_id', '=', $value);
                        });
                });
            }
        }

        // Apply sorting
        foreach ($sortKeys as $key => $sortKey) {
            $sortDirection = $sortDir[$key] ?? 'ASC';
            $query->orderBy($sortKey, $sortDirection);
        }
        $query->select(
            'audits.id',
            'audits.user_type',
            'audits.user_id',
            'audits.event',
            'audits.auditable_type',
            DB::raw("CASE 
            WHEN audits.auditable_type = 'App\\\\Models\\\\Commission' and internal.id is not null  THEN 'Internal Commission'
            WHEN audits.auditable_type = 'App\\\\Models\\\\Commission' and external.id is not null  THEN 'External Commission'
            ELSE
             audits.auditable_type
            END AS auditable_type"),
            'audits.old_values',
            'audits.new_values',
            'audits.created_at',
            'audits.updated_at',
            DB::raw("CASE 
            WHEN audits.auditable_type = 'App\\\\Models\\\\BankTranslation' THEN bank_translations.bank_id
            WHEN audits.auditable_type = 'App\\\\Models\\\\Commission' THEN COALESCE(internal.id,external.id)
            ELSE
             audits.auditable_id
            END AS auditable_id"),
            'admins.username as user_name'
        );
        // Paginate results
        if ($isPaginate)
            return $query->paginate($perPage)->through(function ($audit) use ($auditableNames) {
                $audit->aud_type = $auditableNames[$audit->auditable_type] ?? $audit->auditable_type;
                return $audit;
            });
        else
            return $query->get()->map(function ($audit) use ($auditableNames) {
                $audit->aud_type = $auditableNames[$audit->auditable_type] ?? $audit->auditable_type;
                return $audit;
            });
    }
}
