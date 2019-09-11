<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii 2 Basic Project Template</h1>
    <br>
    <h2>全模块化开发，各个模块可独立使用。</h2>
</p>

目录结构
-------------------

      
    levmecom/               APP
        aalevme/            http://levme.com
        assets/             contains assets definition
        commands/           contains console commands (controllers)
        config/             contains application configurations
        controllers/        contains Web controller classes
        mail/               contains view files for e-mails
        migrations/
        messages/
        models/             contains model classes
        modules/            模块 
            admin/          管理模块
            install/        安装模块 - 首次访问直接跳转此模块
            ucenter/        用户中心 - 只存最基本用户信息 passport登陆机制
            ...
        runtime/            contains files generated during runtime
        tests/              contains various tests for the basic application
        views/              contains view files for the Web application
        web/                contains the entry script and Web resources
    vendor/                 contains dependent 3rd-party packages


------------

