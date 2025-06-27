document.addEventListener("DOMContentLoaded", () => {
    document.documentElement.style.scrollBehavior = "smooth";

    const menuLinks = document.querySelectorAll('.menu a[href^="#"]');
    const menuLinks2 = document.querySelectorAll('.pod-nawigacja a[href^="#"]');
    menuLinks.forEach(link => {
        link.addEventListener("click", e =>{
            e.preventDefault();
            const targetId = link.getAttribute('href').slice(1);
            const section = document.getElementById(targetId);
            if (section ) {
                section.scrollIntoView({behavior: "smooth"});
            }
        })
    });
    menuLinks2.forEach(link => {
        link.addEventListener("click", e =>{
            e.preventDefault();
            const targetId = link.getAttribute('href').slice(1);
            const section = document.getElementById(targetId);
            if (section ) {
                section.scrollIntoView({behavior: "smooth"});
            }
        });
    });
});