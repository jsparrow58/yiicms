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
    public $item = [];

    public function init()
    {
        if(empty($this->item)){
            $this->item = [
                ['label'=>'demo', 'image_url'=>'/images/banner/b_0.png', 'url'=>['site/index'], 'html'=>'', 'active'=>true],
                ['label'=>'demo', 'image_url'=>'/images/banner/b_1.png', 'url'=>['site/index'], 'html'=>''],
                ['label'=>'demo', 'image_url'=>'/images/banner/b_2.png', 'url'=>['site/index'], 'html'=>''],
            ];
        }
    }

    public function run()
    {
        $data['item'] = $this->item;
        return $this->render('index', ['date'=>$data]);
    }
}