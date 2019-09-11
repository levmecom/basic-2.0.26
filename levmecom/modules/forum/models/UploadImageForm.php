<?php
namespace levmecom\modules\forum\models;

use levmecom\aalevme\levHelpers;
use yii\imagine\BaseImage;
use yii\imagine\Image;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Login form
 */
class UploadImageForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg, gif', 'maxSize' => 1024*1024*10],
        ];
    }

    public function attributeLabels()
    {
        return [
            'imageFile' => '图片文件',
        ];
    }
}
