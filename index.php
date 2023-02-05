<?php

require_once __DIR__ . '/vendor/autoload.php';

use Phpml\Regression\LeastSquares;

$experience = $_POST['experience'];
$test_score = $_POST['test_score'];
$interview_score = $_POST['interview_score'];
$salary = "";

if (isset($experience) && isset($test_score) && isset($interview_score)) {

    //Prepare sample age data
    $samples = [];
    $targets = [];

    $salary_data = json_decode(file_get_contents('salary.json'));

    foreach ($salary_data as $salary) {

        $samples[] = [$salary->experience, $salary->test_score_10, $salary->interview_score_10];
        $targets[] = $salary->salary;

    }

    $regression = new LeastSquares();
    $regression->train($samples, $targets);
    $salary = $regression->predict([$experience, $test_score, $interview_score]);
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Salary Prediction</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>

    <div class="container">
        <div class="row" style="margin-top: 20%">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <center><h4>Programmer Salary Prediction</h4></center>
                    </div>
                    <div class="panel-body">
                        <form action="" method="post">
                            <div class="form-group">
                                <label>Experience</label>
                                <input type="number" class="form-control" id="experience"
                                    value="<?php echo $experience; ?>" placeholder="Enter years of experience"
                                    name="experience">
                            </div>
                            <div class="form-group">
                                <label>Test Score</label>
                                <input type="text" class="form-control" max="10" id="test_score"
                                    value="<?php echo $test_score; ?>" placeholder="Enter test score out of 10"
                                    name="test_score">
                            </div>
                            <div class="form-group">
                                <label>Interview Score</label>
                                <input type="text" class="form-control" max="10" id="interview_score"
                                    value="<?php echo $interview_score; ?>"
                                    placeholder="Enter interview score out of 10" name="interview_score">
                            </div>
                            <div class="form-group">
                                <?php if (!empty($salary)) { ?>
                                    <div class="well well-sm">
                                        Suggested salary for the candidate is 
                                        <b>
                                            <?php echo (int)$salary; ?> BDT
                                        </b>
                                    </div>
                                <?php } ?>
                                <button type="submit" class="btn btn-success form-control">Suggest Salary</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>