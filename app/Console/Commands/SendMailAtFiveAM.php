<?php

namespace App\Console\Commands;

use App\Jobs\SendMailJob;
use App\Models\User;
use Illuminate\Console\Command;

class SendMailAtFiveAM extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-mail {email?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $email = $this->argument('email') ?? 'all';
        if($email == 'all'){
            $details = [
                'title' => 'Mail từ Laravel',
                'body' => 'Đây là email demo từ Laravel.'
            ];
        
            $users = User::all();
            foreach ($users as $user) {
                SendMailJob::dispatch($user->email);
            }
            $this->info('Gửi mail cho tất cả người dùng');
        }else{
            SendMailJob::dispatch($email);
            $this->info('Gửi mail cho người dùng '.$email);
        }
    }
}
