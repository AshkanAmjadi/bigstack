<script>
    function setMention(data, el, removeAll = false) {

        if (removeAll) {
            $(el).empty();
        }
        let currents = document.querySelector(el).querySelectorAll('.usernameSelected')


        console.log(removeAll)

        if (!removeAll){
            if (currents.length >= 4){
                swaltoast('You cannot select more than 4 items','error')
                return
            }
        }



        data.forEach(function (data) {
            let append = true;
            currents.forEach(function (el,index) {
                if (el.dataset.value == data.username){
                    append = false;
                }
            })


            if (append){
                $(el).append(`
<div data-value="${data.username}" class="allert usernameSelected flex items-center gap-3 flex-wrap p-4 border border-slate-300 rounded-md">
            <div href="" class="avatar lg md:!w-10 md:!h-10">
                <img class="pointer-events-none"
                     src="${data.src}"
                     alt="آواتار">

            </div>
            <div class="flex flex-col">

                <p class="inline-block text-sm text-rose-600 font-semibold">
                    mentioned 👇
            </p>
                <p class="inline-block text-smid font-bold">
                    ${data.name}
            </p>
            <p class="inline-block text-fsm font-light">
                ${data.username}@
            </p>
        </div>

        <div>

<div class="close bg-rose-200/70 dark:bg-rose-200/20 group-hover:bg-slate-100/20 cursor-pointer p-1 rounded-md text-rose-500"  onclick="clossAllert(this)" >

                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6 icon">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                </svg>


                </div>

                    </div>

                </div>
                    `)
            }

        })
    }
    function formatRepo(repo) {

        repo.text = $(`<b>search</b>`);

        if (repo.loading) {
            return repo.text;
        }

        var $container = $(
            `<div class="flex items-center gap-3 flex-wrap p-2">

            <div href="" class="avatar lg md:!w-10 md:!h-10">
                <img class="pointer-events-none"
                     src="${repo.src}"
                     alt="avatar">

            </div>
            <div class="flex flex-col">

                <p class="inline-block text-smid font-bold">
                    ${repo.name}
            </p>
            <p class="inline-block text-fsm font-light">
                ${repo.username}@
            </p>
        </div>
    </div>
`
        )


        return $container;
    }

    function formatRepoSelection(repo) {
        $(repo.element).attr('data-username-attribute', repo.username + '@');
        return repo.username + '@';
    }
</script>
