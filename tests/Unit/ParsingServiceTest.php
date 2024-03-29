<?php

namespace Tests\Unit;

use App\Http\Services\ParsingService;
use Carbon\Exceptions\UnitException;
use Tests\TestCase;

class ParsingServiceTest extends TestCase
{
    const URL_CORRECT = 'https://standards-oui.ieee.org/';
    const URL_INCORRECT = 'standards-oui.ieee.org';
    const GOOGLE_CORRECT = "http://www,google.com";
    const GOOGLE_INCORRECT = "http://gogle.ua";

    private function text(): string
    {
        /**
         * test string $textContainer
         */
        $textContainer = '
        OUI/MA-L                                                    Organization
company_id                                                  Organization
                                                            Address

00-22-72   (hex)		American Micro-Fuel Device Corp.
002272     (base 16)		American Micro-Fuel Device Corp.
				2181 Buchanan Loop
				Ferndale  WA  98248
				US

00-D0-EF   (hex)		IGT
00D0EF     (base 16)		IGT
				9295 PROTOTYPE DRIVE
				RENO  NV  89511
        ';


        return $textContainer;
    }

    /**
     * test array textArray
     */
    private function textArray(): array
    {
        $textArray = ['
        00-22-72   (hex)	\r\n	American Micro-Fuel Device Corp.
        002272     (base 16)	\r\n	American Micro-Fuel Device Corp.
        	        \r\n \r\n   2181 Buchanan Loop\r\n
				     \r\n   Ferndale  WA  98248\r\n
				       \r\n US\r\n
        '];

        return $textArray;
    }

    /**
     * test get incorrect data for curl
     * set URL_INCORRECT data in getDataForCurl
     * @return void
     */
    public function test_get_data_for_curl_incorrect(): void
    {
        $parsingService = new ParsingService();

        try {
            $parsingService->getDataForCurl(self::URL_INCORRECT, self::GOOGLE_INCORRECT);
            $this->assertTrue(true);
        } catch (UnitException $exception) {
            $this->assertFalse(false);
        }
    }

    /**
     * test get correct data for curl
     * set URL_CORRECT data in getDataForCurl
     * @return void
     */
    public function test_get_data_for_curl_correct(): void
    {
        $parsingService = new ParsingService();

        try {
            $parsingService->getDataForCurl(self::URL_CORRECT, self::GOOGLE_CORRECT);
            $this->assertTrue(true);
        } catch (UnitException $exception) {
            $this->assertFalse(false);
        }
    }

    /**
     * test preg_match_all incorrect
     * set URL_INCORRECT data in pregMatchAll
     * @return void
     */
    public function test_preg_match_all_incorrect(): void
    {
        $parsingService = new ParsingService();

        try {
            $parsingService->pregMatchAll(self::URL_INCORRECT);
            $this->assertTrue(true);
        } catch (UnitException $exception) {
            $this->assertFalse(false);
        }
    }

    /**
     * test preg_match_all correct
     * set URL_CORRECT data in pregMatchAll
     * @return void
     */
    public function test_preg_match_all_correct(): void
    {
        $parsingService = new ParsingService();

        try {
            $parsingService->pregMatchAll($this->text());
            $this->assertTrue(true);
        } catch (UnitException $exception) {
            $this->assertFalse(false);
        }
    }

    /**
     * test get_format incorrect
     * set GOOGLE_INCORRECT data in getFormat
     * @return void
     */
    public function test_get_format_incorrect(): void
    {
        $parsingService = new ParsingService();

        try {
            $parsingService->getFormat([]);
            $this->assertTrue(true);
        } catch (UnitException $exception) {
            $this->assertFalse(false);
        }
    }
}
