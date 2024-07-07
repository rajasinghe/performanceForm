const downloadBtn = document.getElementById("download");
const getReport = document.getElementById("getReport");
downloadBtn.addEventListener("click", (e) => {
  e.preventDefault();
  //change the arguments as needed
  try {
    sendDownloadRequest(6, 2024);
  } catch (error) {}
});

getReport.addEventListener("click", (e) => {
  e.preventDefault();
  //change the arguments as needed
  sendReadRequest(6, 2024);
});

const sendReadRequest = async (month, year) => {
  const endPoint = `http://localhost:3000/performance/reports/data?year=${year}&month=${month}`;
  const response = await fetch(endPoint);
  if (response.ok) {
    const data = await response.json();
    console.log(data);
    //use the data from here
  } else {
    alert("error in reponse");
    throw new Error("error in reponse");
  }
};

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
