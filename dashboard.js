// Submitting

$("#form").on('submit', function(e) {
   e.preventDefault();
   submit();
});
$("#submit-button").on('click', function(e) {
   e.preventDefault();
   submit();
});

var successAlert = $("#success-alert");
var warningAlert = $("#warning-alert");

function submit() {
    successAlert.hide();
    warningAlert.hide();
    $.ajax({
        type: 'POST',
        url: 'update.php',
        data: {
            'prefix': $("#setting-prefix").val(),
            'welcome-channel': $("#setting-welcome-channel").val(),
            'welcome-color': $("#setting-welcome-color").val(),
            'welcome-image': $("#setting-welcome-image").find(':selected').val()
        },
        success: function(data, status, xhr) {
            successAlert.html(xhr.responseText);
            successAlert.show();
        },
        error: function(xhr, status, error) {
            warningAlert.html(xhr.responseText);
            warningAlert.show();
        }
    });
}

// Preview

var color = "hex:#fffff";
var image = "purr";

var welcomeColorInput = $('#setting-welcome-color');
welcomeColorInput.on('input', function() {
    color = this.value;
    updatePreview();
});
color = welcomeColorInput.val();

var welcomeImageSelect = $('#setting-welcome-image');
welcomeImageSelect.on('change', function() {
    image = this.value;
    updatePreview();
});
image = welcomeImageSelect.find(':selected').val();

var imgPreview = $('#preview-img');
function updatePreview() {
    imgPreview.attr('src', 'preview.php?image=' + image + "&color=" + color.replace('#', '%23'));
}

setTimeout(function(){ updatePreview() }, 100);