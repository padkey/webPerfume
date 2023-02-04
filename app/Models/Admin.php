<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;// cái này coppy bên user ,user tự có
use Illuminate\Foundation\Auth\User as Authenticatable; // cái này coppy bên user ,user tự có , models Admin sẽ sử dụng các chức năng của class User này

class Admin extends Authenticatable // thay vì model mình thừa kê authenticatable để xài chức năng
{
    use HasFactory;
    public $timestamps = false;
  protected $fillable = ['admin_email','admin_password','admin_name','admin_phone'];
  protected $primaryKey = 'admin_id';
  protected $table = 'tbl_admin';

  public function roles(){
      return $this->belongsToMany('App\Models\Roles'); // admin có nhiều roles(quyền)
  }
  //hàm trả về password của admin
  public function getAuthPassword(){ // đây thì chức năng của class user mà provider đã phát triển
      return $this->admin_password; // thay vì trả về password theo mặc định , thì mình trả về admin_password cho phù hợp
  }

  public function hasAnyRoles($roles){ //nhiều quyền
      return null !== $this->roles()->whereIn('name',$roles)->first();
  }
  public function hasRole($role){ //một quyền
      return null !== $this->roles()->where('name',$role)->first(); // $role là giá trị admin,author,user , nếu có roles thì lấy ra, còn không thì trả về null
  }


}
