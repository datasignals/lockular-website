const slides = document.querySelectorAll('.slide');
const titleContainer = document.querySelectorAll('.title-container');
slides.forEach(slide => {
    slide.addEventListener('click', function(){
        const isActive = slide.classList.contains('active');
        
        if (!isActive) {
            // Remove 'active' class from all slides
            slides.forEach(slideN => slideN.classList.remove('active'));

            // Add 'active' class to the clicked slide
            slide.classList.add('active');

            // Select elements within the clicked slide
            const info = slide.querySelector('.slide-info');
            const btn = slide.querySelector('.content-button');
            const highlight = slide.querySelector('.content-body-highlight');

            // Define keyframes for animation
            const keyframes = [
                { opacity: '0', offset: 0 },
                { opacity: '1', offset: 1 }
            ];

            // Define animation options
            const options = {
                duration: 3000, // Animation duration in milliseconds
                iterations: 1, // Number of times the animation should repeat
                easing: 'ease-in-out' // Easing function for the animation
            };

            // Animate elements
            info.animate(keyframes, options);
            btn.animate(keyframes, options);
            highlight.animate(keyframes, options);
        }
    });
});



titleContainer.forEach(container => {
    const top = container.offsetWidth > 0 ? container.offsetWidth  : 162;
    container.style.top = (top/2) + 50 + 'px';
})