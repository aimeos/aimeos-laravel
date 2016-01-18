<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Aimeos admin interface</title>
        <link rel="icon" type="image/x-icon" href="<?= asset('favicon.ico') ?>" />

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
                site: <?= $site ?>,
                data: <?= $config ?>,
                smd: <?= $smd ?>,
                itemschema: <?= $itemSchemas ?>,
                searchschema: <?= $searchSchemas ?>,
                urlTemplate: '<?= $urlTemplate ?>',
                activeTab: <?= $activeTab ?>,
                jqadmurl: '<?= $jqadmurl ?>,

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

		<script type="text/javascript" src="<?= route( 'aimeos_shop_extadm_file', array( 'site' => 'default' ) ); ?>"></script>

    </head>
    <body>
        <noscript><p>You need to enable javascript!</p></noscript>
    </body>
</html>
