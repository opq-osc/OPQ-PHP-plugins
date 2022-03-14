<?php
namespace app\controller;

use app\BaseController;
use Imagick;
use ImagickPixel;
use ImagickDraw;
use think\facade\Db;
use hg\apidoc\annotation as Apidoc;
/**
 * @Apidoc\Title("世外天堂图像接口")
 */
class Api extends BaseController
{
    protected $table = 'qq_qiandao';
    /**
     * @Apidoc\Title("爬接口")
     * @Apidoc\Url("/api/pa_pic")
     * @Apidoc\Method("GET")
     * @Apidoc\Param("qq", type="string",require=true, desc="QQ号" )
     * @Apidoc\Returned("image", type="binary", desc="图像")
     */
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
    /**
     * @Apidoc\Title("指人接口")
     * @Apidoc\Url("/api/finger")
     * @Apidoc\Method("GET")
     * @Apidoc\Param("qq", type="string",require=true, desc="QQ号" )
     * @Apidoc\Returned("image", type="binary", desc="图像")
     */
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
    /**
     * @Apidoc\Title("撕接口(裂痕版)")
     * @Apidoc\Url("/api/slash")
     * @Apidoc\Method("GET")
     * @Apidoc\Param("qq", type="string",require=true, desc="QQ号" )
     * @Apidoc\Returned("image", type="binary", desc="图像")
     */
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
    /**
     * @Apidoc\Title("撕接口(血痕版)")
     * @Apidoc\Url("/api/slash2")
     * @Apidoc\Method("GET")
     * @Apidoc\Param("qq", type="string",require=true, desc="QQ号" )
     * @Apidoc\Returned("image", type="binary", desc="图像")
     */
    public function slash2()
    {
        $qq = input('qq',0);
        $head1 = new Imagick("https://q1.qlogo.cn/g?b=qq&nk=$qq&s=640");
        $head2 = new Imagick("https://q1.qlogo.cn/g?b=qq&nk=$qq&s=640");
        $background=new Imagick(WEB_ROOT."slash/slash2.jpg");
        $head1->resizeImage(180,180,Imagick::FILTER_LANCZOS, 1);
        $head1->cropImage(90,180,0,0);
        $head1->rotateImage(new ImagickPixel('none'),-25);
        $head2->resizeImage(180,180,Imagick::FILTER_LANCZOS, 1);
        $head2->cropImage(90,180,90,0);
        $head2->rotateImage(new ImagickPixel('none'),10);
        $background->compositeImage($head1,Imagick::COMPOSITE_OVER, -40, 200);
        $background->compositeImage($head2,Imagick::COMPOSITE_OVER, 345, 160);
        header("Content-Type: image/png");
        ob_end_clean();
        echo $background->getImageBlob();
    }
    /**
     * @Apidoc\Title("旋转丢接口")
     * @Apidoc\Url("/api/throw_pic")
     * @Apidoc\Method("GET")
     * @Apidoc\Param("qq", type="string",require=true, desc="QQ号" )
     * @Apidoc\Returned("image", type="binary", desc="图像")
     */
    public function throw_pic()
    {
        $qq = input('qq',0);
        $head=new Imagick("https://q1.qlogo.cn/g?b=qq&nk=$qq&s=100");
        $backgroud=new Imagick(WEB_ROOT.'throw/throw.png');
        $head->resizeImage(120,120,Imagick::FILTER_LANCZOS, 1);
        $animation = new Imagick();
        $animation->setFormat( "gif" );
        $delay = 4;
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
    /**
     * @Apidoc\Title("rua接口")
     * @Apidoc\Url("/api/petpet")
     * @Apidoc\Method("GET")
     * @Apidoc\Param("qq", type="string",require=true, desc="QQ号" )
     * @Apidoc\Returned("image", type="binary", desc="图像")
     */
    public function petpet(){
        $qq = input('qq',0);
        $head=new Imagick("https://q1.qlogo.cn/g?b=qq&nk=$qq&s=100");
        $animation = new Imagick(); //建立一个对象。
        $animation->setFormat( "gif" ); //设置它的类型。
        $delay = 4; //设置播放速度。
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
            $bg->compositeImage($head,Imagick::COMPOSITE_OVER, $pos_x[$i], $pos_y[$i]);
            $hand=new Imagick(WEB_ROOT.'hand/hand'.(string)($i+1).'.png');
            $bg->compositeImage($hand,Imagick::COMPOSITE_OVER, 0, 0);
            $animation->addImage($bg);
            $bg->destroy();
        }
        $animation->setImageDelay( $delay);
        header("Content-Type: image/gif");
        ob_end_clean();
        echo $animation->getImagesBlob();
    }
    /**
     * @Apidoc\Title("打拳接口")
     * @Apidoc\Url("/api/fist")
     * @Apidoc\Method("GET")
     * @Apidoc\Param("qq", type="string",require=true, desc="QQ号" )
     * @Apidoc\Returned("image", type="binary", desc="图像")
     */
    public function fist(){
        $qq = input('qq',0);
        $head=new Imagick("https://q1.qlogo.cn/g?b=qq&nk=$qq&s=640");
        $animation = new Imagick();
        $animation->setFormat( "gif" );
        $delay = 1; //设置播放速度。
        for($i=0; $i<16; $i++){
            $bg=new Imagick();
            $bg ->newImage(260, 260, 'white');
            $bg->setImageFormat('png');
            $head_pos = [[-30,20],[-16,9],[-6,-5],[3,-17],[14,-24],[27,-19],[38,-8],[45,2],[48,6],[30,-15],[12,-16],[-4,-23],[-18,-24],[-26,-11],[-30,3],[-31,15]];
            $fist1_pos = [[-16,165],[-14,132],[-12,114],[-8,110],[-7,111],[-14,121],[-17,145],[-17,164],[-16,165],[-16,165],[-16,165],[-16,165],[-16,165],[-16,165],[-16,165],[-16,165]];
            $fist2_pos = [[158,171],[158,171],[158,171],[158,171],[158,171],[158,171],[158,171],[158,171],[152,165],[109,130],[74,114],[58,111],[56,111],[95,121],[130,144],[153,164]];
            $fist1_size=[80,120,150,170,170,140,100,85,80,80,80,80,80,80,80,80];
            $fist2_size=[80,80,80,80,80,80,80,80,80,120,150,170,170,140,100,85];
            $fist1_angle=[-45,-40,-30,-25,-20,-40,-45,-50,-45,-45,-45,-45,-45,-45,-45,-45];
            $fist2_angle=[45,45,45,45,45,45,45,45,40,30,25,25,20,40,45,50];
            $head->resizeImage(240,240,Imagick::FILTER_LANCZOS, 1);
            $bg->compositeImage($head,Imagick::COMPOSITE_OVER, $head_pos[$i][0],$head_pos[$i][1]);//放头
            $fist1=new Imagick(WEB_ROOT.'fist/fista.png');
            $fist2=new Imagick(WEB_ROOT.'fist/fistb.png');
            $fist1->resizeImage($fist1_size[$i],$fist1_size[$i],Imagick::FILTER_LANCZOS, 1);
            $fist2->resizeImage($fist2_size[$i],$fist2_size[$i],Imagick::FILTER_LANCZOS, 1);
            $fist1->rotateImage(new ImagickPixel('none'),$fist1_angle[$i]);
            $fist2->rotateImage(new ImagickPixel('none'),$fist2_angle[$i]);
            $bg->compositeImage($fist1,Imagick::COMPOSITE_OVER, $fist1_pos[$i][0], $fist1_pos[$i][1]);//放手
            $bg->compositeImage($fist2,Imagick::COMPOSITE_OVER, $fist2_pos[$i][0], $fist2_pos[$i][1]);//放手
            $animation->addImage($bg);
            $animation->setImageDelay( $delay);
            $bg->destroy();
        }
        header("Content-Type: image/gif");
        ob_end_clean();
        echo $animation->getImagesBlob();
    }
    /**
     * @Apidoc\Title("亲接口")
     * @Apidoc\Url("/api/kiss")
     * @Apidoc\Method("GET")
     * @Apidoc\Param("qq1", type="string",require=true, desc="QQ号1" )
     * @Apidoc\Param("qq2", type="string",require=true, desc="QQ号2" )
     * @Apidoc\Returned("image", type="binary", desc="图像")
     */
    public function kiss(){
        $qq1 = input('qq1',0);
        $qq2 = input('qq2',0);
        $head1=new Imagick("https://q1.qlogo.cn/g?b=qq&nk=$qq1&s=100");
        $head2=new Imagick("https://q1.qlogo.cn/g?b=qq&nk=$qq2&s=100");
        $animation = new Imagick();
        $animation->setFormat( "gif" );
        $src_x = [92, 135, 84, 80, 155, 60, 50, 98, 35, 38, 70, 84, 75];
        $src_y = [64, 40, 105, 110, 82, 96, 80, 55, 65, 100, 80, 65, 65];
        $dsc_x = [58, 62, 42, 50, 56, 18, 28, 54, 46, 60, 35, 20, 40];
        $dsc_y = [90, 95, 100, 100, 100, 120, 110, 100, 100, 100, 115, 120, 96];
        $delay = 4;
        for($i=0; $i<13; $i++){
            $bg=new Imagick(WEB_ROOT.'kiss/'.(string)($i+1).'.png');
            $head1->resizeImage(40,40,Imagick::FILTER_LANCZOS, 1);
            $head1->roundCorners($head1->getImageWidth() / 2, $head1->getImageHeight() / 2);
            $bg->compositeImage($head1,Imagick::COMPOSITE_OVER, $src_x[$i], $src_y[$i]);//放头1
            $head2->resizeImage(50,50,Imagick::FILTER_LANCZOS, 1);
            $head2->roundCorners($head1->getImageWidth() / 2, $head2->getImageHeight() / 2);
            $bg->compositeImage($head2,Imagick::COMPOSITE_OVER, $dsc_x[$i], $dsc_y[$i]);//放头2
            $animation->addImage($bg);
            $animation->setImageDelay( $delay);
            $bg->destroy();
        }
        header("Content-Type: image/gif");
        ob_end_clean();
        echo $animation->getImagesBlob();
    }
    /**
     * @Apidoc\Title("舔接口")
     * @Apidoc\Url("/api/prpr")
     * @Apidoc\Method("GET")
     * @Apidoc\Tag("imagick")
     * @Apidoc\Param("qq", type="string",require=true, desc="QQ号" )
     * @Apidoc\Returned("image", type="binary", desc="图像")
     */
    public function prpr(){
        $qq = input('qq',0);
        $head=new Imagick("https://q1.qlogo.cn/g?b=qq&nk=$qq&s=640");
        $canvas=new Imagick();
        $canvas->newImage(690, 668,'white');
        $canvas->setImageFormat('png');
        $head->resizeImage(330,330,Imagick::FILTER_LANCZOS, 1);
        $canvas->compositeImage($head,Imagick::COMPOSITE_OVER, 56,284);
        $bg=new Imagick(WEB_ROOT.'prpr/0.png');
        $canvas->compositeImage($bg,Imagick::COMPOSITE_OVER, 0,0);
        header("Content-Type: image/png");
        ob_end_clean();
        echo $canvas->getImagesBlob();
    }
    /**
     * @Apidoc\Title("精神支柱接口")
     * @Apidoc\Url("/api/support")
     * @Apidoc\Method("GET")
     * @Apidoc\Tag("imagick")
     * @Apidoc\Param("qq", type="string",require=true, desc="QQ号和图像二选一" )
     * @Apidoc\Param("image", type="string",require=false, desc="base图像数据" )
     * @Apidoc\Returned("image", type="binary", desc="图像")
     */
    public function support(){
        $qq = input('qq',0);
        $image=input('post.image',null);
        if($image!==null){
            $head=new Imagick();
            $head->readImageBlob(base64_decode($image));
        }
        else{
            $head=new Imagick("https://q1.qlogo.cn/g?b=qq&nk=$qq&s=640");
        }
        $canvas=new Imagick();
        $canvas->newImage(1293, 1164,'white');
        $canvas->setImageFormat('png');
        $head->resizeImage(815,815,Imagick::FILTER_LANCZOS, 1);
        $head->rotateImage(new ImagickPixel('none'),-23);
        $canvas->compositeImage($head,Imagick::COMPOSITE_OVER, -172, -17);
        $bg=new Imagick(WEB_ROOT.'support/0.png');
        $canvas->compositeImage($bg,Imagick::COMPOSITE_OVER, 0,0);
        header("Content-Type: image/png");
        ob_end_clean();
        echo $canvas->getImagesBlob();
    }
    /**
     * @Apidoc\Title("继续干活接口")
     * @Apidoc\Url("/api/back_to_work")
     * @Apidoc\Method("GET")
     * @Apidoc\Tag("imagick")
     * @Apidoc\Param("qq", type="string",require=true, desc="QQ号和图像二选一" )
     * @Apidoc\Param("image", type="string",require=false, desc="base图像数据" )
     * @Apidoc\Returned("image", type="binary", desc="图像")
     */
    public function back_to_work(){
        $qq = input('qq',0);
        $image=input('post.image',null);
        if($image!==null){
            $head=new Imagick();
            $head->readImageBlob(base64_decode($image));
        }
        else{
            $head=new Imagick("https://q1.qlogo.cn/g?b=qq&nk=$qq&s=640");
        }
        $canvas=new Imagick();
        $canvas->newImage(750, 750,'white');
        $canvas->setImageFormat('png');
        $head->resizeImage(250,250,Imagick::FILTER_LANCZOS, 1);
        $head->rotateImage(new ImagickPixel('none'),-20);
        $canvas->compositeImage($head,Imagick::COMPOSITE_OVER, 46,43);
        $bg=new Imagick(WEB_ROOT.'back_to_work/0.png');
        $canvas->compositeImage($bg,Imagick::COMPOSITE_OVER, 0,0);
        header("Content-Type: image/png");
        ob_end_clean();
        echo $canvas->getImagesBlob();
    }
    /**
     * @Apidoc\Title("咬接口")
     * @Apidoc\Url("/api/bite")
     * @Apidoc\Method("GET")
     * @Apidoc\Tag("imagick")
     * @Apidoc\Param("qq", type="string",require=true, desc="QQ号和图像二选一" )
     * @Apidoc\Param("image", type="string",require=false, desc="base图像数据" )
     * @Apidoc\Returned("image", type="binary", desc="图像")
     */
    public function bite(){
        $qq = input('qq',0);
        $image=input('post.image',null);
        if($image!==null){
            $head=new Imagick();
            $head->readImageBlob(base64_decode($image));
        }
        else{
            $head=new Imagick("https://q1.qlogo.cn/g?b=qq&nk=$qq&s=100");
        }
        $animation = new Imagick();
        $animation->setFormat( "gif" );
        $locs = [
            [90, 90, 105, 150],
            [90, 83, 96, 172],
            [90, 90, 106, 148],
            [88, 88, 97, 167],
            [90, 85, 89, 179],
            [90, 90, 106, 151],
        ];
        $delay = 4; //设置播放速度。
        for($i=0; $i<16; $i++){
            $canvas=new Imagick();
            $canvas->newImage(362, 364,'white');
            $canvas->setImageFormat('png');
            $bg=new Imagick(WEB_ROOT.'bite/'.(string)($i).'.png');
            if($i<6){
                $head->resizeImage($locs[$i][2],$locs[$i][3],Imagick::FILTER_LANCZOS, 1);
                $canvas->compositeImage($head,Imagick::COMPOSITE_OVER, $locs[$i][0], $locs[$i][1]);//放头
            }
            $canvas->compositeImage($bg,Imagick::COMPOSITE_OVER,0,0);
            $animation->addImage($canvas);
            $animation->setImageDelay( $delay);
            $canvas->destroy();
        }
        header("Content-Type: image/gif");
        ob_end_clean();
        echo $animation->getImagesBlob();
    }
    /**
     * @Apidoc\Title("玩球接口")
     * @Apidoc\Url("/api/play")
     * @Apidoc\Method("GET")
     * @Apidoc\Tag("imagick")
     * @Apidoc\Param("qq", type="string",require=true, desc="QQ号和图像二选一" )
     * @Apidoc\Param("image", type="string",require=false, desc="base图像数据" )
     * @Apidoc\Returned("image", type="binary", desc="图像")
     */
    public function play(){
        $qq = input('qq',0);
        $image=input('post.image',null);
        if($image!==null){
            $head=new Imagick();
            $head->readImageBlob(base64_decode($image));
        }
        else{
            $head=new Imagick("https://q1.qlogo.cn/g?b=qq&nk=$qq&s=100");
        }
        $animation = new Imagick();
        $animation->setFormat( "gif" );
        $delay = 4; //设置播放速度。
        $locs = [
            [180, 60, 100, 100],
            [184, 75, 100, 100],
            [183, 98, 100, 100],
            [179, 118, 110, 100],
            [156, 194, 150, 48],
            [178, 136, 122, 69],
            [175, 66, 122, 85],
            [170, 42, 130, 96],
            [175, 34, 118, 95],
            [179, 35, 110, 93],
            [180, 54, 102, 93],
            [183, 58, 97, 92],
            [174, 35, 120, 94],
            [179, 35, 109, 93],
            [181, 54, 101, 92],
            [182, 59, 98, 92],
            [183, 71, 90, 96],
            [180, 131, 92, 101],
        ];
        for($i=0; $i<23; $i++){
            $canvas = new Imagick();
            $canvas ->newImage(480, 400, 'white');
            $canvas->setImageFormat("png");
            if($i<18){
                $head->resizeImage($locs[$i][2], $locs[$i][3],Imagick::FILTER_LANCZOS, 1);
                $head->roundCorners($head->getImageWidth() / 2, $head->getImageHeight() / 2);
                $canvas->compositeImage($head,Imagick::COMPOSITE_OVER, $locs[$i][0], $locs[$i][1]);//放头
            }
            $bg=new Imagick(WEB_ROOT.'play/'.(string)($i).'.png');//放bg
            $canvas->compositeImage($bg,Imagick::COMPOSITE_OVER, 0,0);//放头
            $animation->addImage($canvas);
            $bg->destroy();
        }
        $animation->setImageDelay( $delay);
        header("Content-Type: image/gif");
        ob_end_clean();
        echo $animation->getImagesBlob();
    }
    /**
     * @Apidoc\Title("扔球接口")
     * @Apidoc\Url("/api/thorw2")
     * @Apidoc\Method("GET")
     * @Apidoc\Tag("imagick")
     * @Apidoc\Param("qq", type="string",require=true, desc="QQ号和图像二选一" )
     * @Apidoc\Param("image", type="string",require=false, desc="base图像数据" )
     * @Apidoc\Returned("image", type="binary", desc="图像")
     */
    public function throw2(){
        $qq = input('qq',0);
        $image=input('post.image',null);
        if($image!==null){
            $head=new Imagick();
            $head->readImageBlob(base64_decode($image));
        }
        else{
            $head=new Imagick("https://q1.qlogo.cn/g?b=qq&nk=$qq&s=100");
        }
        $animation = new Imagick();
        $animation->setFormat( "gif" );
        $delay = 4;
        $locs = [
            [[32, 32, 108, 36]],
            [[32, 32, 122, 36]],
            [],
            [[123, 123, 19, 129]],
            [[185, 185, -50, 200], [33, 33, 289, 70]],
            [[32, 32, 280, 73]],
            [[35, 35, 259, 31]],
            [[175, 175, -50, 220]],
        ];
        foreach ($locs as $k=>$v){
            $bg=new Imagick(WEB_ROOT.'throw_gif/'.(string)($k).'.png');
            foreach ($v as $k2=>$v2){
                $head->resizeImage($v2[0], $v2[1],Imagick::FILTER_LANCZOS, 1);
                $head->roundCorners($head->getImageWidth() / 2, $head->getImageHeight() / 2);
                $bg->compositeImage($head,Imagick::COMPOSITE_OVER, $v2[2], $v2[3]);
            }
            $animation->addImage($bg);
            $bg->destroy();
        }
        $animation->setImageDelay( $delay);
        header("Content-Type: image/gif");
        ob_end_clean();
        echo $animation->getImagesBlob();
    }
    /**
     * @Apidoc\Title("膜拜接口")
     * @Apidoc\Url("/api/worship")
     * @Apidoc\Method("GET")
     * @Apidoc\Tag("imagick")
     * @Apidoc\Param("qq", type="string",require=true, desc="QQ号和图像二选一" )
     * @Apidoc\Param("image", type="string",require=false, desc="base图像数据" )
     * @Apidoc\Returned("image", type="binary", desc="图像")
     */
    public function worship(){
        $qq = input('qq',0);
        $image=input('post.image',null);
        if($image!==null){
            $head=new Imagick();
            $head->readImageBlob(base64_decode($image));
        }
        else{
            $head=new Imagick("https://q1.qlogo.cn/g?b=qq&nk=$qq&s=640");
        }
        $animation = new Imagick();
        $animation->setFormat( "gif" );
        $delay = 4;
        $head->resizeImage(150, 150,Imagick::FILTER_LANCZOS, 1);
        for($i=0; $i<10; $i++){
            $canvas = new Imagick();
            $canvas ->newImage(300, 169, 'black');
            $canvas->setImageFormat("png");
            $canvas->compositeImage($head,Imagick::COMPOSITE_OVER, 0,0);
            $bg=new Imagick(WEB_ROOT.'worship/'.(string)($i).'.png');
            $canvas->compositeImage($bg,Imagick::COMPOSITE_OVER, 0,0);
            $animation->addImage($canvas);
            $canvas->destroy();
        }
        $animation->setImageDelay( $delay);
        header("Content-Type: image/gif");
        ob_end_clean();
        echo $animation->getImagesBlob();
    }
    /**
     * @Apidoc\Title("玩游戏接口")
     * @Apidoc\Url("/api/play_game")
     * @Apidoc\Method("GET")
     * @Apidoc\Tag("imagick")
     * @Apidoc\Param("qq", type="string",require=true, desc="QQ号和图像二选一" )
     * @Apidoc\Param("image", type="string",require=false, desc="base图像数据" )
     * @Apidoc\Returned("image", type="binary", desc="图像")
     */
    public function play_game(){
        $qq = input('qq',0);
        $image=input('post.image',null);
        if($image!==null){
            $head=new Imagick();
            $head->readImageBlob(base64_decode($image));
        }
        else{
            $head=new Imagick("https://q1.qlogo.cn/g?b=qq&nk=$qq&s=640");
        }
        $img_w=$head->getImageWidth();
        $img_h=$head->getImageHeight();
        $ratio=min(220/$img_w,160/$img_h);
        $img_w=(int)($img_w*$ratio);
        $img_h=(int)($img_h*$ratio);
        $head->resizeImage($img_w, $img_h,Imagick::FILTER_LANCZOS, 1);
        //电脑屏幕
        $screen= new Imagick();
        $screen->newImage(220, 160, 'black');
        //头像相对屏幕居中
        $screen->compositeimage($head, Imagick::COMPOSITE_OVER , (int)((220 - $img_w) / 2), (int)((160 - $img_h) / 2));
        $screen->rotateImage(new ImagickPixel('none'),-9.5);
        $canvas = new Imagick();
        $canvas ->newImage(526, 503, 'black');
        $canvas->setImageFormat("png");
        $canvas->compositeImage($screen,Imagick::COMPOSITE_OVER, 161, 117);
        $bg=new Imagick(WEB_ROOT.'play_game/0.png');
        $canvas->compositeImage($bg,Imagick::COMPOSITE_OVER, 0,0);
        $style['font_size'] = 35;
        $style['fill_color'] ='#FFFFFF';
        $style['font'] = WEB_ROOT . "font/msyhbd.ttf";
        $this->textttf($canvas,'来玩休闲游戏啊',270,430,$style);
        header("Content-Type: image/png");
        ob_end_clean();
        echo $canvas->getImagesBlob();
    }
    /**
     * @Apidoc\Title("p站logo接口")
     * @Apidoc\Url("/api/phlogo")
     * @Apidoc\Method("GET")
     * @Apidoc\Param("text1", type="string",require=true, desc="文本1" )
     * @Apidoc\Param("text2", type="string",require=true, desc="文本2" )
     * @Apidoc\Returned("image", type="binary", desc="图像")
     */
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
        $text2_left=$arr1[2]+60;
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
    /**
     * @Apidoc\Title("我有个朋友接口")
     * @Apidoc\Url("/api/my_friend")
     * @Apidoc\Method("GET")
     * @Apidoc\Tag("imagick")
     * @Apidoc\Param("qq", type="string",require=true, desc="QQ号和图像二选一" )
     * @Apidoc\Param("text", type="string",require=true, desc="内容" )
     * @Apidoc\Param("name", type="string",require=true, desc="昵称" )
     * @Apidoc\Param("image", type="string",require=false, desc="base图像数据" )
     * @Apidoc\Returned("image", type="binary", desc="图像")
     */
    public function my_friend()
    {
        $qq = input('qq',0);
        $text=input('text','');
        $name=input('name','朋友');
        $image=input('post.image',null);
        $style1['font']=WEB_ROOT.'font/msyh.ttf';
        $style1['font_size'] = 25;
        $style1['fill_color']='#868894';
        $style2['font']=WEB_ROOT.'font/msyh.ttf';
        $style2['font_size'] = 40;
        $style2['fill_color']='#000000';
        $arr1=imagettfbbox($style1['font_size'], 0, $style1['font'], $name);
        $arr2=imagettfbbox(30, 0, $style2['font'], $text);
        $width1=$arr1[2]-$arr1[0];
        $width2=$arr2[2]-$arr2[0];
        $canvas = new Imagick();
        $canvas ->newImage(max($width1+15,$width2)+240, 210, 'rgb(234,237,246)');
        $canvas->setImageFormat("png");
        if($image!==null){
            $head=new Imagick();
            $head->readImageBlob(base64_decode($image));
            $head->resizeImage(100,100,Imagick::FILTER_LANCZOS, 1);
        }
        else{
            $head=new Imagick("https://q1.qlogo.cn/g?b=qq&nk=$qq&s=100");
        }
        $rank=new Imagick(WEB_ROOT.'my_friend/2.png');
        $tail=new Imagick(WEB_ROOT.'my_friend/0.png');
        $head->roundCorners($head->getImageWidth() / 2, $head->getImageHeight() / 2);
        $canvas->compositeImage($head,Imagick::COMPOSITE_OVER, 20, 20);
        $canvas->compositeImage($rank,Imagick::COMPOSITE_OVER, 160, 25);
        $draw = new ImagickDraw();
        $draw->setFillColor('white');
        $draw->roundRectangle(160, 80, 160+$width2+50, 80+110, 40, 40);
        $canvas->drawImage($draw);
        $canvas->compositeImage($tail,Imagick::COMPOSITE_OVER, 125, 60);
        $this->textttf($canvas,$name,260,50,$style1,'left');
        $this->textttf($canvas,$text,180,150,$style2,'left');
        header("Content-Type: image/png");
        ob_end_clean();
        echo $canvas->getImageBlob();
    }
    /**
     * @Apidoc\Title("运势接口")
     * @Apidoc\Url("/api/fortune")
     * @Apidoc\Method("GET")
     * @Apidoc\Returned("image", type="binary", desc="图像")
     */
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
        $this->textttf($img, $title, 140, 120,$style1);
        if (mb_strlen($text) <= 16) {
            $this->textttf($img, $text, 140, 190,$style2);
        } else if (mb_strlen($text) <= 32) {
            $this->textttf($img, mb_substr($text, 0, 16), 110, 190, $style2);
            $this->textttf($img, mb_substr($text, 16), 170, 190, $style2);
        } else {
            $this->textttf($img, mb_substr($text, 0, 16), 100, 190,$style2);
            $this->textttf($img, mb_substr($text, 16, 16), 140, 190, $style2);
            $this->textttf($img, mb_substr($text, 32), 180, 190,$style2);
        }
        ob_end_clean();
        echo $img->getImageBlob();
    }
    /**
     * @Apidoc\Title("签到接口")
     * @Apidoc\Url("/api/qiandao")
     * @Apidoc\Method("GET")
     * @Apidoc\Param("qq", type="string",require=true, desc="QQ号" )
     * @Apidoc\Param("name", type="string",require=true, desc="昵称" )
     * @Apidoc\Returned("image", type="binary", desc="图像")
     */
    public function qiandao()
    {
        $qq = input('qq');
        $name = input('name');
        $url = "https://q1.qlogo.cn/g?b=qq&nk=$qq&s=640";
        $canvas = new Imagick($url);
        $format = strtolower($canvas->getImageFormat());
        $width=$canvas->getImageWidth();
        $height=$canvas->getImageHeight();
        $rectangle_height=ceil($height*0.12);
        $top=ceil($height-2*$rectangle_height-$height*0.08);
        $margin_top=ceil($rectangle_height*0.45);
        $style['font_size'] = ceil($height*0.04);
        $style['fill_color'] = '#FFFFFF';
        $style['font'] = WEB_ROOT . "qiandao/REEJI-HonghuangLiGB-SemiBold.ttf";
        $style2['font_size'] = ceil($height*0.03);
        $style2['fill_color'] = '#FFFFFF';
        $style2['font'] = WEB_ROOT . "qiandao/REEJI-HonghuangLiGB-SemiBold.ttf";
        header('Content-type: ' . $format);
        $data=Db::name($this->table)->where('qq', $qq)->find();
        $gmp = rand(1, 200);
        if (!$data) {
            $success = 1;
            $continus = 1;
            Db::name($this->table)->insert(array(
                'qq' => $qq,
                'name' => $name,
                'continus' => 1,
                'msuccess' => 1,
                'success' => 1,
                'gmp' => $gmp,
                'time' => date('Y-m-d H:i:s')
            ));
        }
        else {
            if (date('z', time()) == date('z', strtotime($data['time']))) {
                $draw=new ImagickDraw();
                $draw->setFillOpacity(0.3);
                $draw->roundRectangle($width*0.05,$top,$width-$width*0.05,$top+2*$rectangle_height,30,30);
                if ($format == 'gif') {
                    foreach ($canvas as $frame) {
                        $frame->drawImage($draw);
                    }
                }
                else{
                    $canvas->drawImage($draw);
                }
                $this->textttf($canvas,$name,$width/2,$top+1.5*$margin_top,$style);
                $this->textttf($canvas,'签到失败，重复签到',$width/2,$top+3*$margin_top,$style);
                header("Content-Type: image/".$format);
                ob_end_clean();
                echo $canvas->getImagesBlob();
                return false;
            }
            $success = $data['success'] + 1;
            $yesterday=date('z',mktime(0, 0, 0, date("m"),date("d")-1,date("Y")));
            $continus=$yesterday== date('z', strtotime($data['time']))? ($data['continus'] + 1): 1;//考虑到跨年
            $msuccess = date('F', time()) == date('F', strtotime($data['time'])) ? ($data['msuccess'] + 1) : 1;
            Db::name($this->table)->where('qq', $qq)->update(array(
                'name' => $name,
                'continus' => $continus,
                'msuccess' => $msuccess,
                'success' => $success,
                'gmp' => $gmp + $data['gmp'],
                'time' => date('Y-m-d H:i:s')
            ));
        }
        $day_arr = Db::query("SELECT qq FROM $this->table WHERE DATEDIFF(time,NOW())=0 order by time");
        foreach ($day_arr as $k=>$v){
            if($v['qq']==$qq){
                $day_order=$k+1;
            }
        }
        $draw=new ImagickDraw();
        $draw->setFillOpacity(0.3);
        $draw->roundRectangle($width*0.05,$top,$width-$width*0.05,$top+2*$rectangle_height,30,30);
        if ($format == 'gif') {
            foreach ($canvas as $frame) {
                $frame->drawImage($draw);
            }
        }
        else{
            $canvas->drawImage($draw);
        }
        $this->textttf($canvas,$name,$width/2,$top+$margin_top,$style);
        $this->textttf($canvas,'签到成功',$width/2,$top+2*$margin_top,$style);
        $this->textttf($canvas,' 签到天数 '.$success.'    连续签到 '.$continus.' ',$width/2,$top+3*$margin_top,$style2);
        $this->textttf($canvas,' GMP ' .($data['gmp'] + $gmp).'    今日第 '.$day_order.' 名 ',$width/2,$top+4*$margin_top,$style2);
        header("Content-Type: image/".$format);
        ob_end_clean();
        echo $canvas->getImagesBlob();
        return false;
    }
    /**
     * @Apidoc\Title("gif字幕合成接口")
     * @Apidoc\Url("/api/ass2gif")
     * @Apidoc\Method("GET")
     * @Apidoc\Param("type", type="string",require=true, desc="类型" )
     * @Apidoc\Param("data", type="array",require=true, desc="字幕数组" )
     * @Apidoc\Returned("msg", type="string", desc="返回信息")
     * @Apidoc\Returned("code", type="int", desc="状态码")
     * @Apidoc\Returned("url", type="string", desc="返回url")
     */
    public function ass2gif()
    {
        $type = input('type');
        $data = input('data');
        $request_time = time();
        $dir=WEB_ROOT . 'templates/cache/';
        if(!is_dir($dir)){
            mkdir($dir);
        }
        if ($type && $data) {
            $TEMP_ROOT = WEB_ROOT. 'templates/' . $type . '/';
            $TEMP_ASS = $TEMP_ROOT . 'template.ass';
            $CACHE_ASS_PATH = WEB_ROOT. 'templates/cache/' . $type . '_' . $request_time . '.ass';
            $TEMP_VIDEO = $TEMP_ROOT . 'template-small.mp4';
            if (file_exists($TEMP_ROOT)) {
                $ass_file = file_get_contents($TEMP_ASS);
                for ($i = 0; $i < count($data); $i++) {
                    $str_source[$i] = '<?=[' . $i . ']=?>';
                }
                $change_ass = str_replace($str_source, $data, $ass_file);
                $create_temporary_ass = fopen($CACHE_ASS_PATH, "w");
                fwrite($create_temporary_ass, $change_ass);
                fclose($create_temporary_ass);
                $out_put_file = $dir. $request_time . '.gif';
                $command = 'ffmpeg -y -i ' . $TEMP_VIDEO . ' -vf "ass=' . $CACHE_ASS_PATH . '" ' . $out_put_file;
                system($command);
                unlink($CACHE_ASS_PATH);
            } else {
                return error('该模板文件不存在！');
            }
        } else {
            return error('缺少必要参数，请检查！');
        }
        return success("生成成功",['url'=>request()->domain()."/templates/cache/$request_time.gif"]);
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
                $imagick->annotateImage($draw, $x, $y, 0, $text);
            }
        } else {
            $imagick->annotateImage($draw, $x, $y, 0, $text);
        }
    }
}
