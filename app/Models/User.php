<?php

namespace App\Models;

use App\Models\OrderManagement\OrderManagement;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Point;

class User extends Authenticatable
{
    use Notifiable;
    // status [1=>'khởi tạo chưa điền hoàn thiện thông tin',2=>'đã điền hoàn thiện thông tin']

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'username', 'parent_id', 'parent_id2', 'order', 'password', 'active', 'phone', 'date_birth', 'address', 'hktt', 'cmt', 'stk', 'ctk', 'bank_id', 'bank_branch', 'sex', 'status', 'avatar_path', 'date_payment'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    private $data = [];

    // get role by relationship nhieu-nhieu by table trung gian role_users
    // table trung gian role_users chứa column role_id và user_id
    public function getRoles()
    {
        return $this
            ->belongsToMany(Role::class, RoleUser::class, 'user_id', 'role_id')
            ->withTimestamps();
    }
    public function CheckPermissionAccess($key_code)
    {
        $roles = auth()->user()->getRoles()->get();
        foreach ($roles as $role) {
            $permissions = $role->getPermissions()->pluck('key_code');
            if ($permissions->contains($key_code)) {
                return true;
            }
        }
        return false;
    }
    // lấy point từ model point
    public function points()
    {
        return $this->hasMany(Point::class, "user_id", "id");
    }
    // lấy pay
    public function pays()
    {
        return $this->hasMany(Pay::class, 'user_id', 'id');
    }

    // lấy user con 20 tầng
    public function childs()
    {
        return $this->hasMany(User::class, 'parent_id', 'id');
    }
    // lấy user cha 20 tầng
    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id', 'id');
    }

    // lấy user con 20 tầng
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'user_id', 'id');
    }

    // lấy bai kiem tra
    public function tasks()
    {
        return $this->hasMany(Task::class, 'user_id', 'id');
    }


    // lấy user con 7 tầng
    public function childs2()
    {
        return $this->hasMany(User::class, 'parent_id2', 'id');
    }
    // lấy user cha 7 tầng
    public function parent2()
    {
        return $this->belongsTo(User::class, 'parent_id2', 'id');
    }


    // lấy list user theo cấp
    public function listUser20($user)
    {
        $i = 1;
        $this->data = [];
        $data = [];
        $userLoop = [$user];
        // dd($userLoop->childs()->first()->childs()->first()->childs()->first()->childs()->first());
        $data =  $this->getListUser20Recusive($userLoop, 1);
        //  $data=collect($data);
        // dd($data->orderby('created_at'));
        return $data;
    }



    // lấy user đệ quy
    public function getListUser20Recusive($userLoop, $i = 1, $imax = 20)
    {
        if ($i <= $imax) {
            if ($userLoop) {
                foreach ($userLoop as $loopItem) {
                    if ($loopItem->childs->count() > 0) {
                        $list = $loopItem->childs()->get();
                        foreach ($list as $item) {
                            $item->level = $i;
                            array_push($this->data, $item);
                        }
                    }
                }
                foreach ($userLoop as $loopItem) {
                    if ($loopItem->childs->count() > 0) {
                        $this->getListUser20Recusive($loopItem->childs, $i + 1);
                    }
                }
            }
        }
        return $this->data;
    }

    // lấy số thứ tự lớn nhất sau đó +1 để được thứ tự mới
    public function getOrderOfNewUser()
    {
        return $this->max('order') + 1;
    }

    // lấy id của thành phần cha mô hình 7 lớp
    public function getParentIdOfNewUser()
    {
        $numberChild = 3;
        // công thức tính tổng số phần tử ở vòng thứ n là x*0 + (x^(n+1)-x)/(x-1);
        // công thức tính số phần tử của vòng thứ n = x^n;
        $numberUserDatabase = $this->whereIn('active', [1, 2])->get()->count();
        if ($numberUserDatabase > 0) {

            $numberUser = $numberUserDatabase + 1;
            // dd(  $numberUserDatabase );
            if ($numberUser <= 4) {
                $stt = 1;
            } else {
                // dd($numberUser);
                $totalCicle = log((($numberUser - 1) * ($numberChild - 1) + $numberChild), $numberChild) - 1;
                // vòng hoàn thiện cuối cùng
                //  dd($totalCicle-floor($totalCicle)==0);
                if ($totalCicle - floor($totalCicle) == 0) {
                    $n = $totalCicle - 1;
                } else {
                    $n = floor($totalCicle);
                }
                // dd($n);
                // tổng số user đến vòng thứ n là
                $totalUser = 1 + (pow($numberChild, $n + 1) - $numberChild) / ($numberChild - 1);
                // tổng số user đến vòng thứ n -1 là
                $totalUserNPrev = 1 + (pow($numberChild, $n + 1 - 1) - $numberChild) / ($numberChild - 1);
                // dd( $numberUserN);
                // dd($numberUserN);
                // số user đã có ở vòng tiếp theo
                $numberUserNNext = $numberUser - $totalUser;
                // dd($numberUserNNext);
                // số user tối đa ở vòng tiếp theo là
                $numberUserMaxNNext = pow($numberChild, $n + 1);
                $start = $totalUserNPrev + 1;
                $end = $totalUser;
                $ck = $end - $start + 1;
                //  dd($start);
                if ($numberUserNNext % $ck == 0) {
                    $stt = $end;
                } else {
                    $m = $numberUserNNext;
                    while ($m >= $ck) {
                        $m = $m % $ck;
                    }
                    //  dd($m);
                    $stt = $start + $m - 1;
                }

                // dd($stt);
                // dd($ck, $start, $end);
            }

            $userParent = $this->whereIn('active', [1, 2])->orderBy('order', 'asc')->offset($stt - 1)->limit(1)->first();
            $parent_id2 = $userParent->id;
            //  dd($stt);
        } else {
            $parent_id2 = 0;
        }
        return $parent_id2;
    }
    // lấy số điểm hiện có

    //get order
    public function orders()
    {
        return $this->hasMany(OrderManagement::class, 'user_id', 'id');
    }

    const PER_PAGE = 10;
}
