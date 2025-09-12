document.getElementById('addForm1').onclick = function (ev) {

    document.getElementById('addformContent1').insertAdjacentHTML('beforeend',`
    
    
    <div class="wraper form-group grid grid-cols-7 gap-3 px-4 lg:grid-cols-2 fsm:grid-cols-1 mb-5 pb-5 border-b border-slate-300 ElIn">
                    <div class="col-span-2 fsm:col-span-1">
                        <h2 class="text-sm mr-4 mb-2 font-semibold text-slate-400">نام کاربری</h2>
                        <input class="form-input text-smid w-full" type="text" placeholder="نام کاربری..">
                    </div>
                    <div class=" col-span-2 fsm:col-span-1">
                        <h2 class="text-sm mr-4 mb-2 font-semibold text-slate-400">رمز</h2>
                        <input class="form-input text-smid w-full" type="text" placeholder="********">
                    </div>

                    <div class="">
                        <h2 class="text-sm mr-4 mb-2 font-semibold text-slate-400">نام پدر</h2>
                        <input class="form-input text-smid w-full" type="text" placeholder="نام پدر..">
                    </div>

                    <div class="">
                        <h2 class="text-sm mr-4 mb-2 font-semibold text-slate-400">جنسیت</h2>
                        <select class="form-input text-smid w-full">
                            <option value="1">مرد</option>
                            <option value="2">زن</option>
                        </select>
                    </div>

                    <div class="">
                        <h2 class="text-sm mr-4 mb-2 font-semibold text-slate-400">عمل</h2>

                        <button class="btn line text-rose-500 bg-rose-500/10 hover:bg-rose-500/100 inline-block rounded-md border-rose-500 focus:bg-rose-600 focus:border-rose-600 focus:ring-2 focus:ring-rose-600 focus:ring-offset-2 focus:text-slate-50 hover:text-slate-50" onclick="closeForm(this)">
                        <span class="inline text-smid">
                            حذف
                        </span>
                            <span class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="">
  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
</svg>

                            </span>

                        </button>
                    </div>

                </div>
    
    `)

}


function closeForm(El) {

    let group = El.closest('.form-group');


    group.classList.remove('ElIn')
    group.classList.add('ElOut')


    setTimeout(function ()  {

        group.remove()

    },500)

}