
function calcHeight(value) {
    let numberOfLineBreaks = (value.match(/\n/g) || []).length;
    // min-height + lines x line-height + padding + border
    let newHeight = 30 + numberOfLineBreaks * 30 + 12 + 2;
    return newHeight;
}

function setTextArea(){
    let textarea = document.querySelectorAll(".autosizeArea");
    textarea.forEach(function (EL) {
        EL.style.height = "100px"
        EL.addEventListener("input", () => {
            EL.style.height = calcHeight(EL.value) + 50 + "px";
        })
    })
}

function maxL(el) {
    if (!('maxLength' in el)) {
        var max = el.attributes.maxLength.value;
        if (this.value.length >= max){
            return false
        }
    }
}

setTextArea()
