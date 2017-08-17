<?php

namespace mipotech\affiliates;

use Yii;
use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\base\Component;

/**
 * Bootstrap interface to restrict access to the dev environment
 *
 * @link http://www.yiiframework.com/wiki/652/how-to-use-bootstrapinterface/
 * @author Chaim Leichman, MIPO Technologies Ltd
 */
class Bootstrap extends Component implements BootstrapInterface
{
    /**
     * Bootstrap method to be called during application bootstrap stage.
     *
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {


    }
}
