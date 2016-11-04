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
     * 返回值：
     * return['count'] 记录总条数
     * return['curPage'] 当前页，已经重算过
     * return['start'] 起始行数
     * return['end'] 末尾行数
     * return['data'] 返回的结果集
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

        // 重算当前页防止给的参数超出的总页数
        $curPage = (ceil($data['count']/$pageSize)<$curPage) ? ceil($data['count']/$pageSize) : $curPage;
        $data['curPage'] = $curPage;
        //总第条几开始
        $data['start'] = ($curPage-1)*$pageSize+1;
        // 到第几条结束
        $data['end'] = (ceil($data['count']/$pageSize) == $curPage) ? $data['count'] : (($curPage-1)*$pageSize+$pageSize);
        $data['pageSize'] = $pageSize;
        $data['data'] = $query
            ->offset(($curPage-1)*$pageSize)
            ->limit($pageSize)
            ->all();
        return $data;
    }
}