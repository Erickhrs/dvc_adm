const pictureInput = document.getElementById('pictureInput');
const previewImage = document.getElementById('previewImage');
pictureInput.addEventListener('input', function () {
    var reader = new FileReader();
    reader.onload = function(event) {
        previewImage.src = event.target.result;
    }
    reader.readAsDataURL(pictureInput.files[0]);
});