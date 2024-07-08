let year = document.querySelector("#year");
let month = document.querySelector("#month");
let courseName = document.querySelector("#courseName");
let cost = document.querySelector("#cost");
let startDate = document.querySelector("#startDate");
let endDate = document.querySelector("#endDate");
let noParticipantSLPA = document.querySelector("#NoOfSLPA");
let noParticipantOutside = document.querySelector("#NoOfOutside");
let tainingManHrs = document.querySelector("#trainingManHrs");
let trainingWhetherCompleted = document.querySelector("#trainingWeatherCompleted");
let trainingWhetherOngoing = document.querySelector("#trainingWeatherOngoing");
let totalAmount = document.querySelector("#totalAmount");
let trainingtype;
let lblyear = document.querySelector("#yearError");
let lblmonth = document.querySelector("#monthError");
let lblcourseName = document.querySelector("#courseNameError");
let lblcost = document.querySelector("#costError");
let lblstartDate = document.querySelector("#startDateError");
let lblendDate = document.querySelector("#endDateError");
let lblnoParticipantSLPA = document.querySelector("#NoOfSLPAError");
let lblnoParticipantOutside = document.querySelector("#NoOfOutsideError");
let lbltainingManHrs = document.querySelector("#trainingManHrsError");
let lblTrainingWhether = document.querySelector("#trainingWeatherError");
let lbltotalAmount = document.querySelector("#totalAmountError");
const performanceForm = document.getElementById("performanceForm");
let btnSubmit = document.querySelector("#submit");

function validateYear() {
  if (year.value === "") {
    lblyear.innerHTML = "This field is required";
    return false;
  }

  lblyear.innerHTML = "";
  return true;
}

function validateMonth() {
  if (month.value === "Choose Month" || month.value === "") {
    lblmonth.innerHTML = "This field is required";
    return false;
  }

  lblmonth.innerHTML = "";
  return true;
}

function validateCourseName() {
  if (courseName.value === "") {
    lblcourseName.innerHTML = "This field is required";
    return false;
  }

  lblcourseName.innerHTML = "";
  return true;
}

function validateCost() {
  if (cost.value === "") {
    lblcost.innerHTML = "This field is required";
    return false;
  }

  lblcost.innerHTML = "";
  return true;
}

function validateStartDate() {
  if (startDate.value === "") {
    lblstartDate.innerHTML = "This field is required";
    return false;
  }

  lblstartDate.innerHTML = "";
  return true;
}

function validateEndDate() {
  if (endDate.value === "") {
    lblendDate.innerHTML = "This field is required";
    return false;
  }

  lblendDate.innerHTML = "";
  return true;
}

function validateNoParticipantSLPA() {
  if (noParticipantSLPA.value === "") {
    lblnoParticipantSLPA.innerHTML = "This field is required";
    return false;
  }

  lblnoParticipantSLPA.innerHTML = "";
  return true;
}

function validateNoParticipantOutside() {
  if (noParticipantOutside.value === "") {
    lblnoParticipantOutside.innerHTML = "This field is required";
    return false;
  }

  lblnoParticipantOutside.innerHTML = "";
  return true;
}

function validateTainingManHrs() {
  if (tainingManHrs.value === "") {
    lbltainingManHrs.innerHTML = "This field is required";
    return false;
  }

  lbltainingManHrs.innerHTML = "";
  return true;
}

function validateTrainingWhether() {
  if (trainingWhetherCompleted.checked || trainingWhetherOngoing.checked) {
    if (trainingWhetherCompleted.checked) {
      trainingtype = "Completed";
    } else {
      trainingtype = "Ongoing";
    }
    lblTrainingWhether.innerHTML = "";
    return true;
  }

  lblTrainingWhether.innerHTML = "This field is required";
  return false;
}

function validateTotalAmount() {
  if (totalAmount.value === "") {
    lbltotalAmount.innerHTML = "This field is required";
    return false;
  }

  lbltotalAmount.innerHTML = "";
  return true;
}

function validateForm() {
  let valid = validateYear();
  valid = validateMonth() && valid;
  valid = validateCourseName() && valid;
  valid = validateCost() && valid;
  valid = validateStartDate() && valid;
  valid = validateEndDate() && valid;
  valid = validateNoParticipantSLPA() && valid;
  valid = validateNoParticipantOutside() && valid;
  valid = validateTainingManHrs() && valid;
  valid = validateTrainingWhether() && valid;
  valid = validateTotalAmount() && valid;

  return valid;
}

btnSubmit.addEventListener("click", async (event) => {
  event.preventDefault();
  if (validateForm()) {
    let data = {
      year: parseInt(year.value),
      month: month.value,
      courseName: courseName.value,
      cost: parseFloat(cost.value),
      startDate: startDate.value,
      endDate: endDate.value,
      noParticipantSLPA: parseInt(noParticipantSLPA.value),
      noParticipantOutside: parseInt(noParticipantOutside.value),
      trainingManHrs: tainingManHrs.value,
      TrainingWhether: trainingtype,
      totalAmount: parseFloat(totalAmount.value),
    };
    const jsonData = JSON.stringify(data);
    try {
      let response = await sendData(jsonData);
      console.log(response);
      if (response.success) {
        console.log("operation successfull");
        alert("performance reported successfully");
        performanceForm.reset();
      } else {
        console.log("operation unsuccessfull");
      }
    } catch (error) {
      console.log(error);
      alert(error.message);
    }
  }
});

async function sendData(jsonData) {
  let response = await fetch("http://localhost:3000/performance", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: jsonData,
  });
  if (response.ok) {
    let responseObj = await response.json();
    return responseObj;
  } else {
    throw new Error("request failed");
  }
}
