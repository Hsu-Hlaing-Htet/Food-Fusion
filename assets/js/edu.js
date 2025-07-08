document.addEventListener("DOMContentLoaded", function() {
    const eduslider = document.getElementById("eduslider");
    const prev = document.getElementById("prev");
    const next = document.getElementById("next");
    let scrollAmount = 0;
    let slideWidth = document.querySelector("#eduslider div").offsetWidth + 16;

    function updateSlideWidth() {
        slideWidth = document.querySelector("#eduslider div").offsetWidth + 16;
    }

    next.addEventListener("click", () => {
        updateSlideWidth();
        if (scrollAmount + eduslider.clientWidth < eduslider.scrollWidth) {
            scrollAmount += slideWidth;
            eduslider.style.transform = `translateX(-${scrollAmount}px)`;
        }
    });

    prev.addEventListener("click", () => {
        updateSlideWidth();
        if (scrollAmount > 0) {
            scrollAmount -= slideWidth;
            eduslider.style.transform = `translateX(-${scrollAmount}px)`;
        }
    });

    window.addEventListener("resize", () => {
        updateSlideWidth();
        scrollAmount = 0;
        eduslider.style.transform = "translateX(0px)";
    });
});