#!/bin/bash
# 切换工作目录
cd $(cd `dirname $0`; dirname `pwd`)
# 每分钟执行脚本，获取货币最新报价
/usr/bin/php think crontab:coin:quotes