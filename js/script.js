document.addEventListener("DOMContentLoaded", function() {
    const content = document.querySelector('.content');
    content.style.opacity = 0;
    setTimeout(() => {
        content.style.transition = "opacity 2s";
        content.style.opacity = 1;
    }, 500);
});
