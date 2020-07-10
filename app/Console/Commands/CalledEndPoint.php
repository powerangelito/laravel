<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;

class CalledEndPoint extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:post
                            { --fake : fake tests }
                            { --true : true functionality }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'POST request to site https://atomic.incfile.com/fakepost';

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
        $this->info('Initiate POST request to endpoint https://atomic.incfile.com/fakepost');
        if($this->option('fake')){
            Http::fake([
                // We spoof requests to endpoints of 'https: //atomic.incfile.com/fakepost ...
                'https://atomic.incfile.com/fakepost' => Http::response(['message' => 'Access Correct'], 200, ['Headers']),
            ]);
            $response = Http::post(
                'https://atomic.incfile.com/fakepost',
                [
                    'user' => 'angel.alvarez',
                    'password' => '123464879'
                ]
            );
            $this->info($response->body());
            $this->line("success");
        }
        else {
            $response = Http::post(
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
