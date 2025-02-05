/*============================ 
customer-db-test-select 
==============================*/
function dbSelectSample(e) {
  const selectedSample = e.options[e.selectedIndex].value.toLowerCase();
  const selectedTestContainer = e.parentElement.parentElement.parentElement.parentElement.children[1];
  console.log(selectedTestContainer);
  if(!selectedSample.includes("select")) {
    selectedTestContainer.classList.remove("d-none");
    selectedTestContainer.classList.add("d-block");
  }else{
    selectedTestContainer.classList.add("d-none");
    selectedTestContainer.classList.remove("d-block");
  }
}

function dbSelectTest(e){
  const selectedTest = e.options[e.selectedIndex].value.toLowerCase();
  const parameterContainer = e.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.children[2];
  if(!selectedTest.includes("select")){
    parameterContainer.classList.remove("d-none");
    parameterContainer.classList.add("d-block");
  }else{
    parameterContainer.classList.add("d-none");
    parameterContainer.classList.remove("d-block");
  }
}
// ==========================================



let count = 0;
let newArr = [];
function newTestAdd(e) {
  count ++;
  newArr.push(count);
  testSelectContainer(newArr.length+1);
}

function newTestDelete(e){
  newArr.pop();
  e.parentNode.parentNode.parentNode.parentNode.style.display = "none";
}

function testSelectContainer(count){
  let newTestSelectContainer = document.getElementById("new-test-select-container");
  const div = document.createElement('div');
  div.classList.add("border", "p-3", "rounded-3", "custom-card-shadow")
  div.innerHTML = `
    <div class="login-field">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <li class="small-text-12 fw-medium" style="color: #595757; margin-left: 12px;">
            <label class="mb-2">Sample Type</label>
          </li>
          <div class="d-flex gap-2">
            <!-- add btn -->
            <div onclick="newTestAdd(this)" class="test-add-btn">
              <i class="bi bi-plus-lg"></i>
            </div>

            <!-- minus btn -->
            <div onclick="newTestDelete(this)" class="test-delete-btn">
              <i class="bi bi-dash-lg"></i>
            </div>
        </div>
    </div>

    <div class="position-relative">
          <div class="input-style rounded-3">
            <select onchange="dbSelectSample(this)" name="sample"
              class="small-text-12 custom-form-select">
              <option value="">Select sample type</option>
              <option value="Fish">Fish</option>
              <option value="Shirmp">Shirmp</option>
              <option value="Live Eel">Live Eel</option>
              <option value="Crab">Crab</option>
              <option value="Swab">Swab</option>
            </select>
            <div class="select-form-arrow">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" width="16">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
              </svg>
            </div>
          </div>
        </div>
    </div>

    <!-- select district -->
    <div class="d-none">
      <div class="login-field mt-2">
        <label class="mb-2">Choose a Test</label>
        <div>
          <div class="position-relative">
            <div class="input-style rounded-3">
              <select onchange="dbSelectTest(this)" name="test"
                class="small-text-12 custom-form-select">
                <option value="">Select Test</option>
                <option value="Chemical-Test-Report-Antibiotics">
                  Chemical Test Report - Antibiotics
                </option>
                <option value="Test-2">Test-2</option>
                <option value="Test-3">Test-3</option>
              </select>
              <div class="select-form-arrow">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                  stroke-width="1.5" stroke="currentColor" width="16">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Parameter -->
    <div class="login-field parameter-container mt-2 d-none">
      <label class="mb-2">Parameter</label>
      <div class="d-flex gap-3">
        <div>
          <input type="checkbox" name="sample-type" value="nitrofuran-metabol"
            class="form-check-input" />
          <label class="ms-2">Nitrofuran Metabol</label>
        </div>
        <div>
          <input type="checkbox" name="sample-type" value="gentamicin" class="form-check-input" />
          <label class="ms-2">Gentamicin</label>
        </div>
        <div>
          <input type="checkbox" name="sample-type" value="tylosin" class="form-check-input" />
          <label class="ms-2">Tylosin</label>
        </div>
        <div>
          <input type="checkbox" name="sample-type" value="oxalic-acid" class="form-check-input" />
          <label class="ms-2">Oxalic Acid</label>
        </div>
      </div>
    </div>
  `
  newTestSelectContainer.appendChild(div);
}