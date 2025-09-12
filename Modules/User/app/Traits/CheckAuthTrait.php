<?php

namespace Modules\User\app\Traits;

trait CheckAuthTrait
{
    protected function mustBeLoggedIn() : bool
    {
        if (!auth()->id()) {
            $this->dispatch('toast', title: 'در سایت ثبت نام کنید👈' . htmlAlink(route('auth.login'),'ثبت نام'), type: 'info');
            return false;
        }
        return true;
    }
}
