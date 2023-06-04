<?php

	function mensagem($titulo, $msg) {
		echo "
		<script>
			Swal.fire({
				title: '{$titulo}',
				text: '{$msg}',
			}).then((result) => {
				history.back();
			});
		</script>
		";
		exit;
	}

	function formatarValor($valor){
		// 5.900,00 -> 5900,00
		$valor = str_replace(".","",$valor);
		//5900,00 -> 5900.00
		return str_replace(",",".",$valor);
	}


	function encriptador($value){
		$hash = password_hash($value, PASSWORD_BCRYPT);

		return $hash;
	}

	