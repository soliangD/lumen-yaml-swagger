<?php

namespace Soocoo\Swagger;

use Illuminate\Support\Arr;

class SwaggerLumenServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function register()
    {
        //$this->registerConfig('yaml-swagger');

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

        $module = $this->getModule();

        //todo

        $this->mergeConfigFrom($configPath, 'swagger-lume');
    }

    protected function getModule($default)
    {
        $module = $default;
        //前端访问模块
        if ($route = Arr::get($_SERVER, 'REQUEST_URI')) {
            if (preg_match('/\/([^<]*)\/documentation/i', $route, $matches)) {
                $module = $matches[1];
            }
            if (preg_match('/\/docs-([^<]*)/i', $route, $matches)) {
                $module = $matches[1];
            }
        }

        //判断为generate命令
        if (function_exists('fwrite') && defined('STDOUT')) {
            if ($argv = Arr::get($_SERVER, 'argv')) {
                if (isset($argv[1]) && $argv[1] == 'swagger-lume:generate') {
                    fwrite(STDOUT, 'Please input module name (default admin): ');
                    $module = (str_replace(PHP_EOL, '', fgets(STDIN))) ?: $module;
                }
            }
        }

        return $module;
    }
}
