<?php
session_start();
ob_start();
include('configuration.php');

$layer = new Layer();
$display = new Display();
$ClassPDO = new PDO_Connection();
$pdo = $ClassPDO->GetConnection();
$query = $pdo->prepare('SELECT * FROM settings');
$query->execute();
$file_name = $layer->file_name();
$settings = $query->fetch();
$currency = $settings['CurrencySymbol'];
$currency_name = $settings['Currency'];

class PDO_Connection {
    private $pdo;
    private $config = [
        'hostname' => hostname,
        'username' => username,
        'password' => password,
        'database' => database
    ];

    public function __construct() {
        $this->SetConnection();
    }

    private function SetConnection() {
        try {
            $this->pdo = new PDO("mysql:host={$this->config['hostname']};dbname={$this->config['database']}", $this->config['username'], $this->config['password']);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->exec('SET CHARACTER SET utf8mb4');
        } catch (PDOException $ex) {
            die('MySQL connection error: ' . $ex->getMessage());
        }
    }

    public function GetConnection() {
        return $this->pdo ?? false;
    }
}

class Layer {
    private $encryption_key = '91f$0!a6@15359@e86109d$8d!bb@450c$7b1!';
    public $text_limit = 100;

    public function dump($message, $debug = true) {
        if ($debug) {
            echo "<pre>" . print_r($message, true) . "</pre>";
            exit();
        }
    }

    public function add($file_name) {
        if (!file_exists($file_name)) {
            $this->dump($file_name . ' does not exist.');
        }
    }

    public function file_name() {
        $name = ucfirst(basename($_SERVER["SCRIPT_NAME"], ".php"));
        $name = str_replace('-', ' ', $name);
        return ($name == 'Index') ? 'Dashboard' : ucwords($name);
    }

    public function url() {
        return sprintf(
            "%s://%s%s",
            isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
            $_SERVER['SERVER_NAME'],
            dirname($_SERVER["REQUEST_URI"])
        );
    }

    public function redirect($url, $delay = 0) {
        if (file_exists(strtok($url, '?'))) {
            if (!headers_sent()) {
                header("refresh:{$delay};url={$url};");
                ob_end_clean();
            }
            echo "<script>setTimeout(function() { window.location.href = '{$url}'; }, {$delay}000);</script>";
        } else {
            echo "File: <b>{$url}</b> does not exist.";
        }
        exit();
    }

	public

	function safe($var, $request = 'post')
	{
		global $display;
		if ($request == 'post') {
			if (isset($_POST[$var]) && (ctype_digit($_POST[$var]) || in_array($var,['telegram', 'EditUserTelegram']))) {
				return $_POST[$var];
			} else if (isset($_POST[$var]) && is_string($_POST[$var]) && !empty($_POST[$var])) {
				return stripslashes(strip_tags($_POST[$var]));
			} else {
				echo ('Please fill all fields correctly');
				exit();
			}
		} else if ($request == 'get') {
			if (isset($_GET[$var]) && ctype_digit($_GET[$var])) {
				return $_GET[$var];
			} else if (isset($_GET[$var]) && is_string($_GET[$var]) && !empty($_GET[$var])) {
				return stripslashes(strip_tags($_GET[$var]));
			} else {
				echo ('Please fill all fields correctly.');
				exit();
			}
		} else if ($request == 'none') {
			if (isset($var) && ctype_digit($var)) {
				return $var;
			} else if (isset($var) && is_string($var) && !empty($var)) {
				return stripslashes(strip_tags($var));
			} else {
				exit();
			}
		}
	}

	function time_ago($ptime)
	{
		$etime = time() - $ptime;
		if ($etime < 1) {
			return '0 seconds';
		}

		$a = array(
			365 * 24 * 60 * 60 => 'year',
			30 * 24 * 60 * 60 => 'month',
			24 * 60 * 60 => 'day',
			60 * 60 => 'hour',
			60 => 'minute',
			1 => 'second'
		);
		$a_plural = array(
			'year' => 'years',
			'month' => 'months',
			'day' => 'days',
			'hour' => 'hours',
			'minute' => 'minutes',
			'second' => 'seconds'
		);
		foreach ($a as $secs => $str) {
			$d = $etime / $secs;
			if ($d >= 1) {
				$r = round($d);
				return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' ago';
			}
		}
	}

	public

	function CountryList()
	{
		$countries = array(
			"Afghanistan",
			"Albania",
			"Algeria",
			"American Samoa",
			"Andorra",
			"Angola",
			"Anguilla",
			"Antarctica",
			"Antigua and Barbuda",
			"Argentina",
			"Armenia",
			"Aruba",
			"Australia",
			"Austria",
			"Azerbaijan",
			"Bahamas",
			"Bahrain",
			"Bangladesh",
			"Barbados",
			"Belarus",
			"Belgium",
			"Belize",
			"Benin",
			"Bermuda",
			"Bhutan",
			"Bolivia",
			"Bosnia and Herzegowina",
			"Botswana",
			"Bouvet Island",
			"Brazil",
			"British Indian Ocean Territory",
			"Brunei Darussalam",
			"Bulgaria",
			"Burkina Faso",
			"Burundi",
			"Cambodia",
			"Cameroon",
			"Canada",
			"Cape Verde",
			"Cayman Islands",
			"Central African Republic",
			"Chad",
			"Chile",
			"China",
			"Christmas Island",
			"Cocos (Keeling) Islands",
			"Colombia",
			"Comoros",
			"Congo",
			"Congo, the Democratic Republic of the",
			"Cook Islands",
			"Costa Rica",
			"Cote d'Ivoire",
			"Croatia (Hrvatska)",
			"Cuba",
			"Cyprus",
			"Czech Republic",
			"Denmark",
			"Djibouti",
			"Dominica",
			"Dominican Republic",
			"East Timor",
			"Ecuador",
			"Egypt",
			"El Salvador",
			"Equatorial Guinea",
			"Eritrea",
			"Estonia",
			"Ethiopia",
			"Falkland Islands (Malvinas)",
			"Faroe Islands",
			"Fiji",
			"Finland",
			"France",
			"France Metropolitan",
			"French Guiana",
			"French Polynesia",
			"French Southern Territories",
			"Gabon",
			"Gambia",
			"Georgia",
			"Germany",
			"Ghana",
			"Gibraltar",
			"Greece",
			"Greenland",
			"Grenada",
			"Guadeloupe",
			"Guam",
			"Guatemala",
			"Guinea",
			"Guinea-Bissau",
			"Guyana",
			"Haiti",
			"Heard and Mc Donald Islands",
			"Holy See (Vatican City State)",
			"Honduras",
			"Hong Kong",
			"Hungary",
			"Iceland",
			"India",
			"Indonesia",
			"Iran (Islamic Republic of)",
			"Iraq",
			"Ireland",
			"Israel",
			"Italy",
			"Jamaica",
			"Japan",
			"Jordan",
			"Kazakhstan",
			"Kenya",
			"Kiribati",
			"Korea, Democratic People's Republic of",
			"Korea, Republic of",
			"Kuwait",
			"Kyrgyzstan",
			"Lao, People's Democratic Republic",
			"Latvia",
			"Lebanon",
			"Lesotho",
			"Liberia",
			"Libyan Arab Jamahiriya",
			"Liechtenstein",
			"Lithuania",
			"Luxembourg",
			"Macau",
			"Macedonia, The Former Yugoslav Republic of",
			"Madagascar",
			"Malawi",
			"Malaysia",
			"Maldives",
			"Mali",
			"Malta",
			"Marshall Islands",
			"Martinique",
			"Mauritania",
			"Mauritius",
			"Mayotte",
			"Mexico",
			"Micronesia, Federated States of",
			"Moldova, Republic of",
			"Monaco",
			"Mongolia",
			"Montserrat",
			"Morocco",
			"Mozambique",
			"Myanmar",
			"Namibia",
			"Nauru",
			"Nepal",
			"Netherlands",
			"Netherlands Antilles",
			"New Caledonia",
			"New Zealand",
			"Nicaragua",
			"Niger",
			"Nigeria",
			"Niue",
			"Norfolk Island",
			"Northern Mariana Islands",
			"Norway",
			"Oman",
			"Pakistan",
			"Palau",
			"Panama",
			"Papua New Guinea",
			"Paraguay",
			"Peru",
			"Philippines",
			"Pitcairn",
			"Poland",
			"Portugal",
			"Puerto Rico",
			"Qatar",
			"Reunion",
			"Romania",
			"Russian Federation",
			"Rwanda",
			"Saint Kitts and Nevis",
			"Saint Lucia",
			"Saint Vincent and the Grenadines",
			"Samoa",
			"San Marino",
			"Sao Tome and Principe",
			"Saudi Arabia",
			"Senegal",
			"Seychelles",
			"Sierra Leone",
			"Singapore",
			"Slovakia (Slovak Republic)",
			"Slovenia",
			"Solomon Islands",
			"Somalia",
			"South Africa",
			"South Georgia and the South Sandwich Islands",
			"Spain",
			"Sri Lanka",
			"St. Helena",
			"St. Pierre and Miquelon",
			"Sudan",
			"Suriname",
			"Svalbard and Jan Mayen Islands",
			"Swaziland",
			"Sweden",
			"Switzerland",
			"Syrian Arab Republic",
			"Taiwan, Province of China",
			"Tajikistan",
			"Tanzania, United Republic of",
			"Thailand",
			"Togo",
			"Tokelau",
			"Tonga",
			"Trinidad and Tobago",
			"Tunisia",
			"Turkey",
			"Turkmenistan",
			"Turks and Caicos Islands",
			"Tuvalu",
			"Uganda",
			"Ukraine",
			"United Arab Emirates",
			"United Kingdom",
			"United States",
			"United States Minor Outlying Islands",
			"Uruguay",
			"Uzbekistan",
			"Vanuatu",
			"Venezuela",
			"Vietnam",
			"Virgin Islands (British)",
			"Virgin Islands (U.S.)",
			"Wallis and Futuna Islands",
			"Western Sahara",
			"Yemen",
			"Yugoslavia",
			"Zambia",
			"Zimbabwe"
		);
		return $countries;
	}

	function encrypt($string)
	{
		$iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		$encrypted_string = mcrypt_encrypt(MCRYPT_BLOWFISH, $this->_encryption_key, utf8_encode($string), MCRYPT_MODE_ECB, $iv);
		return base64_encode($encrypted_string);
	}

	function decrypt($string)
	{
		$string = base64_decode($string);
		$iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		$decrypted_string = mcrypt_decrypt(MCRYPT_BLOWFISH, $this->_encryption_key, $string, MCRYPT_MODE_ECB, $iv);
		return $decrypted_string;
	}

	function shortener($text, $length = false)
	{
		if ($length == false) $length = $this->text_limit;
		else $length = $length;
		if (strlen($text) > $length) {
			$new_text = substr($text, 0, $length);
			$new_text = trim($new_text);
			return $new_text . "...";
		} else {
			return $text;
		}
	}

	function FilterValidate($string, $filter)
	{
		global $display;
		$string = $this->safe($string);
		if (filter_var($string, $filter) === false) {
			$display->ReturnError('Fill all fields correctly.');
			return;
		}
	}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, strlen($characters) - 1)];
    }
    
    return $randomString;
}

	function DoesExists($table, $value, $where, $redirect = false)
	{
		global $pdo;
		global $layer;
		if ($redirect != false) {
			$redirect = $redirect;
		} else {
			$redirect = 'index.php';
		}

		if (isset($_GET[$value]) && is_numeric($_GET[$value])) {
			$value = $_GET[$value];
			$stmt = $pdo->prepare('SELECT * FROM ' . $table . ' WHERE ' . $where . ' = :Where');
			$stmt->execute(array(
				':Where' => $value
			));
			if ($stmt->rowCount() == 0) {
				$layer->redirect($redirect);
			}
		} else {
			$layer->redirect($redirect);
		}
	}

	function GetData($table, $value, $where, $where_val)
	{
		global $pdo;
		$stmt = $pdo->prepare('SELECT * FROM ' . $table . ' WHERE ' . $where . ' = :Where');
		$stmt->execute(array(
			':Where' => $where_val
		));
		if ($stmt->rowCount() == 1) {
			$row = $stmt->fetch();
			return $row[$value];
		} else	if ($stmt->rowCount() > 1) {
			$rows = array();
			foreach ($stmt->fetchAll() as $row) {
				$rows[] = $row[$value];
			}

			return $rows;
		}
	}

	function ReferEarned($refer)
	{
		global $pdo;
		$stmt = $pdo->prepare('SELECT SUM(`sum`) FROM `refer_deduction` WHERE `refer` = :REFER');
		$stmt->execute(array(':REFER' => $refer));
		$earned = $stmt->fetch();

		return $earned[0];
	}

	function GetReferrBalance($idUser)
	{
		global $pdo;

		$stmt = $pdo->prepare('SELECT ReferrID FROM `referrs` WHERE `ReferrUserID` = :UID');
		$stmt->execute(array(':UID' => $idUser));

		$refs = [];

		while ($row = $stmt->fetch()) {
			$refs[] = (int)$row[0];
		}
		if (count($refs) > 0) {
			$stmt = $pdo->prepare('SELECT SUM(`sum`) FROM `refer_deduction` WHERE `refer` IN (' . implode(',', $refs) . ')');
			$stmt->execute();
			$row = $stmt->fetch();
			$earned = (float)$row[0];
		} else {
			$earned = 0;
		}

		$stmt = $pdo->prepare('SELECT SUM(`outSum`) FROM `refer_out` WHERE `idUser` = :UID');
		$stmt->execute(array(':UID' => $idUser));
		$row = $stmt->fetch();
		$payd = (float)$row[0];

		return $earned - $payd;
	}

	function ReferrWithdraw($idUser, $sum)
	{
		global $pdo;

		$balance = $this->GetReferrBalance($idUser);

		if ($sum < 1) {
			return 'Запрошенная сумма меньше минимальной';
		}

		if ($sum > $balance) {
			return 'Недостаточно средств для совершения платежа';
		}

		$stmt = $pdo->prepare('INSERT INTO refer_out (idUser, outSum) VALUES (:UID, :SUM)');
		if ($stmt->execute(array(':UID' => $idUser, ':SUM' => $sum))) {
			$insId = $pdo->lastInsertId();
			$stmt = $pdo->prepare('UPDATE users SET UserBalance = UserBalance + :SUM WHERE UserID = :UID');
			if (!$stmt->execute(array(':SUM' => $sum, ':UID' => $idUser))) {
				$stmt = $pdo->prepare('DELETE FROM refer_out WHERE id = :ID');
				$stmt->execute(array(':ID' => $insId));
				return 'Внутренняя ошибка 1';
			}
		} else {
			return 'Внутренняя ошибка 1';
		}

		return true;
	}

	function CountRows($table, $where, $where_val)
	{
		global $pdo;
		$stmt = $pdo->prepare('SELECT * FROM ' . $table . ' WHERE ' . $where . ' = :Where');
		$stmt->execute(array(
			':Where' => $where_val
		));
		return $stmt->rowCount();
	}

	function GetIP()
	{
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}

		return $ip;
	}

    function SendCurl($URL, $return = true)
    {
        if (filter_var($URL, FILTER_VALIDATE_URL) === FALSE) {
            return '{"error":"API Service URL is not valid"}';
        }

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $URL,
            CURLOPT_USERAGENT => 'Mozzilla Gecko 4.5',
            CURLOPT_TIMEOUT => 30
        ));
        $resp = curl_exec($curl);
        $curl_errno = curl_errno($curl);
        curl_close($curl);

        if ($curl_errno > 0 || empty($resp)) {
            $resp = '{"error":"API Service no answer"}';
        }

        if ($return == true) return $resp;
    }
}


class Display
{
	function ReturnSuccess($Message, $Icon = true)
	{
		$html = '<div class="alert success" style="margin-top: 4px;">';
		if ($Icon == true) {
			$html .= '<i class="fa fa-lg fa-comments-o"></i>';
			$html .= '<span style="margin-left: 4px;">' . $Message . '</span>';
		} else {
			$html .= $Message;
		}

		$html .= '</div>';
		echo $html;
	}

	function ReturnInfo($Message, $Icon = true)
	{
		$html = '<div class="alert info" style="margin-top: 4px;">';
		if ($Icon == true) {
			$html .= '<i class="fa fa-lg fa-check-circle-o"></i>';
			$html .= '<span style="margin-left: 4px;">' . $Message . '</span>';
		} else {
			$html .= $Message;
		}

		$html .= '</div>';
		echo $html;
	}

	function ReturnWarning($Message, $Icon = true)
	{
		$html = '<div class="alert notice" style="margin-top: 4px;">';
		if ($Icon == true) {
			$html .= '<i class="fa fa-lg fa-exclamation-triangle"></i>';
			$html .= '<span style="margin-left: 4px;">' . $Message . '</span>';
		} else {
			$html .= $Message;
		}

		$html .= '</div>';
		echo $html;
	}

	function ReturnError($Message, $Icon = true)
	{
		$html = '<div class="alert error" style="margin-top: 4px;">';
		if ($Icon == true) {
			$html .= '<i class="fa fa-lg  fa-times-circle"></i>';
			$html .= '<span style="margin-left: 4px;">' . $Message . '</span>';
		} else {
			$html .= $Message;
		}

		$html .= '</div>';
		echo $html;
	}
}
