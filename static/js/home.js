const btn = document.querySelector('.button-top-return')

btn.addEventListener('click', () => {
    window.scrollTo({
        top: 0,
        left: 0,
        behavior : 'smooth'
    })
})
