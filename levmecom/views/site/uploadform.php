<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>CKEditor 5 – super build</title>
    <style>
        body {
            max-width: 800px;
            margin: 20px auto;
        }
    </style>
</head>
<body>

<h1>CKEditor 5 – super build</h1>

<div id="classic-editor">
    <h2>Sample</h2>

    <p>This is an instance of the <a href="https://ckeditor.com/docs/ckeditor5/latest/builds/guides/overview.html#classic-editor">classic editor build</a>.</p>
</div>

<div id="inline-editor">
    <h2>Sample</h2>

    <p>This is an instance of the <a href="https://ckeditor.com/docs/ckeditor5/latest/builds/guides/overview.html#inline-editor">inline editor build</a>.</p>
</div>

<script src="<?=\yii\helpers\Url::to('@web/statics/ckeditor5-build-classic')?>/ckeditor.js"></script>
<script>
    ClassicEditor
        .create( document.querySelector( '#classic-editor' ) )
        .catch( err => {
            console.error( err.stack );
        } );

    InlineEditor
        .create( document.querySelector( '#inline-editor' ) )
        .catch( err => {
            console.error( err.stack );
        } );
</script>

</body>
</html>