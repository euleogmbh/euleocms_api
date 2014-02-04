EuleoRequest
===============

Euleo-CMS SOAP-Client




* Class name: EuleoRequest
* Namespace: 





Properties
----------


### $client

```
protected \SoapClient $client
```

The SoapClient



* Visibility: **protected**


### $usercode

```
protected string $usercode
```

Euleo-Usercode



* Visibility: **protected**


### $handle

```
protected string $handle
```

The handle



* Visibility: **protected**


### $clientVersion

```
protected float $clientVersion = 2.0
```

Version of the Client



* Visibility: **protected**


### $cms

```
protected string $cms = 'custom'
```

CMS type



* Visibility: **protected**


### $sandbox

```
protected bool $sandbox = true
```

Sandbox mode. Switch to false for LIVE-Mode



* Visibility: **protected**


Methods
-------


### EuleoRequest::__construct()

```
mixed EuleoRequest::__construct(string $customer, string $usercode)
```

Connects to Euleo-Service and stores the handle if successful



* Visibility: **public**

#### Arguments

* $customer **string**
* $usercode **string**



### EuleoRequest::getRegisterToken()

```
string EuleoRequest::getRegisterToken(string $cmsroot, string $returnUrl, string $callbackUrl)
```

Returns a register token.

Specify your cms-root and a return-url, to which you will be redirected after connecting

* Visibility: **public**

#### Arguments

* $cmsroot **string**
* $returnUrl **string**
* $callbackUrl **string**



### EuleoRequest::install()

```
array EuleoRequest::install(string $token)
```

Use this after the user has confirmed the connection prompt and been redirected back to get the customer info.



* Visibility: **public**

#### Arguments

* $token **string**



### EuleoRequest::getCustomerData()

```
array EuleoRequest::getCustomerData()
```

Returns the data of the currently connected Euleo customer.



* Visibility: **public**



### EuleoRequest::connected()

```
boolean EuleoRequest::connected()
```

returns TRUE if there is a user connected.



* Visibility: **public**



### EuleoRequest::setLanguageList()

```
array EuleoRequest::setLanguageList(string $languageList)
```

sets the list of supported languages for your site. (comma-separated list).



* Visibility: **public**

#### Arguments

* $languageList **string**



### EuleoRequest::startEuleoWebsite()

```
string EuleoRequest::startEuleoWebsite()
```

returns a link to the current shopping cart in the euleo system.



* Visibility: **public**



### EuleoRequest::getRows()

```
array EuleoRequest::getRows(string $translationIdList)
```

fetches the rows which are currently in translation or ready but not delivered.

don't forget to use confirmDelivery().

* Visibility: **public**

#### Arguments

* $translationIdList **string**



### EuleoRequest::sendRows()

```
array EuleoRequest::sendRows(array $rows)
```

sends the rows for translation

rows can have fields or rows as children<br>
rows are arrays with the following scheme:<br>

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

* Visibility: **public**

#### Arguments

* $rows **array**



### EuleoRequest::confirmDelivery()

```
array EuleoRequest::confirmDelivery(array $translationids)
```

confirms delivery of the translations in the euleo system (comma-separated list)



* Visibility: **public**

#### Arguments

* $translationids **array**



### EuleoRequest::getCart()

```
array EuleoRequest::getCart()
```

returns the contents of the current shopping cart



* Visibility: **public**



### EuleoRequest::clearCart()

```
array EuleoRequest::clearCart()
```

clears cart



* Visibility: **public**



### EuleoRequest::addLanguage()

```
array EuleoRequest::addLanguage(string $code, string $language)
```

adds a language to the row with the specified code



* Visibility: **public**

#### Arguments

* $code **string**
* $language **string**



### EuleoRequest::removeLanguage()

```
array EuleoRequest::removeLanguage(string $code, string $language)
```

removes a language from the row with the specified code



* Visibility: **public**

#### Arguments

* $code **string**
* $language **string**



### EuleoRequest::identifyLanguages()

```
array EuleoRequest::identifyLanguages(array $texts)
```

tries to identify the languages of the elements in $texts



* Visibility: **public**

#### Arguments

* $texts **array**



### EuleoRequest::setCallbackUrl()

```
array EuleoRequest::setCallbackUrl(string $url)
```

sets the callback-url



* Visibility: **public**

#### Arguments

* $url **string**



### EuleoRequest::_createRequest()

```
string EuleoRequest::_createRequest(array $data, string $action)
```

creates a request-xml from $data and $action



* Visibility: **protected**

#### Arguments

* $data **array**
* $action **string**



### EuleoRequest::_createRequest_sub()

```
string EuleoRequest::_createRequest_sub(array $data, string $parentKey)
```

recursive sub-function of _createRequest



* Visibility: **protected**

#### Arguments

* $data **array**
* $parentKey **string**



### EuleoRequest::_rowToXml_sub()

```
string EuleoRequest::_rowToXml_sub(array $row)
```

converts a row to xml



* Visibility: **protected**

#### Arguments

* $row **array**



### EuleoRequest::_parseXml()

```
array EuleoRequest::_parseXml(string $xml)
```

converts xml to arrays



* Visibility: **protected**

#### Arguments

* $xml **string**



### EuleoRequest::_parseXml_sub()

```
array EuleoRequest::_parseXml_sub(object $rownode)
```

recursive sub-function on _parseXml



* Visibility: **protected**
* This method is **static**.

#### Arguments

* $rownode **object**


