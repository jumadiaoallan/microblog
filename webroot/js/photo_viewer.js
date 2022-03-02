//Image view for profile only

$( document ).ready(function() {
imgInpbanner.onchange = evt => {

  var fi = document.getElementById('imgInpbanner');

  var fsize = fi.files.item(0).size;
  var mb = Math.round((fsize * 0.000001));
  if (mb >= 2) {
    $("#image-error").modal("show");
    $("#imgInpbanner").val("");
  } else {
    const [file] = imgInpbanner.files
    if (file) {
      banners.src = URL.createObjectURL(file)
    }
  }
  }


imgInp.onchange = evt => {
  var fi = document.getElementById('imgInp');

  var fsize = fi.files.item(0).size;
  var mb = Math.round((fsize * 0.000001));
  if (mb >= 2) {
    $("#image-error").modal("show");
    $("#imgInp").val("");
  } else {
    const [file] = imgInp.files
    if (file) {
      profile.src = URL.createObjectURL(file)
      }
    }
  }
  });
