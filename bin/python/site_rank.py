#!/usr/bin/env python

import socket, ConfigParser, os, datetime, time, sys
from pyquery import PyQuery as pq
from library import database
from library import thread_pool
from common import util

__basePath__ = '/'.join(__file__.split('/')[:-1])

# read database config
dbCF = ConfigParser.ConfigParser()
dbCF.read(__basePath__ + '/config/database.conf')

class Group():
	
	def getHtmlFromTuan800(self):
		url = 'http://www.tuan800.com/sites'
		data = util.getContentFromUrl(url)

		return data
	
	def analysicUrlFromHtml(self, htmlString):
		content = pq(htmlString)
		for li in content.find('#js_show_all').find('.index_ul').find('li'):
			li = pq(li)
			name   = li.text()
			tmpUrl = li.find('.site_link').attr('href')
			url = self.getUrlFromTuanDetail(tmpUrl)
			print name, url


	def getUrlFromTuanDetail(self, tmpUrl):
		data = util.getContentFromUrl(tmpUrl)
		doc  = pq(data)
		url  = doc.find('.site_page').find('.site_link').text()  
		return url
		
			
class Alexa():
	pass

def main():
	group   = Group()
	content = group.getHtmlFromTuan800().decode('utf-8','ignore')
	group.analysicUrlFromHtml(content)

if __name__=='__main__':
	main()
