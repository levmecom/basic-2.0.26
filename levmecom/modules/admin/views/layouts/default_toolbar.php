<?php
/* 
 * Copyright (c) 2018-2019 http://www.levme.com All rights reserved.
 * 
 * 创建时间：2019-08-23 13:15
 *
 * 项目：levme  -  $  - default_toolbar.php
 *
 * 作者：liwei  Levme.com <675049572@qq.com>
 */
use yii\helpers\Url;
?>

<?php if (Yii::$app->request->get('add')) : ?>
    <?=$this->render('default_toolbar_add')?>
<?php else : ?>

<div class="toolbar toolbar-bottom adminbottom adminbar page-admin-toolbar"><div class="toolbar-inner"><div class="list">
            <div class="item-content">
            <?php if (isset($this->blocks['deleteDay']) && $this->blocks['deleteDay']) :?>
                <div class="item-text delete-day-box">
                    <form name="deleteDay" action="">
                        <input type="hidden" name="<?=Yii::$app->request->csrfParam?>" value="<?=Yii::$app->request->csrfToken ?>">
                        <input type="hidden" name="field" value="<?=is_string($this->blocks['deleteDay']) ? $this->blocks['deleteDay'] : ''?>">
                        <input type="text" name="day" placeholder="删除几天前数据">
                        <label class="button button-fill color-gray doDeleteDay tooltip-init" data-tooltip="确定删除">
                            <i class="fa fa-minus" aria-hidden="true"></i>
                        </label>
                    </form>
                </div>
            <?php endif;?>
            <?php if (isset($this->blocks['dateSearch']) && $this->blocks['dateSearch'] && is_string($this->blocks['dateSearch'])) :?>
                <?php $_srhdate = Yii::$app->request->get('srh'); ?>
                <?php $daydates = isset($_srhdate['_daydate']) ? explode('.', $_srhdate['_daydate']) : []?>
                <div class="item-after"><form name="dateSearch" action="" method="get">
                    <div class="item-after date-search-box">
                        <input type="hidden" name="dateSearch" value="1">
                        <input type="hidden" name="datetype" value="0">
                        <input type="hidden" name="field" value="<?=$this->blocks['dateSearch']?>">
                        <input type="date" name="sdate" value="<?=isset($daydates[0]) ? $daydates[0] : ''?>" placeholder="开始时间"> <b>-</b>
                        <input type="date" name="edate" value="<?=isset($daydates[1]) ? $daydates[1] : ''?>" placeholder="结束时间">
                        <label class="button-fill button dateSearchDo">查询</label>
                        <a class="button-fill button <?=isset($_srhdate['_daydate']) && $_srhdate['_daydate'] == '1.'.$this->blocks['dateSearch'] ?'button-active':''?>" href="<?=Url::current(['srh'=>['_daydate'=>'1.'.$this->blocks['dateSearch']]])?>">今天</a>
                        <a class="button-fill button <?=isset($_srhdate['_daydate']) && $_srhdate['_daydate'] == '2.'.$this->blocks['dateSearch'] ?'button-active':''?>" href="<?=Url::current(['srh'=>['_daydate'=>'2.'.$this->blocks['dateSearch']]])?>">昨天</a>
                    </div>
                    </form>
                </div>
            <?php endif;?>
            <?php if (isset($this->blocks['pages']) && $this->blocks['pages']) :?>
                <div class="item-after"><div class="pagestr-box" style="min-width: 320px;">
                        <div class="box">
                            <?php if (isset($this->blocks['pageSize'])) :?>
                            <div class="input input-dropdown">
                                <select name="setPageSize" onchange="window.location='<?=Url::current(['setPageSize'=>''])?>'+this.value">
                                    <option value="10">显示10条</option>
                                    <option value="15">显示15条</option>
                                    <option value="20">显示20条</option>
                                    <option value="30">显示30条</option>
                                    <option value="40">显示40条</option>
                                    <option value="50">显示50条</option>
                                    <option value="100">显示100条</option>
                                    <option value="200">显示200条</option>
                                    <option value="300">显示300条</option>
                                    <option value="500">显示500条</option>
                                    <option value="1000">显示1000条</option>
                                    <option value="2000">显示2000条</option>
                                </select>
                            </div>
                            <script>
                                document.ready(function () {jQuery('select[name=setPageSize]').val('<?=$this->blocks['pageSize']?>');})
                            </script>
                            <?php endif;?>
                        </div>
                        <?=$this->blocks['pages']?>
                    </div>
                </div>
            <?php endif;?>
            </div>
        </div>
    </div>
</div>

<?php endif;?>
