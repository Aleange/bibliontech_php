$(document).ready(function () {
  $("#titolo").keyup(function () {
    const input = $(this).val();

    if (input.length < 3 || input.length > 100) {
      $("#titolo").removeClass("is-valid");
      $("#titolo").addClass("is-invalid");
    } else {
      $("#titolo").removeClass("is-invalid");
      $("#titolo").addClass("is-valid");
    }
  });

  $("#autore").keyup(function () {
    const input = $(this).val();

    if (input.length < 3 || input.length > 300) {
      $("#autore").removeClass("is-valid");
      $("#autore").addClass("is-invalid");
    } else {
      $("#autore").removeClass("is-invalid");
      $("#autore").addClass("is-valid");
    }
  });

  $("#descrizione").keyup(function () {
    const input = $(this).val();

    if (input.length < 3 || input.length > 500) {
      $("#descrizione").removeClass("is-valid");
      $("#descrizione").addClass("is-invalid");
    } else {
      $("#descrizione").removeClass("is-invalid");
      $("#descrizione").addClass("is-valid");
    }
  });

  $("#sel-copertina").keyup(function () {
    const ele = document.getElementById("sel-copertina");
    if (ele.files.length > 3) {
      $("#sel-copertina").removeClass("is-valid");
      $("#sel-copertina").addClass("is-invalid");
    } else {
      $("#sel-copertina").removeClass("is-invalid");
      $("#sel-copertina").addClass("is-valid");
    }
  });
});
