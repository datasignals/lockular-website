const slides = document.querySelectorAll('.slide');

slides.forEach(slide => {
    slide.addEventListener('click', function(){
        slides.forEach(slideN => slideN.classList.remove('active'));
        slide.classList.add('active');
    })
})