<?php include "includes/header.php" ?>

<?php if (isset($_POST['search'])) include "actions/fetch.php" ?>

<div class="container-fluid">
    <div class="row d-flex justify-content-center">
        <div class="col-6">
            <div class="card">
                <form action="" method="POST">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <input type="text" name="city" class="form-control" placeholder="City" value="<?php echo $_POST['city'] ?? '' ?>" />
                            </div>
                            <div class="col-5">
                                <select class="form-select" name="unit">
                                    <option value="">Select Option</option>
                                    <option value="°C" <?php echo isset($_POST['unit']) ? ($_POST['unit'] === "°C" ? 'selected' : '') : '' ?> >Celsius</option>
                                    <option value="°F" <?php echo isset($_POST['unit']) && $_POST['unit'] === "°F" ? 'selected' : '' ?> >Fahrenheit</option>
                                </select>
                            </div>
                            <div class="col-2">
                                <button type="submit" name="search" class="btn btn-outline-primary fw-bold">Search</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid mt-4">
    <div class="row">

        <?php if (isset($weatherData) && !empty($weatherData)){ ?>
            <div class="col-md-3">
                <div class="card bg-primary-subtle border border-3 border-black rounded-0">
                    <?php $e = empty($_POST['unit']) ? '°C' : $_POST['unit'] ?>
                    <div class="card-body p-2">
                        <div class="d-flex justify-content-between border-bottom border-3 border-black py-3">
                            <div class="m-0">
                                <h4 class="fw-bold fs-4 text-black"><i class="fa fa-city fs-5 me-2"></i><?php echo $weatherData['name'] ?></h4>
                                <div class="fw-semibold text-black fs-6"><?php echo $formattedDate = date('l, F j', strtotime(date('Y-m-d'))); ?></div>
                                <div class="fw-semibold text-black fs-4"><i class="fa fa-thermometer-half fs-5 me-2"></i><?php echo $weatherData['main']['temp'].$e ?></div>
                            </div>
                            <div class="m-0">
                                <?php $iconUrl = "http://openweathermap.org/img/w/" . $weatherData['weather'][0]['icon'] . ".png"; ?>
                                <img src="<?php echo $iconUrl; ?>" alt="Weather Icon" width="80" height="80">
                            </div>
                        </div>
                        <div class="border-bottom border-3 border-black py-3">
                            <i class="fa fa-water fs-5 me-2"></i>
                            <span class="fw-semibold fs-5 text-black">Condition : <?php echo ucwords($weatherData['weather'][0]['description']) ?></span>
                        </div>
                        <div class="border-bottom border-3 border-black py-3">
                            <i class="fa fa-water fs-5 me-2"></i>
                            <span class="fw-semibold fs-5 text-black">Humidity : <?php echo $weatherData['main']['humidity'].'%' ?></span>
                        </div>
                        <div class="border-bottom border-3 border-black py-3">
                            <i class="fa fa-tachometer-alt fs-5 me-2"></i>
                            <span class="fw-semibold fs-5 text-black">Pressure : <?php echo $weatherData['main']['pressure'].' hPa' ?></span>
                        </div>
                        <div class="border-bottom border-3 border-black py-3">
                            <i class="fa fa-wind fs-5 me-2"></i>
                            <span class="fw-semibold fs-5 text-black">Wind Speed : <?php echo $weatherData['wind']['speed'].' km/h' ?></span>
                        </div>
                        <div class="border-bottom border-3 border-black py-3">
                            <i class="fa fa-location-arrow fs-5 me-2"></i>
                            <span class="fw-semibold fs-5 text-black">Wind Direction : <?php echo $weatherData['wind']['deg'] ?></span>
                        </div>
                        <div class="py-3">
                            <i class="fa fa-eye fs-5 me-2"></i>
                            <span class="fw-semibold fs-5 text-black">Visibility : <?php echo $weatherData['visibility'].' m' ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="card bg-primary-subtle border border-3 border-black rounded-0">
                    <div class="card-header">
                        <h4 class="text-center fw-bold"><i class="fa fa-city fs-5 me-2"></i><?php echo $weatherData['name'] ?> 5 Day Weather Forecast</h4>
                    </div>
                </div>

                <div class="row mt-2">
                    <?php if (isset($forecastData)){ ?>
                        <div class="col d-flex justify-content-between gap-2">
                            <?php foreach ($forecastData as $date => $data): ?>
                                <?php list($dayOfWeek, $formattedDate) = getDayAndDate($date); ?>

                                <div class="card bg-primary-subtle border border-3 border-black rounded-0 mt-4 flex-fill">
                                    <div class="mb-0">
                                        <div class="text-center fw-bold fs-5"><?php echo $dayOfWeek; ?></div>
                                        <div class="text-center fw-semibold fs-6"><?php echo $formattedDate; ?></div>
                                    </div>

                                    <div class="p-2">
                                        <div class="border text-center border-3 border-black">
                                            <?php $iconUrl = "http://openweathermap.org/img/w/" . $data['weather'][0]['icon'] . ".png"; ?>
                                            <img src="<?php echo $iconUrl ?>" alt="Weather Icon" height="100" width="100">
                                            <div class="text-center fw-bold fs-6"><?php echo ucwords($data['weather'][0]['description']); ?></div>
                                        </div>
                                    </div>

                                    <div class="p-2">
                                        <div class="border border-3 border-black">
                                            <div class="text-center fw-bold fs-6">Highest Temperature</div>
                                            <div class="text-center fw-semibold fs-6"><?php echo $data['main']['temp_max'].$e ?></div>
                                        </div>
                                    </div>

                                    <div class="p-2">
                                        <div class="border border-3 border-black">
                                            <div class="text-center fw-bold fs-6">Lowest Temperature</div>

                                            <div class="text-center fw-semibold fs-6"><?php echo $data['main']['temp_min'].$e ?></div>
                                        </div>
                                    </div>

                                    <div class="p-2">
                                        <div class="border border-3 border-black">
                                            <div class="text-center fw-bold fs-6">Pressure</div>
                                            <div class="text-center fw-semibold fs-6"><?php echo $data['main']['pressure']; ?> hPa</div>
                                        </div>
                                    </div>
                                </div>

                            <?php endforeach; ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php }else{ ?>
            <div class="d-flex justify-content-center">
                <div class="fw-bold fs-5"><?php echo $error ?? '' ?></div>
            </div>
        <?php } ?>
    </div>
</div>

<?php include "includes/footer.php" ?>


