<?php

namespace app\modules\uploads\models;

use Yii;
use levmecom\aalevme\levHelpers;
use yii\imagine\Image;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%uploads}}".
 *
 * @property int $id
 * @property int $uid
 * @property int $sourceid
 * @property int $idtype  // 0:其它，1：forum
 * @property int $filetype  // 0:图片
 * @property string $filename
 * @property string $src
 * @property int $addtime
 */
class Uploads extends \yii\db\ActiveRecord
{
    /**
     * @var UploadedFile
     */
    public $imageFile;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%uploads}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid', 'sourceid', 'idtype', 'filetype', 'addtime'], 'integer'],
            [['filename', 'src'], 'string', 'max' => 255],
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg, gif', 'maxSize' => 1024*1024*10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'UID',
            'sourceid' => '源ID',
            'idtype' => '附件源',
            'filetype' => '文件类型',
            'filename' => '文件名',
            'src' => '文件路径',
            'addtime' => '上传时间',
        ];
    }

    public function idtype() {
        return [
            0 => ['id'=>0, 'name'=>'其它', 'descs'=>'来自其它的附件'],
            1 => ['id'=>1, 'name'=>'论坛', 'descs'=>'来自论坛的附件'],
        ];
    }
    public function filetype() {
        return [
            0 => ['id'=>0, 'name'=>'图片'],
            1 => ['id'=>1, 'name'=>'压缩包'],
        ];
    }

    public function uploadToForum() {
        return $this->uploadImage('forum', 'upload', 1, true);
    }

    public function uploadImage($dir = 'common', $field = 'upload', $idtype = 0, $savedb = true)
    {
        if (!Yii::$app->request->isPost) {
            return levHelpers::responseMsg(-301, '请上传一张图片');
        }

        //$model->imageFile = UploadedFile::getInstance($model, 'imageFile');
        $this->imageFile = UploadedFile::getInstanceByName($field);

        if ($this->validate()) {
            $uploadDir = Yii::getAlias('@webroot').($url = '/uploads/'.$dir.'/'.date('Y').'/'.date('m').'/'.date('d').'/');

            levHelpers::mkdirs($uploadDir);

            $imgfile = $uploadDir . ($imgName = microtime(true) . '.' . $this->imageFile->extension);

            $this->imageFile->saveAs($imgfile);
            if (is_file($imgfile)) {
                $imginfo = getimagesize($imgfile);
                if ($imginfo[0] >500 || $imginfo[1] >500) {
                    ini_set('memory_limit', '256M');
                    $imginfo[0] = min($imginfo[0], 1200);
                    $imginfo[1] = min($imginfo[1], 1200);
                    Image::thumbnail($imgfile, $imginfo[0], $imginfo[1])->save($imgfile, ['quality' => 80]);
                }
                if ($savedb) {
                    $this->setAttributes(['uid'=>Yii::$app->user->identity->getId(),'idtype'=>$idtype, 'filename'=>levHelpers::stripTags($this->imageFile->baseName), 'src'=>$url.$imgName, 'addtime'=>time()]);
                    $this->save(false);
                }
            }
            return levHelpers::responseMsg(1, '上传成功', ['url'=>$url.$imgName, 'uploaded'=>true]);
        } else {
            return levHelpers::responseMsg(-201, '上传失败：'.$this->errors['imageFile'][0], ['errors'=>$this->errors]);
        }
    }

}