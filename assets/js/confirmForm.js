function regConfirm() {
  const formRegistrazione = document.getElementById("formConfirm");
  const nameReg = document.getElementById("name-reg").value;
  const cognomeReg = document.getElementById("cognome-reg").value;
  const birthdateReg = document.getElementById("birthdate-reg").value;
  const usernameReg = document.getElementById("username-reg").value;
  const ibanReg = document.getElementById("iban-reg").value;
  const capReg = document.getElementById("cap-reg").value;
  const indirizzoReg = document.getElementById("indirizzo-reg").value;

  let pattern;
  let element;
  let elementToShow;

  // check sul nome
  element = document.getElementById("name-reg");
  pattern = pattern = /^([a-zA-Z\xE0\xE8\xE9\xF9\xF2\xEC\x27]\s?)+$/;
  if (!nameReg) {
    document.getElementById("name-reg").value = "";
  } else {
    if (
      !checkPatternChars(element, nameReg, pattern) ||
      nameReg.length < 3 ||
      nameReg.length > 20
    ) {
      element.classList.add("is-invalid");
      element.classList.add("border-red");
      return false;
    }
  }

  // check sul cognome
  element = document.getElementById("cognome-reg");
  pattern = pattern = /^([a-zA-Z\xE0\xE8\xE9\xF9\xF2\xEC\x27]\s?)+$/;
  if (!cognomeReg) {
    document.getElementById("cognome-reg").value = "";
  } else {
    if (
      !checkPatternChars(element, cognomeReg, pattern) ||
      cognomeReg.length < 3 ||
      cognomeReg.length > 20
    ) {
      element.classList.add("is-invalid");
      element.classList.add("border-red");
      return false;
    }
  }

  // check data di nascita
  element = document.getElementById("birthdate-reg");
  elementToShow = document.getElementById("no-maggiorenne");
  pattern = /^([0-9]{4})\-([0-9]{2})\-([0-9]{2})$/;
  if (
    !birthdateReg ||
    !checkPatternChars(element, birthdateReg, pattern) ||
    !checkMaggiorenne(birthdateReg)
  ) {
    element.classList.add("is-invalid");
    element.classList.add("border-red");
    return false;
  }
  // check username
  element = document.getElementById("username-reg");
  pattern = /^([a-zA-Z0-9\.\_\-])+$/;
  if (
    !usernameReg ||
    !checkPatternChars(element, usernameReg, pattern) ||
    usernameReg.length < 4 ||
    usernameReg.length > 20
  ) {
    element.classList.add("is-invalid");
    element.classList.add("border-red");
    return false;
  }

  // check iban
  element = document.getElementById("iban-reg");
  pattern = pattern = /^IT\d{2}[A-Z]{1}\d{10}[A-Z0-9]{12}$/;
  if (!ibanReg) {
    document.getElementById("iban-reg").value = "";
  } else {
    if (!checkPatternChars(element, ibanReg, pattern)) {
      element.classList.add("is-invalid");
      element.classList.add("border-red");
      return false;
    }
  }

  // check cap
  element = document.getElementById("cap-reg");
  pattern = pattern = /^\d{5}$/;

  if (!capReg) {
    document.getElementById("cap-reg").value = 0;
  } else {
    if (!checkPatternChars(element, capReg, pattern)) {
      element.classList.add("is-invalid");
      element.classList.add("border-red");
      return false;
    }
  }
  return true;
}

function checkPatternChars(campo, valore, pattern) {
  if (!pattern.test(valore)) {
    campo.placeholder = "Campo non valido";
    return false;
  } else {
    return true;
  }
}

function checkMaggiorenne(userInput) {
  const dob = new Date(userInput);
  const month_diff = Date.now() - dob.getTime();

  const age_dt = new Date(month_diff);

  const year = age_dt.getUTCFullYear();

  const age = Math.abs(year - 1970);
  if (age < 18) {
    return false;
  } else {
    return true;
  }
}
