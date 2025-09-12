document.querySelectorAll('button[data-modal]').forEach(function (El) {
    let data, modal, modalContent, animationIn, animationOut;
    data = El.dataset.modal;
    modal = document.querySelector(`.modal[data-modal=${data}]`)
    animationIn = modal.getAttribute('data-animation-show');
    animationOut = modal.getAttribute('data-animation-hide');
    modalContent = modal.querySelector('.modal-content');
    if (typeof (animationOut) != "undefined") {
        modalContent.classList.add(animationOut)
    }

    El.addEventListener('click', function (event) {

        modal.classList.remove('none-show');
        modalContent.classList.remove(animationOut)
        modalContent.classList.add(animationIn)

    })
})

function openModal(El) {
    let data, modal, modalContent, animationIn, animationOut;
    data = El.dataset.modal;
    modal = document.querySelector(`.modal[data-modal=${data}]`)
    animationIn = modal.getAttribute('data-animation-show');
    animationOut = modal.getAttribute('data-animation-hide');
    modalContent = modal.querySelector('.modal-content');
    if (typeof (animationOut) != "undefined") {
        modalContent.classList.add(animationOut)
    }
    modal.classList.remove('none-show');
    modalContent.classList.remove(animationOut)
    modalContent.classList.add(animationIn)
}



document.querySelectorAll('.modal .close').forEach(function (El) {
    let modal, modalContent, animationIn, animationOut;

    modal = El.closest('.modal')
    animationIn = modal.getAttribute('data-animation-show');
    animationOut = modal.getAttribute('data-animation-hide');
    modalContent = modal.querySelector('.modal-content');

    El.addEventListener('click', function (event) {
        modalContent.classList.remove(animationIn)
        modalContent.classList.add(animationOut)
        modal.classList.add('none-show')
    })
    modal.addEventListener('click', function (event) {
        if (event.target.classList.contains('modal')){
            modalContent.classList.remove(animationIn)
            modalContent.classList.add(animationOut)
            modal.classList.add('none-show')
        }
    })
})
