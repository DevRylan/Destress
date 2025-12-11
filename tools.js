document.querySelectorAll('.tool-card').forEach(card => {
    card.addEventListener('click', function(e) {
        e.preventDefault();
        const tool = this.getAttribute('data-tool');
    });
});

document.getElementById('moreToolsBtn').addEventListener('click', function(e) {
    e.preventDefault();;
});

document.querySelectorAll('#navBar a').forEach(link => {
    link.addEventListener('click', () => {
        if (window.innerWidth < 768) {
            document.getElementById('navBar').classList.remove('active');
        }
    });
});

