let allTabBtn = document.querySelectorAll('.tabBtns .tabBtn');
allTabBtn.forEach(function (El) {
    El.addEventListener('click', tab)
})
var tabTimout;
function tab(event) {

    var El = event.currentTarget

    if (El.classList.contains('active')){
        return
    }

    var btnFriends = El.closest('.tabBtns').querySelectorAll('.tabBtn');
    var tabFriends = El.closest('.tabWraper').querySelectorAll('.tabs .tab');

    clearTimeout(tabTimout)


    btnFriends.forEach(function (tabBtn) {
        tabBtn.classList.remove('active');
        tabBtn.classList.remove('passed');
    })

    addPassed(El);
    El.classList.add('active')

    tabFriends.forEach(function (tab) {
        tab.classList.remove('ElOut')
        tab.classList.add('ElOut')
    })


    tabTimout = setTimeout(function () {


        //ajax

        tabFriends.forEach(function (tab) {

            tab.classList.add('hidden')


            if (El.getAttribute('data-tab') === tab.getAttribute('data-tab')) {

                tab.classList.remove('hidden')
                tab.classList.remove('ElOut')
                tab.classList.add('ElIn')
            }
        })


    }, 500)


}

function nextTab(event) {
    event.currentTarget.closest('.tabWraper').querySelector('.tabBtns .tabBtn.active').nextElementSibling.click()
}
function prevTab(event) {
    event.currentTarget.closest('.tabWraper').querySelector('.tabBtns .tabBtn.active').previousElementSibling.click()
}

let prevTabBtn = document.querySelectorAll('.tabWraper .prev')
let nextTabBtn = document.querySelectorAll('.tabWraper .next')

prevTabBtn.forEach(function (El) {
    El.addEventListener('click', prevTab)
})
nextTabBtn.forEach(function (El) {
    El.addEventListener('click', nextTab)
})


function addPassed(El) {
    if (El.previousElementSibling){
        El.previousElementSibling.classList.add('passed')
        addPassed(El.previousElementSibling)
    }

}