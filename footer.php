<?php?>
<footer></footer>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="/assets/js/profilepage.js"></script>


<script>
document.addEventListener("DOMContentLoaded", () => {

    const modal = document.getElementById("editModal");
    const form = document.getElementById("editForm");
    const editIcon = document.querySelector(".edit-icon");

    const closeX = document.getElementById("modalX");
    const cancelBtn = document.getElementById("modalCancel");

    // Open modal
    editIcon.addEventListener("click", () => {
        modal.classList.remove("hidden");
    });

    // Close modal
    closeX.addEventListener("click", () => {
        modal.classList.add("hidden");
    });

    cancelBtn.addEventListener("click", () => {
        modal.classList.add("hidden");
    });

    // Ajax
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
</script>

</body>
</html>
