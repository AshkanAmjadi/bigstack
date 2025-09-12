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
