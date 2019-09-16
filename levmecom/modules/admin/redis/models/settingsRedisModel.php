<?php

/* 
 * Copyright (c) 2018-2019 http://www.levme.com All rights reserved.
 * 
 * 创建时间：2019-09-10 11:11
 *
 * 项目：levme  -  $  - adminRedisModel.php
 *
 * 作者：liwei  Levme.com <675049572@qq.com>
 */
namespace app\modules\admin\redis\models;

use app\modules\admin\models\SettingsModel;
use yii\redis\ActiveRecord;

class settingsRedisModel extends ActiveRecord
{

    public static function updates($identifier = '', $delete = false) {
        $where = $identifier ? ['moduleidentifier'=>$identifier] : null;
        if ($delete) {
            settingsRedisModel::deleteAll($where);
        }
        $data = SettingsModel::find()->where($where)->asArray()->all();
        foreach ($data as $v) {
            self::doSave($v['id'], $v);
        }
    }
    public static function doSave($id, $v = [])
    {
        $model = static::findOne(['id'=>$id]);
        if ($model) {
            if ($model->moduleidentifier == $v['moduleidentifier'] && $model->inputname == $v['inputname'] && $model->inputvalue == $v['inputvalue']) {
                return true;
            }
        }
        $model = $model ? $model : new settingsRedisModel();
        $model->id = $id;
        $model->moduleidentifier = $v['moduleidentifier'] ?: '';
        $model->inputname = $v['inputname'] ?: '';
        $model->inputvalue = $v['inputvalue'] ?: '';
        return $model->save();
    }

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
        return ['id', 'moduleidentifier', 'inputname', 'inputvalue'];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'moduleidentifier' => '模块标识符',
            'inputname' => '字段名',
            'inputvalue' => '字段值'
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