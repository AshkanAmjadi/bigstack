document.querySelectorAll('.open-box').forEach(function (El) {
    El.addEventListener('click', function (ev) {
        if (ev.currentTarget.classList.contains('head')) {
            ev.currentTarget.nextElementSibling.classList.toggle('hidden')
        } else {
            ev.currentTarget.closest('.head').nextElementSibling.classList.toggle('hidden');
        }

    })
})


window.onclick = function (event) {

    if (!event.target.matches('.drop')) {
        closeDropContent()
    } else {

    }
}

// search
function openMainsearch() {
    document.getElementById('mainsearch').classList.remove('hidden');
    document.getElementById('searchOverley').classList.remove('hidden');
    $('#searchInput').focus()
}

let interval;

function ifUpTo3Click($input, $id, $idOfMustSet3) {

    clearTimeout(interval)

    if ($input.value.length >= 3) {

        interval = setTimeout(
            function () {



                document.getElementById($idOfMustSet3).classList.add('hidden');

                document.getElementById($id).click();


            }
            , 400)


    }else {
        document.getElementById($idOfMustSet3).classList.remove('hidden');

    }


}

function getValueOfSearch($id) {
    return document.getElementById($id).value;
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
let body = document.querySelector('body')

if (localStorage.getItem('dark') === 'true') {
    body.classList.add('dark')
} else {
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

// document.querySelector('.mode').click()
// document.querySelector('.cursor').click()


function openDropContent(element) {
    element.querySelector('.dropContent').classList.remove('hidden')
}


function DropContent(EL) {
    closeAllWraperDropContent(EL)
    openDropContent(EL);
}

function closeDropContent() {

    document.querySelectorAll('.dropContent').forEach(function (El, index, parent) {
        El.classList.add('hidden')
    })
}

function closeAllWraperDropContent(El) {

    El.closest('.allDropWraper').querySelectorAll('.dropContent').forEach(function (El, index, parent) {
        El.classList.add('hidden')
    })
}

function burgerMenu(type) {

    if (type === 'open') {

        document.querySelector('#front-aside').classList.remove('hide');
        document.querySelectorAll('.aside').forEach(function (El) {
            El.classList.remove('hide');
        })
        document.getElementById('asideOverlay').classList.remove('hide');

    } else if (type === 'close') {

        document.querySelector('#front-aside').classList.add('hide');
        document.querySelectorAll('.aside').forEach(function (El) {
            El.classList.add('hide');
        })
        document.getElementById('asideOverlay').classList.add('hide');
    }

}

function sidebar(action, type) {

    if (action === 'hide') {
        document.querySelector(`#sidebar.${type}`).classList.add('hide')
        document.querySelector(`#sidebarOverley.${type}`).classList.add('hide')
    } else if (action === 'show') {
        document.querySelector(`#sidebar.${type}`).classList.remove('hide')
        document.querySelector(`#sidebarOverley.${type}`).classList.remove('hide')
    }
}


function swaltoast(title, icon = 'success', timing = 4000, position = 'bottom-start') {
    let toast = Swal.fire({
        position: position,
        didOpen: (toast) => {
            toast.addEventListener('click', () => Swal.close())
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

    for (var i = 0, iLen = options.length; i < iLen; i++) {
        opt = options[i];

        if (opt.selected) {
            result.push(opt.value || opt.text);
        }
    }
    return result;
}
