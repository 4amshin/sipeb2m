function togglePasswordVisibility(inputId, showEyeId, hideEyeId) {
    var inputElement = document.getElementById(inputId);
    var showEye = document.getElementById(showEyeId);
    var hideEye = document.getElementById(hideEyeId);
    hideEye.classList.remove("d-none");

    if (inputElement.type === "password") {
        inputElement.type = "text";
        showEye.style.display = "none";
        hideEye.style.display = "block";
    } else {
        inputElement.type = "password";
        showEye.style.display = "block";
        hideEye.style.display = "none";
    }
}
