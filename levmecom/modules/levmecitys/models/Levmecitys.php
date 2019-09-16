<?php

namespace app\modules\levmecitys\models;

use Yii;

/**
 * This is the model class for table "pre_levmecitys".
 *
 * @property int $id
 * @property int $pid
 * @property string $code 编码
 * @property string $name 名称
 * @property string $streetCode 街道编码
 * @property string $provinceCode 省市编码
 * @property string $cityCode 城市编码
 * @property string $areaCode 县城编码
 * @property int $displayorder 排序
 * @property int $status 状态
 * @property int $uptime 更新时间
 * @property int $addtime 添加时间
 */
class Levmecitys extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pre_levmecitys';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pid', 'displayorder', 'status', 'uptime', 'addtime'], 'integer'],
            [['code', 'streetCode', 'provinceCode', 'cityCode', 'areaCode'], 'string', 'max' => 32],
            [['name'], 'string', 'max' => 80],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pid' => 'Pid',
            'code' => '编码',
            'name' => '名称',
            'streetCode' => '街道编码',
            'provinceCode' => '省市编码',
            'cityCode' => '城市编码',
            'areaCode' => '县城编码',
            'displayorder' => '排序',
            'status' => '状态',
            'uptime' => '更新时间',
            'addtime' => '添加时间',
        ];
    }
}
