$(document).ready(function () {
  const imgs = document.getElementsByTagName("img");
  const imgSrcs = [];

  for (let i = 0; i < imgs.length; i++) {
    img = imgs[i];
    const width = img.clientWidth;
    const height = img.clientHeight;
    if (width < height) {
      img.setAttribute("style", "transform:rotate(90deg)");
    }
  }
});
