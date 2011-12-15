README
======

What is Paybox?
-----------------

PAYBOX Services is a "multi-bank" Payment Service Provider to offer a comprehensive approach to processing payments from distance selling, providing a service linked to the whole banking landscape and non-bank card issuers. It's market player with connections to the various businesses, banks, card issuers, processing centres, institutions and integrators.

What is PlemiPayboxBundle?
-----------------

PlemiPayboxBundle is an interface to Paybox Services in order to use them really easily with Symfony2.

Requirements
------------

- [Paybox CGI](http://www1.paybox.com/telechargement_focus.aspx?cat=3)
- A knowledge of the Paybox Services docs
- Symfony2
- cURL (except if you want to use the shell way)

Installation
------------

- ``` git clone git://github.com/plemi/payboxbundle.git /vendor/bundles/Plemi/PlemiPayboxBundle ```

- Install CGI in "%kernel.root_dir%/app/Resources/cgi-bin/paybox.cgi"

Documentation
-------------

- 2 main classes : Request, Response
- Request is what you want to send to Paybox
- Response is what you get from Paybox

You can use request and response completely separately.

By default, you have to insert their CGIs in "%kernel.root_dir%/app/Resources/cgi-bin/paybox.cgi" but you can change this path via config.yml (depends on your environment):

```
plemi_paybox:
    endpoint: %kernel.root_dir%/cgi-bin
```

WARNING: your folder must be +ExecCGI on it. Please, refer to Apache manual.

Usage
-----

### Request

``` php
$object = $this->getContainer('plemi_paybox.request');
$datas = array('pbx_rang' => '34030', 'pbx_site' => '302', 'pbx_total' => '100');
$object->setDatas($datas);
$object->execute();
```

### Response

``` php
$object = $this->getContainer('plemi_paybox.response');
$datas = $_GET[];
$object->setDatas($datas);
$object->getAmount();
```

License
-------

