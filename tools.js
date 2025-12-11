document.addEventListener('DOMContentLoaded', () => {
   fetch('tools.php');

    document.querySelectorAll('.tool-card').forEach(card => {
        card.addEventListener('click', function(e) {
            e.preventDefault();  

            const tool = this.getAttribute('data-tool');
            const videos = {
                breathing:  "hkQxJIs_XZo",   
                exercise:   "pV4w4q1jHpw",   
                meditation: "inpok4MKVLM",   
                journaling: "O2DpP0I1f1o"    
            };

            const videoId = videos[tool];
            if (videoId) {
                window.open(
                    `https://www.youtube.com/embed/${videoId}?autoplay=1`,
                    '_blank',
                    'width=800,height=500'
                );
            }
        });
    });

    
    document.getElementById('moreToolsBtn').addEventListener('click', function() 
    {
        alert("More tools coming soon!");
    });

    
    document.querySelectorAll('#navBar a').forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth < 768) {
                document.getElementById('navBar').classList.remove('active');
            }
        });
    });

});
