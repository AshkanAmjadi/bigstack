




document.querySelectorAll('.dropdown').forEach(function (El) {


    let dropdown = El
    let parent = dropdown.parentElement;
    let position = 'bottom-end';


    if (dropdown.hasAttribute('data-position')){
        position = dropdown.getAttribute('data-position')
    }

    let popperInstance = new Popper.createPopper(parent,dropdown,{
        placement: position,
        modifiers : [
            {
                name: 'offset',
                options: {
                    offset: [0, 4],
                },
            }
        ]
    })


   if (dropdown.classList.contains('pop')){

       parent.addEventListener('click', function (event) {
           showTooltip(event.currentTarget.querySelector('.dropdown'))
       });

       parent.addEventListener('blur', function (event) {
           hideTooltip(event.currentTarget.querySelector('.dropdown'))
       });


   }else {
       parent.addEventListener('mouseenter', function (event) {
           showTooltip(event.currentTarget.querySelector('.dropdown'),popperInstance)
       });

       parent.addEventListener('focus', function (event) {
           showTooltip(event.currentTarget.querySelector('.dropdown'),popperInstance)
       });

       parent.addEventListener('mouseleave', function (event) {
           hideTooltip(event.currentTarget.querySelector('.dropdown'))
       });

       parent.addEventListener('blur', function (event) {
           hideTooltip(event.currentTarget.querySelector('.dropdown'))
       });

   }

})


function showTooltip(dropdown,popperInstance) {

    dropdown.setAttribute('data-show', '');


}

function hideTooltip(dropdown) {


    dropdown.removeAttribute('data-show');



}

function toggleTooltip(dropdown) {

    if (dropdown.hasAttribute('data-show')){
        hideTooltip(dropdown)

    }else {
        showTooltip(dropdown)
    }

}
