<?php
// VDC Events & Consulting — gestore form contatti (SiteGround, PHP mail)
declare(strict_types=1);

$DEST = 'valerio.dichirico@vdcevents.com';
$FROM = 'no-reply@vdcevents.com';

function back(string $q): void {
    header('Location: /?' . $q . '#contatti', true, 303);
    exit;
}
function clean(string $v): string {
    return trim(str_replace(["\r", "\n"], ' ', strip_tags($v)));
}

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    header('Location: /', true, 303);
    exit;
}

// Honeypot antispam: se compilato, finge successo
if (!empty($_POST['azienda'] ?? '')) {
    back('inviato=ok');
}

$nome     = clean((string)($_POST['nome'] ?? ''));
$cognome  = clean((string)($_POST['cognome'] ?? ''));
$email    = clean((string)($_POST['email'] ?? ''));
$telefono = clean((string)($_POST['telefono'] ?? ''));
$tipo     = clean((string)($_POST['tipo'] ?? ''));
$messaggio= trim(strip_tags((string)($_POST['messaggio'] ?? '')));
$privacy  = isset($_POST['privacy']);

if ($nome === '' || $cognome === '' || $messaggio === '' || $tipo === '' || !$privacy
    || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    back('errore=1');
}

$soggetto = 'Richiesta dal sito vdcevents.com — ' . $tipo;
$corpo = "Nuova richiesta di consulenza dal sito vdcevents.com\n"
       . "--------------------------------------------------\n"
       . "Nome:     {$nome} {$cognome}\n"
       . "Email:    {$email}\n"
       . "Telefono: " . ($telefono !== '' ? $telefono : '—') . "\n"
       . "Tipo:     {$tipo}\n"
       . "--------------------------------------------------\n"
       . "Messaggio:\n{$messaggio}\n";

$headers = implode("\r\n", [
    'From: VDC Events Sito <' . $FROM . '>',
    'Reply-To: ' . $nome . ' ' . $cognome . ' <' . $email . '>',
    'MIME-Version: 1.0',
    'Content-Type: text/plain; charset=UTF-8',
]);

$sent = @mail($DEST, '=?UTF-8?B?' . base64_encode($soggetto) . '?=', $corpo, $headers);

back($sent ? 'inviato=ok' : 'errore=1');
