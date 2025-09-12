let html = document.getElementById('html')


if (localStorage.getItem('dark') === 'true') {
    html.classList.add('dark')
}else {
    html.classList.remove('dark')
}

