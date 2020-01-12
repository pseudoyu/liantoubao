<?php
/**
 * 创建服务扩展扩展类库
 */

namespace mod\command\make;

use mod\command\make\Make;
use think\console\input\Option;
use think\console\input\Argument;

class Providers extends Make
{

    protected $type = "Providers";

    protected function configure()
    {
        parent::configure();
        $model_desc = 'Generate a logical class for the specified model.';
        $plain_desc = 'Generate a logical class without a model.';
        $this->setName('mod:make:providers')
             ->addArgument('model',  Argument::OPTIONAL, $model_desc,  '')
             ->addOption('plain', null, Option::VALUE_NONE, $plain_desc)
             ->setDescription('Create a new providers class');
    }

    protected function getStub()
    {
        $file = $this->input->getOption('plain') ? 'providers.plain.stub' : 'providers.stub';
        return __DIR__ . DIRECTORY_SEPARATOR . 'stubs' . DIRECTORY_SEPARATOR . $file;
    }

    protected function getNamespace($appNamespace, $module)
    {
        return parent::getNamespace($appNamespace, $module) . '\providers';
    }

    protected function buildClass($name) {
        $context = parent::buildClass($name);

        if ( ! $this->input->getOption('plain')) {
            $model_name = $this->input->getArgument('model') ?: '';
            $model = str_replace('providers', 'model', $name);
            if ( ! empty($model_name)) {
                $model = substr($model, 0, strripos($model, '\\') + 1) . $model_name;
            }
            $context = str_replace('{%Model%}', $model, $context);
        }

        return $context;
    }

}
