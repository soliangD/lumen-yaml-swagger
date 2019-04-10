<?php

namespace Soocoo\Swagger;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class SwaggerLumenServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function register()
    {
        $this->registerConfig('yaml-swagger');

        $this->app->register(\SwaggerLume\ServiceProvider::class);

        $this->app->singleton('command.swagger-lume.generate', function () {
            return new GenerateDocsCommand();
        });
    }

    protected function registerConfig($key)
    {
        $configPath = __DIR__ . '/../config/yaml-swagger.php';
        $this->mergeConfigFrom($configPath, $key);

        $yamlSwaggerConfig = $this->app['config']->get($key, []);

        $swaagerLumeConfig = $this->getSwaagerLumeConfig($yamlSwaggerConfig);

        $this->app['config']->set('swagger-lume', $swaagerLumeConfig);
    }

    protected function getSwaagerLumeConfig($yamlSwaggerConfig)
    {
        $module = $this->getModule(Arr::get($yamlSwaggerConfig, 'default', 'api'));

        $moduleConfig = Arr::get($yamlSwaggerConfig, "module.{$module}", []);

        $swaagerLumeConfig = array_merge($moduleConfig, Arr::get($yamlSwaggerConfig, "common", []));

        $this->formatRouteList($swaagerLumeConfig, $module);

        return $swaagerLumeConfig;
    }

    protected function formatRouteList(&$swaagerLumeConfig, $module)
    {
        $routeList = Arr::get($swaagerLumeConfig, 'routes');
        if (is_null($routeList)) {
            return;
        }
        foreach ($routeList as &$route) {
            if (is_string($route)) {
                $route = Str::start($module, '/') . Str::start($route, '/');
            }
        }

        Arr::set($swaagerLumeConfig, 'routes', $routeList);
    }

    protected function getModule($default)
    {
        $module = $default;
        //前端访问模块
        if ($route = Arr::get($_SERVER, 'REQUEST_URI')) {
            if (preg_match('/\/([^.]*?)\//i', $route, $matches)) {
                $module = $matches[1];
            }
        }

        //判断为generate命令
        if (function_exists('fwrite') && defined('STDOUT')) {
            if ($argv = Arr::get($_SERVER, 'argv')) {
                if (isset($argv[1]) && $argv[1] == 'swagger-lume:generate') {
                    fwrite(STDOUT, "Please input module name (default {$module}): ");
                    $module = (str_replace(PHP_EOL, '', fgets(STDIN))) ?: $module;
                }
            }
        }

        return $module;
    }
}
