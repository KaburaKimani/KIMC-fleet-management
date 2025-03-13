document.addEventListener("DOMContentLoaded", function () {
    const errorMessage = document.getElementById("errorMessage").value;
    if (errorMessage) {
        showPopup(errorMessage);
    }
});

function showPopup(message) {
    const popup = document.getElementById("popup");
    const popupOverlay = document.getElementById("popupOverlay");
    const popupMessage = document.getElementById("popupMessage");

    popupMessage.textContent = message;
    popup.style.display = "block";
    popupOverlay.style.display = "block";
}

function closePopup() {
    const popup = document.getElementById("popup");
    const popupOverlay = document.getElementById("popupOverlay");

    popup.style.display = "none";
    popupOverlay.style.display = "none";
}