//gets the loggin form and waits for submission

document.getElementById("registerForm").addEventListener("submit", async function(e) {
    
    e.preventDefault();

    //Gets the forM data and error box
    const formData = new FormData(this);
    const errorBox = document.getElementById("errorBox");

    //creates the styling for the error box
    errorBox.style.display = "none";
    errorBox.textContent = "";

    //structure of the fetch for the login
    const theResponse = await fetch("register.php", {
        method: "POST",
        body: formData
    });

    const theResult = await theResponse.json();

    //checks for error 
    if (theResult.status == "error") {
        //sets error message if the status is error
        errorBox.textContent = theResult.message;
        errorBox.style.display = "block";
    } else {
        errorBox.style.color = "green";
        errorBox.textContent = "Account created! Redirecting...";
        //delays the redirect then sends  user to loginpage
        setTimeout(() => {
            window.location.href = "login.html";
        }, 1067);
    }
});
