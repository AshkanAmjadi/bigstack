

document.querySelectorAll('.accordions .accordion .head').forEach(function (El) {
    let accordions = El.closest('.accordions')
    let data = accordions.getAttribute('data-expand')
    El.addEventListener('click',function (event) {


        if (El.closest('.accordion').classList.contains('open')){
            event.currentTarget.parentElement.classList.remove('open')
        }else {
            console.log(data)
            if (!data){
                accordions.querySelectorAll('.accordion').forEach(function (El) {
                    El.classList.remove('open')
                })
                event.currentTarget.parentElement.classList.add('open')
            }else {
                event.currentTarget.parentElement.classList.add('open')
            }

        }



    })

})