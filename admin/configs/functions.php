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
    

    /* ***********************************
	* loadImg($imagem, $nome)
	* Redimenciona das imagens PNG ou JPG
	* $imagem - imagem a se redimencionar
	* $nome - novo nome que esta deve assumir
	* ao final irá apagar a imagem original
	* ********************************** */

	function loadImg($imagem, $nome)
	{
		//pasta das imagens
		$pastaFotos = 'fotos/';

		//pega o tipo de imagem - jpg ou png
		$tipo = mime_content_type($imagem);

		//calcula o tamanho da imagem para redimencionar proporcionalmente a largura
		list($largura1, $altura1) = getimagesize($imagem);

		//configuracoes do maior tamanho - desktopos
		$largura = 1400;
		$percent = ($largura/$largura1);
		$altura = $altura1 * $percent;

		//configurações para tamanho médio - tablets
		$larguram = 800;
		$percentm = ($larguram/$largura1);
		$alturam = $altura1 * $percentm;

		//configurações para tamanho pequeno - smartphones
		$largurap = 350;
		$percentp = ($largurap/$largura1);
		$alturap = $altura1 * $percentp;

		if ( $tipo == "image/png") {

			$imagem_gerada = $pastaFotos.$nome."g.png";
			$path = $imagem;
			$imagem_orig = ImageCreateFromPNG($path);
			$pontoX = ImagesX($imagem_orig);
			$pontoY = ImagesY($imagem_orig);

			$imagem_fin = ImageCreateTrueColor($largura, $altura);

			imagealphablending($imagem_fin, false);
			imagesavealpha($imagem_fin,true);
			$transparent = imagecolorallocatealpha($imagem_fin, 255, 255, 255, 127);
			imagefilledrectangle($imagem_fin, 0, 0, $largura+1, $altura+1, $transparent);

			ImageCopyResampled($imagem_fin, $imagem_orig, 0, 0, 0, 0, $largura+1, $altura+1, $pontoX, $pontoY);
			ImagePNG($imagem_fin, $imagem_gerada,9);
			ImageDestroy($imagem_orig);
			ImageDestroy($imagem_fin);


			$imagem_gerada = $pastaFotos.$nome."m.png";
			$path = $imagem;
			$imagem_orig = ImageCreateFromPNG($path);
			$pontoX = ImagesX($imagem_orig);
			$pontoY = ImagesY($imagem_orig);

			$imagem_fin = ImageCreateTrueColor($larguram, $alturam);

			imagealphablending($imagem_fin, false);
			imagesavealpha($imagem_fin,true);
			$transparent = imagecolorallocatealpha($imagem_fin, 255, 255, 255, 127);
			imagefilledrectangle($imagem_fin, 0, 0, $larguram+1, $alturam+1, $transparent);

			ImageCopyResampled($imagem_fin, $imagem_orig, 0, 0, 0, 0, $larguram+1, $alturam+1, $pontoX, $pontoY);
			ImagePNG($imagem_fin, $imagem_gerada,9);
			ImageDestroy($imagem_orig);
			ImageDestroy($imagem_fin);

			$imagem_gerada = $pastaFotos.$nome."p.png";
			$path = $imagem;
			$imagem_orig = ImageCreateFromPNG($path);
			$pontoX = ImagesX($imagem_orig);
			$pontoY = ImagesY($imagem_orig);

			$imagem_fin = ImageCreateTrueColor($largurap, $alturap);

			imagealphablending($imagem_fin, false);
			imagesavealpha($imagem_fin,true);
			$transparent = imagecolorallocatealpha($imagem_fin, 255, 255, 255, 127);
			imagefilledrectangle($imagem_fin, 0, 0, $largurap+1, $alturap+1, $transparent);

			ImageCopyResampled($imagem_fin, $imagem_orig, 0, 0, 0, 0, $largurap+1, $alturap+1, $pontoX, $pontoY);
			ImagePNG($imagem_fin, $imagem_gerada,10);
			ImageDestroy($imagem_orig);
			ImageDestroy($imagem_fin);


		} else {

			$imagem_gerada = $pastaFotos.$nome."g.jpg";
			$path = $imagem;
			$imagem_orig = ImageCreateFromJPEG($path);
			$pontoX = ImagesX($imagem_orig);
			$pontoY = ImagesY($imagem_orig);
			@$imagem_fin = ImageCreateTrueColor($largura, $altura);
			@ImageCopyResampled($imagem_fin, $imagem_orig, 0, 0, 0, 0, $largura+1, $altura+1, $pontoX, $pontoY);
			ImageJPEG($imagem_fin, $imagem_gerada,130);
			ImageDestroy($imagem_orig);
			ImageDestroy($imagem_fin); 

			$imagem_gerada = $pastaFotos.$nome."m.jpg";
			$path = $imagem;
			@$imagem_orig = ImageCreateFromJPEG($path);
			$pontoX = ImagesX($imagem_orig);
			$pontoY = ImagesY($imagem_orig);
			@$imagem_fin = ImageCreateTrueColor($larguram, $alturam);
			@ImageCopyResampled($imagem_fin, $imagem_orig, 0, 0, 0, 0, $larguram+1, $alturam+1, $pontoX, $pontoY);
			ImageJPEG($imagem_fin, $imagem_gerada,80);
			ImageDestroy($imagem_orig);
			ImageDestroy($imagem_fin);

			$imagem_gerada = $pastaFotos.$nome."p.jpg";
			$path = $imagem;
			@$imagem_orig = ImageCreateFromJPEG($path);
			$pontoX = ImagesX($imagem_orig);
			$pontoY = ImagesY($imagem_orig);
			@$imagem_fin = ImageCreateTrueColor($largurap, $alturap);
			@ImageCopyResampled($imagem_fin, $imagem_orig, 0, 0, 0, 0, $largurap+1, $alturap+1, $pontoX, $pontoY);
			ImageJPEG($imagem_fin, $imagem_gerada,150);
			ImageDestroy($imagem_orig);
			ImageDestroy($imagem_fin);
		}
	
		//apagar a imagem antiga
		unlink ($imagem);
	}

	 /* ***********************************
	* validaCPF($cpf)
	* Validar se o CPF é válido
	* $cpf - número do cpf a validar
	* https://www.geradorcpf.com/script-validar-cpf-php.htm
	* ********************************** */

	function validaCPF($cpf = null) {

		// Verifica se um número foi informado
		if(empty($cpf)) {
			mensagem("Erro","Preencha o CPF");
		}
	
		// Elimina possivel mascara
		$cpf = preg_replace("/[^0-9]/", "", $cpf);
		$cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);
		
		// Verifica se o numero de digitos informados é igual a 11 
		if (strlen($cpf) != 11) {
			mensagem("Erro","Preencha com um CPF válido");
		}
		// Verifica se nenhuma das sequências invalidas abaixo 
		// foi digitada. Caso afirmativo, retorna falso
		else if ($cpf == '00000000000' || 
			$cpf == '11111111111' || 
			$cpf == '22222222222' || 
			$cpf == '33333333333' || 
			$cpf == '44444444444' || 
			$cpf == '55555555555' || 
			$cpf == '66666666666' || 
			$cpf == '77777777777' || 
			$cpf == '88888888888' || 
			$cpf == '99999999999') {
			mensagem("Erro","CPF inválido");
		 // Calcula os digitos verificadores para verificar se o
		 // CPF é válido
		 } else {   
			
			for ($t = 9; $t < 11; $t++) {
				
				for ($d = 0, $c = 0; $c < $t; $c++) {
					$d += $cpf[$c] * (($t + 1) - $c);
				}
				$d = ((10 * $d) % 11) % 10;
				if ($cpf[$c] != $d) {
					mensagem("Erro","CPF inválido");
				}
			}
	
			return true;
		}
	}

	function formatarValor($valor){
		// 5.900,00 -> 5900,00
		$valor = str_replace(".","",$valor);
		//5900,00 -> 5900.00
		return str_replace(",",".",$valor);
	}

	function formatarData($data){
		//06/04/2023 -> 2023-04-06

		$data = explode("/", $data);
		return $data[2]."-".$data[1]."-".$data[0];
	}

	function encriptador($value){
		$hash = password_hash($value, PASSWORD_BCRYPT);

		return $hash;
	}