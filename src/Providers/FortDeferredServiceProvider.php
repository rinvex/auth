<?php

declare(strict_types=1);

namespace Rinvex\Fort\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;
use Rinvex\Fort\Console\Commands\SeedCommand;
use Rinvex\Fort\Console\Commands\MigrateCommand;
use Rinvex\Fort\Console\Commands\MakeAuthCommand;
use Rinvex\Fort\Services\PasswordResetBrokerManager;
use Rinvex\Fort\Services\EmailVerificationBrokerManager;

class FortDeferredServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        // Register bindings
        $this->registerPasswordBroker();
        $this->registerBladeExtensions();
        $this->registerVerificationBroker();

        // Register console commands
        ! $this->app->runningInConsole() || $this->registerCommands();
    }

    /**
     * Register the password broker.
     *
     * @return void
     */
    protected function registerPasswordBroker()
    {
        $this->app->singleton('auth.password', function ($app) {
            return new PasswordResetBrokerManager($app);
        });

        $this->app->bind('auth.password.broker', function ($app) {
            return $app->make('auth.password')->broker();
        });
    }

    /**
     * Register the verification broker.
     *
     * @return void
     */
    protected function registerVerificationBroker()
    {
        $this->app->singleton('rinvex.fort.emailverification', function ($app) {
            return new EmailVerificationBrokerManager($app);
        });

        $this->app->bind('rinvex.fort.emailverification.broker', function ($app) {
            return $app->make('rinvex.fort.emailverification')->broker();
        });
    }

    /**
     * Register the blade extensions.
     *
     * @return void
     */
    protected function registerBladeExtensions()
    {
        $this->app->afterResolving('blade.compiler', function (BladeCompiler $bladeCompiler) {

            // @role('writer') / @hasrole(['writer', 'editor'])
            $bladeCompiler->directive('role', function ($roles) {
                return "<?php if(auth()->user()->hasRole({$roles})): ?>";
            });
            $bladeCompiler->directive('endrole', function () {
                return '<?php endif; ?>';
            });

            // @hasrole('writer') / @hasrole(['writer', 'editor'])
            $bladeCompiler->directive('hasrole', function ($roles) {
                return "<?php if(auth()->user()->hasRole({$roles})): ?>";
            });
            $bladeCompiler->directive('endhasrole', function () {
                return '<?php endif; ?>';
            });

            // @hasanyrole(['writer', 'editor'])
            $bladeCompiler->directive('hasanyrole', function ($roles) {
                return "<?php if(auth()->user()->hasAnyRole({$roles})): ?>";
            });
            $bladeCompiler->directive('endhasanyrole', function () {
                return '<?php endif; ?>';
            });

            // @hasallroles(['writer', 'editor'])
            $bladeCompiler->directive('hasallroles', function ($roles) {
                return "<?php if(auth()->user()->hasAllRoles({$roles})): ?>";
            });
            $bladeCompiler->directive('endhasallroles', function () {
                return '<?php endif; ?>';
            });
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'auth.password',
            'rinvex.fort.emailverification',
            \Illuminate\Contracts\Debug\ExceptionHandler::class,
        ];
    }

    /**
     * Register console commands.
     *
     * @return void
     */
    protected function registerCommands()
    {
        if (config('rinvex.fort.boot.override_makeauth_command')) {
            $this->app->singleton('command.auth.make', function ($app) {
                return new MakeAuthCommand();
            });
            $this->commands('command.auth.make');
        }

        $this->app->singleton('command.rinvex.fort.migrate', function ($app) {
            return new MigrateCommand();
        });

        $this->commands('command.rinvex.fort.migrate');

        $this->app->singleton('command.rinvex.fort.seed', function ($app) {
            return new SeedCommand();
        });

        $this->commands('command.rinvex.fort.seed');
    }
}
