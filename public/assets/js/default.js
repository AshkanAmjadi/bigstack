function ajaxReq(url,data,success,method = 'POST',error = function (reject) {
    swaltoast('مشکلی در سرور وجود دارد' , 'error')
}) {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        }
    })

//     function (data) {
//         console.log(data)
//         if (data.success) {
//             document.getElementById('profile_alerts').insertAdjacentHTML('beforeend', `<p class="successStyle green bdrs20-15-10-5 marg_b_10">همه موارد با موفقیت ثبت شد 😇😇</p>
// `)
//         } else {
//             $.each(data.errors, function (key, value) {
//                 $.each(value, function (key2, value2) {
//                     document.getElementById('profile_alerts').insertAdjacentHTML('beforeend', `<p class="errorStyle red bdrs20-15-10-5 marg_b_10">${key} : ${value2} 🤔</p>`)
//                 })
//             })
//
//         }
//     }
    $.ajax({
        url: url,
        type: method,
        data: JSON.stringify(data),
        success: success,
        error : error
    })
}

function selector(selector){
    return document.querySelector(selector)
}
function hidden(El,action = 'hide',classlist = 'hidden') {
    if (action == 'hide'){
        document.querySelector(El).classList.add(classlist)
    }else if (action == 'show'){
        document.querySelector(El).classList.remove(classlist)
    }
}

function copyUrl(id,thisPage = false,textAllert = 'لینک اشتراک گذاری مورد نظر با موفقیت کپی شد') {
    // Get the text field
    var copyText = document.getElementById(id);

    if (thisPage){
        copyText.value = window.location.href;
    }
    // Select the text field
    copyText.select();
    copyText.setSelectionRange(0, 99999); // For mobile devices

    // Copy the text inside the text field
    navigator.clipboard.writeText(copyText.value);

    // Alert the copied text
    swaltoast(textAllert , 'success')

}
function logHref() {
    console.log(' href => ' + window.location.href);
    console.log(' host => ' + window.location.host);
    console.log(' hostname => ' + window.location.hostname);
    console.log(' port => ' + window.location.port);
    console.log(' protocol => ' + window.location.protocol);
    console.log(' pathname => ' + window.location.pathname);
    console.log(' hashpathname => ' + window.location.hash);
    console.log(' search=> ' + window.location.search);
}
