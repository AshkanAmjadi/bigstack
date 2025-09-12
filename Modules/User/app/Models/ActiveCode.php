<?php

namespace Modules\User\App\Models;



use Illuminate\Database\Eloquent\Model;

class ActiveCode extends Model
{

    protected $fillable = [
        'phone',
        'code',
        'expired_at'
    ];

    public $timestamps = false;


    public function scopeVerifyCode($query , $code,  $phone)
    {
        return !! ActiveCode::query()->where(['code'=>$code,'phone'=>$phone])->where('expired_at' , '>' , now())->first();
    }

    public function DeleteAllExpiredCode(){

        $this::where('expired_at' , '<' , now())->delete();

    }

    public function scopeGenerateCode($query , $phone)
    {
//        if($code = $this->getAliveCodeForUser($phone)) {
//            $code = $code->code;
//        } else {
//
//        }

        $this->DeleteAllExpiredCode();


        ActiveCode::query()->where(['phone'=>$phone])->delete();

        do {
            $code = mt_rand(100000, 999999);
        } while($this->checkCodeIsUnique($phone , $code));

        // store the code
        ActiveCode::query()->create([
            'code' => $code,
            'phone' => $phone,
            'expired_at' => now()->addMinutes(3)
        ]);
        //todo sendsms

        return $code;
    }

    private function checkCodeIsUnique($phone, int $code)
    {
        return !! ActiveCode::query()->where(['code'=>$code,'phone'=>$phone])
            ->first();
    }

    private function getAliveCodeForUser($phone)
    {
        return ActiveCode::query()->where(['phone'=>$phone])->where('expired_at' , '>' , now())->first();
    }

}
