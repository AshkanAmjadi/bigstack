// dropdown
function closAllList() {
    document.querySelectorAll('.hasList').forEach(function (El, index, parent) {
        El.querySelector('.list').classList.add('hidden')
    })
}

function openList(El) {
    closAllList()
    El.parentNode.querySelector('.list').classList.remove('hidden');
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
function dark() {
    document.getElementById('html').classList.toggle('dark')
    document.querySelector('body').classList.toggle('dark')
    document.querySelector('.mode').querySelector('.sun').classList.toggle('hidden')
    document.querySelector('.mode').querySelector('.moon').classList.toggle('hidden')
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
let asideExpend = false;



document.getElementById('aside').addEventListener('mouseenter', function () {
    if (!asideExpend) {
        document.getElementById('aside').classList.remove('mini');
        document.getElementById('aside').classList.add('expanded');
    }
})
document.getElementById('aside').addEventListener('mousemove', function () {
    if (!asideExpend) {
        document.getElementById('aside').classList.remove('mini');
        document.getElementById('aside').classList.add('expanded');
    }
})
document.getElementById('aside').addEventListener('click', function () {
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
    } else {
        document.getElementById('header').classList.add('mini');
        document.getElementById('content').classList.add('mini');
        asideExpend = false;
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
