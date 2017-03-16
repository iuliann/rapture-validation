<?php
// @codeCoverageIgnoreStart

// Update Countries

$names  = json_decode(file_get_contents('http://country.io/names.json'), true);    // iso2=>name
$iso3   = json_decode(file_get_contents('http://country.io/iso3.json'), true);     // iso2=>iso3
$curr   = json_decode(file_get_contents('http://country.io/currency.json'), true); // iso2=>currency

$countries = [
    'name'  =>  [],
    'iso2'  =>  [],
    'iso3'  =>  [],
    'curr'  =>  [],
];
foreach ($names as $iso2 => $name) {
    $countries['name'][$name] = $iso2;
    $countries['iso2'][strtolower($iso2)] = $iso2;
    $countries['iso3'][strtolower($iso3[$iso2])] = $iso2;
    $countries['curr'][strtolower($curr[$iso2])] = $iso2;
}
file_put_contents('countries.json', json_encode($countries));

// Update disposable email list
// Make sure you have OpenSSL extension enabled!

$urls = [
    'https://gist.githubusercontent.com/adamloving/4401361/raw/db901ef28d20af8aa91bf5082f5197d27926dea4/temporary-email-address-domains',
    'https://gist.githubusercontent.com/michenriksen/8710649/raw/e09ee253960ec1ff0add4f92b62616ebbe24ab87/disposable-email-provider-domains',
    'https://raw.githubusercontent.com/martenson/disposable-email-domains/master/disposable_email_blacklist.conf'
];
$string = '';
foreach ($urls as $url) {
    $string .= trim(file_get_contents($url)) . "\n";
}
$array = array_unique(array_filter(explode("\n", $string)));
sort($array);

file_put_contents('email_disposable.json', json_encode($array));
// @codeCoverageIgnoreEnd
