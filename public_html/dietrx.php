<html>
<head>
        <title>Results | DietRx Practice</title>
<style>
    body {
        font-family: Arial, Helvetica, sans-serif;
    } </style>
    </head>
    <body>
        
<?php

//total energy requirement
//desirable body weight (DBW) modified tannhauser

//basic patientData
$patientData = array(
    'height_cm' => floatval($_POST['height_cm']),
    'weight_kg' => floatval($_POST['weight_kg']),
    'activity_level' => $_POST['activity_level'],
    'sex' => $_POST['sex'],
    'dbw' => floatval($_POST['dbw']),
    'ns_percent' => floatval($_POST['ns_percent']),
    //'nutriture' => $_POST['nutriture'],
    'bee' => floatval($_POST['bee']),
    'eepa' => floatval($_POST['eepa']),
    'tef' => floatval($_POST['tef']),
    'ter' => floatval($_POST['ter']),
    'carbs' => floatval($_POST['carbs']),
    'protein' => floatval($_POST['protein']),
    'fat' => floatval($_POST['fat']),
);

//echo patient data
echo "<B>PATIENT INFORMATION:</B>" . "<br>";
echo "Height: " . $patientData['height_cm'] . "cm" . "<br>";
echo "Weight: " . $patientData['weight_kg'] . "kg" . "<br>";
echo "Sex: " . $patientData['sex'] . "<br>";
echo "Activity Level: " . $patientData['activity_level'] . "<br>";
echo "<br>";
//check dbw
$dbw = ($patientData['height_cm'] - 100) - (($patientData['height_cm'] - 100)*.1);
if ($patientData['dbw'] != $dbw) {
    echo "Desirable Body Weight (DBW) is incorrect. The correct answer is: " . $dbw . "<br>";
} else {
    echo "Desirable Body Weight (DBW) is correct. The correct answer is: " . $dbw . "<br>";
}

//check nutriture
$nutriturePercent = (((($patientData['weight_kg'] - $dbw) / $dbw))*100);
//round off $nutriturePercent to 2 decimal places
$nutriturePercent = round($nutriturePercent, 2);
//check if nutriture is correct with two decimal precision
if (round($patientData['ns_percent'], 2) != round($nutriturePercent, 2)) {
    echo "Nutriture Status (%) is incorrect. You answered ". $patientData['ns_percent']. "The correct answer is: " . $nutriturePercent . "<br>";
} else {
    echo "Nutriture Status (%) is correct. The correct answer is: " . $nutriturePercent . "<br>";
}

//interpret nutrition status, if weight_kg is +-10% of DBW, then it is normal, if weight_kg is below DBW by more than 10%, it is underweight, if weight_kg is above DBW by 11-20% it is overweight, if weight_kg is above DBW by more than 20%, it is obese, if weight_kg is at least double the DBW, it is morbid_obese
if ($patientData['ns_percent'] <= 10 && $patientData['ns_percent'] >= -10) {
    $nutriture = "normal";
} elseif ($patientData['ns_percent'] > 10 && $patientData['ns_percent'] <= 20) {
    $nutriture = "overweight";
} elseif ($patientData['ns_percent'] > 20 && $patientData['ns_percent'] <= 30) {
    $nutriture = "obese";
} elseif ($patientData['ns_percent'] > 30 && $patientData['ns_percent'] <= 40) {
    $nutriture = "morbid_obese";
} elseif ($patientData['ns_percent'] > 40) {
    $nutriture = "extreme_obese";
} elseif ($patientData['ns_percent'] < -10) {
    $nutriture = "underweight";
}

//check if nutriture is correct
if ($patientData['nutriture'] != $nutriture) {
    echo "Nutriture Status is incorrect. You answered ". $patientData['nutriture']. "The correct answer is: " . $nutriture . "<br>";
} else {
    echo "Nutriture Status is correct. The correct answer is: " . $nutriture . "<br>";
}

//generate bee following the formula: if patient is male, bee = 1.0 * weight * 24, if patient is female, bee = 0.9 * weight * 24
if ($patientData['sex'] == 'male') {
    $bee = 1.0 * $dbw * 24;
} else {
    $bee = 0.9 * $dbw * 24;
}
if ($patientData['bee'] != $bee) {
    echo "Basal Energy Expenditure (BEE) is incorrect. You answered ". $patientData['bee']. "The correct answer is: " . $bee . "<br>";
} else {
    echo "Basal Energy Expenditure (BEE) is correct. The correct answer is: " . $bee . "<br>";
}
//round off bee to 2 decimal places
$bee = round($bee, 2);

//percent increment depending on activity level
$activityIncrementArrayMale = array(
    'bedrest' => 0.2,
    'sedentary' => 0.3,
    'light' => 0.6,
    'moderate' => 0.7,
    'heavy' => 1.1,
);

$activityIncrementArrayFemale = array(
    'bedrest' => 0.1,
    'sedentary' => 0.3,
    'light' => 0.5,
    'moderate' => 0.6,
    'heavy' => 0.9,
);

//generate EEPA using formula EEPA = BEE * activityIncrement depending on Gender
if ($patientData['sex'] == 'male') {
    $eepa = ($bee * $activityIncrementArrayMale[$patientData['activity_level']]);
} else {
    $eepa = ($bee * $activityIncrementArrayFemale[$patientData['activity_level']]);
}

//round off eepa to 2 decimal places
$eepa = round($eepa, 2);
//check if eepa answered is correct
if ($patientData['eepa'] != $eepa) {
    echo "Energy Expenditure Per Activity (EEPA) is incorrect. You answered ". $patientData['eepa']. "The correct answer is: " . $eepa . "<br>";
} else {
    echo "Energy Expenditure Per Activity (EEPA) is correct. The correct answer is: " . $eepa . "<br>";
}

//generate thermic effect of food (TEF) using formula TEF = 10% of (BEE + EEPA)
$tef = 0.1 * ($bee + $eepa);
//round off tef to 2 decimal places
$tef = round($tef, 2);
//check if tef answered is correct
if ($patientData['tef'] != $tef) {
    echo "Thermic Effect of Food (TEF) is incorrect. You answered ". $patientData['tef']. "The correct answer is: " . $tef . "<br>";
} else {
    echo "Thermic Effect of Food (TEF) is correct. The correct answer is: " . $tef . "<br>";
}

//generate total energy requirement using formula TER = BEE + EEPA + TEF
$ter = $bee + $eepa + $tef;

//adjust ter by +500 kcal if underweight nutrition status, -500 kcal if overweight or obese nutrition status
if ($nutriture == 'underweight') {
    $ter = $ter + 500;
} elseif ($nutriture == 'overweight' || $nutriture == 'obese' || $nutriture == 'morbid_obese' || $nutriture == 'extreme_obese') {
    $ter = $ter - 500;
}

//round ter to nearest number divisible by 50
$ter = round($ter / 50) * 50;

//check if ter answered is correct
if ($patientData['ter'] != $ter) {
    echo "Total Energy Requirement (TER) is incorrect. You answered ". $patientData['ter']. "The correct answer is: " . $ter . "<br>";
} else {
    echo "Total Energy Requirement (TER) is correct. The correct answer is: " . $ter . "<br>";
}

//generate carbs requirement by multiplying TER by 0.6
$carbs = (0.6 * $ter)/4;
//round off carbs to nearest 0 or 5
$carbs = round($carbs / 5) * 5;
//check if carbs answered is correct
if ($patientData['carbs'] != $carbs) {
    echo "Carbohydrates (g) is incorrect. You answered ". $patientData['carbs']. "The correct answer is: " . $carbs . "<br>";
} else {
    echo "Carbohydrates (g) is correct. The correct answer is: " . $carbs . "<br>";
}


//generate protein requirement by multiplying TER by 0.15
$protein = (0.15 * $ter)/4;
//round off protein to nearest 0 or 5
$protein = round($protein / 5) * 5;
//check if protein answered is correct
if ($patientData['protein'] != $protein) {
    echo "Protein (g) is incorrect. You answered ". $patientData['protein']. "The correct answer is: " . $protein . "<br>";
} else {
    echo "Protein (g) is correct. The correct answer is: " . $protein . "<br>";
}

//generate fat requirement by multiplying TER by 0.25
$fat = 0.25 * $ter;
//round off fat to nearest 0 or 5
$fat = (round($fat / 5) * 5)/9;
//check if fat answered is correct
if ($patientData['fat'] != $fat) {
    echo "Fat (g) is incorrect. You answered ". $patientData['fat']. "The correct answer is: " . $fat . "<br>";
} else {
    echo "Fat (g) is correct. The correct answer is: " . $fat . "<br>";
}

//echo button returning them to dietrx-practice
?>
<html>
<br>
        <hr>
        <button onclick="window.location.href='https://kurtgutierrez.com/medtools/dietrx-practice.php'">Generate a New Patient</button>
    </body>
</html>
</html>
