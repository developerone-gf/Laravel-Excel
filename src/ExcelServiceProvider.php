<?php

namespace Periplia\Sheet\Excel;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application as LumenApplication;
use Periplia\Sheet\Excel\Console\ExportMakeCommand;
use Periplia\Sheet\Excel\Console\ImportMakeCommand;
use Periplia\Sheet\Excel\Files\Filesystem;
use Periplia\Sheet\Excel\Files\TemporaryFileFactory;
use Periplia\Sheet\Excel\Mixins\DownloadCollection;
use Periplia\Sheet\Excel\Mixins\StoreCollection;
use Periplia\Sheet\Excel\Transactions\TransactionHandler;
use Periplia\Sheet\Excel\Transactions\TransactionManager;

class ExcelServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            if ($this->app instanceof LumenApplication) {
                $this->app->configure('periplia_sheet');
            } else {
                $this->publishes([
                    $this->getConfigFile() => config_path('periplia_sheet.php'),
                ], 'config');
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->mergeConfigFrom(
            $this->getConfigFile(),
            'periplia_sheet'
        );

        $this->app->bind(TransactionManager::class, function () {
            return new TransactionManager($this->app);
        });

        $this->app->bind(TransactionHandler::class, function () {
            return $this->app->make(TransactionManager::class)->driver();
        });

        $this->app->bind(TemporaryFileFactory::class, function () {
            return new TemporaryFileFactory(
                config('periplia_sheet.temporary_files.local_path', config('periplia_sheet.exports.temp_path', storage_path('framework/laravel-excel'))),
                config('periplia_sheet.temporary_files.remote_disk')

            );
        });

        $this->app->bind(Filesystem::class, function () {
            return new Filesystem($this->app->make('filesystem'));
        });

        $this->app->bind('periplia_sheet', function () {
            return new Excel(
                $this->app->make(Writer::class),
                $this->app->make(QueuedWriter::class),
                $this->app->make(Reader::class),
                $this->app->make(Filesystem::class)
            );
        });

        $this->app->alias('periplia_sheet', Excel::class);
        $this->app->alias('periplia_sheet', Exporter::class);
        $this->app->alias('periplia_sheet', Importer::class);

        Collection::mixin(new DownloadCollection);
        Collection::mixin(new StoreCollection);

        $this->commands([
            ExportMakeCommand::class,
            ImportMakeCommand::class,
        ]);
    }

    /**
     * @return string
     */
    protected function getConfigFile(): string
    {
        return __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'periplia_sheet.php';
    }
}
