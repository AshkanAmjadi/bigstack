document.querySelectorAll('[data-allert]').forEach(function (El) {

    if (El.getAttribute('data-allert') === '1') {
        El.onclick = function () {
            Swal.fire({
                title: 'خوش آمدید 👋',
                confirmButtonText: 'مرسی'
            })
        }
    } else if (El.getAttribute('data-allert') === '2') {
        El.onclick = function () {
            Swal.fire({
                title: 'اینترنت؟',
                text: 'هنوز این اطراف وجود داره؟',
                icon: 'question',
                confirmButtonText: 'بله',
                confirmButtonColor: 'rgb(16 185 129)',
                denyButtonText: 'خیر',
                showDenyButton: true

            })
        }
    } else if (El.getAttribute('data-allert') === '3') {
        El.onclick = function () {
            Swal.fire({
                icon: 'error',
                title: 'اوپس..',
                text: 'Something went wrong!',
                confirmButtonText: 'ادامه',
                footer: '<a href="#">چطور مشکلو حل کنم?</a>'
            })
        }
    } else if (El.getAttribute('data-allert') === '4') {
        El.onclick = function () {
            Swal.fire({
                title: '<strong>اچ تی ام ال <u>مثال</u></strong>',
                icon: 'info',
                html:
                    'میتوانید <b>عنوان ضخیم</b>, ' +
                    '<a href="//sweetalert2.github.io">لینک ها</a> ' +
                    'و دیگر تگ های اچ تی ام ال را استفاده کنید',
                showCloseButton: true,
                showDenyButton: true,
                confirmButtonColor: 'rgb(16 185 129)',
                focusConfirm: false,
                confirmButtonText:
                    '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">\n' +
                    '  <path d="M1 8.25a1.25 1.25 0 112.5 0v7.5a1.25 1.25 0 11-2.5 0v-7.5zM11 3V1.7c0-.268.14-.526.395-.607A2 2 0 0114 3c0 .995-.182 1.948-.514 2.826-.204.54.166 1.174.744 1.174h2.52c1.243 0 2.261 1.01 2.146 2.247a23.864 23.864 0 01-1.341 5.974C17.153 16.323 16.072 17 14.9 17h-3.192a3 3 0 01-1.341-.317l-2.734-1.366A3 3 0 006.292 15H5V8h.963c.685 0 1.258-.483 1.612-1.068a4.011 4.011 0 012.166-1.73c.432-.143.853-.386 1.011-.814.16-.432.248-.9.248-1.388z" />\n' +
                    '</svg>\n',
                denyButtonText:
                    '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">\n' +
                    '  <path d="M18.905 12.75a1.25 1.25 0 01-2.5 0v-7.5a1.25 1.25 0 112.5 0v7.5zM8.905 17v1.3c0 .268-.14.526-.395.607A2 2 0 015.905 17c0-.995.182-1.948.514-2.826.204-.54-.166-1.174-.744-1.174h-2.52c-1.242 0-2.26-1.01-2.146-2.247.193-2.08.652-4.082 1.341-5.974C2.752 3.678 3.833 3 5.005 3h3.192a3 3 0 011.342.317l2.733 1.366A3 3 0 0013.613 5h1.292v7h-.963c-.684 0-1.258.482-1.612 1.068a4.012 4.012 0 01-2.165 1.73c-.433.143-.854.386-1.012.814-.16.432-.248.9-.248 1.388z" />\n' +
                    '</svg>\n',
            })
        }
    } else if (El.getAttribute('data-allert') === '5') {
        El.onclick = function () {

            Swal.fire({
                position: 'top',
                icon: 'success',
                title: 'با موفقیت انجام شد',
                showConfirmButton: false,
                timer: 5000
            })
        }

    }else if (El.getAttribute('data-allert') === '6') {
        El.onclick = function () {

            Swal.fire({
                position: 'top-start',
                icon: 'success',
                title: 'با موفقیت انجام شد',
                showConfirmButton: false,
                timer: 5000
            })
        }

    }else if (El.getAttribute('data-allert') === '7') {
        El.onclick = function () {

            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'با موفقیت انجام شد',
                showConfirmButton: false,
                timer: 5000
            })
        }

    }else if (El.getAttribute('data-allert') === '8') {
        El.onclick = function () {

            Swal.fire({
                position: 'bottom',
                icon: 'success',
                title: 'با موفقیت انجام شد',
                showConfirmButton: false,
                timer: 5000
            })
        }

    }else if (El.getAttribute('data-allert') === '9') {
        El.onclick = function () {

            Swal.fire({
                position: 'bottom-start',
                icon: 'success',
                title: 'با موفقیت انجام شد',
                showConfirmButton: false,
                timer: 5000
            })
        }

    }else if (El.getAttribute('data-allert') === '10') {
        El.onclick = function () {

            Swal.fire({
                position: 'bottom-end',
                icon: 'success',
                title: 'با موفقیت انجام شد',
                showConfirmButton: false,
                timer: 5000
            })
        }

    }else if (El.getAttribute('data-allert') === '11') {
        El.onclick = function () {

            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'با موفقیت انجام شد',
                showConfirmButton: false,
                timer: 5000
            })
        }

    }else if (El.getAttribute('data-allert') === '12') {
        El.onclick = function () {

            Swal.fire({
                position: 'center-start',
                icon: 'success',
                title: 'با موفقیت انجام شد',
                showConfirmButton: false,
                timer: 5000
            })
        }

    }else if (El.getAttribute('data-allert') === '13') {
        El.onclick = function () {

            Swal.fire({
                position: 'center-end',
                icon: 'success',
                title: 'با موفقیت انجام شد',
                showConfirmButton: false,
                timer: 5000
            })
        }

    } else if (El.getAttribute('data-allert') === 'toast-5') {
        El.onclick = function () {

            Swal.fire({
                position: 'top',
                icon: 'success',
                toast : true,
                timerProgressBar : true,
                title: 'با موفقیت انجام شد',
                showConfirmButton: false,
                timer: 5000
            })
        }

    }else if (El.getAttribute('data-allert') === 'toast-6') {
        El.onclick = function () {

            Swal.fire({
                position: 'top-start',
                icon: 'success',
                toast : true,
                timerProgressBar : true,
                title: 'با موفقیت انجام شد',
                showConfirmButton: false,
                timer: 5000
            })
        }

    }else if (El.getAttribute('data-allert') === 'toast-7') {
        El.onclick = function () {

            Swal.fire({
                position: 'top-end',
                icon: 'success',
                toast : true,
                timerProgressBar : true,
                title: 'با موفقیت انجام شد',
                showConfirmButton: false,
                timer: 5000
            })
        }

    }else if (El.getAttribute('data-allert') === 'toast-8') {
        El.onclick = function () {

            Swal.fire({
                position: 'bottom',
                icon: 'success',
                toast : true,
                timerProgressBar : true,
                title: 'با موفقیت انجام شد',
                showConfirmButton: false,
                timer: 5000
            })
        }

    }else if (El.getAttribute('data-allert') === 'toast-9') {
        El.onclick = function () {

            Swal.fire({
                position: 'bottom-start',
                icon: 'success',
                toast : true,
                timerProgressBar : true,
                title: 'با موفقیت انجام شد',
                showConfirmButton: false,
                timer: 5000
            })
        }

    }else if (El.getAttribute('data-allert') === 'toast-10') {
        El.onclick = function () {

            Swal.fire({
                position: 'bottom-end',
                icon: 'success',
                toast : true,
                timerProgressBar : true,
                title: 'با موفقیت انجام شد',
                showConfirmButton: false,
                timer: 5000
            })
        }

    }else if (El.getAttribute('data-allert') === 'toast-11') {
        El.onclick = function () {

            Swal.fire({
                position: 'center',
                icon: 'success',
                toast : true,
                timerProgressBar : true,
                title: 'با موفقیت انجام شد',
                showConfirmButton: false,
                timer: 5000
            })
        }

    }else if (El.getAttribute('data-allert') === 'toast-12') {
        El.onclick = function () {

            Swal.fire({
                position: 'center-start',
                icon: 'success',
                toast : true,
                timerProgressBar : true,
                title: 'با موفقیت انجام شد',
                showConfirmButton: false,
                timer: 5000
            })
        }

    }else if (El.getAttribute('data-allert') === 'toast-13') {
        El.onclick = function () {

            Swal.fire({
                position: 'center-end',
                icon: 'success',
                toast : true,
                timerProgressBar : true,
                title: 'با موفقیت انجام شد',
                showConfirmButton: false,
                timer: 5000
            })
        }

    }else if (El.getAttribute('data-allert') === 'info') {
        El.onclick = function () {

            Swal.fire({
                title: 'اطلاعات',
                text: 'این الرت برای اطلاعات است',
                icon: 'info',
                confirmButtonText: 'ادامه',

            })
        }

    }else if (El.getAttribute('data-allert') === 'success') {
        El.onclick = function () {

            Swal.fire({
                title: 'کارت درسته',
                text: 'با موفقیت ذخیره شد',
                icon: 'success',
                confirmButtonText: 'ادامه',

            })
        }

    }else if (El.getAttribute('data-allert') === 'warning') {
        El.onclick = function () {

            Swal.fire({
                title: 'هشدار',
                text: 'مواظب باش',
                icon: 'warning',
                confirmButtonText: 'ادامه',

            })
        }

    }else if (El.getAttribute('data-allert') === 'error') {
        El.onclick = function () {

            Swal.fire({
                title: 'ارور',
                text: 'مشکلی در اطلاعات وجود دارد',
                icon: 'error',
                confirmButtonText: 'ادامه',

            })
        }

    }else if (El.getAttribute('data-allert') === 'question') {
        El.onclick = function () {

            Swal.fire({
                title: 'آیا بیش از بیست سال سن دارید؟',
                icon: 'question',
                focusConfirm: false,
                confirmButtonText: 'بله',
                confirmButtonColor: 'rgb(16 185 129)',
                denyButtonText: 'خیر',
                showDenyButton: true,


            })
        }

    }else if (El.getAttribute('data-allert') === 'toast-info') {
        El.onclick = function () {

            Swal.fire({
                position: 'top-start',
                icon: 'info',
                toast : true,
                timerProgressBar : true,
                title: 'با موفقیت انجام شد',
                showConfirmButton: false,
                timer: 5000,
                customClass : {
                    popup :'colored-toast'
                }
            })
        }

    }else if (El.getAttribute('data-allert') === 'toast-success') {
        El.onclick = function () {

           Swal.fire({
                position: 'top-start',
                icon: 'success',
                toast : true,
                timerProgressBar : true,
                title: 'با موفقیت انجام شد',
                showConfirmButton: false,
                timer: 5000,
               customClass : {
                    popup :'colored-toast'
               }
            })
        }

    }else if (El.getAttribute('data-allert') === 'toast-warning') {
        El.onclick = function () {

            Swal.fire({
                position: 'top-start',
                icon: 'warning',
                toast : true,
                timerProgressBar : true,
                title: 'با موفقیت انجام شد',
                showConfirmButton: false,
                timer: 5000,
                customClass : {
                    popup :'colored-toast'
                }
            })
        }

    }else if (El.getAttribute('data-allert') === 'toast-error') {
        El.onclick = function () {

            Swal.fire({
                position: 'top-start',
                icon: 'error',
                toast : true,
                timerProgressBar : true,
                title: 'با موفقیت انجام شد',
                showConfirmButton: false,
                timer: 5000,
                customClass : {
                    popup :'colored-toast'
                }
            })
        }

    }else if (El.getAttribute('data-allert') === 'toast-question') {
        El.onclick = function () {

            Swal.fire({
                position: 'top-start',
                icon: 'question',
                toast : true,
                timerProgressBar : true,
                title: 'با موفقیت انجام شد',
                showConfirmButton: false,
                timer: 5000,
                customClass : {
                    popup :'colored-toast'
                }
            })
        }

    }

})
