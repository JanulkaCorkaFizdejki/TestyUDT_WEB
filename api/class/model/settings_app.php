<?php

    class TestsList {

        private const TESTS = [
            // (1)
            "podesty_ruchome_przejezdne"    => array (
                "test-name"                 => "Podesty ruchome przejezdne",
                "test-description"          => "Podesty ruchome to dźwignice zaliczane do grupy maszyn budowlanych, służące do przemieszczania osób i materiałów na określone stanowisko pracy, zarówno w pionie, jak i poziomie.",
                "questions-limit"           => 15,
                "answers-limit"             => 4,
                "part-1"                    => [1, 75, 5],
                "part-2"                    => [76, 178, 5],
                "part-3"                    => [179, 239, 5],
                "threshold"                 => 11,
                "time"                      => 1800
            ),
            // (2)
            "wozki_widlowe_1"    => array (
                "test-name"                 => "Wózki jezdniowe I",
                "test-description"          => "Wózki jezdniowe podnośnikowe z mechanicznym napędem podnoszenia z wysięgnikiem oraz wózki jezdniowe podnośnikowe z mechanicznym napędem podnoszenia z osobą obsługującą podnoszoną.",
                "questions-limit"           => 15,
                "answers-limit"             => 4,
                "part-1"                    => [1, 72, 5],
                "part-2"                    => [73, 217, 5],
                "part-3"                    => [218, 276, 5],
                "threshold"                 => 11,
                "time"                      => 1800
            ),
            // (3)
            "wozki_widlowe_2"    => array (
                "test-name"                 => "Wózki jezdniowe II",
                "test-description"          => "Wózki jezdniowe podnośnikowe z mechanicznym napędem podnoszenia z wyłączeniem wózków z wysięgnikiem oraz wózków z osobą obsługującą podnoszoną wraz z ładunkiem.",
                "questions-limit"           => 15,
                "answers-limit"             => 4,
                "part-1"                    => [1, 73, 5],
                "part-2"                    => [74, 207, 5],
                "part-3"                    => [208, 245, 5],
                "threshold"                 => 11,
                "time"                      => 1800
            ),
            //(4)
            "zurawie"    => array (
                "test-name"                 => "Żurawie",
                "test-description"          => "Żurawie, przewoźne, przenośne i stacjonarne.",
                "questions-limit"           => 15,
                "answers-limit"             => 4,
                "part-1"                    => [1, 79, 5],
                "part-2"                    => [80, 255, 5],
                "part-3"                    => [256, 325, 5],
                "threshold"                 => 11,
                "time"                      => 1800
            ),
           // (5)
            "suwnice"    => array (
                "test-name"                 => "Suwnice",
                "test-description"          => "Suwnice, wciągniki i wciągarki ogólnego przeznaczenia.",
                "questions-limit"           => 15,
                "answers-limit"             => 4,
                "part-1"                    => [1, 73, 5],
                "part-2"                    => [74, 239, 5],
                "part-3"                    => [240, 261, 5],
                "threshold"                 => 11,
                "time"                      => 1800
            ),

         // (6)
            "dzwig_towarowo_osobowy"  => array (
                    "test-name"                 => "Dźwig towarowo-osobowy",
                    "test-description"          => "Dźwigi towarowo-osobowe ze sterowaniem wewnętrznym i szpitalne",
                    "questions-limit"           => 15,
                    "answers-limit"             => 4,
                    "part-1"                    => [1, 68, 5],
                    "part-2"                    => [69, 91, 5],
                    "part-3"                    => [92, 123, 5],
                    "threshold"                 => 11,
                    "time"                      => 1800
                )

        ];

        public function getTests () { return $this::TESTS; }
    }


    class DatabaseSettings {

        private const DB_NAME     = "qwerty_udt";
        private const DB_USER     = "qwerty_admin";
        private const DB_HOST     = "localhost";
        //private const DB_HOST     = "s8.linuxpl.com";
        private const DB_PASSWORD = "DG1{K2$@12co1^@";
        private const DB_PORT     = "3306";

        public function getDBName     () { return $this::DB_NAME; }
        public function getDBUser     () { return $this::DB_USER; } 
        public function getDBHost     () { return $this::DB_HOST; }
        public function getDBPassword () { return $this::DB_PASSWORD; } 
        public function getDBPort     () { return $this::DB_PORT; } 
    }

    class GlobalSettings {
        private const API_MAIN_URL                          = "http://api.testyudt.com/";
        private const API_KEY_VALUE                         = "cdad5e6b5ab66cd4e10b6ace30fee27c";
        private const API_KEY_NAME                          = "api_key";
        private const API_TEST_NAME                         = "api_test_name";
        private const API_TEST_NAME_ALL                     = "api_test_name_all";
        private const API_TESTS_LIST                        = "api_tests_list";
        private const API_GET_MAC_ADDRESS                   = "api_get_mac_address";

        private const API_GET_DESKTOP_APP_PRICE             = "desktop-app-price";
        private const API_DESKTOP_APP_PRICE_VALUE           = 899; // The provided amount should be given in the smallest unit of payment currency (grosz in case of PLN)
        private const API_DESKTOP_APP_PRICE_CURRENCY        = "PLN";

        private const API_GET_PAYNOW_EXTERNALID             = "api_get_paynow_externalid";

        public function getApiKeyValue              () { return $this::API_KEY_VALUE; }
        public function getApiKeyName               () { return $this::API_KEY_NAME; }
        public function getApiTestName              () { return $this::API_TEST_NAME; }
        public function getApiTestNameAll           () { return $this::API_TEST_NAME_ALL; }
        public function getApiTestsList             () { return $this::API_TESTS_LIST; }
        public function getApiMainURL               () { return $this::API_MAIN_URL; }  
        public function getApiGetMacAddress         () { return $this::API_GET_MAC_ADDRESS; }
        public function getDesktopPrice             () { return $this::API_GET_DESKTOP_APP_PRICE; }
        public function getDesktopPriceValue        () { return $this::API_DESKTOP_APP_PRICE_VALUE; } 
        public function getDesktopPriceCurrency     () { return $this::API_DESKTOP_APP_PRICE_CURRENCY; } 
        public function getApiPaynowExternalID      () { return $this::API_GET_PAYNOW_EXTERNALID; } 
    }
?>
