<!DOCTYPE html>
<html>
    <head>
        <title>Aimeos administration Interface</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/extjs/3.4.1-1/resources/css/ext-all.css" />
        <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/extjs/3.4.1-1/resources/css/xtheme-gray.css" />
@foreach ($cssFiles as $cssFile)
        <link rel="stylesheet" href="<?= asset('packages/aimeos/shop/' . $cssFile) ?>" />
@endforeach

        <script type="text/javascript">
        window.MShop = {

            i18n: {
                lang: '<?= $lang ?>',
                content: <?= $i18nContent ?>,
                available: <?= $languages ?>
            },

            config: {
                site: <?= $siteitem ?>,
                data: <?= $config ?>,
                smd: <?= $smd ?>,
                itemschema: <?= $itemSchemas ?>,
                searchschema: <?= $searchSchemas ?>,
                urlTemplate: '<?= $urlTemplate ?>',
                jqadmurl: '<?= $jqadmurl ?>',
                activeTab: <?= $activeTab ?>,

                baseurl: {
                    content: '<?= asset($uploaddir) ?>'
                },

                update: {
                    type: 'Laravel',
                    version: '<?= $version ?>'
                }
            }
        }
        </script>

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/extjs/3.4.1-1/adapter/ext/ext-base.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/extjs/3.4.1-1/ext-all.js"></script>
        <script type="text/javascript" src="<?= route( 'aimeos_shop_extadm_file', array( 'site' => $site ) ); ?>"></script>

    </head>
    <body>
        <noscript><p>You need to enable javascript!</p></noscript>
    </body>
</html>
