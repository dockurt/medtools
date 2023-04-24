<html>

<head>
    <title>Practice DietRX | Medtools</title>
    <style>
    body {
        font-family: Arial, Helvetica, sans-serif;
    } </style>
    </head>
    <body>
        
<h2>Practice DietRX</h2>
<p>by Kurt Gutierrez</b>
<br><br><br>
    <?php
    /*
            nutriture status:
                normal = +-10% of DBW
                underweight = <10%
                overweight = >11-20%
                obese = >20%
                morbidobese = 2x-3x
            sex:
                male
                female
            eepa activity levels:
                bedrest: 10-20%
                sedentary: 30%
                light: 50-60%
                moderate: 60-70%
                heavy: 90-110%
        */

    $sexArray = array('male', 'female');
    $nutritureArray = array('normal', 'underweight', 'overweight', 'obese', 'morbid_obese');
    $activityArray = array('bedrest', 'sedentary', 'light', 'moderate', 'heavy');

    $patientData = array(
        'height_cm' => rand(150, 180),
        'weight_kg' => rand(50, 100),
        'sex' => $sexArray[array_rand($sexArray)],
        'activity_level' => $activityArray[array_rand($activityArray)],
    );

    //generate case
    echo "<B>PATIENT INFORMATION:</B>" . "<br>";
    echo "Height: " . $patientData['height_cm'] . "cm" . "<br>";
    echo "Weight: " . $patientData['weight_kg'] . "kg" . "<br>";
    echo "Sex: " . $patientData['sex'] . "<br>";
    echo "Activity Level: " . $patientData['activity_level'] . "<br>";
    echo "<br>";
    echo "<B>ANSWER SHEET</B>" . "<br>";
    echo "<i>Round answers off to 2 decimal places</i>" . "<br>";
    ?>
    
    <form action="dietrx.php" method="post">
        Desirable Body Weight (DBW): <input type="text" name="dbw"><br>
        Nutriture Status (%): <input type="number" step="any" name="ns_percent"><br>
        <label for="nutriture">Nutriture Interpretation</label>
        <select name="nutriture" id="nutriture">
            <option value="normal">normal</option>
            <option value="underweight">underweight</option>
            <option value="overweight">overweight</option>
            <option value="obese">obese</option>
            <option value="morbid_obese">morbid_obese</option>
        </select> <br>
        Basal Energy Expenditure (kcal): <input type="number" step="any" name="bee"><br>
        Energy Expenditure EEPA (kcal): <input type="number" step="any" name="eepa"><br>
        Thermic Effect of Food (kcal): <input type="number" step="any" name="tef"><br>
        <br>
        <b>Dietary Prescription (Round off to nearest 5)</b><br>
        Total Energy Requirement (kcal): <input type="number" name="ter"><br>
        <i>If TER has to be adjusted, adjust for a maximum of 1 pound (lb) gain/loss</i>
        <br>
        Carbohydrates (g): <input type="number" name="carbs"><br>
        Protein (g): <input type="number" name="protein"><br>
        Fat (g): <input type="number" name="fat"><br>
        <input type="hidden" name="height_cm" value="<?php echo $patientData['height_cm']; ?>">
        <input type="hidden" name="weight_kg" value="<?php echo $patientData['weight_kg']; ?>">
        <input type="hidden" name="sex" value="<?php echo $patientData['sex']; ?>">
        <input type="hidden" name="activity_level" value="<?php echo $patientData['activity_level']; ?>">
        
        <br>
        <input type="submit">
    </form>
</body>

</html>
