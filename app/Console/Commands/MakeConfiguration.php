<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
class MakeConfiguration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:config';

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
        Artisan::call('migrate:refresh');
        $this->info(Artisan::output());
        Artisan::call('passport:install',['--force'=>true]);
        $this->info(Artisan::output());
$this->createAdmin();
    }

    public function createAdmin(){
        $data = [
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'employee_id'=>null,
            'password' =>bcrypt('123456'),
        ];
    
        $user = \App\Models\User::create($data);
    
        // Generate a token for the newly created user
        $token = $user->createToken('UserToken')->accessToken;
    
        return $this->info('success');
    }
}
