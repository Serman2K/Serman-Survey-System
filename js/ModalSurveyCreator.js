//Modal Part

// Get the modal
var modal = document.getElementById("modal");

// Get the button that opens the modal
var btnOpen = document.getElementById("modalBtn");

// Get the button that closes the modal
var btnClose = document.getElementById("closeBtn");

// When the user clicks the button, open the modal 
btnOpen.onclick = function () {
    modal.style.display = "block";
}

btnClose.onclick = function () {
    modal.style.display = "none";
}

var btnSurvey = document.getElementById("btnCreateSurvey");

btnSurvey.onclick = function () {
    modal.style.display = "none";
}


//Survey List Part
const Survey = {  //Survey Example - for tests
    name:[],
  };
  
  const SurveyList = { //List
    list: [],
  };

const btnAddSurvey = document.querySelector('.add-Survey-Btn');   //Button which add new offer
const containerSurveys = document.querySelector('.Survey-list'); //Location of Offers List
const surveyName = document.querySelector('.Survey-Name'); //Name of new created survey
const emptyHider = document.querySelector('.empty-message'); //Part of the main site which is visible when user don't have any offer
var i = 0;

const hideMessage = function() { //function to check when user have any offer
    if (i==0) {
      emptyHider.style.display = "block";
    } else {
      emptyHider.style.display = "none";
    }
  }

  btnAddSurvey.addEventListener('click', function (f) { //add new survey
    f.preventDefault();
    const SName = String(surveyName.value);
    Survey.name.push(SName);

    // Add offer
    SurveyList.list.push(Survey);
    // Update UI
    updateUI(SurveyList.list);
  });

const updateUI = function (list, sort = false) { // Display offers
    const j = 0;
    containerSurveys.innerHTML = '';

    const movs = sort ? list.slice().sort((a, b) => a - b) : list;

    movs.forEach(function (mov, j) {
        const html = `
        <table class="survey-row">
          <tr>
            <th class="survey-id survey-id--${j + 1}"> ${j + 1} </th>
            <td class="survey-name survey-name--${j + 1}"> ${mov.name[j]} </td>
            <td class="survey-btn">
            <button>Edytuj</button>
            </td>
            <td class="survey-btn">
            <button>Usuń</button>
            </td>
          <tr>
        </table>
      `;

        containerSurveys.insertAdjacentHTML('afterbegin', html);
        i += 1;
        hideMessage();
    });
};