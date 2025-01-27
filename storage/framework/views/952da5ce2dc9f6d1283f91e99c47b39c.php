<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
    <!--<script type="text/javascript" src="https://apis.google.com/js/api.js"></script>-->
    <!--<script type="text/javascript" src="https://accounts.google.com/gsi/client"></script>-->
    <!--<script type="text/javascript" src="https://www.dropbox.com/static/api/2/dropins.js" id="dropboxjs" data-app-key="k8kmsf2458sm2vf"></script>-->
    <!--<script type="text/javascript" src="https://js.live.net/v7.2/OneDrive.js"></script>-->
    <title>Inja Unja</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/js/app.js']); ?>
    <?php if (!isset($__inertiaSsrDispatched)) { $__inertiaSsrDispatched = true; $__inertiaSsrResponse = app(\Inertia\Ssr\Gateway::class)->dispatch($page); }  if ($__inertiaSsrResponse) { echo $__inertiaSsrResponse->head; } ?>
</head>
<body>
<?php if (!isset($__inertiaSsrDispatched)) { $__inertiaSsrDispatched = true; $__inertiaSsrResponse = app(\Inertia\Ssr\Gateway::class)->dispatch($page); }  if ($__inertiaSsrResponse) { echo $__inertiaSsrResponse->body; } else { ?><div id="app" data-page="<?php echo e(json_encode($page)); ?>"></div><?php } ?>
</body>
</html>
<?php /**PATH C:\Users\Webhouse\Downloads\InjaUnjaOrigin-development\InjaUnjaOrigin-development\resources\views/app.blade.php ENDPATH**/ ?>