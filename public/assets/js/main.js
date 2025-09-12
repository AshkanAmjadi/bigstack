//editFormContent
function editButton(El, id) {

    El.parentNode.parentNode.querySelector('.formContent').classList.toggle('hidden')

}
//openbox
document.querySelectorAll('.open-box').forEach(function (El) {
    El.addEventListener('click',function (ev) {
        if(ev.currentTarget.classList.contains('head')){
            ev.currentTarget.nextElementSibling.classList.toggle('hidden')
        }else {
            ev.currentTarget.closest('.head').nextElementSibling.classList.toggle('hidden');
        }

    })
})

// dropdown
function closAllList() {
    document.querySelectorAll('.hasList').forEach(function (El, index, parent) {
        El.querySelector('.list').classList.add('hide')
    })
}

function openList(El) {
    closAllList()
    El.parentNode.querySelector('.list').classList.remove('hide');
}

window.onclick = function (event) {
    if (!event.target.matches('.dropBtn')) {
        closAllList()
    }
}

// search
function openMainsearch() {
    document.getElementById('mainsearch').classList.remove('hidden');
    document.getElementById('searchForm').querySelector('input').focus();
}

function closeMainsearch() {
    document.getElementById('mainsearch').classList.add('hidden')
    document.getElementById('searchReturn').classList.add('hidden')
    document.getElementById('overlay').classList.add('hidden')
}

function searching(El) {
    if (El.value.length > 0) {
        document.getElementById('searchReturn').classList.remove('hidden')
        document.getElementById('overlay').classList.remove('hidden')
    } else {
        document.getElementById('searchReturn').classList.add('hidden')
        document.getElementById('overlay').classList.add('hidden')
    }
}

// dark
let  body = document.querySelector('body')
let sun =document.querySelector('.mode').querySelector('.sun')
let moon =document.querySelector('.mode').querySelector('.moon')

if (localStorage.getItem('dark') === 'true') {
    body.classList.add('dark')
    sun.classList.add('hidden')
    moon.classList.remove('hidden')
}else {
    body.classList.remove('dark')
    sun.classList.remove('hidden')
    moon.classList.add('hidden')
}

function dark() {
    html.classList.toggle('dark')
    body.classList.toggle('dark')
    document.querySelector('.mode').querySelector('.sun').classList.toggle('hidden')
    document.querySelector('.mode').querySelector('.moon').classList.toggle('hidden')

    if (body.className.match(/(?:^|\s)dark(?!\S)/)) {

        localStorage.setItem('dark', 'true')

    } else {

        localStorage.setItem('dark', '')

    }
}



//nav
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
// document.querySelector('.mode').click()
// document.querySelector('.cursor').click()
var returned

function checkDataAttr(El,dataAttr,string){

    return El.getAttribute(dataAttr) === string

}
function setDataAttr(El,dataAttr,string){

    return El.setAttribute(dataAttr,string)

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


function ajaxReq(url,data,success,method = 'POST',error = function (reject) {
    swaltoast('مشکلی در سرور وجود دارد' , 'error')
}) {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        }
    })

//     function (data) {
//         console.log(data)
//         if (data.success) {
//             document.getElementById('profile_alerts').insertAdjacentHTML('beforeend', `<p class="successStyle green bdrs20-15-10-5 marg_b_10">همه موارد با موفقیت ثبت شد 😇😇</p>
// `)
//         } else {
//             $.each(data.errors, function (key, value) {
//                 $.each(value, function (key2, value2) {
//                     document.getElementById('profile_alerts').insertAdjacentHTML('beforeend', `<p class="errorStyle red bdrs20-15-10-5 marg_b_10">${key} : ${value2} 🤔</p>`)
//                 })
//             })
//
//         }
//     }
    $.ajax({
        url: url,
        type: method,
        data: JSON.stringify(data),
        success: success,
        error : error
    })
}


function hidden(El,action = 'hide',classlist = 'hidden') {
    if (action == 'hide'){
        document.querySelector(El).classList.add(classlist)
    }else if (action == 'show'){
        document.querySelector(El).classList.remove(classlist)
    }
}

function selector(selector){
    return document.querySelector(selector)
}

function nodeToArr(Node) {
    let arr = Array.prototype.slice.call(Node);
    return arr;
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
function copyUrl(id,thisPage = false,textAllert = 'لینک اشتراک گذاری مورد نظر با موفقیت کپی شد') {
    // Get the text field
    var copyText = document.getElementById(id);

    if (thisPage){
        copyText.value = window.location.href;
    }
    // Select the text field
    copyText.select();
    copyText.setSelectionRange(0, 99999); // For mobile devices

    // Copy the text inside the text field
    navigator.clipboard.writeText(copyText.value);

    // Alert the copied text
    swaltoast(textAllert , 'success')

}
