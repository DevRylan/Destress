<?php
session_start();
//PHP code meant to establish a session for the admin user
if(isset($_SESSION["adminUser"])){
 //then admin is logged in
}
else if(!isset($_SESSION["adminId"])){
 header("Location: adminLogin.html");
 exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard</title>
</head>
<body>

<h2>Admin Dashboard</h2>
<p id="welcome"></p>
<!--Table for all of the users to be displayed-->
<table border="1" cellpadding="10" id="usersTable">
    <tr>
        <th>Username</th>
        <th>Email</th>
        <th>Created</th>
        <th>Actions</th>
    </tr>
</table>
<button id="logoutBtn">Logout</button>

<script>
async function loadUsers( ){
    //Gets the users from the php script
    let res = await fetch("getUsers.php");;
    const dta = await res.json()
    
    if(dta.status=="not_logged_in"){
        window.location.href="adminLogin.html"
        return;
    }

    document.getElementById("welcome").textContent = "Loggedd in as "+dta.admin;

    let tbl = document.getElementById("usersTable")
    //maps all of thee users onto the table individually
    dta.users.forEach(u=>{
        const rw=document.createElement("tr")
        rw.innerHTML = `
        <td>${u.username}</td>
        <td>${u.email}</td>
        <td>${u.created_at}</td>
        <td>
        <button onclick="editUsr(${u.userId})">Edit</button>
        <button style="color:white;background:red" onclick="deactiv8(${u.userId})">Deactivate</button>
        </td>
        `
        tbl.appendChild(rw)
    })
}

function editUsr(iD){
    window.location.href = "editUser.html?id=" + iD
}

async function deactiv8(x){
    await fetch("deactivateUser.php",{
        method:"POST",
        body:new URLSearchParams({id:x})
    })
    
    ;location.reload()
}

document.getElementById("logoutBtn").onclick=()=>{
    fetch("logoutAdmin.php",{method:"POST"}).then(()=>{
        window.location.href="adminLogin.html"
    })
}

loadUsers()
</script>

</body>
</html>
