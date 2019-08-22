<?php

namespace backend\assets;

use yii\web\AssetBundle;

class CommonAsset extends AssetBundle{
    public $css = [
         'css/addAgent.css',
        'css/icons/css/all.css'
    ];
    public  $js= [
        'js/connectionBetweenAgent.js'
    ];
//    public $depends =[
//        'yii\web\JqueryAsset',
//    ];
}

