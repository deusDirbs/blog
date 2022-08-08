<?php

namespace App\Http\Services;


class ParsingService
{
    private const GOOGLE = "http://www,google.com";

    /**
     * create cross domain request
     *
     * @param $url
     * @param $referer
     * @return string
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
     * Use function pregMatchAll on the curl data
     *
     * @param string $data
     * @return array
     */
    public function pregMatchAll(string $data): array
    {
        preg_match_all('/([A-F0-9]{2})-([A-F0-9]{2})-([A-F0-9]{2})\s+\(\w+\)\s+(.+)\s+([A-Z0-9]{6})\s+\(.+\)\s+(.+){3}(.+\s+){3}\w{2}/', $data, $matches);

        return $matches;
    }

    /**
     * set in array $out data with $pregMatchAll after process
     *
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
     * use split function on the arrays $match
     *
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
     * return array process $result for MacAddress
     *
     * @param string $string MacAddress
     * @return array
     */
    public function splitMacAddress(string $string): array
    {
        $result = preg_replace("/\(|\)/", '', preg_split("/(\s+){2}/", $string));

        return $result;
    }
}
