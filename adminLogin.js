document.getElementById("loginForm").addEventListener("submit", async function(e) {

    //prevents the default form sub. behavior and gets errorBox element
    e.preventDefault();
    const formDatta = new FormData(this);
    const errorBox = document.getElementById("errorBox");

    //Sets error box stylings
    errorBox.style.display = "none" ;
    errorBox.style.color = "red";
    errorBox.textContent = "";

    //send the data to thee php file and stores it
    const response = await fetch("adminLogin.php", {
        method: "POST",
        body: formDatta
    });
    const resultforResponse = await response.json();

    //Will handle the styling and routing based on success from PHP reponse
    if (resultforResponse.status == "error") {
        errorBox.textContent = resultforResponse.message;
        errorBox.style.display = "block";
    } else {
        errorBox.style.color = "green";
        errorBox.textContent = "Logins good! Redirecting...";
        errorBox.style.display = "block";
        setTimeout(() => {
            window.location.href = "dashboard.php";
        }, 1010);
    }
});
