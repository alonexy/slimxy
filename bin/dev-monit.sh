#!/usr/bin/env bash
basepath=$(cd `dirname $0`; pwd)
app_path=$(cd "$basepath/../"; pwd)

echo "MonitDir : $app_path/Controller "
echo "Exec Script : $basepath/send-notify.sh "
IncludeDir="$app_path/Configs/* $app_path/Controller/* $app_path/Helpers/* $app_path/Model/* $app_path/Services/* $app_path/routes.php $app_path/Middlewares/* $app_path/Templates/*"
fswatch  -0 $IncludeDir -v -l 1 | xargs -0 -n 1 "$basepath/send-notify.sh"