<?php

/* * * define constants ** */
define('SITE_TITLE', 'Real Pro Agent');
define('SITE_URL', 'realproagent.com');
define('TAG_LINE', 'Real Pro Agent');
define('MAIL_FROM', 'realproagent.com');
define('TITLE_FOR_PAGES', SITE_TITLE . " :: ");

define('HTTP_PATH', "http://realproagent.com/");
define("BASE_PATH", $_SERVER['DOCUMENT_ROOT'] . "");



define('CURR', 'EGP');

/* * ******************  users images ************************ */
define('UPLOAD_FULL_PROFILE_IMAGE_PATH', 'uploads/users');
define('DISPLAY_FULL_PROFILE_IMAGE_PATH', 'uploads/users/');
define('TEMP_PATH', 'uploads/temp');

define('UPLOAD_FULL_ATTACHMENT_IMAGE_PATH', 'uploads/task_attachment');
define('DISPLAY_FULL_ATTACHMENT_IMAGE_PATH', 'uploads/task_attachment/');


//Facebook Login
//define('APP_ID','660708920737424');
//define('APP_SECRET','d25b2608a36c76f5ea808ff946102fcf');
//Google Login
//define('CLIENT_ID','340656858254-vrc1lvkmdggv25qrnhltk3cgbi4i8b75.apps.googleusercontent.com');
//define('CLIENT_SECRET','SBhYvabPn-F7HEelQrNBzCSR');
//define('REDIRECT_URI',HTTP_PATH.'user/login?google');
//define('APPROVAL_PROMPT', 'auto');
//define('ACCESS_TYPE', 'offline');
//define('IP_KEY', '7edef70969777e53513a5dea32b2cfbc7244a0a5801d68d05debf6ae56a338f2');



global $countrylist;
$countrylist = array(
    '' => 'Select Country',
    'AF' => 'Afghanistan',
    'AL' => 'Albania',
    'DZ' => 'Algeria',
    'AS' => 'American Samoa',
    'AD' => 'Andorra',
    'AO' => 'Angola',
    'AI' => 'Anguilla',
    'AQ' => 'Antarctica',
    'AG' => 'Antigua And Barbuda',
    'AR' => 'Argentina',
    'AM' => 'Armenia',
    'AW' => 'Aruba',
    'AU' => 'Australia',
    'AT' => 'Austria',
    'AZ' => 'Azerbaijan',
    'BS' => 'Bahamas',
    'BH' => 'Bahrain',
    'BD' => 'Bangladesh',
    'BB' => 'Barbados',
    'BY' => 'Belarus',
    'BE' => 'Belgium',
    'BZ' => 'Belize',
    'BJ' => 'Benin',
    'BM' => 'Bermuda',
    'BT' => 'Bhutan',
    'BO' => 'Bolivia',
    'BA' => 'Bosnia And Herzegovina',
    'BW' => 'Botswana',
    'BV' => 'Bouvet Island',
    'BR' => 'Brazil',
    'IO' => 'British Indian Ocean Territory',
    'BN' => 'Brunei',
    'BG' => 'Bulgaria',
    'BF' => 'Burkina Faso',
    'BI' => 'Burundi',
    'KH' => 'Cambodia',
    'CM' => 'Cameroon',
    'CA' => 'Canada',
    'CV' => 'Cape Verde',
    'KY' => 'Cayman Islands',
    'CF' => 'Central African Republic',
    'TD' => 'Chad',
    'CL' => 'Chile',
    'CN' => 'China',
    'CX' => 'Christmas Island',
    'CC' => 'Cocos (Keeling) Islands',
    'CO' => 'Columbia',
    'KM' => 'Comoros',
    'CG' => 'Congo',
    'CK' => 'Cook Islands',
    'CR' => 'Costa Rica',
    'CI' => 'Cote D\'Ivorie (Ivory Coast)',
    'HR' => 'Croatia (Hrvatska)',
    'CU' => 'Cuba',
    'CY' => 'Cyprus',
    'CZ' => 'Czech Republic',
    'CD' => 'Democratic Republic Of Congo (Zaire)',
    'DK' => 'Denmark',
    'DJ' => 'Djibouti',
    'DM' => 'Dominica',
    'DO' => 'Dominican Republic',
    'TP' => 'East Timor',
    'EC' => 'Ecuador',
    'EG' => 'Egypt',
    'SV' => 'El Salvador',
    'GQ' => 'Equatorial Guinea',
    'ER' => 'Eritrea',
    'EE' => 'Estonia',
    'ET' => 'Ethiopia',
    'FK' => 'Falkland Islands (Malvinas)',
    'FO' => 'Faroe Islands',
    'FJ' => 'Fiji',
    'FI' => 'Finland',
    'FR' => 'France',
    'FX' => 'France, Metropolitan',
    'GF' => 'French Guinea',
    'PF' => 'French Polynesia',
    'TF' => 'French Southern Territories',
    'GA' => 'Gabon',
    'GM' => 'Gambia',
    'GE' => 'Georgia',
    'DE' => 'Germany',
    'GH' => 'Ghana',
    'GI' => 'Gibraltar',
    'GR' => 'Greece',
    'GL' => 'Greenland',
    'GD' => 'Grenada',
    'GP' => 'Guadeloupe',
    'GU' => 'Guam',
    'GT' => 'Guatemala',
    'GN' => 'Guinea',
    'GW' => 'Guinea-Bissau',
    'GY' => 'Guyana',
    'HT' => 'Haiti',
    'HM' => 'Heard And McDonald Islands',
    'HN' => 'Honduras',
    'HK' => 'Hong Kong',
    'HU' => 'Hungary',
    'IS' => 'Iceland',
    'IN' => 'India',
    'ID' => 'Indonesia',
    'IR' => 'Iran',
    'IQ' => 'Iraq',
    'IE' => 'Ireland',
    'IL' => 'Israel',
    'IT' => 'Italy',
    'JM' => 'Jamaica',
    'JP' => 'Japan',
    'JO' => 'Jordan',
    'KZ' => 'Kazakhstan',
    'KE' => 'Kenya',
    'KI' => 'Kiribati',
    'KW' => 'Kuwait',
    'KG' => 'Kyrgyzstan',
    'LA' => 'Laos',
    'LV' => 'Latvia',
    'LB' => 'Lebanon',
    'LS' => 'Lesotho',
    'LR' => 'Liberia',
    'LY' => 'Libya',
    'LI' => 'Liechtenstein',
    'LT' => 'Lithuania',
    'LU' => 'Luxembourg',
    'MO' => 'Macau',
    'MK' => 'Macedonia',
    'MG' => 'Madagascar',
    'MW' => 'Malawi',
    'MY' => 'Malaysia',
    'MV' => 'Maldives',
    'ML' => 'Mali',
    'MT' => 'Malta',
    'MH' => 'Marshall Islands',
    'MQ' => 'Martinique',
    'MR' => 'Mauritania',
    'MU' => 'Mauritius',
    'YT' => 'Mayotte',
    'MX' => 'Mexico',
    'FM' => 'Micronesia',
    'MD' => 'Moldova',
    'MC' => 'Monaco',
    'MN' => 'Mongolia',
    'MS' => 'Montserrat',
    'MA' => 'Morocco',
    'MZ' => 'Mozambique',
    'MM' => 'Myanmar (Burma)',
    'NA' => 'Namibia',
    'NR' => 'Nauru',
    'NP' => 'Nepal',
    'NL' => 'Netherlands',
    'AN' => 'Netherlands Antilles',
    'NC' => 'New Caledonia',
    'NZ' => 'New Zealand',
    'NI' => 'Nicaragua',
    'NE' => 'Niger',
    'NG' => 'Nigeria',
    'NU' => 'Niue',
    'NF' => 'Norfolk Island',
    'KP' => 'North Korea',
    'MP' => 'Northern Mariana Islands',
    'NO' => 'Norway',
    'OM' => 'Oman',
    'PK' => 'Pakistan',
    'PW' => 'Palau',
    'PA' => 'Panama',
    'PG' => 'Papua New Guinea',
    'PY' => 'Paraguay',
    'PE' => 'Peru',
    'PH' => 'Philippines',
    'PN' => 'Pitcairn',
    'PL' => 'Poland',
    'PT' => 'Portugal',
    'PR' => 'Puerto Rico',
    'QA' => 'Qatar',
    'RE' => 'Reunion',
    'RO' => 'Romania',
    'RU' => 'Russia',
    'RW' => 'Rwanda',
    'SH' => 'Saint Helena',
    'KN' => 'Saint Kitts And Nevis',
    'LC' => 'Saint Lucia',
    'PM' => 'Saint Pierre And Miquelon',
    'VC' => 'Saint Vincent And The Grenadines',
    'SM' => 'San Marino',
    'ST' => 'Sao Tome And Principe',
    'SA' => 'Saudi Arabia',
    'SN' => 'Senegal',
    'SC' => 'Seychelles',
    'SL' => 'Sierra Leone',
    'SG' => 'Singapore',
    'SK' => 'Slovak Republic',
    'SI' => 'Slovenia',
    'SB' => 'Solomon Islands',
    'SO' => 'Somalia',
    'ZA' => 'South Africa',
    'GS' => 'South Georgia And South Sandwich Islands',
    'KR' => 'South Korea',
    'ES' => 'Spain',
    'LK' => 'Sri Lanka',
    'SD' => 'Sudan',
    'SR' => 'Suriname',
    'SJ' => 'Svalbard And Jan Mayen',
    'SZ' => 'Swaziland',
    'SE' => 'Sweden',
    'CH' => 'Switzerland',
    'SY' => 'Syria',
    'TW' => 'Taiwan',
    'TJ' => 'Tajikistan',
    'TZ' => 'Tanzania',
    'TH' => 'Thailand',
    'TG' => 'Togo',
    'TK' => 'Tokelau',
    'TO' => 'Tonga',
    'TT' => 'Trinidad And Tobago',
    'TN' => 'Tunisia',
    'TR' => 'Turkey',
    'TM' => 'Turkmenistan',
    'TC' => 'Turks And Caicos Islands',
    'TV' => 'Tuvalu',
    'UG' => 'Uganda',
    'UA' => 'Ukraine',
    'AE' => 'United Arab Emirates',
    'UK' => 'United Kingdom',
    'US' => 'United States',
    'UM' => 'United States Minor Outlying Islands',
    'UY' => 'Uruguay',
    'UZ' => 'Uzbekistan',
    'VU' => 'Vanuatu',
    'VA' => 'Vatican City (Holy See)',
    'VE' => 'Venezuela',
    'VN' => 'Vietnam',
    'VG' => 'Virgin Islands (British)',
    'VI' => 'Virgin Islands (US)',
    'WF' => 'Wallis And Futuna Islands',
    'EH' => 'Western Sahara',
    'WS' => 'Western Samoa',
    'YE' => 'Yemen',
    'YU' => 'Yugoslavia',
    'ZM' => 'Zambia',
    'ZW' => 'Zimbabwe'
);
global $array_ser_category;
$array_ser_category = array(
    'For Sale' => 'For Sale',
    'Auction' => 'Auction',
    'Make me an offer' => 'Make me an offer',
    'Homes Wanted' => 'Homes Wanted',
);


global $userTypeArray;
$userTypeArray = array(
    '0' => 'Agent',
    '1' => 'Lender',
    '2' => 'Title',
    '3' => 'Client',
);

global $transactionTypeArray;
$transactionTypeArray = array(
    '0' => 'Buyer Transaction',
    '1' => 'Seller Transaction',
);


global $arrayType;
$arrayType = array(
'1' => "Email",
'2' => "SMS",
);

define('SMS_ACCOUNT_SID', 'AC11700e92246afa32ba8915858cd7730d');
define('SMS_AUTH_TOKEN', 'dd8aa18138546f22d45426252652340b');



global $additionalField;
$additionalField = array(
    '0' => 'Year Built',
    '1' => 'Lockbox Type',
    '2' => 'Transaction ID',
    '3' => 'EMD Deposit',
    '4' => 'Type of Loan',
    '5' => 'HOA/Condo/NA',
    '6' => 'Source',
    '7' => 'Total Commission',
);


/*global $additionalField;    
$additionalField = array(
    '0' => 'MLS #',
    '1' => 'Escrow #',
    '2' => 'Bedrooms',
    '3' => 'Bathrooms',
    '4' => 'Property Type',
    '5' => 'Representing',
    '6' => 'Source',
    '7' => 'Total Commission',
);*/

//define('PAYPAL_EMAIL', 'dinesh_1346821651_biz@logicspice.com');
//define('PAYPAL_URL', 'https://www.sandbox.paypal.com/cgi-bin/webscr');
