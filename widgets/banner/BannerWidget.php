<?php
/**
 * Created by PhpStorm.
 * User: jsparrow
 * Date: 16-11-8
 * Time: 下午3:56
 */

namespace app\widgets\banner;


use yii\bootstrap\Widget;

class BannerWidget extends Widget
{
    public $items = [];

    public function init()
    {
        if(empty($this->items)){
            $this->items = [
                ['label'=>'demo', 'image_url'=>'/image/banner/b0.jpg', 'url'=>['site/index'], 'html'=>'', 'active'=>true],
                ['label'=>'demo', 'image_url'=>'/image/banner/b1.jpg', 'url'=>['site/index'], 'html'=>''],
                ['label'=>'demo', 'image_url'=>'/image/banner/b2.jpg', 'url'=>['site/index'], 'html'=>''],
            ];
        }
    }

    public function run()
    {
        $data['items'] = $this->items;
        return $this->render('index', ['data'=>$data]);
    }
}