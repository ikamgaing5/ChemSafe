window.addEventListener('load', ()=>{
    document.body.style.overflowY = 'auto';
    document.documentElement.style.overflow = 'auto';
    document.querySelectorAll('*').forEach(el=>{
        const style = getComputedStyle(el);
        if (style.overflow === 'hidden' ||style.overflowY === 'hidden' ) {
            el.style.overflow = 'visible';
            el.style.overflowY = 'auto';
        }
    });
});
