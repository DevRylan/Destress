document.getElementById("loginForm").addEventListener("submit", function (e) {

    if (!this.checkValidity()) {
        e.preventDefault();
        console.log("HTML failed during validation");
        return;
    }

    e.preventDefault(); 
    console.log("Form has been submitted");
    alert("Form has been Submitted");
});
