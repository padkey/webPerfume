<?php

namespace App\Http\Controllers;


//sử dung session
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Auth;
use App\Models\Video;
use App\Models\CatePost;
use DB;

class VideoController extends Controller
{
    //kiểm tra login
    public function authLogin(){
        $adminId = Auth::id();
        if($adminId){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    public function allVideo(){
        return view('admin.video.allVideo');
    }
    public function selectVideo(Request $req){
        $video = Video::orderby('video_id','DESC')->get();
        $countVideo = $video->count();
        $output =' <table class="table table-striped b-t b-light">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Video Title</th>
                        <th>Slug</th>
                        <th>Image</th>
                        <th>Link</th>
                        <th>Description</th>
                        <th>Demo</th>
                        <th>Management</th>
                    </tr>
                    </thead>
                    <tbody>';

        //kiểm tra xem có video không
        if($countVideo >0){
            $i=1;
            foreach ($video as $key => $vid){
                $output .= '<tr>
                                <td>'.$i++.'</td>
                                <td contenteditable  class="editVideo" data-action="video_title" data-id="'.$vid->video_id.'">'.$vid->video_title.'</td>
                                <td contenteditable class="editVideo" data-action="video_slug" data-id="'.$vid->video_id.'">'.$vid->video_slug.'</td>
                                <td>
                                <img  width="150" src="'.url('public/uploads/videos/'.$vid->video_image).'" class="img-thumbnail">
                                <input type="file" name="videoImage" class ="editVideoImage" id="fileImage-'.$vid->video_id.'" data-id="'.$vid->video_id.'" accept="image/*">
                                </td>
                                <td contenteditable class="editVideo" data-action="video_link" data-id="'.$vid->video_id.'">https://youtu.be/'.$vid->video_link.' </td>
                                <td contenteditable class="editVideo" data-action="video_des" data-id="'.$vid->video_id.'">'.$vid->video_des.'</td>
                                <td>
                                    <iframe width="200" height="150" src="https://www.youtube.com/embed/'.$vid->video_link.'"
                                    title="YouTube video player" frameborder="0" allow="accelerometer; autoplay;
                                     clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
                                    </iframe>
                                 </td>
                                <td><button type="button" class="btn btn-danger deleteVideo" data-id="'.$vid->video_id.'">Delete</button></td>
                            </tr>';
            }
        }else{
            $output .='<tr>There are no video yet !</tr>';
        }

        $output .='</tbody></table>';
        echo $output;
    }

    public function saveVideo(Request $req){
        $video = new Video();
        $video->video_title = $req->videoTitle;
        $video->video_slug = $req->videoSlug;
        $video->video_des = $req->videoDes;
        // cái link video ta chỉ cần lấy cái đuôi thôi nên ta cắt phần đầu đi bằng hàm subtr()
        $subLink = substr($req->videoLink,17);
        $video->video_link = $subLink;
        $getImage = $req->file('fileVideoImage');
        if($getImage){
            $fullNameImage = $getImage->getClientOriginalName();
            $nameImage = current(explode('.',$fullNameImage));
            $newName = $nameImage.rand(0,99).'.'.$getImage->getClientOriginalExtension();

            $getImage->move('public/uploads/videos',$newName);

            $video->video_image = $newName;
        }

        $video->save();
    }
    public function updateVideo (Request $req){
   //khi thêm cột mới vd:video_slug thì phải vào trong model khai báo, nếu không là update không được

        //coppy từ video dán vào chứ, sửa trên đường link là lỗi
        if($req->action == 'video_link'){
            $req->value = substr($req->value,17); //cắt đầu lấy đuôi thôi
        }
        Video::find($req->videoId)->update([$req->action => $req->value]);
    }
    public function updateVideoImage(Request $req){
        //tìm video qua id
        $video = Video::find($req->videoId);
        $getImage = $req->file('fileVideoImage');
        if($getImage){
            //xóa image cũ đi bằng hàm unlink()
            unlink('public/uploads/videos/'.$video->video_image);
            //thêm video mới
            $fullNameImage = $getImage->getClientOriginalName();
            $nameImage = current(explode('.',$fullNameImage));
            $newName = $nameImage.rand(0,99).'.'.$getImage->getClientOriginalExtension();

            $getImage->move('public/uploads/videos',$newName);
            $video->video_image = $newName;
            $video->save(); // lưu lại
        }
    }
    public function deleteVideo(Request $req){
        $video = Video::find($req->videoId);
        //xóa hình
        unlink('public/uploads/videos/'.$video->video_image);
        $video->delete();
    }

    /// END ADMIN PAGE



    public function listVideo(Request $req){


        $metaDes = "video review perfume";
        $metaKeywords = "video review perfume, video review nước hoa";
        $metaTitle = 'video review perfume '; // tiêu đề
        $urlCanonical = $req->url(); //lấy ra đường dẫn hiện tại của trang mình đang truy cập
        // ----------- End Seo -----------\\


        $allVideo = Video::orderby('video_id','DESC')->paginate(5);
        return view('pages.video.listVideo')
            ->with(compact('urlCanonical','metaTitle',
                'metaKeywords','metaDes', 'allVideo'));
    }

    public function watchVideo(Request $req){
        $video = Video::find($req->videoId);
        $output['videoTitle'] = $video->video_title; // videoTitle là key , còn = đằng là value , khi gửi qua ajax thì dễ xử lú, gọi key ra là được khỏi cần chạy vòng lặp
        $output['videoLink'] = '<iframe width="700px" height="500px" src="https://www.youtube.com/embed/'.$video->video_link.'"
                                    title="YouTube video player" frameborder="0" allow="accelerometer; autoplay;
                                     clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
                                    </iframe>';
        // dùng hàm encode để gửi giữ liệu json qua ajax
        echo json_encode($output);
    }
}
