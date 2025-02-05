const testSelect = document.getElementById("db-select-test");
let sampleTypeContainer = document.querySelector(".sample-type-container");
let parameterContainer = document.querySelector(".parameter-container");
const recivedBtn = document.getElementById("sample-recived-btn");
const rejectedBtn = document.getElementById("sample-rejected-btn");

testSelect.addEventListener("change", () => {
  const selectedValue =
    testSelect.options[testSelect.selectedIndex].value.toLowerCase();
  if (selectedValue.includes("select")) {
    sampleTypeContainer.classList.remove("d-block");
    sampleTypeContainer.classList.add("d-none");
    parameterContainer.classList.remove("d-block");
    parameterContainer.classList.add("d-none");
  } else {
    sampleTypeContainer.classList.remove("d-none");
    sampleTypeContainer.classList.add("d-block");
  }
});

function SampleType(e) {
  if (e.checked) {
    parameterContainer.classList.remove("d-none");
    parameterContainer.classList.add("d-block");
    rejectedBtn.classList.remove("d-none");
    recivedBtn.classList.add("d-none");
  } else {
    parameterContainer.classList.add("d-none");
    parameterContainer.classList.remove("d-block");
    recivedBtn.classList.remove("d-none");
    rejectedBtn.classList.add("d-none");
  }
}

// collect message show

const buttonHide = document.getElementById("btn-collectHide");
const messageText = document.getElementById("message-text");

buttonHide.addEventListener("click", () => {
  buttonHide.style.display = "none";
  messageText.style.display = "block";
});

// select sample list added
// function addSampleList() {
//   const textNewInput = document.createElement("div");
//   textNewInput.className = "bg-primary text-white mb-3";
//   textNewInput.innerHTML = `
//         <div class="d-flex align-items-center gap-2">
//           <span>New Sample List Added</span>
//       </div>
//       <div onclick="removeAddEmployee()">
//          <i class="bi bi-x fw-bold fs-6"></i>
//       </div>
// `;
//   document.getElementById("newDiv").appendChild(textNewInput);
// }
