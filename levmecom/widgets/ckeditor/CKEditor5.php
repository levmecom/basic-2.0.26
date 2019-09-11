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

class CKEditor5 extends InputWidget
{

    public $editorType = 'Classic';
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
        'basic' => ['heading','bold','italic','link','bulletedList','numberedList','imageUpload','blockQuote', 'insertTable', 'undo', 'redo'],
        'mobile' => ['heading','bold','italic','imageUpload','blockQuote'],
    ];

    public function run()
    {

        if ($this->hasModel()) {
            echo Html::activeTextarea($this->model, $this->attribute, $this->options);
        } else if ($this->editorType == 'Inline') {
            echo '<div class="placeholderDiv" id="'.$this->options['id'].'" placeholder="'.$this->options['placeholder'].'">'.$this->value.'</div>';
        }else {
            echo Html::textarea($this->name, $this->value, $this->options);
        }

        CKEditor5Assets::register($this->getView())->js[0] = 'build/'.$this->editorType.'/ckeditor.js';

        $toolbar = 'toolbar:'.Json::encode(isset($this->_styles[$this->style]) ? $this->_styles[$this->style] :
            ($this->toolbar ? $this->toolbar : $this->_styles['basic']));
        $csrf = \Yii::$app->request->getCsrfToken();

        return $this->view->registerJs(<<<JS
        class myUploadAdapter {
            constructor(loader) {
                this.loader = loader;
            }
            upload() {
                return this.loader.file
            .then( file => new Promise( ( resolve, reject ) => {
                this._initRequest();
                this._initListeners( resolve, reject, file );
                this._sendRequest( file );
            } ) );
            }
             _initRequest() {
                const xhr = this.xhr = new XMLHttpRequest();
                xhr.open( 'POST', '{$this->uploadUrl}', true );
                xhr.responseType = 'json';
            }
            _sendRequest( file ) {
                    const data = new FormData();
            
                    data.append( 'upload', file );
                    data.append('_csrf', '{$csrf}');
            
                    this.xhr.send( data );
            }
            _initListeners( resolve, reject, file ) {
                const xhr = this.xhr;
                const loader = this.loader;
                const genericErrorText = `文件上传失败: \${ file.name }.`;
        
                xhr.addEventListener( 'error', () => reject( genericErrorText ) );
                xhr.addEventListener( 'abort', () => reject() );
                xhr.addEventListener( 'load', () => {
                    const response = xhr.response;
        
                    if ( !response || !response.succeed  ) {
                        if (response) {
                            levtoast(response.error ? response.error.message : (response.message ? response.message : (response.tips ? response.tips : genericErrorText)), 5000)
                        }
                        return reject();
                    }
        
                    resolve( {
                        default: response.url
                    } );
                } );
        
                if ( xhr.upload ) {
                    xhr.upload.addEventListener( 'progress', evt => {
                        if ( evt.lengthComputable ) {
                            loader.uploadTotal = evt.total;
                            loader.uploaded = evt.loaded;
                        }
                    } );
                }
            }
            abort() {
                if ( this.xhr ) {
                    this.xhr.abort();
                }
            }
        }
        
        function MyCustomUploadAdapterPlugin( editor ) {
            editor.plugins.get( 'FileRepository' ).createUploadAdapter = ( loader ) => {
                // Configure the URL to the upload script in your back-end here!
                return new myUploadAdapter( loader );
            };
        }
        
        {$this->editorType}Editor.create( 
            document.querySelector( "#{$this->options['id']}" ), {
            language:"zh-cn",
            extraPlugins: [ MyCustomUploadAdapterPlugin ],
//            ckfinder: {
//                uploadUrl: '{$this->uploadUrl}',
//            },
            {$toolbar}
        }).then( editor => {
            window.editor = editor;
            // window.editor.plugins.get('FileRepository').createUploadAdapter = (loader)=>{
            //     return new myUploadAdapter(loader);
            // };
            
        }).catch( err => {
            console.error( err.stack );
        });

JS
        );
    }
}


class CKEditor5Assets extends AssetBundle
{

    public $sourcePath = '@levmecom/widgets/ckeditor/assets/ckeditor5';
    public $css = [
    ];
    public $js = [
        //'build/Classic/ckeditor.js',
        'build/translations/zh-cn.js',
    ];
}


















