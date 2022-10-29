$(document).ready(function () {
  var imgs = document.getElementsByTagName("img");
  var imgSrcs = [];

  for (var i = 0; i < imgs.length; i++) {
    img = imgs[i];
    var width = img.clientWidth;
    var height = img.clientHeight;
    if (width < height) {
      img.setAttribute("style", "transform:rotate(90deg)");
    }
  }
});
