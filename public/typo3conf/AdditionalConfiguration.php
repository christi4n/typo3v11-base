<?php

$GLOBALS['TYPO3_CONF_VARS']['BE']['installToolPassword'] = getenv('TYPO3_INSTALL_TOOL_PASSWORD');

# Database
$GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['dbname'] = getenv('TYPO3_DB_NAME');
$GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['user'] = getenv('TYPO3_DB_USERNAME');
$GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['password'] = getenv('TYPO3_DB_PASSWORD');
$GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['host'] = getenv('TYPO3_DB_HOST');
$GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['port'] = getenv('TYPO3_DB_PORT');

# Graphics
$GLOBALS['TYPO3_CONF_VARS']['DB']['GFX']['processor'] = 'ImageMagick';
$GLOBALS['TYPO3_CONF_VARS']['DB']['GFX']['processor_path'] = '/usr/bin/';
$GLOBALS['TYPO3_CONF_VARS']['DB']['GFX']['processor_path_lzw'] = '/usr/bin/';

# System
$GLOBALS['TYPO3_CONF_VARS']['SYS']['devIPmask'] = getenv('TYPO3_SYS_DEV_IP_MASK');
$GLOBALS['TYPO3_CONF_VARS']['SYS']['encryptionKey'] = getenv('TYPO3_SYS_ENCRYPTION_KEY');
$GLOBALS['TYPO3_CONF_VARS']['SYS']['sitename'] = getenv('TYPO3_SYS_SITE_NAME');
$GLOBALS['TYPO3_CONF_VARS']['SYS']['trustedHostsPattern'] = getenv('TYPO3_SYS_TRUSTED_HOSTS_PATTERN');

# Mail settings
$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport'] = getenv('TYPO3_MAIL_TRANSPORT');
$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_encrypt'] = getenv('TYPO3_MAIL_TRANSPORT_SMTP_ENCRYPT');
$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_password'] = getenv('TYPO3_MAIL_TRANSPORT_SMTP_PASSWORD');
$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_server'] = getenv('TYPO3_MAIL_TRANSPORT_SMTP_SERVER');
$GLOBALS['TYPO3_CONF_VARS']['MAIL']['transport_smtp_username'] = getenv('TYPO3_MAIL_TRANSPORT_SMTP_USERNAME');
$GLOBALS['TYPO3_CONF_VARS']['MAIL']['defaultMailFromAddress'] = getenv('TYPO3_MAIL_DEFAULT_FROM');

# Application contexts
$appContext = (string)\TYPO3\CMS\Core\Core\Environment::getContext();
switch ($appContext) {

    case 'Development':
    case 'Development/Integration':
        $disabledCaches = ['l10n', 'cache_core'];
        foreach ($disabledCaches as $disabledCache) {
            $GLOBALS['TYPO3_CONF_VARS']['SYS']['caching']['cacheConfigurations'][$disabledCache]['backend'] =
                \TYPO3\CMS\Core\Cache\Backend\NullBackend::class;
        }
        $GLOBALS['TYPO3_CONF_VARS']['BE']['lockIP'] = 1;
        $GLOBALS['TYPO3_CONF_VARS']['BE']['lockSSL'] = 0;

        $GLOBALS['TYPO3_CONF_VARS']['displayErrors'] = 1;

        break;

    case 'Production/Validation':
    case 'Production':
        break;
}

if (getenv('IS_DDEV_PROJECT') == 'true') {
    $GLOBALS['TYPO3_CONF_VARS'] = array_replace_recursive(
        $GLOBALS['TYPO3_CONF_VARS'],
        [
            'DB' => [
                'Connections' => [
                    'Default' => [
                        'dbname' => 'db',
                        'host' => 'ddev-typo3v11-db',
                        'password' => 'db',
                        'port' => '3306',
                        'user' => 'db',
                    ],
                ],
            ],
            // This GFX configuration allows processing by installed ImageMagick 6
            'GFX' => [
                'processor' => 'ImageMagick',
                'processor_path' => '/usr/bin/',
                'processor_path_lzw' => '/usr/bin/',
            ],
            // This mail configuration sends all emails to mailhog
            'MAIL' => [
                'transport' => 'smtp',
                'transport_smtp_server' => 'localhost:1025',
            ],
            'SYS' => [
                'trustedHostsPattern' => '.*.*',
                'devIPmask' => '*',
                'displayErrors' => 1,
            ],
        ]
    );
}
