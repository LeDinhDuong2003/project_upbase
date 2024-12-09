<?php

namespace App\Jobs;

use App\Mail\TestEmail;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendMailJob implements ShouldQueue
{
    use Queueable;

    protected $email;
    public $tries = 3;  // Số lần thử lại khi job thất bại
    public $timeout = 120; // Thời gian timeout của job


    /**
     * Create a new job instance.
     */
    public function __construct($email)
    {
        $this->email = $email;
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        $details = [
            'title' => 'Mail từ Laravel',
            'body' => 'Đây là email demo từ Laravel.'
        ];
        try{
            Mail::to($this->email)->send(new TestEmail($details));
        }catch (\Exception $e){
            Log::error($e->getMessage());
        }
    }

    public function failed(Exception $exception)
    {
        // Gửi email thông báo lỗi
        Mail::to('ledinhduong802@gmail.com')->send(new TestEmail($exception));
        
        // Hoặc lưu log thông báo lỗi
        Log::error('Job failed: ' . $exception->getMessage());
    }
}
