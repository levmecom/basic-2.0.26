<?php
/* 
 * Copyright (c) 2018-2019 http://www.levme.com All rights reserved.
 * 
 * 创建时间：2019-08-09 07:36
 *
 * 项目：levme  -  $  - CKEditor5.php
 *
 * 作者：liwei  Levme.com <675049572@qq.com>
 *
 *
    <?= $form->field($model, 'contents')->widget(\levmecom\widgets\ckeditor\CKEditor5::className(), [
        //'toolbar' => ['imageUpload'],
        'uploadUrl' => \yii\helpers\Url::to('@web/forum/ajax/upload'),
    ]) ?>

 */


namespace levmecom\widgets\ckeditor;

use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\AssetBundle;
use yii\widgets\InputWidget;

class CKEditor4 extends InputWidget
{
    /**
     * @var array
     */
    public $clientOptions = [];

    /**
     *
     * ['heading','bold','italic','link','numberedList','imageUpload','blockQuote'],
     *
     * @var array Toolbar options array
     */
    public $toolbar = [];


    /**
     * @var string Url to image upload
     */
    public $uploadUrl = '/';

    /**
     * @var array
     */
    public $options = [];

    public $style = '';

    private $_styles = [
        'basic' => "toolbarGroups: [
		            //{ name: 'colors', groups: [ 'colors' ] },
		            { name: 'styles', groups: [ 'styles' ] },
                    { 'name': 'basicstyles', 'groups': [ 'basicstyles', 'cleanup' ] },
                    { 'name': 'insert', 'groups': [ 'insert' ] },
                    { 'name': 'forms', 'groups': [ 'forms' ] },
                    { 'name': 'tools', 'groups': [ 'tools' ] },
                    { 'name': 'document', 'groups': [ 'mode', 'document', 'doctools' ] },
		            { name: 'paragraph', groups: [ 'list', 'blocks', 'indent', 'align', 'bidi', 'paragraph' ] },
                    { 'name': 'others', 'groups': [ 'others' ] },
                    { 'name': 'links', 'groups': [ 'links' ] },
                    { 'name': 'clipboard', 'groups': [ 'undo' ] },
                ]",
        'mobile' => "toolbarGroups: [
                    { 'name': 'basicstyles', 'groups': [ 'basicstyles', 'cleanup' ] },
                    { 'name': 'insert', 'groups': [ 'insert' ] },
                ]",
    ];

    public function run()
    {

        if ($this->hasModel()) {
            echo Html::activeTextarea($this->model, $this->attribute, $this->options);
        } else {
            echo Html::textarea($this->name, $this->value, $this->options);
        }

        CKEditor4Assets::register($this->getView());

        $toolbar = isset($this->_styles[$this->style]) ? $this->_styles[$this->style] :
                  ($this->toolbar ? 'toolbarGroups:'.Json::encode($this->toolbar) : $this->_styles['basic']);
        $csrf = \Yii::$app->request->getCsrfToken();
        $plugins = $this->style == 'mobile' ? 'image2' : 'codesnippet';

        return $this->view->registerJs(<<<JS
            CKEDITOR.replace('{$this->options['id']}', {
                $toolbar,
                removeButtons: 'Cut,Copy,Paste,PasteText,PasteFromWord,Scayt,Anchor,Table,HorizontalRule,Maximize,Source,Outdent,Indent,About,Styles,SpecialChar',//,Format
                extraPlugins: '{$plugins}',
                //filebrowserBrowseUrl: '',
                filebrowserUploadUrl: '{$this->uploadUrl}',
                filebrowserImageUploadUrl: "{$this->uploadUrl}",
                removeDialogTabs: 'image:advanced;link:advanced',

	            codeSnippet_theme: 'monokai_sublime',
	            // codeSnippet_languages: {
                //     'javascript': 'JavaScript',
                //     'php': 'PHP'
                // },
            });
            CKEDITOR.instances['{$this->options['id']}'].on( 'fileUploadRequest', function( evt ) {
                evt.data.requestData._csrf = '{$csrf}';
            } );
JS
        );
    }
}


class CKEditor4Assets extends AssetBundle
{

    public $sourcePath = '@levmecom/widgets/ckeditor/assets/ckeditor4';
    public $css = [
    ];
    public $js = [
        'ckeditor.js',
    ];
}


















