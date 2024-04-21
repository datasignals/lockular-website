const slides = document.querySelectorAll('.slide');
const titleContainer = document.querySelectorAll('.title-container');

slides.forEach(slide => {
    slide.addEventListener('click', function(){
        slides.forEach(slideN => slideN.classList.remove('active'));
        slide.classList.add('active');
    })
})

titleContainer.forEach(container => {
    const top = container.offsetWidth > 0 ? container.offsetWidth  : 162;
    container.style.top = (top/2) + 50 + 'px';
})