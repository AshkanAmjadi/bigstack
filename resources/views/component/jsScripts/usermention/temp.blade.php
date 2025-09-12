<div class="wraper">
    <div class="text-sm mr-4 font-semibold mt-5">mention</div>

    <div id="{{$wraper}}" class="flex flex-wrap  gap-3 mt-3 mb-5">

    </div>

    <div class="relative ">
        <div class="absolute topToCenter right-2 z-[1]">
            <div class="inline-flex font-bold text-sm items-center close bg-rose-200/70 dark:bg-rose-200/20 group-hover:bg-slate-100/20 cursor-pointer p-1 rounded-md text-rose-500"  onclick="setMention([],'#{{$wraper}}',true)" >

                delete all
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6 icon">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                </svg>


            </div>

        </div>


        <select id="{{$select2}}" class="form-input select2 text-smid w-full font-YekanBakh "
                name="mentions"
                multiple>



        </select>
    </div>
</div>
