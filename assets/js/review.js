const addReviewOpen = document.getElementById("add-review-open");
const addReviewClose = document.getElementById("add-review-close");
const addReviewClose1 = document.getElementById("add-review-close-1");
var addReview = document.getElementById("add-review");
var addReview1 = document.getElementById("add-review1");

addReviewOpen.addEventListener("click", () => {
  addReview.style.display = "flex";
});

addReviewClose.addEventListener("click", () => {
  addReview.style.display = "none";
});

addReviewClose1.addEventListener("click", () => {
  addReview1.style.display = "none";
});

function readMore(i) {
  
    $("#" + i.toString()).css("-webkit-line-clamp", "100");
  var buttonReadMore = document.getElementById('readmore' + i.toString());
  var buttonReadLess = document.getElementById('readless' + i.toString());
  buttonReadMore.style.display = 'none';
  buttonReadLess.style.display = 'block';

  }

  

function readLess(i) {

  $("#" + i.toString()).css("-webkit-line-clamp", "5");
  var buttonReadMore = document.getElementById('readmore' + i.toString());
  var buttonReadLess = document.getElementById('readless' + i.toString());
  buttonReadMore.style.display = 'block';
  buttonReadLess.style.display = 'none';
}

$(document).ready(function() {

  $("#recensione").keyup(function() {
      var input = $(this).val();

      if (input.length < 3 || input.length > 600) {
          $("#recensione").removeClass("is-valid");
          $("#recensione").addClass("is-invalid");

      } else {
          $("#recensione").removeClass("is-invalid");
          $("#recensione").addClass("is-valid");
      }

  });
});
