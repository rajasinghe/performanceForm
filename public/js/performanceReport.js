let element = document.getElementById("download");

element.addEventListener("click", (e) => {
  e.preventDefault();
  //change the arguments as needed
  sendDownloadRequest(2, 2024);
});

const sendReadRequest = async (month, year) => {
  const endPoint = `http://localhost:3000/performance/reports/download?month=${month}&year=${year}`;
  const response = await fetch(endPoint);
  if (response.ok) {
    const data = response.json();
    console.log(data);
    //use the data from here
  } else {
    alert("error in response");
  }
};

const sendDownloadRequest = async (month, year) => {
  const endPoint = `http://localhost:3000/performance/reports/download?month=${month}&year=${year}`;
  const response = await fetch(endPoint);

  if (response.ok) {
    const pdfblob = await response.blob();
    const url = window.URL.createObjectURL(pdfblob);
    const a = document.createElement("a");
    a.style.display = "none";
    a.href = url;
    a.download = "performanceReport.pdf";
    document.body.appendChild(a);
    a.click();
    window.URL.revokeObjectURL(url);
  } else {
  }
  console.log(response);
};
