




document.querySelectorAll('.tooltip').forEach(function (El) {

    El.insertAdjacentHTML('afterbegin',`
    
    <div class="tooltipArrow" data-popper-arrow></div>
    
    `)

    let tooltip = El
    let parent = tooltip.parentElement;
    let position = 'top';


    if (tooltip.classList.contains('top')){
        position ='top'
    }else if (tooltip.classList.contains('bottom')){
        position ='bottom'

    }else if (tooltip.classList.contains('left')){
        position ='left'

    }else if (tooltip.classList.contains('right')){
        position ='right'

    }

    let popperInstance = new Popper.createPopper(parent,tooltip,{
        placement: position,
        modifiers : [
            {
                name: 'offset',
                options: {
                    offset: [0,8]
                }
            }
        ]
    })


   if (tooltip.classList.contains('pop')){

       parent.addEventListener('click', function (event) {
           toggleTooltip(event.currentTarget.querySelector('.tooltip'))
       });

       parent.addEventListener('blur', function (event) {
           hideTooltip(event.currentTarget.querySelector('.tooltip'))
       });


   }else {
       parent.addEventListener('mouseenter', function (event) {
           showTooltip(event.currentTarget.querySelector('.tooltip'))
       });

       parent.addEventListener('focus', function (event) {
           showTooltip(event.currentTarget.querySelector('.tooltip'))
       });

       parent.addEventListener('mouseleave', function (event) {
           hideTooltip(event.currentTarget.querySelector('.tooltip'))
       });

       parent.addEventListener('blur', function (event) {
           hideTooltip(event.currentTarget.querySelector('.tooltip'))
       });

   }

})


function showTooltip(tooltip) {



    tooltip.setAttribute('data-show', '');
}

var tooltipTimout;
function hideTooltip(tooltip) {


    tooltip.removeAttribute('data-show');



}

function toggleTooltip(tooltip) {

    if (tooltip.hasAttribute('data-show')){
        hideTooltip(tooltip)

    }else {
        showTooltip(tooltip)
    }

}
