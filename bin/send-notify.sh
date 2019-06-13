#!/usr/bin/env bash
basepath=$(cd `dirname $0`; pwd)

/usr/local/opt/php@7.1/bin/php $basepath/Console http:server reload