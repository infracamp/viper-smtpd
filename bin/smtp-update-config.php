<?php
/**
 * Created by PhpStorm.
 * User: matthes
 * Date: 18.07.18
 * Time: 16:20
 */

namespace App;

use Leuffen\TextTemplate\TextTemplate;

require __DIR__ . "/../vendor/autoload.php";


define("FILES_ENV_SENDERS", "/etc/postfix/controlled_envelope_senders");


$config = json_decode(CONF_JSON, true);


$tpl = new TextTemplate();
$tpl->loadTemplate(file_get_contents(__DIR__ . "/../etc/postfix/main.cf"));

echo "\nWriting /etc/postfix/main.cfg...";
file_put_contents("/etc/postfix/main.cf", $tpl->apply($config));


file_put_contents("/etc/postfix/sasl/smtpd.conf", file_get_contents(__DIR__ . "/../etc/postfix/sasl/smtpd.conf"));
file_put_contents("/etc/postfix/master.cf", file_get_contents(__DIR__ . "/../etc/postfix/master.cf"));

$envelopeSenders = [];
foreach ($config["smtp_sasl_users"] as $curUser) {
    [$user, $pass, $allowedSenderDomains] = explode(":", $curUser);

    [$user, $domain] = explode("@", $user);

    echo "\nCreating sasluser: $user @ $domain with allowed domains: $allowedSenderDomains";

    phore_exec("echo :passwd | saslpasswd2 -p -c -u :domain :user", ["user"=>$user, "domain"=>$domain, "passwd"=>$pass]);

    foreach (explode(",", $allowedSenderDomains) as $curDomain) {
        if ($curDomain === "*")
            $curDomain = "";
        if ( ! isset ($envelopeSenders[$curDomain])) {
            $envelopeSenders[$curDomain] = [];
        }
        $envelopeSenders[$curDomain][] = $user."@".$domain;
    }

}

$envSenders = "";
foreach ($envelopeSenders as $envSender => $users) {
    $envSenders .= "\n$envSender  " . implode(", ", $users);
}
file_put_contents(FILES_ENV_SENDERS, $envSenders);
try {
    phore_exec("postmap hash:".FILES_ENV_SENDERS);
} catch (\Exception $e) {
    echo "\nFailed postmap: File contents of " . FILES_ENV_SENDERS;
    echo "\n------------------------\n" . file_get_contents(FILES_ENV_SENDERS) . "\n---------------------\n";
    throw $e;
}
echo "\n";