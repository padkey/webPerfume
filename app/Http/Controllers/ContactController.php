<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\CatePost;
use Auth;
use DB;
use Illuminate\Support\Facades\Redirect;
use App\Models\Icon;

class ContactController extends Controller
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
    public function infoManagement(){
        $this->authLogin();
        // contact thì chỉ có một, nên ta không tạo mới, nếu không tồn lại contact thì ta cho nó thành rỗng

        $contact = Contact::first(); // lấy ra thông tin website ,rỗng thì vào trang thêm

        return view('admin.information.information')->with(compact('contact'));
    }

    // contact thì chỉ có một, nên ta không tạo mới, nếu không tồn lại contact thì ta cho nó thành rỗng
    public function updateContact(Request $req){
        $contact = Contact::find($req->infoId);
    if($contact){  // nếu có contact thì update  , khố có thì tạo mới
        $contact->info_address = $req->infoAddress;
        $contact->info_phone = $req->infoPhone;
        $contact->info_map = $req->infoMap;
        $contact->info_fanpage = $req->infoFanpage;
        $contact->info_slogan = $req->infoSlogan;
        $getImage = $req->file('InfoLogo');
        if($getImage){
            $fullNameImage = $getImage->getClientOriginalName();
            $nameImage = current(explode('.',$fullNameImage));
            $newName = $nameImage.rand(0,99).'.'.$getImage->getClientOriginalExtension();
            // xóa hình cũ đi
            unlink('public/uploads/contact/'.$contact->info_logo);
            //thêm hình mới
            $getImage->move('public/uploads/contact',$newName);
            $contact->info_logo = $newName;
        }
        $contact->save();
        return \redirect()->back()->with('message','Updated contact successfully!');
    }else{
        $contact = new Contact();
        $contact->info_address = $req->infoAddress;
        $contact->info_phone = $req->infoPhone;
        $contact->info_map = $req->infoMap;
        $contact->info_fanpage = $req->infoFanpage;
        $getImage = $req->file('InfoLogo');
        if($getImage){
            $fullNameImage = $getImage->getClientOriginalName();
            $nameImage = current(explode('.',$fullNameImage));
            $newName = $nameImage.rand(0,99).'.'.$getImage->getClientOriginalExtension();

            $getImage->move('public/uploads/contact',$newName);

            $contact->info_logo = $newName;
        }
        $contact->save();
        return \redirect()->back()->with('message','Added contact successfully!');
    }

    }
    //================ END ADMIN PAGE=====================


    public function showContact(Request $req){

        //----seo để cho google biết là google biết mình miêu tả trang web như thế này
        $metaDes = "Contact us";
        $metaKeywords = "Contact us";  //keywords này để người dùng nhập trên google xong nó hiện trang web của mình
        $metaTitle = "Contact us"; // tiêu đề
        $urlCanonical = $req->url(); //lấy ra đường dẫn hiện tại của trang mình đang truy cập
        // ----------- End Seo -----------\\

        //lấy ra contact
        $contact = Contact::first();

        return view('pages.contact.showContact')
            ->with(compact('contact',
        'metaTitle','metaKeywords','metaDes','urlCanonical'));
    }

    //ICON
    public function loadIcon(){
        $allIcon = Icon::orderBy('icon_id','DESC')->get();

        $countIcon = $allIcon->count();
        $output = '<table class="table table-striped">
                                      <thead>
                                        <tr>
                                          <th scope="col">#</th>
                                          <th scope="col">Icon name</th>
                                          <th scope="col">Icon link</th>
                                          <th scope="col">Image</th>
                                        </tr>
                                      </thead>
                                      <tbody>';
        $i = 1;
        if($countIcon>0){
            foreach ($allIcon as $key => $icon){
                $output .='
                                        <tr>
                                          <th scope="row">'.$i.'</th>
                                          <td>'.$icon->icon_name.'</td>
                                          <td>'.$icon->icon_link.'</td>
                                          <td><img width="25px" src="'.url('/public/uploads/icons/'.$icon->icon_image).'"></td>
                                          <td><button data-id="'.$icon->icon_id.'" class="btn btn-danger btn-sm deleleIcon">Delete</button></td>
                                        </tr>

                                      ';
                $i++;
            }
        }
        $output .='</tbody></table>';
        echo  $output;

    }

    public function saveIcon(Request $req){
        $icon = new Icon();
        $icon->icon_name = $req->iconName;
        $icon->icon_link = $req->iconLink;
        $getImage = $req->file('iconImage');
        if($getImage){
            $fullNameImage = $getImage->getClientOriginalName();
            $nameImage = current(explode('.',$fullNameImage));
            $newName = $nameImage.time().'.'.$getImage->getClientOriginalExtension();

            //không được để dấu / ở đầu , nó sẽ lỗi không đi tới được đường dẫn
            $getImage->move('public/uploads/icons',$newName);
            $icon->icon_image = $newName;
        }else{
            $icon->icon_image = '';
        }
        $icon->save();
    }
    public function deleteIcon(Request $req){
        $icon = Icon::find($req->iconId);
        //xóa hình bằng hàm unlink('đường dẫn đến hình')
        unlink('public/uploads/icons/'.$icon->icon_image);
        //xóa icon
        $icon->delete();
    }
}
