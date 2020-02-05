<?php
    class WeatherMonitor {
        protected $service;

        public function __construct(TemperatureService $service) {
            $this->service = $service;
        }

        public function getAverageTemperature(string $start, string $end) {
            $start_temp = $this->service->getTemperature($start);
            $end_temp = $this->service->getTemperature($end);
            return ($start_temp + $end_temp) / 2;
        }
        
    }
?>