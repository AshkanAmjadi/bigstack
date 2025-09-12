<?php

namespace Modules\User\App\Http\Controllers\Admin;

//todo درست کن کوپن و رول و پرمیشن رو
use App\facade\BaseImage\BaseImage;
use App\facade\BaseMethod\BaseMethod;
use App\facade\BaseRequest\BaseRequest;
use App\facade\BaseValidation\BaseValidation;
use App\Http\Controllers\Controller;
use Modules\User\App\Models\Permission;
use Modules\User\App\Models\Rule as RuleModel;
use Modules\User\App\Models\User;
use Modules\User\App\Models\UserAllert;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;


class UserController extends Controller
{


    private $prefix = 'admin.users.';
    private $model = 'users';
    private $name = 'user';

    private $module = 'user::';


    public function __construct()
    {
//        $this->middleware('can:show_'.$this->model)->only(['index']);
//        $this->middleware('can:create_'.$this->name)->only(['create' , 'store']);
//        $this->middleware('can:edit_'.$this->name)->only(['edit' , 'update']);
//        $this->middleware('can:delete_'.$this->name)->only(['destroy']);
//        $this->middleware('can:'.$this->name.'_permission')->only(['permission','setPermission']);
    }


    public function index(Request $request)
    {


//        dd($request);

        $users = User::query()->orderBy('id', 'desc')->withUserData();

        if ($keyword = \request('search')) {
            $users = $users
                ->where('email', 'LIKE', "%{$keyword}%")
                ->orWhere('name', 'LIKE', "%{$keyword}%")
                ->orWhere('username', 'LIKE', "%{$keyword}%")
                ->orWhere('id', $keyword)
                ->orWhereHas('phones', function ($query) use ($keyword) {
                $query->where('phone', 'like', '%' . $keyword . '%');
            });
        }

        if (\request('admin') == 1) {
            $users = $users->where('superuser', 1)->orWhere('staff', 1)->orWhere('boss', 1);
        }


        $list = $users->paginate(20);

//        dd($list);

        return view($this->module.$this->prefix . $this->model, compact('list'));

    }

    public function create()
    {
        return view($this->module."admin.$this->model.create.$this->model");

    }

    public function store(Request $request)
    {
//        dd($request->all());
        $data = $this->validationUser($request);

        $newData = $this->getNeedData($data);

        $user = User::query()->create($newData);

        BaseImage::saveBase64image(Arr::get($data, 'avatar'), $user, 'avatar');

        $this->setAcl($data, $user);

        alert()->success('ثبت شد', 'همه چی به خوبی ثبت شد 👍😉')->persistent(true, false)->timerProgressBar();

        return redirect(route($this->prefix . 'index'));

    }

    public function edit(User $user)
    {
        return view($this->module."admin.$this->model.create.$this->model", compact($this->name));


    }

    public function update(Request $request, User $user)
    {

        $data = $this->validationUser($request, true, $user);

        $newData = $this->getNeedData($data);

        $user->update($newData);

        BaseImage::saveBase64image(Arr::get($data, 'avatar'), $user, 'avatar');

        $this->setAcl($data, $user);

        toast('اطلاعات ثبت شد 👍😉', 'success')->autoClose(5000)->position('bottom-end')->timerProgressBar();

        return redirect(route($this->prefix . 'index'));
    }

    private function validationUser($request, $update = false, $object = null)
    {


        $unique_validation = 'unique:' . $this->model;

        if ($update) {
            $unique_validation = Rule::unique($this->model)->ignore($object->id);
        }

        BaseRequest::mergePrToEnRequest($request, ['melicode', 'phone', 'birth']);

        $data = $request->validate([

            'name' => ['required', 'string', 'min:3', 'max:100'],
            'username' => [
                'required',
                'string',
                'min:5',
                'max:30',
                $unique_validation,
                function ($attribute, $value, $fail) {
                    if (!preg_match(BaseValidation::validationForUsername(), $value)) {
                        $fail('فرمت اشتباه است');
                    }
                }
                ],
            'email' => ['nullable', 'string', 'email', 'min:3', 'max:200', $unique_validation],
            'email_verify' => [
                'nullable',
                Rule::in('on')
            ],
            'melicode' => ['numeric', 'nullable', BaseValidation::validationForMelicode(), $unique_validation, 'ir_national_id'],
            'phone' => ['nullable', 'numeric', BaseValidation::validationForPhone(), $unique_validation, 'ir_mobile:zero'],
            'phone_verify' => [
                'nullable',
                Rule::in('on')
            ],
            'birth' => [
                'nullable',
                'persian_date',
                function ($attribute, $value, $fail) {
                    if (!preg_match("/^[0-9]{4}\/(|[0-1])[0-9]\/(|[0-3])[0-9]$/", $value)) {
                        $fail('تاریخ اعتبار ندارد');
                    }
                }
            ],
            'gender' => [
                'nullable',
                Rule::in('man', 'woman', 'other')
            ],
            'acl' => [
                'nullable',
                Rule::in('superuser', 'boss', 'staff', 'user')
            ],

            'avatar' => ['nullable', 'string', 'base64max:512', 'base64image:image', 'base64mimes:webp,png,jpeg,jpg',
                function ($attribute, $value, $fail) {
                    BaseValidation::base64ratio($attribute, $value, $fail, 1, 1);
                }
            ],


        ]);


        $data = BaseMethod::setParseDate($data, 'birth');

        $data = setCheckboxValue($data, ['email_verify', 'phone_verify']);

        $data = removeEmptyOnArray($data);

        return $data;

    }

    public function destroy(User $user)
    {
        //todo delete all related befor main delete
        $user->delete();

        alert()->success('حذف شد', 'به صورت کامل حذف شد 👍😉')->persistent(true, false)->timerProgressBar();

        return back();
    }

    private function getNeedData($data)
    {
        $fillable = app(User::class)->getFillable();
        $fillable = unsetValue($fillable, 'avatar');
        return Arr::only($data, $fillable);
    }

    private function setAcl($data, $obj)
    {
        $dataSet = [
            'superuser' => 0,
            'boss' => 0,
            'staff' => 0
        ];
        $acl = isset($data['acl']) ? $data['acl'] : false;
        if ($acl && $acl != 'superuser') {
            if (!$obj->superuser) {

                if ($acl != 'user') {
                    $dataSet[$acl] = 1;
                }
                $obj->update($dataSet);

            }
        }


    }

    public function permission($user)
    {
        $user = User::with(['permissions', 'roles'])->find($user);

        return view($this->module.$this->prefix . 'set_' . $this->model . '_permissions', compact('user'));
    }

    public function allerts(User $user)
    {

        return view($this->module.'admin.users.allerts', compact('user'));
    }

    public function deleteUserAllert(UserAllert $userAllert)
    {
        $userAllert->delete();
    }

    public function setPermission(Request $request, User $user)
    {


//        $request->merge(['permissions' => ['asad','5','6','13']]);

//        dd($request->all());

        $data = $request->validate([
            'permissions' => [
                'array',
                function ($attribute, $value, $fail) {
                    foreach ($value as $item) {

                        if (BaseValidation::pregForNum($item)) {
                            if (Permission::query()->select('id')->find($item) === null) {
                                alert()->error('دسترسی یافت نشد');
                                $fail($attribute . 'not found id:' . $item);
                            }
                        } else {
                            alert()->error('دسترسی ها باید به عدد باشن');
                            $fail('its must be int');
                        }

                    }
                }
            ],
            'roles' => [
                'array',
                function ($attribute, $value, $fail) {
                    foreach ($value as $item) {

                        if (BaseValidation::pregForNum($item)) {
                            if (Role::query()->select('id')->find($item) === null) {
                                $fail($attribute . 'not found id:' . $item);
                            }
                        } else {
                            $fail($attribute . 'keys must be int');
                        }

                    }
                }
            ]
        ]);

        $data = setSelectInputValue($data, ['permissions', 'roles'], []);
//        dd($data);

        $user->permissions()->sync($data['permissions']);
        $user->roles()->sync($data['roles']);

        toast('دسترسی ها و مقام ها اعمال شد 👍😉', 'success')->autoClose(5000)->position('bottom-end')->timerProgressBar();

        return redirect(route($this->prefix . 'index'));
    }

    public function coupon($user)
    {
        $user = User::with(['coupons', 'coupon_usages'])->find($user);


//        dd($user);

        return view($this->module.$this->prefix . 'set_' . $this->model . '_coupon', compact('user'));
    }

    public function unsetUserCoupon(User $user, $coupon)
    {

        $user->coupons()->detach($coupon);

        toast('Discount code' . $user->name . 'It was deactivated 😪', 'success')->autoClose(5000)->position('bottom-end')->timerProgressBar();

        return back();

    }

    public function setCoupon(Request $request, User $user)
    {


//        $request->merge(['permissions' => ['asad','5','6','13']]);

//        dd($request->all());

        $data = $request->validate([
            'coupon' => [
                function ($attribute, $value, $fail) use ($user) {
                    if ($object = Coupon::query()->with([
                        'users' => function ($query) use ($user) {
                            $query->where('user_id', $user->id)->get(['id']);
                        }
                    ])->find($value, ['id', 'name', 'all_user'])) {

                        if ($object->all_user) {
                            $fail('It is active for all users, no need to do this 😉👍');
                        }

                        if ($object->users->toArray() !== []) {
                            $fail('The user already has this discount code 😉👍');
                        }


                    } else {

                        $fail('Discount code not found 🤔');
                    }
                }
            ],
        ]);


        $user->coupons()->attach($data['coupon']);

        toast('Discount code for' . $user->name . 'Activated 👍😉', 'success')->autoClose(5000)->position('bottom-end')->timerProgressBar();

        return redirect(route($this->prefix . 'index'));
    }


}
