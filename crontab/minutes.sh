#!/bin/bash
# 切换工作目录
cd $(cd `dirname $0`; pwd)
cd ..
# 每三分钟执行脚本，更新阈值报警
/usr/bin/php think crontab:coin:alert