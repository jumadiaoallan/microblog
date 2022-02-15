//Image view for profile only

$( document ).ready(function() {
imgInpbanner.onchange = evt => {
  const [file] = imgInpbanner.files
  if (file) {
    banners.src = URL.createObjectURL(file)
  }
  }


imgInp.onchange = evt => {
  const [file] = imgInp.files
  if (file) {
    profile.src = URL.createObjectURL(file)
  }
  }
  });
