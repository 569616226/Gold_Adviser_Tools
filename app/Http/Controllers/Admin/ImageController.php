<?php
/*
 * 项目图片
 * 
 * */

namespace App\Http\Controllers\Admin;

use App\Models\Hand;
use App\Models\Image;
use App\Models\Item;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Yuansir\Toastr\Facades\Toastr;


class ImageController extends BaseController
{
    /**
     * CustomerController constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /*
     * 上传图片到服务器
     *
     * 首先我使用Image模型的验证数组验证输入，
     * 在那里我指定了图片格式并声明图片是必填项。
     * 你也可以添加其它约束，比如图片尺寸等。
     * 如果验证失败，后台会发送错误响应，Croppic也会弹出错误对话框。
     * 注：原生的弹出框看上去真的很丑，所以我总是使用SweetAlert，
     * 要使用SweetAlert可以在croppic.js文件中搜索alert并将改行替换成：sweetAlert("Oops...", response.message, 'error');
     * 当然你还要在HTML中引入SweetAlert相关css和js文件。
     * 我们使用sanitize和createUniqueFilename方法创建服务器端文件名
     *
     * */
    public function upload($item_id)
    {
        $item = Item::find($item_id);

        $username = '/uploads/users/' . $item->hands->users->code . '/';//目录路径

        $photo_data = Input::all();
        $validator = Validator::make($photo_data, Image::$rules, Image::$messages);

        if( $validator->fails() )
        {
            return Response::json([
                'success'   => false,
                'status' => 'error',
                'message' => $validator->messages()->first(),
            ], 200);
        }

        $photo = $photo_data[ 'img' ];

        if($photo->getSize() > 1048576){
            return Response::json([
                'success'   => false,
                'status' => 'error',
                'message' => '图片不能大于1M',
            ], 200);
        }

        $original_name = $photo->getClientOriginalName();
        $original_name_without_ext = (json_encode(substr($original_name, 0, strlen($original_name) - 4)));
        $imageExt = substr($original_name, -3);
        $filename = $this->sanitize($original_name_without_ext);
        $allowed_filename = $this->createUniqueFilename($username,$filename, $imageExt);
        $filename_ext = $allowed_filename.'.'.$imageExt;

        $manager = new ImageManager();
        if(!is_dir(public_path().$username)){
            mkdir(public_path().$username,0777,true);
        }
        $image = $manager->make($photo)->encode($imageExt)->save(public_path().$username.$filename_ext);
        $image = $manager->make($photo)->encode($imageExt)->save(public_path().$username.$filename_ext);

        if( !$image )
        {
            return Response::json([
                'success'   => false,
                'status' => 'error',
                'message' => '图片上传失败',
            ], 200);
        }

        return Response::json([
            'success'   => true,
            'status'    => 'success',
            'url'       => asset($username. $filename_ext),
            'width'     => $image->width(),
            'height'    => $image->height()
        ], 200);

//        return redirect(route('item.index'));

    }

    private function sanitize($string, $force_lowercase = true, $anal = false)
    {
        $strip = array( "~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]", "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;", "â€”", "â€“", ",", "<", ".", ">", "/", "?" );
        $clean = trim(str_replace($strip, "", strip_tags($string)));
        $clean = preg_replace('/\s+/', "-", $clean);
        $clean = ( $anal ) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean;

        return ( $force_lowercase ) ? ( function_exists('mb_strtolower') ) ? mb_strtolower($clean, 'UTF-8') : strtolower($clean) : $clean;
    }

    private function createUniqueFilename($username,$filename, $imageExt)
    {
        $upload_path = public_path().$username;
        $full_image_path = $upload_path.$filename.'.'.$imageExt;

        if( File::exists($full_image_path) )
        {
            // Generate token for image
            $image_token = substr(sha1(mt_rand()), 0, 5);

            return $filename.'-'.$image_token;
        }
        return $filename;
    }


    public function postCrop($item_id)
    {
        $item = Item::find($item_id);
        $username = '/uploads/users/'.$item->hands->users->code.'/';//目录路径
        $form_data = Input::all();
        $image_url = $form_data['photo'];

        // resized sizes
        $imgW = 304;
        $imgH = 304;
        // offsets
        $imgY1 = $form_data['x'];
        $imgX1 = $form_data['y'];
        // crop box
        $cropW = $form_data['w'];
        $cropH = $form_data['h'];
        // rotation angle
//        $angle = 5;

        $filename_array = explode('/', $image_url);
        $filename = $filename_array[sizeof($filename_array)-1];

        $manager = new ImageManager();
        $image = $manager->make($image_url );
        $image->resize($imgW, $imgH)
            ->crop($cropW, $cropH, $imgX1, $imgY1)
            ->save(public_path() . $username . 'cropped-' . $filename);

        if( !$image) {
            Toastr::error('图片上传错误');
        }

        $itemIds = Image::all()->pluck('item_id')->toArray();
        if( in_array($item_id, $itemIds) )
        {
            $database_image = $item->images;
            $database_image->name = $filename;
            $database_image->url = asset($username. 'cropped-' . $filename);
            $database_image->item_id = $item_id;
            $database_image->save();
        }else{
            $database_image = new Image();
            $database_image->name = $filename;
            $database_image->url = asset($username . 'cropped-' . $filename);
            $database_image->item_id = $item_id;
            $database_image->save();
        }

        Toastr::success('图片上传成功');

        return redirect(route('item.edit',[$item_id]));
    }
}
