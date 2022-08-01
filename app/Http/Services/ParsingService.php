<?php

namespace App\Http\Services;


use GuzzleHttp\Client;

class ParsingService
{
    private const GOOGLE = "http://www,google.com";

    /**
     * @param $url
     * @param $referer
     * @return bool|string
     */
    public function getDataForCurl($url, $referer = self::GOOGLE): string
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.3; W…) Gecko/20100101 Firefox/57.0");
        curl_setopt($ch, CURLOPT_REFERER, $referer);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }

    /**
     * @param string $getCurl
     * @return array
     */
    public function pregMatchAll(string $getCurl): array
    {
        preg_match_all('/([A-F0-9]{2})-([A-F0-9]{2})-([A-F0-9]{2})\s+\(\w+\)\s+(.+)\s+([A-Z0-9]{6})\s+\(.+\)\s+(.+){3}(.+\s+){3}\w{2}/', $getCurl, $matches);

        return $matches;
    }

    /**
     * @param array $pregMatchAll
     * @return array
     */
    public function getFormat(array $pregMatchAll): array
    {
        $out = [];
        foreach ($pregMatchAll as $match) {
            $out = $this->splitData($match, $out);
        }

        return $out;
    }

    /**
     * @param array $match
     * @param $out
     * @return array
     */
    private function splitData(array $match, $out): array
    {
        foreach ($match as $items) {
            $values = preg_split("/\t+|\r\n/", $items);
            $values = array_unique($values, SORT_NATURAL);
            $values = array_values(array_diff($values, array('')));
            $out[] = $values;
        }

        return $out;
    }

    /**
     * @param string $string
     * @return array|string|string[]|null
     */
    public function splitMacAddress(string $string)
    {
        $result = preg_replace("/\(|\)/", '', preg_split("/(\s+){2}/", $string));

        return $result;
    }
}
