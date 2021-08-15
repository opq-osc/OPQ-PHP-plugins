<?php
namespace app\controller;

use app\BaseController;
use Imagick;
use ImagickPixel;
use ImagickDraw;

class Api extends BaseController
{
    //爬
    public function pa_pic()
    {
        $qq = input('qq',0);
        $head=new Imagick("https://q1.qlogo.cn/g?b=qq&nk=$qq&s=640");
        $pa=rand(0,53);
        $percent=rand(1,100);
        if($percent<20 && $qq!==0){
            $backgroud=new Imagick(WEB_ROOT.'pa/不爬.jpg');
        }
        else{
            $backgroud=new Imagick(WEB_ROOT.'pa/爬'.(string)$pa.'.jpg');
            $head->roundCorners($head->getImageWidth() / 2, $head->getImageHeight() / 2);
            $head->resizeImage($backgroud->getImageHeight()/5,$backgroud->getImageHeight()/5,Imagick::FILTER_LANCZOS, 1);
            $backgroud->compositeImage($head,Imagick::COMPOSITE_OVER, 5, $backgroud->getImageHeight()-$head->getImageHeight());
        }
        header("Content-Type: image/jpeg");
        ob_end_clean();
        echo $backgroud->getImageBlob();
    }
    //FBI指人
    public function finger()
    {
        $qq = input('qq',0);
        $canvas = new Imagick();
        $canvas ->newImage(513, 511, 'black');
        $canvas->setImageFormat("png");
        $head=new Imagick("https://q1.qlogo.cn/g?b=qq&nk=$qq&s=640");
        $finger=new Imagick(WEB_ROOT.'finger/finger.png');
        $head->resizeImage(450,450,Imagick::FILTER_LANCZOS, 1);
        $canvas->compositeImage($head,Imagick::COMPOSITE_OVER, 90, 60);
        $head->resizeImage(100,100,Imagick::FILTER_LANCZOS, 1);
        $head->rotateImage(new ImagickPixel('none'),-5);
        $canvas->compositeImage($finger,Imagick::COMPOSITE_OVER, 0, 0);
        $canvas->compositeImage($head,Imagick::COMPOSITE_OVER, 70, 373);
        header("Content-Type: image/png");
        ob_end_clean();
        echo $canvas->getImageBlob();
    }
    //撕头像
    public function slash()
    {
        $qq = input('qq',0);
        $head1 = new Imagick("https://q1.qlogo.cn/g?b=qq&nk=$qq&s=100");
        $head2 = new Imagick("https://q1.qlogo.cn/g?b=qq&nk=$qq&s=100");
        $background=new Imagick(WEB_ROOT."slash/slash.jpg");
        $points1=[
            ['x' => 0, 'y' => 0],
            ['x' => 0, 'y' => 100],
            ['x' => 40, 'y' => 100],
            ['x' => 60, 'y' => 80],
            ['x' => 40, 'y' => 60],
            ['x' => 60, 'y' => 40],
            ['x' => 40, 'y' => 20],
            ['x' => 60, 'y' => 0]];
        $points2=[
            ['x' => 100, 'y' => 0],//关于y轴对称
            ['x' => 100, 'y' => 100],//关于y轴对称
            ['x' => 40, 'y' => 100],
            ['x' => 60, 'y' => 80],
            ['x' => 40, 'y' => 60],
            ['x' => 60, 'y' => 40],
            ['x' => 40, 'y' => 20],
            ['x' => 60, 'y' => 0]];
        $shape1= new Imagick();
        $shape1->newImage(100, 100, 'none');
        $draw1 = new ImagickDraw();
        $draw1->polyline($points1);//画折线
        $shape1->drawimage($draw1);
        $shape2= new Imagick();
        $shape2->newImage(100, 100, 'none');
        $draw2 = new ImagickDraw();
        $draw2->polyline($points2);//画折线
        $shape2->drawimage($draw2);
        $head1->setImageFormat('png');
        $head1->setimagematte(true);
        $head2->setImageFormat('png');
        $head2->setimagematte(true);
        $head1->compositeimage($shape1, Imagick::COMPOSITE_COPYOPACITY , 0, 0);
        $head2->compositeimage($shape2, Imagick::COMPOSITE_COPYOPACITY , 0, 0);
        $head1->roundCorners($head1->getImageWidth() / 2, $head1->getImageHeight() / 2);
        $head1->resizeImage(120,120,Imagick::FILTER_LANCZOS, 1);
        $head1->rotateImage(new ImagickPixel('none'),30);
        $head2->roundCorners($head2->getImageWidth() / 2, $head2->getImageHeight() / 2);
        $head2->resizeImage(120,120,Imagick::FILTER_LANCZOS, 1);
        $head2->rotateImage(new ImagickPixel('none'),-30);
        $background->compositeImage($head1,Imagick::COMPOSITE_OVER, 20, 290);
        $background->compositeImage($head2,Imagick::COMPOSITE_OVER, 300, 140);
        header("Content-Type: image/png");
        ob_end_clean();
        echo $background->getImageBlob();
    }
    //旋转丢
    public function throw_pic()
    {
        $qq = input('qq',0);
        $head=new Imagick("https://q1.qlogo.cn/g?b=qq&nk=$qq&s=100");
        $backgroud=new Imagick(WEB_ROOT.'throw/throw.png');
        $head->resizeImage(120,120,Imagick::FILTER_LANCZOS, 1);
        $animation = new Imagick();
        $animation->setFormat( "gif" );
        $delay = 10;
        for($i=1; $i<8; $i++){
            $head->roundCorners($head->getImageWidth() / 2, $head->getImageHeight() / 2);
            $head->rotateImage(new ImagickPixel('none'),45*$i);
            $backgroud->compositeImage($head,Imagick::COMPOSITE_OVER, 85 - $head->getImageHeight() / 2, 250 - $head->getImageWidth() / 2);
            $animation->addImage($backgroud);
        }
        $animation->setImageDelay( $delay );
        header("Content-Type: image/gif");
        ob_end_clean();
        echo $animation->getImagesBlob();
    }
    //rua(摸)
    public function petpet(){
        $qq = input('qq',0);
        $head=new Imagick("https://q1.qlogo.cn/g?b=qq&nk=$qq&s=100");
        $animation = new Imagick(); //建立一个对象。
        $animation->setFormat( "gif" ); //设置它的类型。
        $delay = 6; //设置播放速度。
        for($i=0; $i<5; $i++){
            $bg=new Imagick();
            $bg ->newImage(112, 112, 'white');
            $bg->setImageFormat('png');
            $pos_x = [18,14,6,10,14];
            $pos_y = [18,30,36,30,18];
            $size_x = [94,98,106,98,94];
            $size_y = [94,82,76,82,94];
            $head->resizeImage($size_x[$i],$size_y[$i],Imagick::FILTER_LANCZOS, 1);
            $head->roundCorners($head->getImageWidth() / 2, $head->getImageHeight() / 2);
            $bg->compositeImage($head,Imagick::COMPOSITE_OVER, $pos_x[$i], $pos_y[$i]);//放头
            $hand=new Imagick(WEB_ROOT.'hand/hand'.(string)($i+1).'.png');
            $bg->compositeImage($hand,Imagick::COMPOSITE_OVER, 0, 0);//放手
            $animation->addImage($bg); //加入到刚才建立的那个gif imagick对象之中。
            $bg->destroy();
        }
        $animation->setImageDelay( $delay); //设置好播放速度。
        header("Content-Type: image/gif");
        ob_end_clean();
        echo $animation->getImagesBlob();
    }
    //亲
    public function kiss(){
        $qq1 = input('qq1',0);
        $qq2 = input('qq2',0);
        $head1=new Imagick("https://q1.qlogo.cn/g?b=qq&nk=$qq1&s=100");
        $head2=new Imagick("https://q1.qlogo.cn/g?b=qq&nk=$qq2&s=100");
        $animation = new Imagick(); //建立一个对象。
        $animation->setFormat( "gif" ); //设置它的类型。
        //坐标和图像资源参考自xiyaowong
        $src_x = [92, 135, 84, 80, 155, 60, 50, 98, 35, 38, 70, 84, 75];
        $src_y = [64, 40, 105, 110, 82, 96, 80, 55, 65, 100, 80, 65, 65];
        $dsc_x = [58, 62, 42, 50, 56, 18, 28, 54, 46, 60, 35, 20, 40];
        $dsc_y = [90, 95, 100, 100, 100, 120, 110, 100, 100, 100, 115, 120, 96];
        $delay = 0; //设置播放速度。
        for($i=0; $i<13; $i++){
            $bg=new Imagick(WEB_ROOT.'kiss/'.(string)($i+1).'.png');
            $head1->resizeImage(40,40,Imagick::FILTER_LANCZOS, 1);
            $head1->roundCorners($head1->getImageWidth() / 2, $head1->getImageHeight() / 2);
            $bg->compositeImage($head1,Imagick::COMPOSITE_OVER, $src_x[$i], $src_y[$i]);//放头1
            $head2->resizeImage(50,50,Imagick::FILTER_LANCZOS, 1);
            $head2->roundCorners($head1->getImageWidth() / 2, $head2->getImageHeight() / 2);
            $bg->compositeImage($head2,Imagick::COMPOSITE_OVER, $dsc_x[$i], $dsc_y[$i]);//放头2
            $animation->addImage($bg); //加入到刚才建立的那个gif imagick对象之中。
            $animation->setImageDelay( $delay); //设置好播放速度。
            $bg->destroy();
        }
        header("Content-Type: image/gif");
        ob_end_clean();
        echo $animation->getImagesBlob();
    }
    //p站logo
    public function phlogo()
    {
        $text1 = input('text1');
        $text2 = input('text2');
        $style1['font']=WEB_ROOT.'font/msyhbd.ttc';
        $style1['font_size'] = 90;
        $style1['fill_color']='#FFFFFF';
        $style2['font']=WEB_ROOT.'font/msyhbd.ttc';
        $style2['font_size'] = 90;
        $style2['fill_color']='#000000';
        $arr1=imagettfbbox(70, 0, $style1['font'], $text1);
        $arr2=imagettfbbox(70, 0, $style1['font'], $text2);
        $width1=$arr1[2]-$arr1[0];
        $width2=$arr2[2]-$arr2[0];
        $background = new Imagick();
        $background ->newImage($width1 +$width2 + 150, 210, 'black');
        $background->setImageFormat("png");
        $text2_left=$arr1[2]+60;//第二种字体的起始位置
        $draw = new ImagickDraw();
        $draw->setFillColor('#f7971d');
        $draw->roundRectangle($text2_left, 40, $text2_left+$width2+50, 170, 10, 10);
        $background->drawImage($draw);
        $this->textttf($background,$text1,40,140,$style1,'left');
        $this->textttf($background,$text2,$text2_left+25,140,$style2,'left');
        header("Content-Type: image/png");
        ob_end_clean();
        echo $background->getImageBlob();
    }
    //今日运势
    function fortune()
    {
        $img = new Imagick(WEB_ROOT . 'fortune/image/frame_' . (string)rand(1, 66) . '.jpg');
        $style1['font_size'] = 45;
        $style1['fill_color'] = '#F5F5F5';
        $style1['font'] = WEB_ROOT . "fortune/font/Mamelon.otf";
        $style2['font_size'] = 25;
        $style2['font'] = WEB_ROOT . "fortune/font/sakura.ttf";
        $style2['fill_color'] = '#323232';
        $file1 = json_decode(file_get_contents(WEB_ROOT . "fortune/fortune/goodLuck.json"), true);
        $file2 = json_decode(file_get_contents(WEB_ROOT . "fortune/fortune/copywriting.json"), true);
        $lucky = $file2['copywriting'][rand(0, 178)];
        $content = $lucky['content'];
        $text = '';
        foreach ($file1['types_of'] as $v) {
            if ($lucky['good-luck'] == $v['good-luck']) {
                $title = $v['name'];
            }
        }
        for ($i = 0; $i < mb_strlen($content); $i++) {
            $text .= mb_substr($content, $i, 1) . PHP_EOL;
        }
        header('Content-type:image/png');
        $this->textttf($img, $title, 140, 120, 0, $style1);
        if (mb_strlen($text) <= 16) {
            $this->textttf($img, $text, 140, 190, 0, $style2);
        } else if (mb_strlen($text) <= 32) {
            $this->textttf($img, mb_substr($text, 0, 16), 110, 190, 0, $style2);
            $this->textttf($img, mb_substr($text, 16), 170, 190, 0, $style2);
        } else {
            $this->textttf($img, mb_substr($text, 0, 16), 100, 190, 0, $style2);
            $this->textttf($img, mb_substr($text, 16, 16), 140, 190, 0, $style2);
            $this->textttf($img, mb_substr($text, 32), 180, 190, 0, $style2);
        }
        ob_end_clean();
        echo $img->getImageBlob();
    }
        public function textttf(&$imagick, $text, $x = 0, $y = 0, $style = [],$align='center')
    {
        $draw = new ImagickDraw ();
        if (isset ($style ['font']))
            $draw->setFont($style ['font']);
        if (isset ($style ['font_size']))
            $draw->setFontSize($style ['font_size']);
        if (isset ($style ['fill_color']))
            $draw->setFillColor($style ['fill_color']);
        if (isset ($style ['under_color']))
            $draw->setTextUnderColor($style ['under_color']);
        if (isset ($style ['font_family']))
            $draw->setfontfamily($style ['font_family']);
        if(isset ($style ['gradient'])){
            $gradient  = new Imagick();
            $gradient ->newPseudoImage(300, 300,$style['gradient']);
            $draw = new ImagickDraw();
            $draw->pushPattern('gradient', 0, 0, 300, 300);
            $draw->composite(Imagick::COMPOSITE_OVER, 0, 0, 300, 300, $gradient);
            $draw->popPattern();
            $draw->setFillPatternURL('#gradient');
        }
        //$draw->annotation($x,$y,$text);
        if(isset($align)){
            switch ($align){
                case 'center':$draw->setTextAlignment(2);break;
                case 'left':$draw->setTextAlignment(1);break;
                default :$draw->setTextAlignment(2);
            }
        }
        $draw->settextencoding('UTF-8');
        if (strtolower($imagick->getImageFormat()) == 'gif') {
            foreach ($imagick as $frame) {
                //$frame->drawImage($draw);
                $imagick->annotateImage($draw, $x, $y, 0, $text);
            }
        } else {
            $imagick->annotateImage($draw, $x, $y, 0, $text);
            //$imagick->drawImage($draw);
        }
    }
}
