# Euleo-CMS API - Quick-Start Guide

## Zeilen-Struktur

Um Texte an Euleo zu senden, m&uuml;ssen diese wie folgt aufbereitet werden.

Es gibt Zeilen (rows) und Felder (fields). Zeilen k&ouml;nnen mehrere Felder sowie weitere Zeilen enthalten, die wiederum Felder und Zeilen enthalten k&ouml;nnen.

Z.B. eine Seite mit Titel und Keywords sowie einem Inhalt mit Richtext:

```
$row = array();
$row['code'] = 'seiten_1'; // Eindeutiger Identifikator
$row['title'] = 'Seite 1'; // Titel der Zeile.
$row['description'] = 'Beschreibung'; // Beschreibung der Zeile. Wird z.B. im Warenkorb angezeigt.
$row['srclang'] = 'de'; // Ausgangssprache
$row['languages'] = 'en'; // Zielsprachen (Komma-separierte Liste)

$row['fields'] = array();

$field = array();
$field['type'] = 'text';
$field['value'] = 'Dies ist der Seiten-Titel.';

$row['fields']['titel'] = $field;

$field = array();
$field['type'] = 'text';
$field['value'] = 'Keywords';

$row['fields']['keywords'] = $field;

$subrow = array();
$subrow['code'] = 'inhalte_1';
$subrow['title'] = 'Inhalt 1';
$subrow['description'] = 'Beschreibung';

$field = array();
$field['type'] = 'richtextarea';
$field['value'] = '<ul><li>123</li><li>2</li></ul>';

$subrow['fields']['text'] = $field;

$row['rows'][] = $subrow;
```

Optional kann bei der Zeile ein Link ("link") mitgegeben werden. Dieser wird dem &Uuml;bersetzer angezeigt.

## Installation

Um Ihre Software mit Euleo zu verkn&uuml;pfen, sind folgende Schritte notwendig:

### Erzeugen eines EuleoRequest-Objektes ohne Zugangsdaten:

```
$request = new EuleoRequest();
```

### Anfordern eines Registrierungs-Tokens:

```
$cmsroot = 'http://api.euleo.com/example/';
$returnUrl = $cmsroot . 'request.php';
$callbackUrl = $cmsroot . 'callback.php';

$token = $request->getRegisterToken($cmsroot, $returnUrl, $callbackUrl);
```

### Speichern des Tokens:

Speichern Sie diesen Token UNBEDINGT unabh&auml;ngig von einer Session. Z.B.:

```
$config = new stdClass();
$config->token = $token;

file_put_contents('config.json', json_encode($config));
```

### Umleitung auf die Euleo CMS-Registrierungs-Seite:

```
$link = 'https://www.euleo.com/registercms/' . $token;

header('Location: ' . $link);
exit;
```

### Callback:

Beim Klick auf den Button "Mit CMS verbinden" wird $customer und $usercode generiert und dem Token zugeordnet.

Anschlie&szlig;end wird die &uuml;bergebene Callback-URL aufgerufen. Hier werden die Daten abgeholt und gespeichert.

```
$config = json_decode(file_get_contents('config.json'));

if ($config->token) {
    $req = new EuleoRequest();
    $data = $req->install($config->token);

    unset($config->token);
    $config->customer = $data['customer'];
    $config->usercode = $data['usercode'];

    file_put_contents(dirname(__FILE__) . '/config.json', json_encode($config));
}
```

## Verwendung des Webservice

### Aufbau der Verbindung zum Webservice

Um sich mit dem Euleo-Webservice zu verbinden, muss lediglich ein Objekt der Klasse EuleoRequest erzeugt werden.

```
require_once 'EuleoRequest.php';$request = new EuleoRequest($customer, $usercode);
```
Die Zuangsdaten ($customer und $usercode) erhalten Sie bei der Installation.

### Senden von Zeilen (Rows)

```
require_once 'EuleoRequest.php';
$request = new EuleoRequest($customer, $usercode);

$rows = $myCMS->getRows(); // Rows vom CMS holen. Das Schema entnehmen Sie bitte dem Punkt "Zeilen-Struktur"

$request->sendRows($rows);
```

### Abholen von &uuml;bersetzten Inhalten (Callback)

Der GET-Parameter "translationIdList" wird beim Aufruf des Callbacks &uuml;bergeben.

```
require_once 'EuleoRequest.php';
$request = new EuleoRequest($customer, $usercode);

$rows = $request->getRows($_GET['translationIdList']);
```

Das Ergebnis enth&auml;lt wieder Rows im gleichen Format wie beim Senden.

Zus&auml;tzlich gibt es das Flag "ready".
W&auml;hrend des &Uuml;bersetzungsprozesses ist dieses auf 0.
Wird hier das Ergebnis eingespielt und ein Link bei der Zeile mitgeschickt, kann der &Uuml;bersetzer die &Uuml;bersetzung im Livesystem ansehen.

### Als abgeholt markieren (Callback)

Zum Abschluss m&uuml;ssen Eintr&auml;ge mit dem Flag "ready" = 1 als abgeholt markiert werden.

```
$translationIds = array(1, 2, 3);
$request->confirmDelivery($translationIds);
```

## Beispielimplementierung

Die EuleoRequest-Klasse und eine Beispielimplementierung finden Sie unter: [hier](https://github.com/euleogmbh/euleocms_api)

Die Dokumentation der Klasse EuleoRequest finden Sie unter [hier](EuleoRequest.md)
