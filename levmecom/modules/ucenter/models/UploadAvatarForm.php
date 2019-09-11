<?php
namespace app\modules\ucenter\models;

use levmecom\aalevme\levHelpers;
use app\modules\ucenter\widgets\Ucenter;
use yii\console\Exception;
use yii\imagine\Image;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Login form
 */
class UploadAvatarForm extends Model
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

    public function upload()
    {

        if ($this->validate()) {
            $avatarDir = Yii::getAlias('@webroot').Ucenter::avatarDir(Yii::$app->user->identity->getId());

            levHelpers::mkdirs($avatarDir);

            $imgfile = $avatarDir . Yii::$app->user->identity->getId() . '.jpg';

            $this->imageFile->saveAs($imgfile);
            if (is_file($imgfile)) {
                $imginfo = getimagesize($imgfile);
                if ($imginfo[0] >120 || $imginfo[1] >120) {
                    ini_set('memory_limit', '256M');
                    Image::thumbnail($imgfile, 120, 120, \Imagine\Image\ManipulatorInterface::THUMBNAIL_OUTBOUND)->save($imgfile, ['quality' => 100]);
                }
            }
            return levHelpers::responseMsg(1, '头像上传成功');
        } else {
            return levHelpers::responseMsg(-201, '头像上传失败：'.$this->errors['imageFile'][0], ['errors'=>$this->errors]);
        }
    }

    public function attributeLabels()
    {
        return [
            'imageFile' => '图片文件',
        ];
    }
}
