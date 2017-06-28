<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use UsersTableSeeder;

class ReseedDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:reseed {userCount}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reseeds the database with the specified number of random users';

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
     * @return mixed
     */
    public function handle()
    {
      $seeder = new UsersTableSeeder();
      $seeder->run($this->argument('userCount'));
    }
}
