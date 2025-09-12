document.querySelectorAll('.allert .close').forEach(closAllert)

function closAllert(El) {
    var allert,allertTimout;
    El.addEventListener('click',function (event) {
        allert = event.currentTarget.closest('.allert');
        allert.classList.add('ElOut')
        setTimeout(function ()  {

            allert.remove()

        },500)


    })
}
function clossAllert(El) {
    allert = El.closest('.allert');
    allert.classList.add('ElOut')
    setTimeout(function ()  {

        allert.remove()

    },500)
}
