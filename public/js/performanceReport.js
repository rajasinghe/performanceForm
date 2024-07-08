const tableBody = document.getElementById("tableBody")


const downloadBtn = document.getElementById("download");
const getReport = document.getElementById("getReport");

const yearCombo = document.getElementById("year");
const month = document.getElementById("month");



downloadBtn.addEventListener("click", (e) => {
  e.preventDefault();
  //change the arguments as needed
  try {

    if(yearCombo.value === "Select Year" || month.value === "Select Month"){
      
    }else{
      sendDownloadRequest(month.value, yearCombo.value);
    }
    
  } catch (error) {}
});

getReport.addEventListener("click", (e) => {
  e.preventDefault();
  //change the arguments as needed

  if(yearCombo.value === "Select Year" || month.value === "Select Month"){
      
  }else{
    tableBody.innerHTML = "";
    sendReadRequest(month.value, yearCombo.value);
  }
  
});

const sendReadRequest = async (month, year) => {
  const endPoint = `http://localhost:3000/performance/reports/data?year=${year}&month=${month}`;
  const response = await fetch(endPoint);
  if (response.ok) {
    const data = await response.json();
    console.log(data);
    //use the data from here
    for (const item of data) {
    tableBody.innerHTML += `
            <tr>
              <td>${item['Name_of_Course']}</td>
              <td>${item['Cost_Per_Participant']}</td>
              <td>${item['Scheduled_Start_Date']}</td>
              <td>${item['Scheduled_End_Date']}</td>
              <td>${item['No_of_participated(SLPA)']}</td>
              <td>${item['No_of_participated(Outside)']}</td>
              <td>${item['No_of_Training_Man_Hrs']}</td>
              <td>${item['Whether_Training']}</td>
              <td>${item['Remarks']}</td>
            </tr>
    `
    }

  } else {
    alert("error in reponse");
    throw new Error("error in reponse");
  }
};



const sendYearRequest = async () => {
  const endPoint = `http://localhost:3000/performance/reports/getYearList`;
  const response = await fetch(endPoint);
  if (response.ok) {
    const data = await response.json();
    console.log(data);
    //use the data from here
    for (const item of data) {

      yearCombo.innerHTML +=`
      <option value="${item["Year"]}">${item["Year"]}</option>
      `;

    }

  } else {
    alert("error in reponse");
    throw new Error("error in reponse");
  }
};

window.addEventListener("load", sendYearRequest);


const sendDownloadRequest = async (month, year) => {
  const endPoint = `http://localhost:3000/performance/reports/download/${year}/${month}`;
  const response = await fetch(endPoint);

  if (response.ok) {
    const pdfblob = await response.blob();
    const url = window.URL.createObjectURL(pdfblob);
    const a = document.createElement("a");
    a.style.display = "none";
    a.href = url;
    a.download = `performanceReport(${month}-${year}).pdf`;
    document.body.appendChild(a);
    a.click();
    window.URL.revokeObjectURL(url);
  } else {
    throw new Error("error in reponse");
  }
  console.log(response);
};
