#!/bin/bash
# 切换工作目录
cd $(cd `dirname $0`; pwd)
# 每天定时任务
/usr/bin/php think crontab:coin:rank
/usr/bin/php think crontab:money:rate