<?php
/**
 *
 * User: JSparrow
 * DateTime: 2016/11/2 15:39
 * Created by PhpStorm.
 */

namespace app\models\base;


use yii\db\ActiveRecord;
use yii\db\Query;
use yii\db\QueryTrait;

/**
 * 基础模型
 * @package app\models\base
 */
class BaseModel extends ActiveRecord
{
    /**
     * 说明:获取当前页数据
     * @param \yii\db\Query $query
     * @param int $curPage
     * @param int $pageSize
     * @param null $search
     * @return array
     */
    public function getPages($query, $curPage=1, $pageSize=10, $search = null)
    {
        if($search)
            $query = $query->andFilterWhere($search);

        $data['count'] = $query->count();
        if(!$data['count']) {
            return ['count'=>0, 'curPage'=>$curPage, 'pageSize'=>$pageSize, 'start'=>0, 'data'=>[]];
        }

        // 重算当前面防止显示超出的页
        $curPage = (ceil($data['count']/$pageSize)<$curPage) ? ceil($data['count']/$pageSize) : $curPage;
        $data['curPage'] = $curPage;
        //起始页
        $data['start'] = ($curPage-1)*$pageSize+1;
        // 末页
        $data['end'] = (ceil($data['count']/$pageSize) == $curPage) ? $data['count'] : (($curPage-1)*$pageSize+$pageSize);
        $data['data'] = $query
            ->offset(($curPage-1)*$pageSize)
            ->limit($pageSize)
            //->asArray()
            ->all();
        var_dump($data);
        return $data;
    }
}