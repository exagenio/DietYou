<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DietYou</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.21.3/bootstrap-table.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <table id="table" data-toggle="table" data-search="true" data-search-highlight="true" data-pagination="true">
                    <thead>
                        <tr>
                            <th data-field="id" rowspan="2"></th>
                            <th colspan="3" class="center-header">Meals</th>
                            <th colspan="3" class="center-header">Snacks</th>
                        </tr>
                        <tr>
                            <th data-field="meal1">Meal 1</th>
                            <th data-field="meal2">Meal 2</th>
                            <th data-field="meal3">Meal 3</th>
                            <th data-field="snack1">Snack 1</th>
                            <th data-field="snack2">Snack 2</th>
                            <th data-field="snack3">Snack 3</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="checkbox"></td>
                            <td>Meal option 1</td>
                            <td>Meal option 2</td>
                            <td>Meal option 3</td>
                            <td>Snack option 1</td>
                            <td>Snack option 2</td>
                            <td>Snack option 3</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.3/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.21.3/bootstrap-table.min.js"></script>
</body>

</html>