<?php

/*
 * NOTICE OF LICENSE
 *
 * Part of the Rinvex Fort Package.
 *
 * This source file is subject to The MIT License (MIT)
 * that is bundled with this package in the LICENSE file.
 *
 * Package: Rinvex Fort Package
 * License: The MIT License (MIT)
 * Link:    https://rinvex.com
 */

namespace Rinvex\Fort\Providers;

use Collective\Html\FormFacade;
use Collective\Html\HtmlFacade;
use Rinvex\Fort\Services\AccessGate;
use Illuminate\Foundation\AliasLoader;
use Rinvex\Repository\Traits\Bindable;
use Rinvex\Fort\Services\BrokerManager;
use Illuminate\Support\ServiceProvider;
use Collective\Html\HtmlServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;
use Rinvex\Fort\Repositories\RoleRepository;
use Rinvex\Fort\Repositories\UserRepository;
use Rinvex\Fort\Repositories\AbilityRepository;
use Laravel\Socialite\SocialiteServiceProvider;
use Rinvex\Fort\Console\Commands\UserFindCommand;
use Rinvex\Fort\Console\Commands\RoleFindCommand;
use Rinvex\Fort\Console\Commands\RoleCreateCommand;
use Rinvex\Fort\Console\Commands\RoleUpdateCommand;
use Rinvex\Fort\Repositories\PersistenceRepository;
use Rinvex\Fort\Console\Commands\UserCreateCommand;
use Rinvex\Fort\Console\Commands\UserRemindCommand;
use Rinvex\Fort\Console\Commands\UserUpdateCommand;
use Rinvex\Fort\Console\Commands\AbilityFindCommand;
use Rinvex\Fort\Console\Commands\AbilityCreateCommand;
use Rinvex\Fort\Console\Commands\UserAssignRoleCommand;
use Rinvex\Fort\Console\Commands\UserRemoveRoleCommand;
use Rinvex\Fort\Console\Commands\UserGiveAbilityCommand;
use Rinvex\Fort\Console\Commands\RoleGiveAbilityCommand;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Rinvex\Fort\Console\Commands\RoleRevokeAbilityCommand;
use Rinvex\Fort\Console\Commands\UserRevokeAbilityCommand;
use Rinvex\Fort\Console\Commands\PasswordTokenClearCommand;
use Rinvex\Fort\Console\Commands\VerificationTokenClearCommand;
use Rinvex\Fort\Console\Commands\AbilityUpdateCommand\AbilityUpdateCommand;

class FortDeferredServiceProvider extends ServiceProvider
{
    use Bindable;

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $commands = [

        'command.rinvex.fort.ability.find'   => AbilityFindCommand::class,
        'command.rinvex.fort.ability.update' => AbilityUpdateCommand::class,
        'command.rinvex.fort.ability.create' => AbilityCreateCommand::class,

        'command.rinvex.fort.role.find'          => RoleFindCommand::class,
        'command.rinvex.fort.role.update'        => RoleUpdateCommand::class,
        'command.rinvex.fort.role.create'        => RoleCreateCommand::class,
        'command.rinvex.fort.role.giveability'   => RoleGiveAbilityCommand::class,
        'command.rinvex.fort.role.revokeability' => RoleRevokeAbilityCommand::class,

        'command.rinvex.fort.user.find'          => UserFindCommand::class,
        'command.rinvex.fort.user.create'        => UserCreateCommand::class,
        'command.rinvex.fort.user.update'        => UserUpdateCommand::class,
        'command.rinvex.fort.user.reminder'      => UserRemindCommand::class,
        'command.rinvex.fort.user.assignrole'    => UserAssignRoleCommand::class,
        'command.rinvex.fort.user.removerole'    => UserRemoveRoleCommand::class,
        'command.rinvex.fort.user.giveability'   => UserGiveAbilityCommand::class,
        'command.rinvex.fort.user.revokeability' => UserRevokeAbilityCommand::class,

        'command.rinvex.fort.verification.clear'  => VerificationTokenClearCommand::class,
        'command.rinvex.fort.reset.clear'         => PasswordTokenClearCommand::class,

    ];

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        // Merge config
        $this->mergeConfigFrom(realpath(__DIR__.'/../../config/config.php'), 'rinvex.fort');

        // Register bindings
        $this->registerCommands();
        $this->registerAccessGate();
        $this->registerRepositories();
        $this->registerBrokerManagers();
        $this->registerBladeExtensions();

        // Override exception handler
        $this->app->singleton(
            \Illuminate\Contracts\Debug\ExceptionHandler::class,
            \Rinvex\Fort\Exceptions\ExceptionHandler::class
        );

        // Register the Socialite Service Provider
        $this->app->register(SocialiteServiceProvider::class);

        // Register the LaravelCollective HTML Service Provider
        $this->app->register(HtmlServiceProvider::class);

        // Alias the LaravelCollective Form & HTML Facades
        AliasLoader::getInstance()->alias('Form', FormFacade::class);
        AliasLoader::getInstance()->alias('Html', HtmlFacade::class);
    }

    /**
     * Register the console commands.
     *
     * @return void
     */
    protected function registerCommands()
    {
        foreach ($this->commands as $commandKey => $commandClass) {
            $this->app->singleton($commandKey, function () use ($commandClass) {
                return new $commandClass();
            });
        }

        $this->commands(array_keys($this->commands));
    }

    /**
     * Register the access gate service.
     *
     * @return void
     */
    protected function registerAccessGate()
    {
        $this->app->singleton(GateContract::class, function ($app) {
            return new AccessGate($app, function () use ($app) {
                return call_user_func($app['auth']->userResolver());
            });
        });
    }

    /**
     * Bind the repositories into the IoC.
     *
     * @return void
     */
    protected function registerRepositories()
    {
        $this->bindRepository('rinvex.fort.role', RoleRepository::class);
        $this->bindRepository('rinvex.fort.user', UserRepository::class);
        $this->bindRepository('rinvex.fort.ability', AbilityRepository::class);
        $this->bindRepository('rinvex.fort.persistence', PersistenceRepository::class);
    }

    /**
     * Register the broker managers.
     *
     * @return void
     */
    protected function registerBrokerManagers()
    {
        // Register reset broker manager
        $this->app->singleton('rinvex.fort.passwordreset', function ($app) {
            return new BrokerManager($app, 'PasswordReset');
        });

        // Register verification broker manager
        $this->app->singleton('rinvex.fort.emailverification', function ($app) {
            return new BrokerManager($app, 'EmailVerification');
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
        return array_keys($this->commands) + [
                GateContract::class,
                'rinvex.fort.role',
                'rinvex.fort.user',
                'rinvex.fort.ability',
                'rinvex.fort.persistence',
                'rinvex.fort.passwordreset',
                'rinvex.fort.emailverification',
                \Illuminate\Contracts\Debug\ExceptionHandler::class,
            ];
    }
}