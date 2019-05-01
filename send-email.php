<?php


$Nome		= $_POST["inputName"];	// Pega o valor do campo Nome
$Fone		= $_POST["inputPhone"];	// Pega o valor do campo Telefone
$Email		= $_POST["inputEmail"];	// Pega o valor do campo Email
$Mensagem	= $_POST["inputMessage"];	// Pega os valores do campo Mensagem

// Variável que junta os valores acima e monta o corpo do email

$Conteudo 		= "Nome: $Nome\n\nE-mail: $Email\n\nTelefone: $Fone\n\nMensagem: $Mensagem\n\n ------------------------------------------------------\n\n Este email foi enviado automaticamente pelo formulário de contato no site do Mao3D\n\n---------------------------";

require_once("phpmailer/class.phpmailer.php");

define('GUSER', 'naoresponda.Mao3D@gmail.com');	// <-- Insira aqui o seu GMail
define('GPWD', 'biomec2015');		// <-- Insira aqui a senha do seu GMail

function smtpmailer($para, $de, $de_nome, $assunto, $corpo) { 
	global $error;
	$mail = new PHPMailer();
	$mail->IsSMTP();		// Ativar SMTP
	$mail->SMTPDebug = 0;		// Debugar: 1 = erros e mensagens, 2 = mensagens apenas
	$mail->SMTPAuth = true;		// Autenticação ativada
	$mail->SMTPSecure = 'tls';	// SSL REQUERIDO pelo GMail
	$mail->Host = 'smtp.gmail.com';	// SMTP utilizado
	$mail->Port = 587;  		// A porta 587 deverá estar aberta em seu servidor
	$mail->Username = GUSER;
	$mail->Password = GPWD;
	$mail->SetFrom($de, $de_nome);
	$mail->Subject = $assunto;
	$mail->Body = $corpo;
	$mail->AddAddress($para);
	if(!$mail->Send()) {
		$error = 'Mail error: '.$mail->ErrorInfo; 
		return false;
	} else {
		$error = 'Mensagem enviada!';
		return true;
	}
}

// Insira abaixo o email que irá receber a mensagem, o email que irá enviar (o mesmo da variável GUSER), 
//o nome do email que envia a mensagem, o Assunto da mensagem e por último a variável com o corpo do email.



 if (smtpmailer('mao3d.unifesp@gmail.com', $Email, $Nome, 'Contato - Site do Mao3D', $Conteudo)) {
	Header("location:/mao3d/index.html?email_send=1"); // Redireciona para uma página de obrigado.

}
else{
	Header("location:/mao3d/index.html?email_send=0"); // Redireciona para uma página de obrigado.
} 
?>