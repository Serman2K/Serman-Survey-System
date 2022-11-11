<?php 
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
?>

<?php
include "../php/db_conn.php";
?>

<!doctype html>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>New Question</title>
    <link rel="icon" type="favicon" href="../pictures/favicon.ico">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link href="../css/main.css" rel="stylesheet">
    <link href="../css/que.css" rel="stylesheet">
  </head>

<body>

<main class="text-center align-center">
<h1><img class="mt-2" src="../pictures/Logo.png" alt="" width="200" height="200"></h1>

<form action="../php/questionNewSeq.php" method="post">

  <div class="w-100 text-center">

    <h2>New Question</h2>
		<input type="hidden" name="sid" value="<?php echo $_GET['sid']?>">
            
    <p class="lead text-muted">Question:</p>
    <textarea class="form-control mb-4 Question" name="question" id="question" required></textarea>

    <p class="lead text-muted">Question answer type:</p>
		<select name="qtype" class="qtype" id="qtype" onchange="ansType()">
			<option value="none" disabled="" selected="">--Select--</option>
  			<option value="radio_btn">Single choice</option>
  			<option value="check_box" >Multiple choice</option>
  			<option value="text_f" >Text Field</option>
		</select>

    <p class="lead text-muted preview">Answers (preview):</p>

		<div id="answersPreview">
      <center><b>Select Question Answer type first.</b></center>
    </div>    

    <div>
      <button type="submit" name="submit" class="add-Question-Btn btn btn-primary preview" id="btnCreateQuestion" value="Create">Add Question</button>
    </div>

  </div>

</form>
</main>

<div class="text-center">
  <button class="mt-2 btn text-center align-center btn-secondary w-10 mb-4" id="closeBtn" onclick="location.href='../html/ShowSurvey.php?id=<?php echo  $_GET['sid']?>'">Cancel</button>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
      
</body>




<script>
var i = 2;

function ansType() {
    var qtype = document.getElementById("qtype").value;
    if (qtype == "text_f") {
        document.getElementById("answersPreview").innerHTML = textAnswer;
        i = 2;
    }
    else if (qtype == "radio_btn") {
        document.getElementById("answersPreview").innerHTML = radioAnswer;
        i = 2;
    }
    else if (qtype == "check_box") {
        document.getElementById("answersPreview").innerHTML = checkAnswer;
        i = 2;
    }
    else {
        document.getElementById("answersPreview").innerHTML = "<center><b>Select Question Answer type first.</b></center>";
    }
}

function new_Radio() {
    var tbody = document.querySelector('.answers-list');
    opt = `
    <tr id="optAns-${i + 1}">
        <td class="text-center">
            <input type="radio" id="radioAns${i + 1}" name="radio" checked="" />
            <label for="radioAns${i + 1}"></label>
        </td>
        <td class="text-center">
            <input type="text" class="form-control" placeholder="Enter Answer" name="label[]" />
        </td>
        <td class="text-center"><a href="javascript:void(0)" onclick="removeAns(${i + 1})">Remove</a></td>
    </tr>
    `;
    i++;
    tbody.insertAdjacentHTML('beforeend', opt);
}

function new_Check() {
    var tbody = document.querySelector('.answers-list');
    opt = `
    <tr id="optAns-${i + 1}">
        <td class="text-center">
            <input type="checkbox" id="checkAns${i + 1}" name="check" checked="" />
            <label for="checkAns${i + 1}"></label>
        </td>
        <td class="text-center">
            <input type="text" class="form-control" placeholder="Enter Answer" name="label[]" />
        </td>
        <td class="text-center"><a href="javascript:void(0)" onclick="removeAns(${i + 1})">Remove</a></td>
    </tr>
    `;
    i++;
    tbody.insertAdjacentHTML('beforeend', opt);
}

function removeAns(obj) {
    const target = document.getElementById('optAns-'+obj);
    target.remove();
}

var textAnswer = '<textarea id="textAns" cols="30" rows="4" class="form-control" disabled=""  placeholder="Write Your answer here..."></textarea>';

var radioAnswer = `
<div id="radio_btn_preview">
    <div class="callout callout-info">

        <table width="100%">
            <colgroup>
                <col width="10%">
                <col width="80%">
                <col width="10%">
            </colgroup>
            <tbody class="answers-list">
                <tr>
                    <td class="text-center">
                        <input type="radio" id="radioAns1" name="radio" checked="" />
                        <label for="radioAns1"></label>
                    </td>
                    <td class="text-center">
                        <input type="text" class="form-control" placeholder="Option 1" name="label[]" />
                    </td>
                    <td class="text-center"></td>
                </tr>
                <tr>
                    <td class="text-center">
                        <input type="radio" id="radioAns2" name="radio" checked="" />
                        <label for="radioAns2"></label>
                    </td>
                    <td class="text-center">
                        <input type="text" class="form-control" placeholder="Option 2" name="label[]" />
                    </td>
                    <td class="text-center"></td>
                </tr>
            </tbody>
        </table>

        <div class="row">
            <div class="col-sm-12 pt-4 text-center">
                <button class="btn btn-success" type="button" onclick="new_Radio()">Add</button>
            </div>
        </div>

    </div>
</div>
`;

var checkAnswer = `
<div id="radio_btn_preview">
    <div class="callout callout-info">

        <table width="100%">
            <colgroup>
                <col width="10%">
                <col width="80%">
                <col width="10%">
            </colgroup>
            <tbody class="answers-list">
                <tr>
                    <td class="text-center">
                        <input type="checkbox" id="checkAns1" name="check" checked="" />
                        <label for="checkAns1"></label>
                    </td>
                    <td class="text-center">
                        <input type="text" class="form-control" placeholder="Option 1" name="label[]" />
                    </td>
                    <td class="text-center"></td>
                </tr>
                <tr>
                    <td class="text-center">
                        <input type="checkbox" id="checkAns2" name="check" checked="" />
                        <label for="checkAns2"></label>
                    </td>
                    <td class="text-center">
                        <input type="text" class="form-control" placeholder="Option 2" name="label[]" />
                    </td>
                    <td class="text-center"></td>
                </tr>
            </tbody>
        </table>

        <div class="row">
            <div class="col-sm-12 pt-4 text-center">
                <button class="btn btn-success" type="button" onclick="new_Check()">Add</button>
            </div>
        </div>

    </div>
</div>
`;
</script>




</html>

<?php
}
else {
  header("Location: Login.php");
  exit();
}
?>