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
        zoom : false
    });


    // On crop button clicked
    cropBtn.addEventListener('click', function(){
        var webp =  cropper.getCroppedCanvas({
            imageSmoothingQuality: 'high',
            imageSmoothingEnabled: false,
        }).toDataURL('image/webp');
        var jpeg =  cropper.getCroppedCanvas({
            imageSmoothingQuality: 'high',
            imageSmoothingEnabled: false,
        }).toDataURL('image/jpeg');
        var png =  cropper.getCroppedCanvas({
            imageSmoothingQuality: 'high',
            imageSmoothingEnabled: false,
        }).toDataURL('image/png');
        // imgForCrop.src = imgurl2;
        // console.log(webp,jpeg,png)
        imgwraper.classList.add('hidden')
        cropBtn.classList.add('hidden')
        renderSelect(webp,jpeg,png)
        // mainImageInput.value =imgurl2
        // wraper.querySelector('.webp').value =webp
        // wraper.querySelector('.jpeg').value =jpeg
        // wraper.querySelector('.png').value =png
        cropper.destroy();

    })
}
function setMainInputValue(el){
    let img = el.querySelector('img').src
    el.closest('.wraper').querySelector('.mainImageInput').value = img;
    el.closest('.selectSize').remove();

    console.log(img)

    imgwraper.classList.remove('hidden')
    imgForCrop.src = img;
}
function renderSelect(webp,jpeg,png) {
    imgwraper.insertAdjacentHTML('afterend',`
    <div class="selectSize">
        <h2 class="font-bold text-felg mr-6 mb-2 md:mr-3">
            انتخاب کنید
        </h2>
        <div class="grid grid-cols-2 gap-3 cursor-pointer">
            <div onclick="setMainInputValue(this)">
                <img src="${webp}" class="w-full rounded-md" alt="">
                    <div
                        class="badg shadow-md shadow-indigo-200 dark:shadow-indigo-500/60 hover:shadow-lg hover:shadow-indigo-200 dark:hover:shadow-indigo-700 bg-indigo-500 text-slate-50 hover:bg-indigo-400 inline-block rounded-md mt-2">
                        <p class="inline text-sm">
                            سایز (webp) تقریبا = ${(webp.length*7321/10000/1000).toFixed(1)} کیلوبایت
                        </p>
                    </div>
            </div>
            <div onclick="setMainInputValue(this)">
                <img src="${jpeg}" class="w-full rounded-md" alt="">
                    <div
                        class="badg shadow-md shadow-indigo-200 dark:shadow-indigo-500/60 hover:shadow-lg hover:shadow-indigo-200 dark:hover:shadow-indigo-700 bg-indigo-500 text-slate-50 hover:bg-indigo-400 inline-block rounded-md mt-2">
                        <p class="inline text-sm">
                            سایز (jpeg) تقریبا = ${(jpeg.length*7321/10000/1000).toFixed(1)} کیلوبایت
                        </p>
                    </div>
            </div>
            <div onclick="setMainInputValue(this)">
                <img src="${png}" class="w-full rounded-md" alt="">
                    <div
                        class="badg shadow-md shadow-indigo-200 dark:shadow-indigo-500/60 hover:shadow-lg hover:shadow-indigo-200 dark:hover:shadow-indigo-700 bg-indigo-500 text-slate-50 hover:bg-indigo-400 inline-block rounded-md mt-2">
                        <p class="inline text-sm">
                            سایز (png) تقریبا = ${(png.length*7321/10000/1000).toFixed(1)} کیلوبایت
                        </p>
                    </div>
            </div>
        </div>
    </div>

    `)
}






function simpleImage(fileInput,image = 'image',mainInput = 'mainInputImage') {


    let myWraper = fileInput.closest('.wraper');
    image = myWraper.querySelector('.'+image)
    let url;

    if (fileInput.files && fileInput.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            url = e.target.result;
            setUrlToInput(url,myWraper.querySelector('.'+mainInput))
            // myWraper.querySelector('.'+mainInput).value = url
            image.style.backgroundImage = `url(${url})`;
        };
        reader.readAsDataURL(fileInput.files[0]);
    }

    if (myWraper.querySelector('.placeholder')){
        myWraper.querySelector('.placeholder').classList.add('hidden')
    }

}

function setUrlToInput(url,input) {
    console.log(url,input)
    input.value = url;
}

function showpreview(file,ajax = false,clickElement = null) {


    console.log(cropper)
    if (cropper){
        cropper.destroy();
    }


    wraper = file.closest('.wraper')

    inputImageCrop = file
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

    var reader = new FileReader();
    reader.readAsDataURL(file.files[0]);
    reader.onload = function () {
        mainImageInput.value = reader.result
        imgForCrop.src = reader.result
        imgForCrop.classList.remove('hidden')
        if (ajax == false){
            imgwraper.classList.remove('hidden')
        }else {
            console.log('#' + clickElement + '_set')
            document.querySelector('#' + clickElement + '_set').click()
        }
        // console.log(mainImageInput,imgForCrop)



    };

}


function getImg(name){
    return document.querySelector(`.mainImageInput[name=${name}]`).value
}
