let inputImageCrop;
let imgForCrop;
let cropBtn;
let mainImageInput;
let imgwraper;
let wraper;
let cropper;
let Ratio;
function cropImage(input,ratio){

    Ratio = ratio


    console.log(cropper)
    if (cropper){
        cropper.destroy();
    }

    wraper = input.closest('.wraper')

    inputImageCrop = input
    imgForCrop = wraper.querySelector('.imageWraper img');
    cropBtn = wraper.querySelector('.cropBtn')
    mainImageInput = wraper.querySelector('.mainImageInput');
    imgwraper = wraper.querySelector('.imageWraper');

    if (wraper.querySelector('.cropper-container')){
        wraper.querySelector('.cropper-container').remove()
    }
    if (wraper.querySelector('.selectSize')){
        wraper.querySelector('.selectSize').remove()
    }
    cropBtn.classList.add('hidden')
    imgForCrop.closest('.imageWraper').classList.add('hidden')


    readURL(input)
}
function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            imgForCrop.src = e.target.result;
            imgwraper.classList.remove('hidden')
            imgForCrop.classList.remove('cropper-hidden')
            input.value = null
        };
        reader.readAsDataURL(input.files[0]);
        setTimeout(initCropper, 500);
    }
}
function initCropper(){
    console.log("Came here")
    cropBtn.classList.remove('hidden')
    cropper = new Cropper(imgForCrop, {
        aspectRatio: Ratio,
        dragMode: 'move',
        autoCropArea: 1,
        viewMode: 2,
        zoom : false,
    });


    // On crop button clicked
    cropBtn.addEventListener('click', function(){
        var webp =  cropper.getCroppedCanvas().toDataURL('image/webp');
        // imgForCrop.src = imgurl2;
        imgwraper.classList.add('hidden')
        cropBtn.classList.add('hidden')
        setMainInputValue(webp)

        // mainImageInput.value =imgurl2
        // wraper.querySelector('.webp').value =webp
        // wraper.querySelector('.jpeg').value =jpeg
        // wraper.querySelector('.png').value =png
        cropper.destroy();


    })
}
function setMainInputValue(img){
    mainImageInput.value = img;
    setTimeout(function () {

        document.querySelector('#setAvatar').click()

    },'200')
}

function getAvatarImg(){
    return document.querySelector('#mainAvatar').value
}


