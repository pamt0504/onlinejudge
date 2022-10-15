<?php

use yii\helpers\Html;

$this->title = Yii::t('app', 'Home');
?>
<div class="row blog">
    <div class="col-md-8">
        <style>
            * {
                box-sizing:border-box
            }
            h2 {
                text-align: left;
            }
            .slideshow-container {
                max-width: 80%;
                position: relative;
                margin: auto;
            }
            .mySlides {
                display: none;
            }
            .text {
                color: #f2f2f2;
                font-size: 15px;
                padding: 8px 12px;
                position: absolute;
                bottom: 8px;
                width: 100%;
                text-align: center;
            }
            .dot {
                cursor:pointer;
                height: 10px;
                width: 10px;
                margin: 0 2px;
                background-color: #bbb;
                border-radius: 50%;
                display: inline-block;
                transition: background-color 0.6s ease;
            }
            .active, .dot:hover {
                background-color: #717171;
            }
            .fade {
                -webkit-animation-name: fade;
                -webkit-animation-duration: 10s;
                animation-name: fade;
                animation-duration: 10s;
            }

            @-webkit-keyframes fade {
                from {opacity: .4} 
                to {opacity: 1}
            }

            @keyframes fade {
                from {opacity: .4} 
                to {opacity: 1}
            }
        </style>
        <div class="slideshow-container">
            <div class="mySlides fade">
                <img src="<?= Yii::getAlias('@web') ?>/images/pic1.jpg" style="width:100%">
            </div>

            <div class="mySlides fade">
                <img src="<?= Yii::getAlias('@web') ?>/images/pic2.jpg" style="width:100%">
            </div>

            <div class="mySlides fade">
              <img src="<?= Yii::getAlias('@web') ?>/images/pic3.jpg" style="width:100%">
            </div>

            <div class="mySlides fade">
                <img src="<?= Yii::getAlias('@web') ?>/images/pic4.jpg" style="width:100%">
            </div>

            <div class="mySlides fade">
                <img src="<?= Yii::getAlias('@web') ?>/images/pic5.jpg" style="width:100%">
            </div>
        </div>
        <br>

        <div style="text-align:center">
            <span class="dot" onclick="currentSlide(0)"></span> 
            <span class="dot" onclick="currentSlide(1)"></span> 
            <span class="dot" onclick="currentSlide(2)"></span> 
            <span class="dot" onclick="currentSlide(3)"></span> 
            <span class="dot" onclick="currentSlide(4)"></span> 
        </div>  
        <script>
      
            var slideIndex;
      
            function showSlides() {
                var i;
                var slides = document.getElementsByClassName("mySlides");
                var dots = document.getElementsByClassName("dot");
                for (i = 0; i < slides.length; i++) {
                    slides[i].style.display = "none";  
                }
                for (i = 0; i < dots.length; i++) {
                    dots[i].className = dots[i].className.replace(" active", "");
                }

                slides[slideIndex].style.display = "block";  
                dots[slideIndex].className += " active";
          
                slideIndex++;
          
                if (slideIndex > slides.length - 1) {
                    slideIndex = 0
                }    
          
                setTimeout(showSlides, 10000);
            }
      
            showSlides(slideIndex = 0);


            function currentSlide(n) {
                showSlides(slideIndex = n);
            }
        </script>
        <h3>Giới thiệu về hệ thống</h3>
            <p>Greenhat Online Judge là hệ thống chấm điểm lập trình trực tuyến được phát triển bởi Khoa Công nghệ thông tin - Trường Đại học Kỹ thuật Hậu cần CAND.</p>
            <p>Mã nguồn chương trình (viết bằng ngôn ngữ C, C++, Java, Python,...) sẽ được hệ thống tự động biên dịch thành chương trình để kiểm tra tính chính xác thông qua các bộ dữ liệu có sẵn.</p>
    </div>
    <div class="col-md-4">
        <div class="blog-main">
            <?php foreach ($news as $v): ?>
                <div class="blog-post">
                    <h2><span><?=Yii::t('app','Notification')?></span></h2>
                    <h4 class="blog-post-title"><?= Html::a(Html::encode($v['title']), ['/site/news', 'id' => $v['id']]) ?></h4>
                    <p class="blog-post-meta"><span class="glyphicon glyphicon-time"></span> <?= Yii::$app->formatter->asDate($v['created_at']) ?></p>
                </div>
            <?php endforeach; ?>
            <?= \yii\widgets\LinkPager::widget([
                'pagination' => $pages,
                ]); ?>
        </div>
        <?php if (!empty($contests)): ?>
            <hr>
            <div class="sidebar-module">
                <h2><?= Yii::t('app','Recent Contests')?></h2>
                <ol class="list-unstyled">
                    <?php foreach ($contests as $contest): ?>
                        <li>
                            <h4 class="blog-post-title"><?= Html::a(Html::encode($contest['title']), ['/contest/view', 'id' => $contest['id']]) ?></h4>
                        </li>
                    <?php endforeach; ?>
                </ol>
            </div>
        <?php endif; ?>
        <?php if (!empty($discusses)): ?>
            <div class="sidebar-module">
                <h2>Recent Discussion</h2>
                    <ol class="list-unstyled">
                        <?php foreach ($discusses as $discuss): ?>
                            <li class="index-discuss-item">
                                <div>
                                    <?= Html::a(Html::encode($discuss['title']), ['/discuss/view', 'id' => $discuss['id']]) ?>
                                </div>
                                <small class="text-muted">
                                    <span class="glyphicon glyphicon-user"></span>
                                    <?= Html::a(Html::encode($discuss['nickname']), ['/user/view', 'id' => $discuss['username']]) ?>
                                    &nbsp;•&nbsp;
                                    <span class="glyphicon glyphicon-time"></span> <?= Yii::$app->formatter->asRelativeTime($discuss['created_at']) ?>
                                    &nbsp;•&nbsp;
                                    <?= Html::a(Html::encode($discuss['ptitle']), ['/problem/view', 'id' => $discuss['pid']]) ?>
                                </small>
                            </li>
                        <?php endforeach; ?>
                    </ol>
                </div>
        <?php endif; ?>
    </div>
</div>

