const signUpButton = document.getElementById("signUp");
const signInButton = document.getElementById("signIn");
const container = document.getElementById("external-form-container");

signUpButton.addEventListener("click", () => {
  container.classList.add("right-panel-active");
});

signInButton.addEventListener("click", () => {
  container.classList.remove("right-panel-active");
});

const linkSignUp = document.getElementById("reg-link");
const linkSignIn = document.getElementById("acc-link");

linkSignUp.addEventListener("click", () => {
  container.classList.add("right-panel-active");
});

linkSignIn.addEventListener("click", () => {
  container.classList.remove("right-panel-active");
});

function regSubmit() {
  const formRegistrazione = document.getElementById("form-registrazione");
  // var nameReg = document.getElementById('name-reg').value;

  const birthdateReg = document.getElementById("birthdate-reg").value;
  const usernameReg = document.getElementById("username-reg").value;
  const emailReg = document.getElementById("email-reg").value;
  const passwordReg = document.getElementById("password-reg").value;

  let pattern;
  let element;

  // check sul nome
  /* element = document.getElementById("name-reg");
	pattern = pattern = /^([a-zA-Z\xE0\xE8\xE9\xF9\xF2\xEC\x27]\s?)+$/;
	if (!nameReg || !checkPatternChars(element, nameReg, pattern)) {
		element.classList.add("is-invalid");
		element.classList.add("border-red");
		return false;
	} */

  // check data di nascita
  // anno attuale
  const actualD = new Date();
  const actualYear = actualD.getFullYear();
  const actualYearFor18 = actualYear - 18;
  element = document.getElementById("birthdate-reg");
  const d = new Date(element.value);
  const year = d.getFullYear();
  if (year > actualYearFor18) {
    element.classList.add("is-invalid");
    element.classList.add("border-red");
    return false;
  }
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

  // check email
  element = document.getElementById("email-reg");
  pattern = /^[a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
  if (!emailReg || !checkPatternChars(element, emailReg, pattern)) {
    element.classList.add("is-invalid");
    element.classList.add("border-red");
    return false;
  }

  // check password
  element = document.getElementById("password-reg");
  pattern =
    /^[a-zA-Z0-9\_\*\-\+\!\?\,\:\;\.\xE0\xE8\xE9\xF9\xF2\xEC\x27]{8,20}/;
  if (!passwordReg || !checkPatternChars(element, passwordReg, pattern)) {
    element.classList.add("is-invalid");
    element.classList.add("border-red");
    return false;
  }
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

function checkBook() {
  const titolo = document.getElementById("titolo").value;
  const autore = document.getElementById("autore").value;
  const isbn1 = document.getElementById("isbn1").value;
  const condizioni = document.getElementById("condizioni").value;
  if (!titolo || titolo.length < 3 || titolo.length > 100) {
    document.getElementById("titolo").classList.add("is-invalid");
    return false;
  }
  if (!autore || autore.length < 3 || autore.length > 300) {
    document.getElementById("titolo").classList.add("is-invalid");
    return false;
  }
  if (isbn1) {
    if (isbn1.length !== 13) {
      document.getElementById("isbn1").classList.add("is-invalid");
      return false;
    }
  }
  if (condizioni < 1 || condizioni > 5) {
    document.getElementById("condizioni").classList.add("is-invalid");
    return false;
  }
  return true;
}
