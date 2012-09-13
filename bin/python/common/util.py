import os, io, sys, time, random
import sys, socket, hashlib
import urllib2, cookielib, shutil

reload(sys)
sys.setdefaultencoding('utf-8')

def getContentFromUrl(url, timeout=300):
	data = ''
	socket.setdefaulttimeout(timeout)

	try:
		user_agent = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; zh-CN; rv:1.8.1.9) Gecko/20071025 Firefox/2.0.0.9' 
		request = urllib2.Request(url)
		request.add_header('User-Agent', user_agent)
		cookie = cookielib.CookieJar()
		opener  = urllib2.build_opener(urllib2.HTTPCookieProcessor(cookie))
		f = opener.open(request)
		if f.code == 200:
			data = f.read()
	except Exception,e:
		print e

	return data
