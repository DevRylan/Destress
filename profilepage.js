// Stress chart
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

document.addEventListener("DOMContentLoaded", () => {

    const form = document.getElementById("editForm");
    const modal = document.getElementById("editModal");
    const editIcon = document.querySelector(".edit-icon");
    const closeBtn = document.getElementById("closeModal");

    // Open modal
    editIcon.addEventListener("click", () => {
        modal.classList.remove("hidden");
    });

    // Close modal
    closeBtn.addEventListener("click", () => {
        modal.classList.add("hidden");
    });

    // Handle form submit without redirecting
    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const formData = new FormData(form);

        const res = await fetch("update_profile.php", {
            method: "POST",
            body: formData
        });

        const json = await res.json();

        if (json.success) {
            modal.classList.add("hidden");

            document.querySelector(".profile-name").innerHTML =
                "<strong>" + formData.get("name") + "</strong>";
            document.querySelector(".profile-age").innerHTML =
                "<strong>Age:</strong> " + formData.get("age");
            document.querySelector(".profile-gender").innerHTML =
                "<strong>Gender:</strong> " + formData.get("gender");
            document.querySelector(".profile-stress_levels").innerHTML =
                "<strong>Average Stress Levels:</strong> " + formData.get("stress_level") + "/10";
        } else {
            alert("Error: " + json.error);
        }
    });
});
