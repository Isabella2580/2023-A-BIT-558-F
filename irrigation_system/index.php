<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solar Powered Irrigation System</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function fetchSensorData() {
            $.ajax({
                url: 'get_sensor_data.php',
                method: 'GET',
                success: function(data) {
                    var sensor = JSON.parse(data);
                    $('#soil_moisture').text(sensor.soil_moisture + '%');
                    $('#temperature').text(sensor.temperature + '°C');
                    $('#sunlight').text(sensor.sunlight + ' lux');
                    $('#solar_power').text(sensor.solar_power + ' W');
                    checkIrrigationNeed(sensor.soil_moisture);
                }
            });
        }

        function checkIrrigationNeed(soil_moisture) {
            var threshold = $('#irrigation_threshold').val();
            if (soil_moisture < threshold) {
                $('#irrigation_status').text('Irrigation Needed');
                $('#irrigation_button').prop('disabled', false);
            } else {
                $('#irrigation_status').text('Sufficient Moisture');
                $('#irrigation_button').prop('disabled', true);
            }
        }

        $(document).ready(function() {
            fetchSensorData();
            setInterval(fetchSensorData, 5000); // Refresh every 5 seconds
            
            $('#irrigation_button').click(function() {
                $.ajax({
                    url: 'update_system_settings.php',
                    method: 'POST',
                    data: {
                        threshold: $('#irrigation_threshold').val(),
                        status: 1 // Activate irrigation
                    },
                    success: function(response) {
                        alert(response);
                    }
                });
            });
        });
    </script>
</head>
<body>
    <div class="container mt-5">
        <h2>Solar Powered Irrigation System Dashboard</h2>

        <!-- Sensor Data -->
        <div class="row mt-4">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Soil Moisture</h5>
                        <p id="soil_moisture">Loading...</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Temperature</h5>
                        <p id="temperature">Loading...</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Sunlight Intensity</h5>
                        <p id="sunlight">Loading...</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Solar Power</h5>
                        <p id="solar_power">Loading...</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Irrigation Control -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Irrigation Control</h5>
                        <p id="irrigation_status">Loading...</p>
                        <input type="number" class="form-control" id="irrigation_threshold" value="30" min="0" max="100">
                        <button class="btn btn-primary mt-3" id="irrigation_button" disabled>Activate Irrigation</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</body>
</html>
