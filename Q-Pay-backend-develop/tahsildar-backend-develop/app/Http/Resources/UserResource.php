<?php

namespace App\Http\Resources;

use App\Definitions\PaymentStatus;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|\JsonSerializable
     */
    public function toArray($request): array|\JsonSerializable|Arrayable
    {
        $data =  parent::toArray($request);
        $data['paid_amount'] = $this->whenLoaded('payments',$this->payments->where('status',PaymentStatus::PAID)->sum('amount'));
        $data['pending_amount'] = $this->whenLoaded('payments',$this->payments->where('status',PaymentStatus::PENDING)->sum('amount'));
        $data['settled_amount'] = $this->whenLoaded('payments',$this->payments->where('status',PaymentStatus::SETTLED)->sum('amount'));
        unset($data['payments']);
        return $data;
    }
}
