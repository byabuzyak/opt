<?php

use App\App;
use App\Infrastructure\Exception\ApplicationException;
use App\Infrastructure\Routing\Exception\HttpNotFoundException;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

(function () {
    $app = new App();

    try {
        $app->run();
    } catch (HttpNotFoundException $ex) {
        header("Status: 404 Not Found");

        echo $ex->getMessage();
    } catch (ApplicationException $ex) {
        header("Status: 400 Bad request");

        echo "oops..", $ex->getMessage();
    } catch (\Exception $ex) {
        header("Status: 500 Server error");

        echo $ex->getMessage();
    }
})();