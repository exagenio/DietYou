<!DOCTYPE html>
<html>

<head>
    <title>Calorie Progress Card</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .progress-card {
            width: 300px;
            margin: 0 auto;
        }

        .progress {
            width: 100%;
            height: 20px;
            background-color: #f2f2f2;
            border-radius: 5px;
        }

        .progress-bar {
            height: 100%;
            background-color: #EA8E17;
            opacity: 60%;
            color: white;
            text-align: center;
            border-radius: 5px;
            transition: width 0.5s ease-in-out;
        }

        #progressPercentage{
            font-size: 40px;
            font-weight: 900;
            color: #EA8E17;
            opacity: 80%;
        }
        .kcalValue{
            color: grey;
            font-size: 20px;
            margin-top: 18px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="progress-card">
            <div class="progress">
                <div id="progressBar" class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div class="d-flex justify-content-between mt-3">
                <span class="kcalValue"><span id="currentCalories">0</span>/<span id="totalCalories">0</span> Kcal</span>
                <span id="progressPercentage">0%</span>
            </div>
        </div>
    </div>
    <script>
        // Set total calories and current calories
        const totalCalories = 2000;
        let currentCalories = 0;

        // updateProgressBar();

        // Function to update progress bar
        function updateProgressBar() {
            const progressBar = document.getElementById('progressBar');
            const progressPercentage = document.getElementById('progressPercentage');
            const totalCaloriesElement = document.getElementById('totalCalories');
            const currentCaloriesElement = document.getElementById('currentCalories');

            const progress = (currentCalories / totalCalories) * 100;
            progressBar.style.width = progress + '%';
            progressBar.setAttribute('aria-valuenow', progress);
            progressPercentage.textContent = progress.toFixed(1) + '%';
            totalCaloriesElement.textContent = totalCalories;
            currentCaloriesElement.textContent = currentCalories;
        }

        // Simulate progress by incrementing current calories
        const interval = setInterval(function() {
            currentCalories += 100;
            if (currentCalories > totalCalories) {
                clearInterval(interval);
            } else {
                updateProgressBar();
            }
        }, 1000);
    </script>
</body>

</html>