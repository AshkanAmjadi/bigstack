
function calcHeight(value) {
    let numberOfLineBreaks = (value.match(/\n/g) || []).length;
    // min-height + lines x line-height + padding + border
    let newHeight = 20 + numberOfLineBreaks * 20 + 12 + 2;
    return newHeight;
}

let textarea = document.querySelector(".autosizeArea");
textarea.addEventListener("keyup", () => {
    textarea.style.height = calcHeight(textarea.value) + 12 + "px";
});

function maxL(el) {
    if (!('maxLength' in el)) {
        var max = el.attributes.maxLength.value;
        if (this.value.length >= max){
            return false
        }
    }
}
