<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class MultiCallEndPoint extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'multisend:post
                            { --request= : number of requests  }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Multiple POST requests to the site https://atomic.incfile.com/fakepost';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Initiate multiple POST requests to endpoint https://atomic.incfile.com/fakepost');
        if($this->option('request')){
            $request = $this->option('request');
            $this->info("number request $request");
            for($x = 0; $x <= $request; $x++){
                $response = Http::retry(2, 100)->post(
                    'https://atomic.incfile.com/fakepost',
                    [
                        'user' => 'angel.alvarez',
                        'password' => '123464879'
                    ]
                );
                if($response->clientError()){
                    $this->error("Error {$response->status()}");
                }
                else if($response->successful()){
                    $this->info($response->body());
                    $this->line("success");
                }
                else if ($response->serverError()){
                    $this->info($response->status());
                    $this->line("error in server");
                }
            }
        }
        else {
            $this->info('No request was entered, default number is executed');
            for($x = 0; $x <= 100; $x++){
                $response = Http::retry(2, 100)->post(
                    'https://atomic.incfile.com/fakepost',
                    [
                        'user' => 'angel.alvarez',
                        'password' => '123464879'
                    ]
                );
                if($response->clientError()){
                    $this->error("Error {$response->status()}");
                }
                else if($response->successful()){
                    $this->info($response->body());
                    $this->line("success");
                }
                else if ($response->serverError()){
                    $this->info($response->status());
                    $this->line("error in server");
                }
            }
        }

    }
}
