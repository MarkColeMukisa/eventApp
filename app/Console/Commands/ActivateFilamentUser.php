<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class ActivateFilamentUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:activate-filament-user
                            {email : The user email to activate}
                            {--verify : Also mark the email as verified}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Activate a Filament user for production access';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $email = (string) $this->argument('email');

        $user = User::query()
            ->where('email', $email)
            ->first();

        if (! $user) {
            $this->error("User not found for email: {$email}");

            return self::FAILURE;
        }

        $user->is_active = true;

        if ($this->option('verify') && blank($user->email_verified_at)) {
            $user->email_verified_at = now();
        }

        $user->save();

        $this->info("User {$email} is now active.");

        if ($this->option('verify')) {
            $this->info('Email has been marked as verified.');
        }

        return self::SUCCESS;
    }
}
