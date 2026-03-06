function showTeachers(){

document.getElementById("mainContent").style.display="none";
document.getElementById("teachers").style.display="block";

window.scrollTo(0,0)

}

function backHome(){

document.getElementById("mainContent").style.display="block";
document.getElementById("teachers").style.display="none";

}

function openProfile(){

let modal = new bootstrap.Modal(document.getElementById('profileModal'));
modal.show();

}