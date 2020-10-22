<?php

use App\Controllers\AppController;
use App\Services\SchedulingService;

class AppControllerTest extends \PHPUnit\Framework\TestCase
{
    public function testHandle()
    {
        $json = '
            {
              "search": {
                "startDate": "2018-06-04",
                "endDate": "2018-06-06"
              },
              "campsites": [
                {
                  "id": 1,
                  "name": "Cozy Cabin"
                },
                {
                  "id": 2,
                  "name": "Comfy Cabin"
                },
                {
                  "id": 3,
                  "name": "Rustic Cabin"
                },
                {
                  "id": 4,
                  "name": "Rickety Cabin"
                },
                {
                  "id": 5,
                  "name": "Cabin in the Woods"
                }
              ],
              "reservations": [
                {"campsiteId": 1, "startDate": "2018-06-01", "endDate": "2018-06-03"},
                {"campsiteId": 1, "startDate": "2018-06-08", "endDate": "2018-06-10"},
                {"campsiteId": 2, "startDate": "2018-06-01", "endDate": "2018-06-01"},
                {"campsiteId": 2, "startDate": "2018-06-02", "endDate": "2018-06-03"},
                {"campsiteId": 2, "startDate": "2018-06-07", "endDate": "2018-06-09"},
                {"campsiteId": 3, "startDate": "2018-06-01", "endDate": "2018-06-02"},
                {"campsiteId": 3, "startDate": "2018-06-08", "endDate": "2018-06-09"},
                {"campsiteId": 4, "startDate": "2018-06-07", "endDate": "2018-06-10"}
              ]
            }
        ';

        $json_data = json_decode($json);
        $app_controller = new AppController(new SchedulingService());

        $this->expectOutputString('"Comfy Cabin"\n"Rickety Cabin"\n"Cabin in the Woods"\n');

        $app_controller->handle($json_data);
    }
}