//gets the loggin form and waits for submission
document.getElementById("loginForm").addEventListener("submit", async function(e) {

    e.preventDefault();
    //Gets the forM data and error box
    const formData = new FormData(this);
    const errorBox = document.getElementById("errorBox");

    //creates the styling for the error box
    errorBox.style.display = "none";
    errorBox.style.color = "red";
    errorBox.textContent = "";

    //structure of the fetch for the login
    const theResponse = await fetch("login.php", {
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
        errorBox.textContent = "Login successful! Redirecting...";
        errorBox.style.display = "block";
        //delays the redirect then sends  user to homepage
        setTimeout(() => {
            window.location.href = "homepage.html?username="+encodeURIComponent(theResult.username);
        }, 167);
    }
});

