<?php

if(!empty($_POST["input1"]) || !empty($_POST["input2"]) || !empty($_POST["input3"])) {
	echo "Ботяра";
	exit;
}

$res = '';

if(isset($_POST["aparts"]) && isset($_POST["name"]) && isset($_POST["phone"]) && isset($_POST["street"])) {
	$address = $_POST["aparts"];
	$name = $_POST["name"];
	$phone = $_POST["phone"];
	$street = htmlentities($_POST["street"]);


		$batch = array();

		for($i = 0; $i < count($name); $i++) {
			$batch['cmd_'.$i] = 
				'crm.lead.add?'.http_build_query(array(
					"fields" => array(
						"TITLE" => "Коллективная Заявка ул. $street, кв. ".htmlentities($address[$i]),
						"NAME" => htmlentities($name[$i]),
						"PHONE" => array(
							"VALUE" => htmlenitites($phone[$i]),
							"VALUE_TYPE" => "WORK"
						)
					),
			));

			if($i != 0 && $i % 50 == 0) {
				$res .= '>>>'.print_r(executeHook(array('cmd' => $batch)), true);
				$batch = array();
			}
		}


		if (count($batch) > 0) $res .= '>>>'.print_r(executeHook(array('cmd' => $batch)), true);
}

function executeHook($params) {

	$queryUrl = "https://b24-ac2nlo.bitrix24.ru/rest/1/xxpu8wsowbklzil2/batch.json?";
	$queryData = http_build_query($params);

	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_SSL_VERIFYPEER => 0,
		CURLOPT_POST => 1,
		CURLOPT_HEADER => 0,
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_URL => $queryUrl,
		CURLOPT_POSTFIELDS => $queryData,
	));

	$res = curl_exec($curl);

	curl_close($curl);

	return $res;
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="styles.css">
	<title>Коллективная заявка</title>
</head>
<body>
	<div class="page">
	<form method="POST">
		<div class="form__header">
			<div class="form__title">Коллективная заявка</div>
		</div>
		<div class="form__content">
			<span></span>
			<input name="input1" type="text" class="form__inpot">
			<input name="input2" type="number" class="form__inpot">
			<input name="input3" type="email" class="form__inpot">
			<div class="inputs__group">
				<input name="street" type="text" class="form__input" autocomplete="off" placeholder="Адрес" required>
			</div>
			<div class="inputs__group">
				<input name="aparts[]" type="text" class="form__input" autocomplete="off" placeholder="кв." required>
				<input name="name[]" type="text" class="form__input" autocomplete="off" placeholder="Имя" required>
				<input name="phone[]" type="text" class="form__input" autocomplete="off" placeholder="Телефон" required>
			</div>
			<div class="inputs__group">
				<input name="aparts[]" type="text" class="form__input" autocomplete="off" placeholder="кв." required>
				<input name="name[]" type="text" class="form__input" autocomplete="off" placeholder="Имя" required>
				<input name="phone[]" type="text" class="form__input" autocomplete="off" placeholder="Телефон" required>
			</div>
			<div class="inputs__group">
				<input name="aparts[]" type="text" class="form__input" autocomplete="off" placeholder="кв." required>
				<input name="name[]" type="text" class="form__input" autocomplete="off" placeholder="Имя" required>
				<input name="phone[]" type="text" class="form__input" autocomplete="off" placeholder="Телефон" required>
			</div>
			<div class="inputs__group">
				<input name="aparts[]" type="text" class="form__input" autocomplete="off" placeholder="кв." required>
				<input name="name[]" type="text" class="form__input" autocomplete="off" placeholder="Имя" required>
				<input name="phone[]" type="text" class="form__input" autocomplete="off" placeholder="Телефон" required>
			</div>
			<div class="inputs__group">
				<input name="aparts[]" type="text" class="form__input" autocomplete="off" placeholder="кв." required>
				<input name="name[]" type="text" class="form__input" autocomplete="off" placeholder="Имя" required>
				<input name="phone[]" type="text" class="form__input" autocomplete="off" placeholder="Телефон" required>
			</div>


			
			<span class="form-control-add-btn">Добавить еще</span>
		</div>
		<div class="form__footer">
			<button type="submit" class="form__button">Отправить</button>
		</div>
	</form>
	</div>
	<script src="script.js"></script>
</body>
</html>






