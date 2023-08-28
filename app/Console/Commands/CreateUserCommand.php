<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class CreateUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create {--name=} {--email=} {--password=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a New User';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->option('email');
        if ($email) {
            if (User::where('email', $email)->exists()) {
                $this->error('Try Another Email.');
                return 0;
            }
        }
        $randomText = Str::random(6);
        $name = $this->option('name') ?? $randomText;
        $email = $email ?? $randomText;
        $password = $this->option('password') ?? Str::random(12);
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password)
        ]);
        $this->info(
            'created user Name: ' . $user->name . ' Email: ' . $user->email . ' Password: ' . $password
        );
        return 1;
    }
}
