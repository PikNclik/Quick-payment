<?php

namespace App\Jobs;

use App\Services\Shared\SmsService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendSmsToPhone implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $phone,$message;
    protected SmsService $service;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($phone,$message)
    {
        $this->phone = $phone;
        $this->message = $message;
        $this->service = new SmsService();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->service->sendSms($this->phone,$this->message);
    }
}
