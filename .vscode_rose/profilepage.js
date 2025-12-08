// Stress chart
document.addEventListener("DOMContentLoaded", function () {

    console.log("JS FILE LOADED");

    const ctx = document.getElementById('stressChart').getContext('2d');

    const profileStressChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Mon', 'Tues', 'Wed', 'Thur', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'Stress level',
                data: [3, 5, 4, 6, 7, 5, 2], // placeholder data
                borderWidth: 1,
                borderRadius: 6,
                backgroundColor: '#1d617a'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    suggestedMax: 10,
                    title: {
                        display: true,
                        text: 'Stress level'
                    }
                }
            }
        }
    });

    //Dropdown nav bar
    const button=document.getElementById("menuButton")
    const menu=document.getElementById("navBar");

    button.addEventListener("click", (e) => {
        e.stopPropagation();
        menu.classList.toggle("hidden");
    });

    menu.addEventListener("click", (e) => {
        e.stopPropagation();
    });

    document.addEventListener("click", (e) => {
        if (!button.contains(e.target) && !menu.contains(e.target)) {
            menu.classList.add("hidden");
        }
    });


   

});




