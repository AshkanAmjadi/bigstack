function closAllList() {
    document.querySelectorAll('.hasList').forEach(function (El, index, parent) {
        El.querySelector('.list').classList.add('hide')
    })
}

function openList(El) {
    closAllList()
    El.parentNode.querySelector('.list').classList.remove('hide');
}

window.addEventListener('click',function (ev) {
    if (!ev.target.matches('.dropBtn')) {
        closAllList()
    }
})


function closeAllMenuList() {
    document.querySelectorAll('.menuList').forEach(function (El, index) {
        El.classList.remove('open');
        El.querySelectorAll('.subMenuList').forEach(function (El, index) {
            El.classList.remove('open');
        })
    })
}

document.querySelectorAll('.menuList .head').forEach(function (El, index) {

    El.addEventListener('click', function (ev) {
        if (!ev.currentTarget.parentElement.classList.contains('open')) {

            if (ev.currentTarget.parentElement.classList.contains('menuList')) {
                closeAllMenuList();
            }
            ev.currentTarget.parentElement.classList.add('open')
        } else {
            ev.currentTarget.parentElement.classList.remove('open')
        }

    })

})
//asideColaps



document.getElementById('aside').addEventListener('mousemove', function () {
    if (!asideExpend) {
        document.getElementById('aside').classList.remove('mini');
        document.getElementById('aside').classList.add('expanded');
    }
})

document.getElementById('aside').addEventListener('mouseleave', function () {
    if (!asideExpend) {
        document.getElementById('aside').classList.add('mini');
        document.getElementById('aside').classList.remove('expanded');
    }
})

function toggleAside(El) {
    El.classList.toggle('active')

    if (El.classList.contains('active')) {
        document.getElementById('header').classList.remove('mini');
        document.getElementById('content').classList.remove('mini');
        document.getElementById('aside').classList.remove('mini');
        document.getElementById('aside').classList.add('expanded');
        asideExpend = true;

        localStorage.setItem('aside' , 'expand')
    } else {
        document.getElementById('header').classList.add('mini');
        document.getElementById('content').classList.add('mini');
        asideExpend = false;
        localStorage.setItem('aside' , '')

    }
}

//aside in mobile
function hideMenu() {
    document.getElementById('aside').classList.add('hide');

}
function openMenu() {
    document.getElementById('aside').classList.remove('hide');

}




document.querySelectorAll('.open-box').forEach(function (El) {
    El.addEventListener('click',function (ev) {
        if(ev.currentTarget.classList.contains('head')){
            ev.currentTarget.nextElementSibling.classList.toggle('hidden')
        }else {
            ev.currentTarget.closest('.head').nextElementSibling.classList.toggle('hidden');
        }

    })
})


window.onclick = function (event) {

    if (!event.target.matches('.drop')) {
        closeDropContent()
    }else {

    }
}

// search
function openMainsearch() {
    document.getElementById('mainsearch').classList.remove('hidden');
    document.getElementById('searchOverley').classList.remove('hidden');
}

function closeMainsearch() {
    document.getElementById('mainsearch').classList.add('hidden');
    document.getElementById('searchOverley').classList.add('hidden');
}

// function searching(El) {
//     if (El.value.length > 0) {
//         document.getElementById('searchReturn').classList.remove('hidden')
//         document.getElementById('overlay').classList.remove('hidden')
//     } else {
//         document.getElementById('searchReturn').classList.add('hidden')
//         document.getElementById('overlay').classList.add('hidden')
//     }
// }

// dark
let  body = document.querySelector('body')

if (localStorage.getItem('dark') === 'true') {
    body.classList.add('dark')
}else {
    body.classList.remove('dark')
}

function dark() {
    html.classList.toggle('dark')
    body.classList.toggle('dark')


    if (body.className.match(/(?:^|\s)dark(?!\S)/)) {

        localStorage.setItem('dark', 'true')

    } else {

        localStorage.setItem('dark', '')

    }
}
//nav

document.querySelectorAll('.menuList .head').forEach(function (El, index) {

    El.addEventListener('click', function (ev) {
        if (!ev.currentTarget.parentElement.classList.contains('open')) {

            if (ev.currentTarget.parentElement.classList.contains('menuList')) {
                closeAllMenuList();
            }
            ev.currentTarget.parentElement.classList.add('open')
        } else {
            ev.currentTarget.parentElement.classList.remove('open')
        }

    })

})

// document.querySelector('.mode').click()
// document.querySelector('.cursor').click()


function openDropContent(element){
    element.querySelector('.dropContent').classList.remove('hidden')
}



function DropContent(EL){
    closeAllWraperDropContent(EL)
    openDropContent(EL);
}

function closeDropContent(){

    document.querySelectorAll('.dropContent').forEach(function (El, index, parent) {
        El.classList.add('hidden')
    })
}
function closeAllWraperDropContent(El){

    El.closest('.allDropWraper').querySelectorAll('.dropContent').forEach(function (El, index, parent) {
        El.classList.add('hidden')
    })
}

function burgerMenu(type){

    if (type === 'open'){

        document.querySelector('aside').classList.remove('hide');
        document.querySelectorAll('.aside').forEach(function (El){
            El.classList.remove('hide');
        })
        document.getElementById('asideOverlay').classList.remove('hide');

    }else if (type === 'close'){

        document.querySelector('aside').classList.add('hide');
        document.querySelectorAll('.aside').forEach(function (El){
            El.classList.add('hide');
        })
        document.getElementById('asideOverlay').classList.add('hide');
    }

}

function sidebar(action,type){

    if (action === 'hide'){
        document.querySelector(`#sidebar.${type}`).classList.add('hide')
        document.querySelector(`#sidebarOverley.${type}`).classList.add('hide')
    }else if (action === 'show'){
        document.querySelector(`#sidebar.${type}`).classList.remove('hide')
        document.querySelector(`#sidebarOverley.${type}`).classList.remove('hide')
    }
}


function swaltoast(title,icon ='success',timing = 4000 ,position = 'bottom-start') {
    let toast = Swal.fire({
        position: position,
        didOpen :(toast)=>{
            toast.addEventListener('click', ()=> Swal.close())
        },
        icon: icon,
        toast: true,
        timerProgressBar: true,
        html: `<p class="font-bold text-sm">
                ${title}
                </p>`,
        showConfirmButton: false,
        timer: timing,
        customClass: {
            popup: 'colored-toast'
        }
    })
}

function blurId(id) {
    document.getElementById(id).blur()
}

function getSelectValues(select) {
    var result = [];
    var options = select && select.options;
    var opt;

    for (var i=0, iLen=options.length; i<iLen; i++) {
        opt = options[i];

        if (opt.selected) {
            result.push(opt.value || opt.text);
        }
    }
    return result;
}
