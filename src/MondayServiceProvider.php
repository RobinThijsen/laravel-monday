<?php

namespace RobinThijsen\LaravelMonday;

use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use RobinThijsen\LaravelMonday\Commands\SkeletonCommand;

class MondayServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-monday')
            ->hasConfigFile()
            ->hasInstallCommand(function(InstallCommand $command) {
                $command->publishConfigFile();
            });
    }
}
