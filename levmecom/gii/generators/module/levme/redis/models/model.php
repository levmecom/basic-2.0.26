<?php
/**
 * This is the template for generating a controller class within a module.
 */

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\module\Generator */

$className = $generator->moduleClass;
$pos = strrpos($className, '\\');
$ns = ltrim(substr($className, 0, $pos), '\\');
$className = substr($className, $pos + 1);

echo "<?php\n";
?>

/* 
 * Copyright (c) 2018-2019 http://www.levme.com All rights reserved.
 * 
 * 创建时间：2019-09-10 11:11
 *
 * 项目：levme  -  $  - <?=$generator->moduleID?>RedisModel.php
 *
 * 作者：liwei  Levme.com <675049572@qq.com>
 */
namespace <?= $ns ?>\redis\models;

use yii\redis\ActiveRecord;

class <?=$generator->moduleID?>RedisModel extends ActiveRecord
{
    /**
     * 主键 默认为 id
     *
     * @return array|string[]
     */
    public static function primaryKey()
    {
        return ['id'];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [];
    }

    /**
     * 模型对应记录的属性列表
     *
     * @return array
     */
    public function attributes()
    {
        return ['id', 'name', 'status', 'uptime', 'addtime'];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '彩种名称',
            'status' => '状态',
            'uptime' => '更新时间',
            'addtime' => '创建时间',
        ];
    }
    /**
     * 定义和其它模型的关系
     *
     * @return \yii\db\ActiveQueryInterface
     */
    public static function getOrders()
    {
        //return $this->hasMany(Order::className(), ['customer_id' => 'id']);
    }

}