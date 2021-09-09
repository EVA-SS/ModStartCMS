<?php

namespace ModStart\Command;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use ModStart\Core\Exception\BizException;
use ModStart\Core\Input\Response;
use ModStart\Core\Util\FileUtil;
use ModStart\Core\Util\VersionUtil;
use ModStart\ModStart;
use ModStart\Module\ModuleManager;

class ModuleInstallCommand extends Command
{
    protected $signature = 'modstart:module-install {module}';

    public function handle()
    {
        $module = $this->argument('module');
        BizException::throwsIf(L('Module Invalid'), !ModuleManager::isExists($module));
        $installeds = ModuleManager::listAllInstalledModules();
        $basic = ModuleManager::getModuleBasic($module);
        BizException::throwsIf('Module basic empty', !$basic);
        BizException::throwsIf(L('Module %s:%s depend on ModStart:%s, install fail', $module, $basic['version'], $basic['modstartVersion']), !VersionUtil::match(ModStart::$version, $basic['modstartVersion']));
        foreach ($basic['require'] as $require) {
            $v = '*';
            $pcs = explode(':', $require);
            $m = $pcs[0];
            if (isset($pcs[1])) {
                $v = $pcs[1];
            }
            BizException::throwsIf(L('Module %s:%s depend on %s:%s, install fail', $module, $basic['version'], $m, $v), !isset($installeds[$m]));
            $mBasic = ModuleManager::getModuleBasic($m);
            BizException::throwsIf(L('Module %s:%s depend on %s:%s, install fail', $module, $basic['version'], $m, $v), !VersionUtil::match($mBasic['version'], $v));
        }
        $output = null;

        $this->migrate($module);
        $this->publishAsset($module);
        $this->publishRoot($module);

        if (!isset($installeds[$module])) {
            $installeds[$module] = [
                'isSystem' => ModuleManager::isSystemModule($module),
                'enable' => false,
                'config' => []
            ];
            ModuleManager::saveUserInstalledModules($installeds);
        }


        ModStart::clearCache();

        $this->info('Module Install Success');
    }

    private function migrate($module)
    {
        $path = ModuleManager::path($module, 'Migrate');
        if (!file_exists($path)) {
            return;
        }
        $this->info('Module Migrate Success');
        $this->call('migrate', ['--path' => ModuleManager::relativePath($module, 'Migrate')]);
    }

    private function publishRoot($module)
    {
        $root = ModuleManager::path($module, 'ROOT');
        if (!file_exists($root)) {
            return;
        }
        $files = FileUtil::listAllFiles($root);
        $files = array_filter($files, function ($file) {
            return $file['isFile'];
        });
        $publishFiles = 0;
        foreach ($files as $file) {
            $relativePath = $file['filename'];
            $relativePathBackup = $relativePath . '._delete_.' . $module;
            $currentFile = base_path($relativePath);
            $currentFileBackup = $currentFile . '._delete_.' . $module;
            if (file_exists($currentFile) && !file_exists($currentFileBackup)) {
                rename($currentFile, $currentFileBackup);
                $this->info("Module Root Publish : $relativePath -> $relativePathBackup");
            }
            if (!file_exists($currentFile) || md5_file($currentFile) != file_get_contents($file['pathname'])) {
                FileUtil::ensureFilepathDir($currentFile);
                file_put_contents($currentFile, file_get_contents($file['pathname']));
                $publishFiles++;
            }
        }
        $this->info("Module Root Publish : $publishFiles item(s)");
    }

    private function publishAsset($module)
    {
        $fs = $this->laravel['files'];
        $from = ModuleManager::path($module, 'Asset') . '/';
        if (!file_exists($from)) {
            return;
        }
        $to = public_path("vendor/$module/");
        if (file_exists($to)) {
            $this->info("Module Asset Publish : Ignore");
            return;
        }
        $fs->deleteDirectory($to);
        $fs->copyDirectory($from, $to);
        $this->info("Module Asset Publish : $from -> $to");
    }

}
