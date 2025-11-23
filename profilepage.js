// PROFILE PAGE STRESS CHART
document.addEventListener("DOMContentLoaded", function () {

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

});
