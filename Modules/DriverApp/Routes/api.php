<?php

Route::prefix('drivers')->group(function () {

    foreach (["auth.php", "orders.php"] as $value) {
        require(module_path('DriverApp', 'Routes/Api/' . $value));
    }

});
